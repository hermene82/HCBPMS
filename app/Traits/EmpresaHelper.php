<?php

namespace App\Traits;

trait EmpresaHelper
{
    protected function obtenerIndiceDesdeUri($pos = 3): string
    {
        $indice = service('uri')->getSegment($pos);
        $this->_param($indice);
        return $indice;
    }

    protected function obtenerCampos($tipo = '', $indice = 0)
    {
        switch ($tipo) {
            case 'D':
                return $this->config->r_camposdet[$indice]['cmp'] ?? [];
            case 'B':
                return $this->config->r_camposbot[$indice]['cmp'] ?? [];
            default:
                return $this->config->r_campos['cmp'] ?? [];
        }
    }

    protected function generarIdDesdeIndex($index, $estructura)
    {
        $valores = explode("--", $index);
        array_pop($valores);

        $campos = explode("|", $estructura);
        array_pop($campos);

        return array_combine($campos, $valores);
    }

    protected function procesarCombosMultiples(array &$data, array $campos): void
    {
        foreach ($campos as $campo) {
            $nombre = $campo['campo'];
            foreach ($campo as $elem) {
                if (is_array($elem) && $elem['tipo'] === 'cbo') {
                    if (strpos($elem['attr']['attr'] ?? '', 'multiple="multiple"') !== false && isset($data[$nombre]) && is_array($data[$nombre])) {
                        $data[$nombre] = implode("|", $data[$nombre]);
                    }
                }
            }
        }
    }

    protected function completarCamposEspeciales(array &$data, array $campos): void
    {
        foreach ($campos as $campo) {
            $_prm = explode('-', $campo['esp'] ?? '');
            if (count($_prm) > 1 && $_prm[1] !== '') {
                if (strpos($_prm[1], 'SECUENCIA') !== false) {
                    $_prm[1] .= '|' . $campo['campo'];
                }
                if (!array_key_exists($campo['campo'], $data)) {
                    $data[$campo['campo']] = $this->datoD($_prm[1], 'E');
                }
            }
        }
    }

    protected function responderJson($respuesta)
    {
        return $this->response->setJSON($respuesta);
    }
}
