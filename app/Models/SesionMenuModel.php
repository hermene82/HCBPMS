<?php

namespace App\Models;

use CodeIgniter\Model;

class SesionMenuModel extends Model
{
    protected $table      = 'admin_sesionmenu';
    protected $primaryKey = 'IDSESIONMENU';

    protected $allowedFields = [
        'IDSESION',
        'IDTRANSACCION',
        'ACCESO',
        'ACCION',
        'ESTADO',
        'REFERENCIA',
        'USUCRA',
        'FCHCREA',
        'USUMODIF',
        'FCHMODIF',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'FCHCREA';
    protected $updatedField  = 'FCHMODIF';
    protected $dateFormat    = 'datetime';

    // Método para registrar un acceso al menú
    public function logMenuAccess($sessionId, $transactionId, $action)
    {
        $data = [
            'IDSESION'     => $sessionId,
            'IDTRANSACCION' => $transactionId,
            'ACCION'       => $action,
            'ESTADO'       => 'A',
            'ACCESO'       => date('Y-m-d H:i:s'),
            'USUCRA'       => 'system', // Usuario o sistema que registra el acceso
        ];

        return $this->insert($data);
    }

        /**
     * Poblar la tabla SESIONMENU con los permisos del usuario.
     */
    public function poblarSesionMenu($idEmpresa, $idUsuario, $idSesion)
    {
        $db = \Config\Database::connect();

        try {
            // Obtener los roles del usuario
            $sqlRoles = "SELECT IDROL FROM ADMIN_ROL_USUARIO WHERE IDEMPRESA = ? AND IDUSUARIO = ?";
            $roles = $db->query($sqlRoles, [$idEmpresa, $idUsuario])->getResultArray();

            if (empty($roles)) {
                throw new \Exception("El usuario no tiene roles asignados.");
            }

            // Obtener los permisos asociados a los roles
            $sqlPermisos = "SELECT DISTINCT IDTRANSACCION, PERMISO 
                            FROM ADMIN_ROL_PERMISO 
                            WHERE IDEMPRESA = ? AND IDROL IN (" . implode(',', array_column($roles, 'IDROL')) . ")";

            $permisos = $db->query($sqlPermisos, [$idEmpresa])->getResultArray();

            if (empty($permisos)) {
                throw new \Exception("No hay permisos asignados a los roles del usuario.");
            }

            // Insertar los accesos en SESIONMENU
            foreach ($permisos as $permiso) {
                $this->logMenuAccess($idSesion, $permiso['IDTRANSACCION'], $permiso['PERMISO']);
            }

            return "Sesión de menú poblada correctamente para el usuario $idUsuario.";

        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

//    public function getMenuByUser($sessionId)
//    {
//        return $this->db->table('SESIONMENU sm')
//            ->select('t.NOMBRE, t.RUTA')
//            ->join('TRANSACCION t', 'sm.IDTRANSACCION = t.IDTRANSACCION')
//            ->where('sm.IDSESION', $sessionId)
//            ->where('sm.ESTADO', 'A')
//            ->groupBy('t.NOMBRE, t.RUTA')
//            ->get()
//            ->getResultArray();
//    }

    public function getMenuByUser($sessionId)
    {
        $results = $this->db->table('ADMIN_SESIONMENU sm')
            ->select('p.NOMBRE NOMBRE_PRODUCTO, m.NOMBRE NOMBRE_MODULO, t.NOMBRE, t.RUTA, t.IDTRANSACCION, t.IDPRODUCTO, t.IDMODULO') // Agrega los campos necesarios
            ->join('ADMIN_TRANSACCION t', 'sm.IDTRANSACCION = t.IDTRANSACCION')
            ->join('ADMIN_MODULO m', 't.IDMODULO = m.IDMODULO', 'left') // Une con la tabla MODULO si es necesario
            ->join('ADMIN_PRODUCTO p', 't.IDPRODUCTO = p.IDPRODUCTO', 'left')
            ->where('sm.IDSESION', $sessionId)
            ->where('sm.ESTADO', 'A')
            ->where('t.ESTADO', 'A')
            ->where('m.ESTADO', 'A')
            ->where('p.ESTADO', 'A')
            ->groupBy('p.NOMBRE , m.NOMBRE ,t.NOMBRE, t.RUTA, t.IDTRANSACCION, t.IDPRODUCTO, t.IDMODULO') // Agrupar correctamente
            ->get()
            ->getResultArray();

            $menu = [];

            foreach ($results as $row) {
                $producto = $row['NOMBRE_PRODUCTO'];
                $modulo   = $row['NOMBRE_MODULO'];
                $transaccion = ['nombre' => $row['NOMBRE'], 'ruta' => $row['RUTA'], 'idTransaccion' => $row['IDTRANSACCION'],'idProducto' => $row['IDPRODUCTO'],'idModulo' => $row['IDMODULO']];
        
                if (!isset($menu[$producto])) {
                    $menu[$producto] = [];
                }
                if (!isset($menu[$producto][$modulo])) {
                    $menu[$producto][$modulo] = [];
                }
        
                $menu[$producto][$modulo][] = $transaccion;
            }
        
            return $menu;        
    }
}
