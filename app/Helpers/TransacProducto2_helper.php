<?php
//http://192.168.100.8/HCbpms/empresa/index/2-220101

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// listas - manteninmiento catalogos
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function ConfigTransacc220101(){         
    $tablao = 'hc.clista';
    $produc = '2';
    $transa = '220101';

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
    
    $botoo = [
        ['title' => 'Datos', 'proceso' => "carga('" . base_url() . "empresa/Edatos','filtro');", 'contene' => 'ESTEMP', 'imagen' => './app/Views/empresa/images/Ppush.png']
    ];
    
    $comboo = [];
    
    //$datoo = '2-220101|0|1|1|catalogo';
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
        [ 'LISTA'  , 'lista'      , 'TXT', '3', '1', '1|0|1|0|0|0|0|0|0|', '-E SECUENCIA admin.clista-' ,'trim|required', '', 'size="3" style="width:100%" required readonly'],
        [ 'NOMBRE' , 'Nombre'     , 'TXT', '3', '0', '1|1|1|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="3" style="width:100%" required readonly'],
        [ 'DESCRIP', 'Descripcion', 'TXT', '3', '0', '1|1|1|0|0|0|0|0|0|', ''                           ,'trim|required', '', 'size="3" style="width:100%" required readonly'],
        [ 'ESTADO' , 'Estado'     , 'CBO', '3', '0', '1|1|1|0|0|1|BAI--|0|0|', ''                           ,'trim|required', '', 'size="3" style="width:100%" required readonly'],
    ];
    
    $filtroo  = '';
    $filtroo_campos = '';
    $importao = '';
    $importao_campos='';
    $camposboto = '';
    $camposboto_campos = '';
    
    $camposdeto = [
        [
            'title' => 'detalle-lista',
            'tabla' => 'hc.dlista',
            'where' => [],
            'relacion' => ['LISTA' => 'LISTA'],
            'join' => [],
            'sp'=>[],
            'prm' => 'dlista|pr_con_dlista|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1||admin.dlista', 
            'cmp' => []
        ]
    ];
    
    $camposdeto_campos = [[
        [ 'LISTA'  , 'lista'  , 'TXT', '3' , '1',  '1|1|1|0|0|0|0|0|0|','', 'trim|required', '', 'size="3" style="width:100%" required readonly'],
        [ 'CODIGO' , 'codigo' , 'TXT', '3' , '1',  '1|1|1|0|0|0|0|0|0|','', 'trim|required', '', 'size="3" style="width:100%" required readonly'],
        [ 'NOMBRE' , 'Nombre' , 'TXT', '3' , '0',  '1|1|1|0|0|0|0|0|0|','', 'trim|required', '', 'size="3" style="width:100%" required readonly'],
        [ 'NOMBRE1', 'Nombre1', 'TXT', '3' , '0',  '1|1|1|0|0|0|0|0|0|','', 'trim|required', '', 'size="3" style="width:100%" required readonly'],
        [ 'NOMBRE2', 'Nombre2', 'TXT', '3' , '0',  '1|1|1|0|0|0|0|0|0|','', 'trim|required', '', 'size="3" style="width:100%" required readonly'],
        [ 'ESTADO' , 'Estado' , 'CBO', '3' , '0',  '1|1|1|0|0|1|BAI--|0|0|','', 'trim|required', '', 'size="3" style="width:100%" required readonly'],
    ]];


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


