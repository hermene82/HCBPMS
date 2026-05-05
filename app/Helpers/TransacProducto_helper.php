<?php

function obtenerConfiguracionTransaccion($indice)
{
    try {
        $session = session();
        $sessionUser = $session->get('username');
        $menu = $session->get('userMenu');

        $transacc = explode('-', $indice);
        $idProducto = $transacc[0] ?? '';
        $idTransacc = $transacc[1] ?? '';

        if ($idProducto === '' || $idTransacc === '') {
            throw new \Exception("Índice de transacción inválido: {$indice}", 1001);
        }

        $transaccNombre = obtenerNombrePorIdTransaccion($menu, $idTransacc);

        $session->set('transaccionId', $idTransacc);
        $session->set('transaccionName', $transaccNombre['transaccionName']);
        $session->set('productoId', $idProducto);
        $session->set('productoName', $transaccNombre['productoName']);
        $session->set('moduloId', $transaccNombre['moduloId']);
        $session->set('moduloName', $transaccNombre['moduloName']);
        $session->set('transaccionIn', $transaccNombre['transaccionIn']);

        $helperPath = APPPATH . 'Helpers/TransacProducto' . $idProducto . '_helper.php';

        if (!file_exists($helperPath)) {
            throw new \Exception("El helper '{$helperPath}' no existe.", 1002);
        }

        require_once $helperPath;

        $funcion = "ConfigTransacc{$idTransacc}";

        if (!function_exists($funcion)) {
            throw new \Exception("La función '{$funcion}' no existe. Verifica el helper '{$helperPath}'.", 1003);
        }

        $resultado = call_user_func($funcion);

        if (!is_array($resultado)) {
            throw new \Exception("La función '{$funcion}' no retornó un arreglo válido.", 1004);
        }

        if (isset($resultado['r_campos']) && is_array($resultado['r_campos'])) {
            $resultado['r_campos']['cmp'] = configuraCampos($resultado['campos']['camposo_campos'] ?? []);
        }

        if (isset($resultado['r_importa']) && is_array($resultado['r_importa'])) {
            $resultado['r_importa']['cmp'] = configuraCampos($resultado['campos']['importao_campos'] ?? []);
        }

        if (isset($resultado['r_filtros']) && is_array($resultado['r_filtros'])) {
            $resultado['r_filtros']['cmp'] = configuraCampos($resultado['campos']['filtroo_campos'] ?? []);
        }

        if (isset($resultado['r_camposdet']) && is_array($resultado['r_camposdet'])) {
            foreach ($resultado['r_camposdet'] as $idx => $i) {
                $resultado['r_camposdet'][$idx]['cmp'] = configuraCampos($resultado['campos']['camposdeto_campos'][$idx] ?? []);
            }
        } else {$resultado['r_camposdet'] = [];}

        if (isset($resultado['r_camposbot']) && is_array($resultado['r_camposbot'])) {
            foreach ($resultado['r_camposbot'] as $idx => $i) {
                $resultado['r_camposbot'][$idx]['cmp'] = configuraCampos($resultado['campos']['camposboto_campos'][$idx] ?? []);
            }
        } else {$resultado['r_camposbot'] = [];}

        $rCombo = [];
        $rTabla = '';

        if (isset($resultado['r_campos']['tabla'])) {
            $rTabla = $resultado['r_campos']['tabla'];
            $rCombo = array_merge($rCombo, configuraCombo($resultado['campos']['camposo_campos'] ?? [], $rTabla));
        }

        if (isset($resultado['r_importa']) && is_array($resultado['r_importa'])) {
            $rCombo = array_merge($rCombo, configuraCombo($resultado['campos']['importao_campos'] ?? [], $rTabla));
        }

        if (isset($resultado['r_filtros']) && is_array($resultado['r_filtros'])) {
            $rCombo = array_merge($rCombo, configuraCombo($resultado['campos']['filtroo_campos'] ?? [], $rTabla));
        }

        if (isset($resultado['r_camposdet']) && is_array($resultado['r_camposdet'])) {
            foreach ($resultado['r_camposdet'] as $idx => $i) {
                $rTabla = $resultado['r_camposdet'][$idx]['tabla'] ?? '';
                $rCombo = array_merge($rCombo, configuraCombo($resultado['campos']['camposdeto_campos'][$idx] ?? [], $rTabla));
            }
        }

        if (isset($resultado['r_camposbot']) && is_array($resultado['r_camposbot'])) {
            foreach ($resultado['r_camposbot'] as $idx => $i) {
                $rTabla = $resultado['r_camposbot'][$idx]['tabla'] ?? '';
                $rCombo = array_merge($rCombo, configuraCombo($resultado['campos']['camposboto_campos'][$idx] ?? [], $rTabla));
            }
        }

        $resultado['r_combo'] = $rCombo;

        return $resultado;

    } catch (\Throwable $e) {
        log_message(
            'error',
            'errorproceso|obtenerConfiguracionTransaccion|' . $e->getCode() . '|' . $e->getMessage()
        );
        return [];
    }
}


