<?php

function obtenerConfiguracionTransaccion($indice) {

    $session = session();
    $sessionUser = $session->get('username'); // Obtiene el nombre del usuario de la sesión
    $menu = $session->get('userMenu'); // Obtiene el nombre del usuario de la sesión

    //print_r ($menu); exit;

    $transacc = explode('-', $indice);
    $idTransacc = $transacc[1];
    $idProducto = $transacc[0];

    $transaccNombre = obtenerNombrePorIdTransaccion($menu, $idTransacc);
    $session->set('transaccionId',$idTransacc);
    $session->set('transaccionName',$transaccNombre['transaccionName']);
    $session->set('productoId',$idProducto);
    $session->set('productoName',$transaccNombre['productoName']);
    $session->set('moduloId',$transaccNombre['moduloId']);
    $session->set('moduloName',$transaccNombre['moduloName']);
    $session->set('transaccionIn',$transaccNombre['transaccionIn']);

    // Ruta del helper específico
    $helperPath = APPPATH . 'Helpers/TransacProducto' . $idProducto . '_helper.php';

    // Verifica si el archivo existe antes de incluirlo
    if (file_exists($helperPath)) {
        require_once $helperPath; // Cargar el helper dinámico
    } else {
        die("⚠️ ERROR: El helper '{$helperPath}' no existe.");
    }

    // Construye el nombre de la función
    $funcion = "ConfigTransacc{$idTransacc}";

    // Verifica si la función existe después de cargar el helper
    if (!function_exists($funcion)) {
        die("⚠️ ERROR: La función '{$funcion}' no existe. Verifica si el helper '{$helperPath}' está correcto.");
    }

    // Llamar a la función dinámicamente
    $resultado = call_user_func($funcion);    
    
    //conigura campos
    //if (is_array($resultado['r_camposdet'])) { $resultado['r_camposdet'][0]['cmp'] = configuraCampos($resultado['campos']['camposdeto_campos']);}
    if (is_array($resultado['r_campos'])) { $resultado['r_campos']['cmp'] = configuraCampos($resultado['campos']['camposo_campos']);}
    if (is_array($resultado['r_importa'])) { $resultado['r_importa']['cmp'] = configuraCampos($resultado['campos']['importao_campos']);}
    if (is_array($resultado['r_filtros'])) { $resultado['r_filtros']['cmp'] = configuraCampos($resultado['campos']['filtroo_campos']);}

    //recorre det
    if (is_array($resultado['r_camposdet'])) {
    foreach ($resultado['r_camposdet'] as $indice => $i) { 
        $resultado['r_camposdet'][$indice]['cmp'] = configuraCampos($resultado['campos']['camposdeto_campos'][$indice]); 
    }}
    
    //recorre btn
    if (is_array($resultado['r_camposbot'])) {
    foreach ($resultado['r_camposbot'] as $indice => $i) { 
        $resultado['r_camposbot'][$indice]['cmp'] = configuraCampos($resultado['campos']['camposboto_campos'][$indice]); 
    }}

    //configura combo
    $resultado['r_combo'] = configuraCombo($resultado['campos']['camposo_campos']);

    //print_r ($resultado); exit;
    return $resultado;
}


function configuraCampos($campos)
{
    if (!is_array($campos)) {
        return "";
    }

    $ArrayCampos = []; // Inicializa correctamente el array

    foreach ($campos as $c) {
        //$c[0] = strtolower($c[0]);
        
        $campo_config = [
            'campo' => $c[0],
            'as'    => $c[1],
            'id'    => $c[4],
            'lst'   => $c[5],
            'esp'   => $c[6],
            ['tipo' => 'rls', 'attr' => ['field' => $c[0], 'label' => $c[1], 'rules' => $c[7]]],
            ['tipo' => 'lbl', 'attr' => ['text' => $c[1] . ':', 'for' => $c[0], 'attr' => []]]
        ];

        // Verificamos si es un campo de texto o un combo
        if ($c[2] === 'TXT') {
            $campo_config[] = [
                'tipo' => 'txt',
                'attr' => [
                    'name'        => $c[0],
                    'id'          => $c[0],
                    'placeholder' => 'Escribe '. $c[1], // Corrección en la descripción
                    'maxlength'   => $c[3],
                    'value'       => $c[8],
                    'attr'        => $c[9]
                ]
            ];
        } elseif ($c[2] === 'CBO') {
            $campo_config[] = [
                'tipo' => 'cbo',
                'attr' => [
                    'select' => '',
                    'for'    => $c[0],
                    'opcion' => [''  => ''],                    
                    'attr' => $c[9]
                ]
            ];
        }

        $ArrayCampos[] = $campo_config; // Agregar correctamente al array
    }

    return $ArrayCampos; // Retornar correctamente la variable
}

function configuraCombo($campos)
{
    $ArrayCampos = []; // Inicializa correctamente el array

    foreach ($campos as $c) {
       if ($c[2] === 'CBO') {
        $_lst = explode('|',$c[5] );
        $_cmp = explode('-',$_lst[6] );  
        $campo_config = [
            'dato'   => '',
            'campo' => $c[0],
            'cat'   => $_cmp[0],
            'ver'   => $_lst[5]
        ];

        if ($_cmp[1] != '') {
            $campo_config['fill'] = $_cmp[1] . '|' . $_cmp[2];
        }

        $ArrayCampos[] = $campo_config; // Agregar correctamente al array
        }        
    }

    return $ArrayCampos; // Retornar correctamente la variable
}

function obtenerNombrePorIdTransaccion($menu, $idTransaccion) {
    foreach ($menu as $categoria => $secciones) {
        foreach ($secciones as $seccion => $acciones) {
            foreach ($acciones as $accion) {
                // Comprobamos si el idTransaccion coincide con el valor
                if ($accion['idTransaccion'] == $idTransaccion) {
                    return [
                        'productoId' => $accion['idProducto'],
                        'productoName' => $categoria,  // El nombre de la categoría
                        'moduloId' => $accion['idModulo'],      // El nombre de la sección
                        'moduloName' => $seccion,      // El nombre de la sección
                        'transaccionName' => $accion['nombre'],  // El nombre de la acción
                        'transaccionIn' => true
                    ];
                }
            }
        }
    }
    return[
        'productoId'      => '0',  // El nombre de la sección
        'productoName'    => '',  // El nombre de la categoría
        'moduloId'        => '0',  // El nombre de la sección
        'moduloName'      => '',  // El nombre de la sección
        'transaccionName' => '',  // El nombre de la acción
        'transaccionIn'   => false
    ]; // Si no se encuentra el idTransaccion
}

