<?php
//http://192.168.100.8/HCbpms/empresa/index/2-220101

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// transaccion - manteninmiento producto modulo transaccion
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function ConfigTransacc110102(){

    $tablao = 'hc.admin_transaccion';
    $produc = '1';
    $transa = '110102';

    $structo = [
        ['base' => 'admin', 'nombre' => 'clista', 'metodo' => '0|0|0|0', 'join' => ''],
        ['base' => 'admin', 'nombre' => 'dlista', 'metodo' => '0|0|0|0', 'join' => ['lista' => 'lista']]
    ];

    $modelo = [
        'lista'     => '',
        'consulta'  => '',
        'ingreso'   => '',
        'actualiza' => '',
        'elimina'   => ''
    ];
    
    $botoo = '';
    
    $comboo = [];
    
    $datoo = $produc.'-'.$transa.'|0|1|1|catalogo';
    
    $camposo = [
        'tabla' => $tablao,
        'prm' => 'clista|sp_grb_clista|clista||admin.clista',
        'cmp' => [],
        'btn' => [
            ['title' => 'Actualiza', 'procesoa' => "add_person('N','N');carga('" . base_url() . "empresa/actualizar/",'procesob' =>"','contenidom');", 'id' => 'lnk_act', 'men' => 'a'],             
            ['title' => 'Elimina', 'procesoa' => "if (eliminar() == true) { carga('" . base_url() . "empresa/eliminar/", 'procesob' => "','filtro');}", 'id' => 'lnk_eli', 'men' => 'e']
        ]
    ];

    $camposo_campos = [
        [ 'IDTRANSACCION'	, 'Transacion', 'TXT', '10' , '1', '1|1|1|0|0|0|0|0|0|',          ''                  ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'IDPRODUCTO'		, 'Producto'  , 'CBO', '10' , '0', '1|1|1|0|0|1|PRODUCTO--|0|0|', ''                  ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'IDMODULO'		, 'moodulo'   , 'CBO', '10' , '0', '1|1|1|0|0|1|MODULO--|0|0|', ''                    ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'NOMBRE'			, 'Nombre'    , 'TXT', '200', '0', '1|1|1|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'DESCRIPCION'		, 'Descrip'   , 'TXT', '200', '0', '0|1|1|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'RUTA'			, 'Ruta'      , 'TXT', '500', '0', '1|1|1|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'PERMISO'		    , 'Permiso'   , 'CBO', '100', '0', '1|1|1|0|0|0|PER--|0|0|', ''                       ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'REFERENCIA'		, 'Refer'     , 'TXT', '200', '0', '0|1|1|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'ESTADO'			, 'Estado'    , 'CBO', '3'  , '0', '1|1|1|0|0|1|BAI--|0|0|', ''                       ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'USUCRA'			, 'Nombre'    , 'TXT', '100', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'FCHCREA'			, 'Nombre'    , 'TXT', '20' , '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'USUMODIF'		, 'Nombre'    , 'TXT', '100', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'FCHMODIF'		, 'Nombre'    , 'TXT', '20' , '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        ];

    $camposboto = [
        [
            'btnn' => '1',
            'title' => 'PRODUCTOS',
            'tabla' => 'hc.admin_producto',
            'where' => [],
            'prm' => 'mensajes|pr_con_rol_roles|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1|-E PROCESO DFAC-',
            'cmp' => [],
            'btn' => [
                ['title' => 'Actualiza', 'procesoa' => "add_person('N','N');carga('".base_url()."empresa/actualizar/", 'procesob' => "','contenidom');", 'id' => 'lnk_act', 'men' => 'a'],
                ['title' => 'Elimina', 'procesoa' => "if (eliminar() == true) { carga('".base_url()."empresa/eliminar/", 'procesob' => "','filtro');}", 'id' => 'lnk_eli', 'men' => 'e']
            ]
        ],
        [
            'btnn' => '1',
            'title' => 'MODULOS',
            'tabla' => 'hc.admin_modulo',
            'where' => [],
            'prm' => 'dlista|pr_con_rol_roles|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1 ',
            'cmp' => [],
            'btn' => [
                ['title' => 'Actualiza', 'procesoa' => "add_person('N','N');carga('".base_url()."empresa/actualizar/", 'procesob' => "','contenidom');", 'id' => 'lnk_act', 'men' => 'a'],
                ['title' => 'Elimina', 'procesoa' => "if (eliminar() == true) { carga('".base_url()."empresa/eliminar/", 'procesob' => "','filtro');}", 'id' => 'lnk_eli', 'men' => 'e']
            ]
        ]
    ];
    $camposboto_campos = [
        [ // Primer bloque de campos
            [ 'IDPRODUCTO'		, 'Producto'  , 'TXT', '10', '1', '1|1|1|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'NOMBRE'			, 'Nombre'    , 'TXT', '200', '0', '1|1|1|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'DESCRIPCION'		, 'Descrip'   , 'TXT', '200', '0', '1|1|1|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'REFERENCIA'		, 'Refer'     , 'TXT', '200', '0', '1|1|1|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'ESTADO'			, 'Estado'    , 'CBO', '3', '0', '1|1|1|0|0|1|BAI--|0|0|', ''                       ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'USUCRA'			, 'Nombre'    , 'TXT', '20', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'FCHCREA'			, 'Nombre'    , 'TXT', '20', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'USUMODIF'		, 'Nombre'    , 'TXT', '20', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'FCHMODIF'		, 'Nombre'    , 'TXT', '20', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        ],
        [ // Segundo bloque de campos
            [ 'IDMODULO'		, 'Producto'  , 'TXT', '10', '1', '1|1|1|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'IDPRODUCTO'		, 'Producto'  , 'CBO', '10', '0', '1|1|1|0|0|1|PRODUCTO--|0|0|', ''                  ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'NOMBRE'			, 'Nombre'    , 'TXT', '100', '0', '1|1|1|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'DESCRIPCION'		, 'Descrip'   , 'TXT', '100', '0', '1|1|1|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'REFERENCIA'		, 'Refer'     , 'TXT', '100', '0', '1|1|1|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'ESTADO'			, 'Estado'    , 'CBO', '3', '0', '1|1|1|0|0|1|BAI--|0|0|', ''                       ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'USUCRA'			, 'Nombre'    , 'TXT', '20', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'FCHCREA'			, 'Nombre'    , 'TXT', '20', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'USUMODIF'		, 'Nombre'    , 'TXT', '20', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'FCHMODIF'		, 'Nombre'    , 'TXT', '20', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        ]
    ];
        
    
    $filtroo  = '';
    $filtroo_campos = '';
    $importao = '';
    $importao_campos='';    
    $camposdeto = "";    
    $camposdeto_campos = "";

    $structo = json_decode(json_encode($structo, JSON_FORCE_OBJECT));

$config['r_struct'] = $structo;
$config['r_boto']   = $botoo;
$config['r_combo']  = $comboo;
$config['r_dato']   = $datoo;
$config['r_tabla']  = $tablao;
$config['r_campos'] = $camposo;
$config['r_filtros']   = $filtroo;
$config['r_camposdet'] = $camposdeto;
$config['r_camposbot'] = $camposboto;
$config['r_importa']   = $importao;
$config['r_modelo']   = $modelo;

$config['campos']['camposo_campos'] = $camposo_campos;
$config['campos']['camposboto_campos'] = $camposboto_campos;
$config['campos']['camposdeto_campos'] = $camposdeto_campos;
$config['campos']['importao_campos'] = $importao_campos;
$config['campos']['filtroo_campos'] = $filtroo_campos;

return $config;

}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// usuario - manteninmiento usuario rol roltransaccion  usuarioRol
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function ConfigTransacc110101(){

    $tablao = 'hc.admin_usuario';
    $produc = '1';
    $transa = '110101';

    $structo = [
        ['base' => 'admin', 'nombre' => 'clista', 'metodo' => '0|0|0|0', 'join' => ''],
        ['base' => 'admin', 'nombre' => 'dlista', 'metodo' => '0|0|0|0', 'join' => ['lista' => 'lista']]
    ];

    $modelo = [
        'lista'     => '',
        'consulta'  => '',
        'ingreso'   => '',
        'actualiza' => '',
        'elimina'   => ''
    ];
    
    $botoo = '';
    
    $comboo = [];
    
    $datoo = $produc.'-'.$transa.'|0|1|1|catalogo';
    
    $camposo = [
        'tabla' => $tablao,
        'prm' => 'clista|sp_grb_clista|clista||admin.clista',
        'cmp' => [],
        'btn' => [
            ['title' => 'Actualiza', 'procesoa' => "add_person('N','N');carga('" . base_url() . "empresa/actualizar/",'procesob' =>"','contenidom');", 'id' => 'lnk_act', 'men' => 'a'],             
            ['title' => 'Elimina', 'procesoa' => "if (eliminar() == true) { carga('" . base_url() . "empresa/eliminar/", 'procesob' => "','filtro');}", 'id' => 'lnk_eli', 'men' => 'e']
        ]
    ];

    $camposo_campos = [
        [ 'ID'	     , 'ID'      , 'TXT', '10',  '1', '1|0|1|0|0|0|0|0|0|', '-E SECUENCIA '.$tablao.'-'  ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'USER'	 , 'Usuario' , 'TXT', '20',  '0', '1|1|1|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'PASSWORD' , 'clave'   , 'TXT', '60',  '0', '0|1|1|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'NAME'	 , 'Nombre'  , 'TXT', '200', '0', '1|1|1|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'EMAIL'	 , 'Correo'  , 'TXT', '200', '0', '0|1|1|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        //[ 'ESTADO'	 , 'Estado'  , 'CBO', '1',   '0', '1|1|1|0|0|0|BAI--|0|0|', ''                       ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        ];

    $camposboto = [
        [
            'btnn' => '1',
            'title' => 'ROL',
            'tabla' => 'hc.admin_rol',
            'where' => [],
            'prm' => 'mensajes|pr_con_rol_roles|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1|-E PROCESO DFAC-',
            'cmp' => [],
            'btn' => [
                ['title' => 'Actualiza', 'procesoa' => "add_person('N','N');carga('".base_url()."empresa/actualizar/", 'procesob' => "','contenidom');", 'id' => 'lnk_act', 'men' => 'a'],
                ['title' => 'Elimina', 'procesoa' => "if (eliminar() == true) { carga('".base_url()."empresa/eliminar/", 'procesob' => "','filtro');}", 'id' => 'lnk_eli', 'men' => 'e']
            ]
        ],
        [
            'btnn' => '1',
            'title' => 'ROL-TRANSACCION',
            'tabla' => 'hc.admin_rol_permiso',
            'where' => [],
            'prm' => 'dlista|pr_con_rol_roles|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1 ',
            'cmp' => [],
            'btn' => [
                ['title' => 'Actualiza', 'procesoa' => "add_person('N','N');carga('".base_url()."empresa/actualizar/", 'procesob' => "','contenidom');", 'id' => 'lnk_act', 'men' => 'a'],
                ['title' => 'Elimina', 'procesoa' => "if (eliminar() == true) { carga('".base_url()."empresa/eliminar/", 'procesob' => "','filtro');}", 'id' => 'lnk_eli', 'men' => 'e']
            ]
        ]
    ];
    $camposboto_campos = [
        [ // Primer bloque de campos
            [ 'IDROL'		    , 'Rol'       , 'TXT', '10', '1', '1|1|1|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'IDEMPRESA'       , 'Empresa'   , 'CBO', '10', '1', '1|1|1|0|0|1|EMPRESA--|0|0|', ''                   ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'NOMBRE'			, 'Nombre'    , 'TXT', '200','0', '1|1|1|0|0|0|0|0|0|', ''                          ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'DESCRIPCION'		, 'Descrip'   , 'TXT', '200','0', '1|1|1|0|0|0|0|0|0|', ''                          ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'REFERENCIA'		, 'Refer'     , 'TXT', '200','0', '1|1|1|0|0|0|0|0|0|', ''                          ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'ESTADO'			, 'Estado'    , 'CBO', '1',  '0', '1|1|1|0|0|1|BAI--|0|0|', ''                        ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'USUCRA'			, 'Nombre'    , 'TXT', '20', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'FCHCREA'			, 'Nombre'    , 'TXT', '20', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'USUMODIF'		, 'Nombre'    , 'TXT', '20', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'FCHMODIF'		, 'Nombre'    , 'TXT', '20', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        ],
        [ // Segundo bloque de campos
            [ 'IDEMPRESA'		, 'Producto'  , 'CBO', '10', '1', '1|1|1|0|0|1|EMPRESA--|0|0|', ''                   ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'IDROL'		    , 'Producto'  , 'CBO', '10', '1', '1|1|1|0|0|1|ROL--|0|0|', ''                       ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'IDTRANSACCION'	, 'Nombre'    , 'CBO', '10', '1', '1|1|1|0|0|1|TRANSACCION--|0|0|', ''               ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'PERMISO'		    , 'Descrip'   , 'TXT', '10', '0', '1|1|1|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'REFERENCIA'		, 'Refer'     , 'TXT', '200','0', '1|1|1|0|0|0|0|0|0|', ''                          ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'ESTADO'			, 'Estado'    , 'CBO', '1',  '0', '1|1|1|0|0|1|BAI--|0|0|', ''                        ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'USUCRA'			, 'Nombre'    , 'TXT', '20', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'FCHCREA'			, 'Nombre'    , 'TXT', '20', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'USUMODIF'		, 'Nombre'    , 'TXT', '20', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
            [ 'FCHMODIF'		, 'Nombre'    , 'TXT', '20', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        ]
    ];
        
    
    $filtroo  = '';
    $filtroo_campos = '';
    $importao = '';
    $importao_campos='';      
    
    $camposdeto = [
        [
            'title' => 'Usuario-Rol',
            'tabla' => 'hc.admin_rol_usuario',
            'where' => [],
            'relacion' => ['ID' => 'IDUSUARIO'],
            'join' => [],
            'sp'=>[],
            'prm' => 'dlista|pr_con_dlista|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1||admin.dlista', 
            'cmp' => []
        ],
        [
            'title' => 'Usuario-Empresa',
            'tabla' => 'hc.admin_usuario_empresa',
            'where' => [],
            'relacion' => ['ID' => 'IDUSUARIO'],
            'join' => [],
            'sp'=>[],
            'prm' => 'dlista|pr_con_dlista|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1||admin.dlista', 
            'cmp' => []
        ]

    ];
    
    $camposdeto_campos = [
        [
        [ 'IDROLUSUARIO'    , 'Id'        , 'TXT', '3', '1', '1|1|1|0|0|0|0|0|0|', ''                       ,'trim|required', '', 'size="30" style="width:100%" required readonly'],    
        [ 'IDEMPRESA'		, 'Empresa'   , 'CBO', '3', '0', '1|1|1|0|0|1|EMPRESA--|0|0|', ''                   ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'IDROL'		    , 'Rol'       , 'CBO', '3', '0', '1|1|1|0|0|1|ROL--|0|0|', ''                       ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'IDUSUARIO'		, 'Usuario'   , 'CBO', '3', '0', '1|1|1|0|0|1|USUARIO--|0|0|', ''                   ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'REFERENCIA'		, 'Refer'     , 'TXT', '3', '0', '1|1|1|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'ESTADO'			, 'Estado'    , 'CBO', '3', '0', '1|1|1|0|0|1|BAI--|0|0|', ''                       ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'USUCRA'			, 'Nombre'    , 'TXT', '3', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'FCHCREA'			, 'Nombre'    , 'TXT', '3', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'USUMODIF'		, 'Nombre'    , 'TXT', '3', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'FCHMODIF'		, 'Nombre'    , 'TXT', '3', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        ],
        [
        [ 'IDUSUARIO'		, 'Usuario'   , 'CBO', '3', '1', '1|1|1|0|0|1|USUARIO--|0|0|', ''                   ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'IDEMPRESA'		, 'Empresa'   , 'CBO', '3', '1', '1|1|1|0|0|1|EMPRESA--|0|0|', ''                   ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'REFERENCIA'		, 'Refer'     , 'TXT', '3', '0', '1|1|1|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'ESTADO'			, 'Estado'    , 'CBO', '3', '0', '1|1|1|0|0|1|BAI--|0|0|', ''                       ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'USUCRA'			, 'Nombre'    , 'TXT', '3', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'FCHCREA'			, 'Nombre'    , 'TXT', '3', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'USUMODIF'		, 'Nombre'    , 'TXT', '3', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        [ 'FCHMODIF'		, 'Nombre'    , 'TXT', '3', '0', '0|0|0|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="30" style="width:100%" required readonly'],
        ]

    ];




    $structo = json_decode(json_encode($structo, JSON_FORCE_OBJECT));

$config['r_struct'] = $structo;
$config['r_boto']   = $botoo;
$config['r_combo']  = $comboo;
$config['r_dato']   = $datoo;
$config['r_tabla']  = $tablao;
$config['r_campos'] = $camposo;
$config['r_filtros']   = $filtroo;
$config['r_camposdet'] = $camposdeto;
$config['r_camposbot'] = $camposboto;
$config['r_importa']   = $importao;
$config['r_modelo']   = $modelo;

$config['campos']['camposo_campos'] = $camposo_campos;
$config['campos']['camposboto_campos'] = $camposboto_campos;
$config['campos']['camposdeto_campos'] = $camposdeto_campos;
$config['campos']['importao_campos'] = $importao_campos;
$config['campos']['filtroo_campos'] = $filtroo_campos;

return $config;

}
