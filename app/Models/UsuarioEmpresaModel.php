<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioEmpresaModel extends Model
{
    protected $table            = 'admin_usuario_empresa';
    protected $primaryKey       = null;
    protected $returnType       = 'array';
    protected $useAutoIncrement = false;

    protected $allowedFields = [
        'IDUSUARIO',
        'IDEMPRESA',
        'TIPO',
        'ESTADO',
        'REFERENCIA',
        'USUCRA',
        'FCHCREA',
        'USUMODIF',
        'FCHMODIF'
    ];

    public function getEmpresasUsuario($idUsuario): array
    {
        return $this->db->table($this->table . ' ue')
            ->select('ue.IDUSUARIO, ue.IDEMPRESA, ue.TIPO, ue.ESTADO, ue.REFERENCIA, c.COMERCIAL AS NOMEMPRESA')
            ->join('hc.cliente c', 'ue.IDEMPRESA = c.CODIGO')
            ->where('ue.IDUSUARIO', $idUsuario)
            ->where('ue.ESTADO', 'A')
            ->orderBy("CASE WHEN ue.TIPO = 'D' THEN 0 ELSE 1 END", '', false)
            ->orderBy('ue.IDEMPRESA', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getEmpresaDefault(array $empresas): ?array
    {
        if (empty($empresas)) {
            return null;
        }

        foreach ($empresas as $empresa) {
            if (($empresa['TIPO'] ?? '') === 'D') {
                return $empresa;
            }
        }

        return $empresas[0] ?? null;
    }
}