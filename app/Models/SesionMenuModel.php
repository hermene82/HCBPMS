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

    public function logMenuAccess($sessionId, $transactionId, $action)
    {
        $data = [
            'IDSESION'      => $sessionId,
            'IDTRANSACCION' => $transactionId,
            'ACCION'        => $action,
            'ESTADO'        => 'A',
            'ACCESO'        => date('Y-m-d H:i:s'),
            'USUCRA'        => 'system',
        ];

        return $this->insert($data);
    }

    /**
     * Elimina el menú actual asociado a una sesión.
     */
    public function eliminarMenuSesion($idSesion): bool
    {
        return $this->where('IDSESION', $idSesion)->delete();
    }

    /**
     * Poblar la tabla ADMIN_SESIONMENU con los permisos del usuario.
     */
    public function poblarSesionMenu($idEmpresa, $idUsuario, $idSesion)
    {
        $db = \Config\Database::connect();

        try {
            // Limpiar menú previo de la sesión para evitar duplicados
            $this->eliminarMenuSesion($idSesion);

            // Obtener roles activos del usuario para la empresa
            $sqlRoles = "SELECT IDROL
                         FROM ADMIN_ROL_USUARIO
                         WHERE IDEMPRESA = ?
                           AND IDUSUARIO = ?
                           AND ESTADO = 'A'";

            $roles = $db->query($sqlRoles, [$idEmpresa, $idUsuario])->getResultArray();

            if (empty($roles)) {
                throw new \Exception("El usuario no tiene roles asignados para la empresa seleccionada.");
            }

            $rolesIds = array_column($roles, 'IDROL');
            $placeholders = implode(',', array_fill(0, count($rolesIds), '?'));

            // Obtener permisos activos asociados a los roles
            $sqlPermisos = "SELECT DISTINCT IDTRANSACCION, PERMISO
                            FROM ADMIN_ROL_PERMISO
                            WHERE IDEMPRESA = ?
                              AND ESTADO = 'A'
                              AND IDROL IN ($placeholders)";

            $paramsPermisos = array_merge([$idEmpresa], $rolesIds);

            $permisos = $db->query($sqlPermisos, $paramsPermisos)->getResultArray();

            if (empty($permisos)) {
                throw new \Exception("No hay permisos asignados a los roles del usuario.");
            }

            foreach ($permisos as $permiso) {
                $this->logMenuAccess(
                    $idSesion,
                    $permiso['IDTRANSACCION'],
                    $permiso['PERMISO']
                );
            }

            return "Sesión de menú poblada correctamente para el usuario $idUsuario.";
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function getMenuByUser($sessionId)
    {
        $results = $this->db->table('ADMIN_SESIONMENU sm')
            ->select('
                p.NOMBRE AS NOMBRE_PRODUCTO,
                m.NOMBRE AS NOMBRE_MODULO,
                t.NOMBRE,
                t.RUTA,
                t.IDTRANSACCION,
                t.IDPRODUCTO,
                t.IDMODULO
            ')
            ->join('ADMIN_TRANSACCION t', 'sm.IDTRANSACCION = t.IDTRANSACCION')
            ->join('ADMIN_MODULO m', 't.IDMODULO = m.IDMODULO', 'left')
            ->join('ADMIN_PRODUCTO p', 't.IDPRODUCTO = p.IDPRODUCTO', 'left')
            ->where('sm.IDSESION', $sessionId)
            ->where('sm.ESTADO', 'A')
            ->where('t.ESTADO', 'A')
            ->where('m.ESTADO', 'A')
            ->where('p.ESTADO', 'A')
            ->groupBy('p.NOMBRE, m.NOMBRE, t.NOMBRE, t.RUTA, t.IDTRANSACCION, t.IDPRODUCTO, t.IDMODULO')
            ->get()
            ->getResultArray();

        $menu = [];

        foreach ($results as $row) {
            $producto = $row['NOMBRE_PRODUCTO'];
            $modulo   = $row['NOMBRE_MODULO'];

            $transaccion = [
                'nombre'        => $row['NOMBRE'],
                'ruta'          => $row['RUTA'],
                'idTransaccion' => $row['IDTRANSACCION'],
                'idProducto'    => $row['IDPRODUCTO'],
                'idModulo'      => $row['IDMODULO'],
            ];

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