// http://192.168.100.8/HCbpms/empresa/index/2-220103

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// clientes - mantenimiento clientes
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function ConfigTransacc220102()
{
    $tablao = 'hc.cliente';
    $produc = '2';
    $transa = '220102';

    $structo = [
        ['base' => 'admin', 'nombre' => 'cliente', 'metodo' => '0|0|0|0', 'join' => ''],
        ['base' => 'admin', 'nombre' => 'nomina_cliente', 'metodo' => '0|0|0|0', 'join' => ['codigo' => 'codcli']]
    ];

    $modelo = [
        'lista'     => '',
        'consulta'  => '',
        'ingreso'   => '',
        'actualiza' => '',
        'elimina'   => ''
    ];

    $botoo = [
        [
            'title'   => 'Datos',
            'proceso' => "carga('" . base_url() . "empresa/Edatos','filtro');",
            'contene' => 'ESTEMP',
            'imagen'  => './app/Views/empresa/images/Ppush.png'
        ]
    ];

    $comboo = [];

    $datoo = $produc . '-' . $transa . '|0|1|1|catalogo';

    $camposo = [
        'tabla' => $tablao,
        'prm'   => 'cliente|sp_grb_cliente|cliente||admin.cliente',
        'cmp'   => [],
        'btn'   => [
            [
                'title'    => 'Actualiza',
                'procesoa' => "add_person('N','N');carga('" . base_url() . "empresa/actualizar/",
                'procesob' => "','contenidom');",
                'id'       => 'lnk_act',
                'men'      => 'a'
            ],
            [
                'title'    => 'Elimina',
                'procesoa' => "if (eliminar() == true) { carga('" . base_url() . "empresa/eliminar/",
                'procesob' => "','filtro');}",
                'id'       => 'lnk_eli',
                'men'      => 'e'
            ]
        ]
    ];

    $camposo_campos = [
        ['CODIGO'   , 'Codigo'        , 'TXT', '5'  , '1', '1|0|1|0|0|0|0|0|0|', '-E SECUENCIA hc.cliente-' , 'trim|required', '', 'size="5" style="width:100%" required readonly'],
        ['TPNUC'    , 'Tipo Doc.'     , 'CBO', '3'  , '0', '1|1|1|0|0|1|TIPOID--|0|0|' , '' , 'trim|required', '', 'style="width:100%" required'],
        ['NUC'      , 'Identificacion', 'TXT', '20' , '0', '1|1|1|0|0|0|0|0|0|' , '' , 'trim|required', '', 'size="20" style="width:100%" required'],
        ['NOMBRE'   , 'Nombre'        , 'TXT', '200', '0', '1|1|1|0|0|0|0|0|0|' , '' , 'trim|required', '', 'size="80" style="width:100%" required'],
        ['COMERCIAL', 'Comercial'     , 'TXT', '200', '0', '1|1|1|0|0|0|0|0|0|' , '' , 'trim', '', 'size="80" style="width:100%"'],
        ['DIREC'    , 'Direccion'     , 'TXT', '500', '0', '1|1|1|0|0|0|0|0|0|' , '' , 'trim', '', 'size="100" style="width:100%"'],
        ['TELEF'    , 'Telefono'      , 'TXT', '50' , '0', '1|1|1|0|0|0|0|0|0|' , '' , 'trim', '', 'size="20" style="width:100%"'],
        ['CORREO'   , 'Correo'        , 'TXT', '100', '0', '0|1|1|0|0|0|0|0|0|' , '' , 'trim|valid_email', '', 'size="60" style="width:100%"'],
        ['TPPERS'   , 'Tipo Persona'  , 'CBO', '3'  , '0', '1|1|1|0|0|1|TPPERS--|0|0|' , '' , 'trim', '', 'style="width:100%"'],
        ['TPCLI'    , 'Tipo Cliente'  , 'CBO', '3'  , '0', '1|1|1|0|0|1|TPCLI--|0|0|' , '' , 'trim', '', 'style="width:100%"'],
        ['ESTADO'   , 'Estado'        , 'CBO', '2'  , '0', '1|1|1|0|0|1|BAI--|0|0|' , '' , 'trim|required', '', 'style="width:100%" required'],
        ['REFTRAN'  , 'Referencia'    , 'TXT', '200', '0', '1|1|1|0|0|0|0|0|0|' , '' , 'trim', '', 'size="80" style="width:100%"'],
        ['CORREOF'  , 'Correo Fact.'  , 'TXT', '500', '0', '0|1|1|0|0|0|0|0|0|' , '' , 'trim', '', 'size="80" style="width:100%"'],
        ['FEREPO'   , 'Reporte'       , 'CBO', '3'  , '0', '0|1|1|0|0|1|SINO--|0|0|' , '' , 'trim', '', 'style="width:100%"'],
        ['CORREOL'  , 'Correo Lista'  , 'TXT', '500', '0', '0|1|1|0|0|0|0|0|0|' , '' , 'trim', '', 'size="80" style="width:100%"'],
    ];

    $filtroo = '';

    $filtroo_campos = '';

    $importao = '';
    $importao_campos = '';

    $camposboto = '';
    $camposboto_campos = '';

    $camposdeto = [
        [
            'title'    => 'nomina-cliente',
            'tabla'    => 'hc.nomina_cliente',
            'where'    => [],
            'relacion' => ['CODCLI' => 'CODIGO'],
            'join'     => [],
            'sp'       => [],
            'prm'      => 'nomina_cliente|sp_grb_nomina_cliente|nomina_cliente||admin.nomina_cliente',
            'cmp'      => []
        ]
    ];

    $camposdeto_campos = [[
        ['SEC'     , 'Sec'       , 'TXT', '10', '1', '1|1|1|0|0|0|0|0|0|', '-E SECUENCIA hc.nomina_cliente-', 'trim|required', '', 'size="10" style="width:100%" required readonly'],
        ['CODCLI'  , 'Cliente'   , 'TXT', '5' , '1', '1|1|1|0|0|0|0|0|0|', '', 'trim|required', '', 'size="5" style="width:100%" required readonly'],
        ['EMPRESA' , 'Empresa'   , 'TXT', '3' , '0', '1|1|1|0|0|0|0|0|0|', '', 'trim|required', '', 'size="3" style="width:100%" required'],
        ['SUCURSAL', 'Sucursal'  , 'TXT', '3' , '0', '1|1|1|0|0|0|0|0|0|', '', 'trim', '', 'size="3" style="width:100%"'],
        ['DEPART'  , 'Depart.'   , 'TXT', '3' , '0', '1|1|1|0|0|0|0|0|0|', '', 'trim', '', 'size="3" style="width:100%"'],
        ['CARGO'   , 'Cargo'     , 'TXT', '3' , '0', '1|1|1|0|0|0|0|0|0|', '', 'trim', '', 'size="3" style="width:100%"'],
        ['SALARIO' , 'Salario'   , 'TXT', '10', '0', '1|1|1|0|0|0|0|0|0|', '', 'trim', '', 'size="10" style="width:100%"'],
        ['FCHING'  , 'Fch Ingreso', 'TXT', '10', '0', '1|1|1|0|0|0|0|0|0|', '', 'trim', '', 'type="date" style="width:100%"'],
        ['FCHSAL'  , 'Fch Salida' , 'TXT', '10', '0', '1|1|1|0|0|0|0|0|0|', '', 'trim', '', 'type="date" style="width:100%"'],
        ['CTABANCO', 'Cta Banco' , 'TXT', '60', '0', '1|1|1|0|0|0|0|0|0|', '', 'trim', '', 'size="60" style="width:100%"'],
        ['ESTADO'  , 'Estado'    , 'CBO', '2' , '0', '1|1|1|0|0|1|BAI--|0|0|', '', 'trim|required', '', 'style="width:100%" required'],
        ['REFER'   , 'Referencia', 'TXT', '20', '0', '1|1|1|0|0|0|0|0|0|', '', 'trim', '', 'size="20" style="width:100%"'],
        ['APORTE'  , 'Aporte'    , 'CBO', '2' , '0', '1|1|1|0|0|1|SINO--|0|0|', '', 'trim', '', 'style="width:100%"'],
    ]];

    $structo = json_decode(json_encode($structo, JSON_FORCE_OBJECT));

    $config['r_struct']    = $structo;
    $config['r_boto']      = $botoo;
    $config['r_combo']     = $comboo;
    $config['r_dato']      = $datoo;
    $config['r_tabla']     = $tablao;
    $config['r_campos']    = $camposo;
    $config['r_filtros']   = $filtroo;
    $config['r_camposdet'] = $camposdeto;
    $config['r_camposbot'] = $camposboto;
    $config['r_importa']   = $importao;
    $config['r_modelo']    = $modelo;

    $config['campos']['camposo_campos']    = $camposo_campos;
    $config['campos']['camposboto_campos'] = $camposboto_campos;
    $config['campos']['camposdeto_campos'] = $camposdeto_campos;
    $config['campos']['importao_campos']   = $importao_campos;
    $config['campos']['filtroo_campos']    = $filtroo_campos;

    return $config;
}