function configuraCampos($campos)
{
    try {
        if (!is_array($campos)) {
            return [];
        }

        $ArrayCampos = [];

        foreach ($campos as $c) {
            $campo_config = [
                'campo' => $c[0] ?? '',
                'as'    => $c[1] ?? '',
                'id'    => $c[4] ?? '',
                'lst'   => $c[5] ?? '',
                'esp'   => $c[6] ?? '',
                ['tipo' => 'rls', 'attr' => ['field' => $c[0] ?? '', 'label' => $c[1] ?? '', 'rules' => $c[7] ?? '']],
                ['tipo' => 'lbl', 'attr' => ['text' => ($c[1] ?? '') . ':', 'for' => $c[0] ?? '', 'attr' => []]]
            ];

            if (($c[2] ?? '') === 'TXT') {
                $campo_config[] = [
                    'tipo' => 'txt',
                    'attr' => [
                        'name'        => $c[0] ?? '',
                        'id'          => $c[0] ?? '',
                        'placeholder' => 'Escribe ' . ($c[1] ?? ''),
                        'maxlength'   => $c[3] ?? '',
                        'value'       => $c[8] ?? '',
                        'attr'        => $c[9] ?? ''
                    ]
                ];
            } elseif (($c[2] ?? '') === 'CBO') {
                $campo_config[] = [
                    'tipo' => 'cbo',
                    'attr' => [
                        'select' => '',
                        'for'    => $c[0] ?? '',
                        'opcion' => ['' => ''],
                        'attr'   => $c[9] ?? ''
                    ]
                ];
            }

            $ArrayCampos[] = $campo_config;
        }

        return $ArrayCampos;

    } catch (\Throwable $e) {
        log_message(
            'error',
            'errorproceso|configuraCampos|' . $e->getCode() . '|' . $e->getMessage()
        );
        return [];
    }
}


function configuraCombo($campos, $tabla)
{
    try {
        if (!is_array($campos)) {
            return [];
        }

        $ArrayCampos = [];

        foreach ($campos as $c) {
            if (($c[2] ?? '') === 'CBO') {
                $_lst = explode('|', $c[5] ?? '');
                $_cmp = explode('-', $_lst[6] ?? '');

                $campo_config = [
                    'dato'  => '',
                    'tabla' => $tabla,
                    'campo' => $c[0] ?? '',
                    'cat'   => $_cmp[0] ?? '',
                    'ver'   => $_lst[5] ?? ''
                ];

                if (!empty($_cmp[1])) {
                    $campo_config['fill'] = ($_cmp[1] ?? '') . '|' . ($_cmp[2] ?? '');
                }

                $ArrayCampos[] = $campo_config;
            }
        }

        return $ArrayCampos;

    } catch (\Throwable $e) {
        log_message(
            'error',
            'errorproceso|configuraCombo|' . $e->getCode() . '|' . $e->getMessage()
        );
        return [];
    }
}


function obtenerNombrePorIdTransaccion($menu, $idTransaccion)
{
    try {
        if (!is_array($menu)) {
            throw new \Exception('El menú de sesión no es válido.', 1005);
        }

        foreach ($menu as $categoria => $secciones) {
            foreach ($secciones as $seccion => $acciones) {
                foreach ($acciones as $accion) {
                    if (($accion['idTransaccion'] ?? null) == $idTransaccion) {
                        return [
                            'productoId'      => $accion['idProducto'] ?? '0',
                            'productoName'    => $categoria,
                            'moduloId'        => $accion['idModulo'] ?? '0',
                            'moduloName'      => $seccion,
                            'transaccionName' => $accion['nombre'] ?? '',
                            'transaccionIn'   => true
                        ];
                    }
                }
            }
        }

        return [
            'productoId'      => '0',
            'productoName'    => '',
            'moduloId'        => '0',
            'moduloName'      => '',
            'transaccionName' => '',
            'transaccionIn'   => false
        ];

    } catch (\Throwable $e) {
        log_message(
            'error',
            'errorproceso|obtenerNombrePorIdTransaccion|' . $e->getCode() . '|' . $e->getMessage()
        );

        return [
            'productoId'      => '0',
            'productoName'    => '',
            'moduloId'        => '0',
            'moduloName'      => '',
            'transaccionName' => '',
            'transaccionIn'   => false
        ];
    }
}