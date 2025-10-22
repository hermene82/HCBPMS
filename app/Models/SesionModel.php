<?php

namespace App\Models;

use CodeIgniter\Model;

class SesionModel extends Model
{
    protected $table      = 'admin_sesion';
    protected $primaryKey = 'IDSESION';

    protected $allowedFields = [
        'IDEMPRESA',
        'IDUSUARIO',
        'TOKEN',
        'IPADDRESS',
        'MAQUINA',
        'ESTADO',
        'REFERENCIA',
        'FCHINI',
        'FCHFIN',
        'USUCREA',
        'FCHCREA',
        'USUMODIF',
        'FCHMODIF',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'FCHCREA';
    protected $updatedField  = 'FCHMODIF';
    protected $dateFormat    = 'datetime';

    // Método para buscar sesiones activas de un usuario
    public function findActiveSession($userId)
    {
        return $this->where(['IDUSUARIO' => $userId, 'ESTADO' => 'A'])->first();
    }

    // Método para cerrar sesiones activas de un usuario
    public function closeUserSessions($userId)
    {
        $this->where(['IDUSUARIO' => $userId, 'ESTADO' => 'A'])
             ->set(['FCHFIN' => date('Y-m-d H:i:s')])
             ->update();
    }
}