<?php

function ConfigTransacc440101(){

//=====================================================================================================================
$structo = [
    ['base'   => 'factura','nombre' => 'factura','metodo' => '0|0|0|0', 'join'   => ''],
    ['base'   => 'factura','nombre' => 'facdetalle','metodo' => '0|0|0|0', 'join'   => ['sec' => 'sec']]
];

//=====================================================================================================================
$botoo = [
    ['title'   => 'Datos','proceso' => "carga('" . base_url() . "empresa/Pdatos','filtro');",'contene' => 'ESTEMP','imagen'  => '../guia/application/views/empresa/images/Ppull.png'],
    ['title'   => 'Guias','proceso' => "carga('" . base_url() . "empresa/Pguias','filtro');",'contene' => 'ESTEMP','imagen'  => '../guia/application/views/empresa/images/pguias.png'],
    ['title'   => 'Costo','proceso' => "carga('" . base_url() . "empresa/Pcosto','filtro');",'contene' => 'ESTEMP','imagen'  => '../guia/application/views/empresa/images/pcosto.png'],
    ['title'   => 'Reporte','proceso' => "add_person('N','S');cargaRpt('" . base_url() . "empresa/Preporteqx','contenidom');",'contene' => 'ESTEMP','imagen'  => '../guia/application/views/empresa/images/reportes.png'],
    ['title'   => 'Unidas','proceso' => "add_person('N','S');cargaRpt('" . base_url() . "empresa/Preporteun','contenidom');",'contene' => 'ESTEMP','imagen'  => '../guia/application/views/empresa/images/reportes.png'],
    ['title'   => 'Difare','proceso' => "add_person('N','S');cargaRpt('" . base_url() . "empresa/Preportedif','contenidom');",'contene' => 'ESTEMP','imagen'  => '../guia/application/views/empresa/images/reportes.png']
];

//=====================================================================================================================    
$datoo  = '4-440101|1|1|1';

//=====================================================================================================================    
$tablao = 'pq_pro_procesos.pr_con_guia|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1 ';

//=====================================================================================================================    
$importao = [
        'prm' => 'GUIA|sp_grb_GUIA|GUIA',
        'cmp' => []
];
$importao_campos = [
    ['ARCHGUIA'	    , 'ARCHIVO' , 'ACH'  , '3'  , '0' , '0|0|0|0|0|0|0|0|0|' , 'D FECHA F|FD|30|D--' , '' , '' , '' ],
    ['PROARCHGUIA'	, 'PROCESO' , 'BTN'  , '3'  , '0' , '0|0|0|0|0|0|0|0|0|' , 'ARCHGUIA'            , '' , '' , '' ],
];

//=====================================================================================================================    
$camposo  = [
        'prm' => 'dGUIA|pr_con_dGUIA|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1 ',
        'cmp' => [],
        'btn' => [
            ['id' => 'lnk_act', 'men' => 'a', 'title' => 'Actualiza','procesoa'=>"add_person('N','N');carga('".base_url()."empresa/actualizar/",'procesob'=>"','contenidom');"],
            ['id' => 'lnk_eli', 'men' => 'e', 'title' => 'Elimina'  ,'procesoa'=>"if (eliminar()== true) { carga('".base_url()."empresa/eliminar/",'procesob'=>"','filtro');}"]		
        ]
];    
$camposo_campos = [
    ['IGUIA'    , 'ID'      , 'TXT', '3'    , '0', '1|1|1|0|0|0|0|0|0|'                     , ''                    , 'trim|required', '', 'size="3" style="width:100%" required readonly'],
    ['TRANSP'   , 'TRANSP'  , 'CBO', ''     , '0', '0|0|0|0|0|1|TRA--|0|0|'                 , ''                    , 'trim|required|max_length[30]', '', ''],
    ['IDCLI'    , 'IDCLI'   , 'CBO', ''     , '0', '1|1|1|0|0|1|CLIENTE--|0|0|'             , '-D CAMPO 9-'         , 'trim|required|max_length[30]', '', 'id="IDCLI" onchange="cambioss(...)"'],
    ['TIPO'     , 'TIPO'    , 'CBO', ''     , '0', '1|1|1|0|0|1|TIPO-NOMBRE1-IDCLI|0|0|'    , ''                    , 'trim|required|max_length[30]', '', 'id="TIPO"'],
    ['DOCUMENTO', 'DOC'     , 'TXT', '100'  , '0', '1|1|1|0|0|0|0|0|0|'                     , ''                    , 'trim|required|max_length[100]', '', 'placeholder="Escribe Direccion" required'],
    ['FECHA'    , 'FECHA'   , 'TXT', '20'   , '0', '1|1|1|0|0|0|0|0|0|'                     , '-D FECHA A|FD|0|D-'  , 'trim|required', '', 'placeholder="Escribe Direccion" required'],
    ['TN'       , 'TN'      , 'CBO', ''     , '0', '1|0|1|0|0|1|TON--|0|0|'                 , ''                    , 'trim|required', '', ''],
    ['TPCLIMA'  , 'CL'      , 'CBO', ''     , '0', '1|0|1|0|0|1|TEM--|0|0|'                 , ''                    , 'trim|required', '', ''],
    ['PLACA'    , 'PLACA'   , 'CBO', ''     , '0', '1|1|1|0|0|1|PLACA--|0|0|'               , ''                    , 'trim|required|max_length[30]', '', ''],
    ['ZONA'     , 'ZN'      , 'CBO', ''     , '0', '1|1|1|0|0|1|ZONA-NOMBRE2-IDCLI|0|0|'    , ''                    , '', '', 'id="ZONA" multiple="multiple" class="mdb-select colorful-select dropdown-primary"'],
    ['NDOC'     , 'ND'      , 'TXT', '10'   , '0', '0|0|0|0|0|0|0|0|0|'                     , ''                    , 'trim|required', '', 'placeholder="Escribe Direccion" required'],
    ['NBUL'     , 'NB'      , 'TXT', '10'   , '0', '1|1|1|0|0|0|0|0|0|'                     , ''                    , 'trim|required', '', 'placeholder="Escribe Direccion" required'],
    ['IDMSG'    , 'IDMSG'   , 'TXT', '10'   , '0', '0|0|0|0|0|0|0|0|0|'                     , ''                    , '', '', ''],
    ['USUCREA'  , 'usuario' , 'TXT', '3'    , '0', '0|0|0|0|0|0|0|0|0|'                     , '-E USUARIO USU-'     , '', '', 'placeholder="Escribe Codigo"'],
    ['FCHCREA'  , 'usuario' , 'TXT', '3'    , '0', '0|0|0|0|0|0|0|0|0|'                     , '-E FECHA A|FD|0|D-'  , '', '', 'placeholder="Escribe Codigo"'],
    ['USUMODIF' , 'usuario' , 'TXT', '3'    , '0', '0|0|0|0|0|0|0|0|0|'                     , '-E USUARIO USU-E USUARIO USU', '', '', 'placeholder="Escribe Codigo"'],
    ['FCHMODIF' , 'usuario' , 'TXT', '3'    , '0', '0|0|0|0|0|0|0|0|0|'                     , '-E FECHA A|FD|0|D-'  , '', '', 'placeholder="Escribe Codigo"'],
    ['PROVAL'   , 'PROVAL'  , 'CBO', ''     , '0', '0|0|1|0|0|1|BSN--|0|0|'                 , ''                    , 'trim|required|max_length[30]', '', ''],
    ['PROLIQ'   , 'PROLIQ'  , 'CBO', ''     , '0', '0|0|1|0|0|1|BSN--|0|0|'                 , ''                    , 'trim|required|max_length[30]', '', ''],
    ['PLACALQ'  , 'LQ'      , 'CBO', ''     , '0', '1|0|1|0|0|1|PLACA--|0|0|'               , ''                    , 'trim|required|max_length[30]', '', ''],
    ['PROITEM'  , 'ITEM'    , 'CBO', ''     , '0', '1|0|1|0|0|1|LOC--|0|0|'                 , ''                    , 'trim|required|max_length[30]', '', ''],
    ['COSTO'    , 'COSTO'   , 'TXT', '10'   , '0', '1|0|1|0|0|0|0|0|0|'                     , ''                    , 'trim', '', 'placeholder="Escribe Direccion"'],
    ['ESTADO'   , 'EST'     , 'CBO', ''     , '0', '1|1|1|0|0|1|BAI--|0|0|'                 , '-D CAMPO A-'         , 'trim|required', '', ''],
    ['OBSER'    , 'OBSER'   , 'TXT', '100'  , '0', '0|1|1|0|0|0|0|0|0|'                     , ''                    , '', '', 'placeholder="Escribe Codigo" required'],
    ['PESO'     , 'PESO'    , 'TXT', '10'   , '0', '0|0|1|0|0|0|0|0|0|'                     , ''                    , 'trim', '', 'placeholder="Escribe Direccion"']
];

//=====================================================================================================================
$camposdeto = [
    [
        'prm' => 'dGUIA|pr_con_dGUIA|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1 ',
        'cmp' => []
    ]
];
// 0 CAMPO      1 ALIAS      2 TIPO   3 TAMANO 4 ID  5 LST    6 ESP  7 RULES         8VALUE  9  attr 
$camposdeto_campos = [
    ['SEC'		, 'SEC'      , 'TXT'  , '3'  , '0' , '1|1|1|0|0|0|0|0|0|' , '' , 'trim|required' , '' , 'size="3" style="width:100%" required readonly' ],
    ['IGUIA'	, 'LISTA'    , 'TXT'  , '3'  , '0' , '1|1|1|0|0|0|0|0|0|' , '' , 'trim|required' , '' , 'size="3" style="width:100%" required readonly' ],
    ['FECHA'	, 'FECHA'    , 'TXT'  , '20' , '0' , '1|1|1|0|0|0|0|0|0|' , '' , 'trim|required' , '' , 'size="3" style="width:100%" required '         ],
    ['TIPO'		, 'TIPO'     , 'TXT'  , '20' , '0' , '1|1|1|0|0|0|0|0|0|' , '' , 'trim|required' , '' , 'size="3" style="width:100%" required readonly' ],
    ['DOCUMEN'	, 'DOCUMENTO', 'TXT'  , '100', '0' , '1|1|1|0|0|0|0|0|0|' , '' , 'trim|required' , '' , 'size="3" style="width:100%" required '         ],
    ['DESTINO'	, 'DESTINO'  , 'TXT'  , '100', '0' , '1|1|1|0|0|0|0|0|0|' , '' , 'trim|required' , '' , 'size="3" style="width:100%" required '         ],
    ['NBUL'		, 'BULTOS'   , 'TXT'  , '10' , '0' , '1|1|1|0|0|0|0|0|0|' , '' , 'trim|required' , '' , 'size="3" style="width:100%" required '         ],
    ['TBUL'		, 'TBUL'     , 'TXT'  , '100', '0' , '1|1|1|0|0|0|0|0|0|' , '' , 'trim|required' , '' , 'size="3" style="width:100%" required '         ],
    ['VALOR'	, 'VALOR'    , 'TXT'  , '10' , '0' , '1|1|1|0|0|0|0|0|0|' , '' , 'trim|required' , '' , 'size="3" style="width:100%" required '         ],
    ['OBSER'	, 'RETIRO'   , 'TXT'  , '100', '0' , '1|1|1|0|0|0|0|0|0|' , '' , 'trim|required' , '' , 'size="3" style="width:100%" required '         ],
    ['IDGUIA'	, 'IDGUIA'   , 'TXT'  , '3'  , '0' , '1|1|1|0|0|0|0|0|0|' , '' , 'trim|required' , '' , 'size="3" style="width:100%" required readonly' ],
    ['UBICA'	, 'RETIRO'   , 'TXT'  , '100', '0' , '1|1|1|0|0|0|0|0|0|' , '' , 'trim|required' , '' , 'size="3" style="width:100%" required '         ],
    ['REFEREN'	, 'RETIRO'   , 'TXT'  , '100', '0' , '1|1|1|0|0|0|0|0|0|' , '' , 'trim|required' , '' , 'size="3" style="width:100%" required '         ],
    ['ESTADO'	, 'ESTADO'   , 'TXT'  , '3'  , '0' , '1|1|1|0|0|0|0|0|0|' , '' , 'trim|required' , '' , 'size="3" style="width:100%" required '         ],
    ['USUCREA'	, 'USUCREA'  , 'TXT'  , '3'  , '0' , '1|1|1|0|0|0|0|0|0|' , '' , 'trim|required' , '' , 'size="3" style="width:100%" required '         ],
    ['FCHCREA'	, 'FCHCREA'  , 'TXT'  , '3'  , '0' , '1|1|1|0|0|0|0|0|0|' , '' , 'trim|required' , '' , 'size="3" style="width:100%" required '         ],
    ['FCHMODIF'	, 'FCHMODIF' , 'TXT'  , '3'  , '0' , '1|1|1|0|0|0|0|0|0|' , '' , 'trim|required' , '' , 'size="3" style="width:100%" required '         ],
    ['USUMODIF'	, 'USUMODIF' , 'TXT'  , '3'  , '0' , '1|1|1|0|0|0|0|0|0|' , '' , 'trim|required' , '' , 'size="3" style="width:100%" required '         ],
];

//=====================================================================================================================
$camposboto = [
    [
        'btnn' => '0',
        'title' => 'Guias Error',
        'tabla' => 'mensajes',
        'where' => ['PROCESO' => 'ERROR'],
        'prm' => 'mensajes|pr_con_rol_roles|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1|-E PROCESO DFAC-',
        'cmp' => [],
        'btn' => [
            ['title' => 'Actualiza', 'procesoa' => "add_person('N','N');carga('".base_url()."empresa/actualizar/", 'procesob' => "','contenidom');", 'id' => 'lnk_act', 'men' => 'a'],
            ['title' => 'Elimina', 'procesoa' => "if (eliminar() == true) { carga('".base_url()."empresa/eliminar/", 'procesob' => "','filtro');}", 'id' => 'lnk_eli', 'men' => 'e']
        ]
    ],
    [
        'btnn' => '1',
        'title' => 'OPERADORES',
        'tabla' => 'dlista',
        'where' => ['LISTA' => '14'],
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
        ['CODIGO'   , 'CODIGO'      , 'TXT', '3', '0', '1|1|1|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="3" style="width:100%" required readonly'],
        ['MENSAJE'  , 'MENSAJE'     , 'TXT', '3', '0', '1|1|1|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="3" style="width:100%" required'],
        ['USUARIO'  , 'USUARIO'     , 'TXT', '3', '0', '1|0|0|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="30%" style="width:30%" required readonly'],
        ['FECHA'    , 'FECHA'       , 'TXT', '3', '0', '1|0|0|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="30%" style="width:30%" required readonly'],
        ['PROCESO'  , 'PROCESO'     , 'TXT', '3', '0', '1|1|1|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="100%" style="width:100%" required'],
        ['RANGO'    , 'RANGO'       , 'TXT', '3', '0', '0|0|0|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="30%" style="width:30%" required readonly'],
        ['REFEREN'  , 'REFEREN'     , 'TXT', '3', '0', '1|0|0|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="30%" style="width:30%" required readonly'],
        ['USUACT'   , 'USUACT'      , 'TXT', '3', '0', '0|0|0|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="30%" style="width:30%" required readonly'],
        ['FCHACT'   , 'FCHACT'      , 'TXT', '3', '0', '0|0|0|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="30%" style="width:30%" required readonly'],
        ['USUPRO'   , 'USUPRO'      , 'TXT', '3', '0', '0|0|0|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="30%" style="width:30%" required readonly'],
        ['FCHPRO'   , 'FCHPRO'      , 'TXT', '3', '0', '0|0|0|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="30%" style="width:30%" required readonly'],
        ['OPERADOR' , 'OPERADOR'    , 'TXT', '3', '0', '1|0|0|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="30%" style="width:30%" required readonly'],
        ['DETALLE'  , 'DETALLE'     , 'TXT', '3', '0', '0|1|1|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="30%" style="width:30%" required readonly']
    ],
    [ // Segundo bloque de campos
        ['LISTA'    , 'lista'       , 'TXT', '3', '0', '0|1|1|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="3" style="width:100%" required readonly'],
        ['CODIGO'   , 'CODIGO'      , 'TXT', '3', '0', '1|1|1|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="20" style="width:100%" required readonly'],
        ['NOMBRE'   , 'FORMATOFAC'  , 'TXT', '3', '0', '1|1|1|0|0|0|0|0|0|' , '', 'required'     , '', 'size="100" style="width:100%" required'],
        ['NOMBRE1'  , 'FECHAINI'    , 'TXT', '3', '0', '1|1|1|0|0|0|0|0|0|' , '', 'trim|'        , '', 'size="100" style="width:100%" required'],
        ['NOMBRE2'  , 'FECHAFIN'    , 'TXT', '3', '0', '1|1|1|0|0|0|0|0|0|' , '', 'trim|'        , '', 'size="100" style="width:100%" required'],
        ['ESTADO'   , 'EST'         , 'CBO', '3', '0', '1|1|1|0|0|0|0|0|0|' , '', 'trim|required', '', '']
    ]
];

$filtroo =[
        'prm' => 'GUIA|sp_grb_GUIA|GUIA',
        'cmp' => []
];
$filtroo_campos = [
    ['IDCLI'	, 'CLiente'  , 'CBO'  , '3'  , '0' , '1|1|1|0|0|0|0|1|=|'  , ''                     , 'trim|required' , '' , 'size="3" style="width:100%" required readonly' ],
    ['IGUIA'	, 'Codigo'   , 'TXT'  , '3'  , '0' , '1|1|1|0|0|0|0|1|=|'  , ''                     , 'trim|required' , '' , 'size="3" style="width:100%" required readonly' ],
    ['FECHA'	, 'DESDE'    , 'TXT'  , '20' , '0' , '1|1|1|0|0|0|0|1|>=|' , 'D FECHA I|FD|N30|D--' , 'trim|required' , '' , 'size="3" style="width:100%" required '         ],
    ['FECHA'	, 'HASTA'    , 'TXT'  , '20' , '0' , '1|1|1|0|0|0|0|1|<=|' , 'D FECHA F|FD|30|D--'  , 'trim|required' , '' , 'size="3" style="width:100%" required readonly' ],
    ['PROLIQ'	, 'PROLIQ'   , 'CBO'  , '100', '0' , '1|1|1|0|0|0|0|1|=|'  , 'D CAMPO N--'          , 'trim|required' , '' , 'size="3" style="width:100%" required '         ]
];

$comboo =[];


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

$config['campos']['camposo_campos'] = $camposo_campos;
$config['campos']['camposboto_campos'] = $camposboto_campos;
$config['campos']['camposdeto_campos'] = $camposdeto_campos;
$config['campos']['importao_campos'] = $importao_campos;
$config['campos']['filtroo_campos'] = $filtroo_campos;

return $config;

}
    

    function ConfigTransacc4401011(){
        $comi = "'";

        $structo = array(array('base'=>'factura','nombre'=>'factura','metodo'=>'0|0|0|0','join'=>''),
        array('base'=>'factura','nombre'=>'facdetalle','metodo'=>'0|0|0|0','join'=>array('sec'=>'sec'))  
); 

$botoo  = array  (array('title'=>'Datos','proceso'=>"carga('".base_url()."empresa/Pdatos','filtro');",'contene'=>'ESTEMP','imagen'=>'../guia/application/views/empresa/images/Ppull.png'),
array('title'=>'Guias','proceso'=>"carga('".base_url()."empresa/Pguias','filtro');",'contene'=>'ESTEMP','imagen'=>'../guia/application/views/empresa/images/pguias.png'),
array('title'=>'Costo','proceso'=>"carga('".base_url()."empresa/Pcosto','filtro');",'contene'=>'ESTEMP','imagen'=>'../guia/application/views/empresa/images/pcosto.png'),
array('title'=>'reporte','proceso'=>"add_person('N','S');cargaRpt('".base_url()."empresa/Preporteqx','contenidom');",'contene'=>'ESTEMP','imagen'=>'../guia/application/views/empresa/images/reportes.png'),
array('title'=>'Unidas','proceso'=>"add_person('N','S');cargaRpt('".base_url()."empresa/Preporteun','contenidom');",'contene'=>'ESTEMP','imagen'=>'../guia/application/views/empresa/images/reportes.png'),
array('title'=>'Difare','proceso'=>"add_person('N','S');cargaRpt('".base_url()."empresa/Preportedif','contenidom');",'contene'=>'ESTEMP','imagen'=>'../guia/application/views/empresa/images/reportes.png')
);

$comboo = array(array('dato'=>'Guia','campo'=>'ESTADO','cat'=>'BAI','nom'=>'julio'),
array('dato'=>'Guia','campo'=>'PLACA','cat'=>'PLACA','nom'=>'julio'),
array('dato'=>'Guia','campo'=>'PLACALQ','cat'=>'PLACA','nom'=>'julio'),
array('dato'=>'Guia','campo'=>'ZONA','cat'=>'ZONA','fill'=>'NOMBRE2|IDCLI'),
array('dato'=>'Guia','campo'=>'TN','cat'=>'TON','nom'=>'julio'),
array('dato'=>'Guia','campo'=>'TPCLIMA','cat'=>'TEMP','nom'=>'julio'),
array('dato'=>'Guia','campo'=>'PROITEM','cat'=>'LOC','nom'=>'julio'),
array('dato'=>'Guia','campo'=>'TRANSP','cat'=>'TRA','nom'=>'julio'),
array('dato'=>'Guia','campo'=>'PROVAL','cat'=>'BSN','nom'=>'julio'),
array('dato'=>'Guia','campo'=>'TIPO','cat'=>'TIPO','fill'=>'NOMBRE1|IDCLI'),
array('dato'=>'Guia','campo'=>'IDCLI','cat'=>'CLIENTE','nom'=>'julio'),
array('dato'=>'Guia','campo'=>'PROLIQ','cat'=>'BSN','nom'=>'julio')
);
$datoo  = 'GUIA|1|1|1';

$tablao = 'pq_pro_procesos.pr_con_guia|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1 ';
$camposo = array('prm'=>'GUIA|sp_grb_GUIA|GUIA|-E PROCESO GUIA-',
'cmp'=>array(
array('campo'=>'IGUIA','as'=>'ID','id'=>'1','lst'=>'0|0|1','esp'=>'-E SECUENCIA GUIA-',
array('tipo'=>'rlsa','attr'=> array('field' => 'IGUIA','label' => 'CODIGO','rules' => '')),
array('tipo'=>'lbl','attr'=> array('text'=>'CODIGO:','for'=>'IGUIA','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'IGUIA','IGUIA'  ,'placeholder' => 'Escribe Codigo','maxlength' => '3',
'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','onkeypress'=>'return numero(event);','onblur'=>'rev();' ))
),
array('campo'=>'TRANSP','as'=>'TRANSP','id'=>'0','lst'=>'0|0|0','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'TRANSP','label' => 'TRANSPORTE','rules' => 'trim|required|max_length[30]')),
array('tipo'=>'lbl','attr'=> array('text'=>'TRANSPORTE:','for'=>'TRANSP','attr'=>array())),
array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'TRANSP','opcion'=>array(''=>''),'attr'=>''))
),
array('campo'=>'IDCLI','as'=>'IDCLI','id'=>'0','lst'=>'1|1|1','esp'=>'-D CAMPO 9-',
array('tipo'=>'rls','attr'=> array('field' => 'IDCLI','label' => 'IDCLI','rules' => 'trim|required|max_length[30]')),
array('tipo'=>'lbl','attr'=> array('text'=>'IDCLI:','for'=>'IDCLI','attr'=>array())),
array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'IDCLI','opcion'=>array(''=>''),'attr'=>'id= "IDCLI" onchange ="cambioss('.$comi.'TIPO|IDCLI-NOMBRE1@ZONA|IDCLI-NOMBRE2'.$comi.','.$comi.'GUIA'.$comi.');"'))
),
array('campo'=>'TIPO','as'=>'TIPO','id'=>'0','lst'=>'1|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'TIPO','label' => 'TIPO','rules' => 'trim|required|max_length[30]')),
array('tipo'=>'lbl','attr'=> array('text'=>'TIPO:','for'=>'TIPO','attr'=>array())),
array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'TIPO','opcion'=>array(''=>''),'attr'=>'id = "TIPO"'))
),
array('campo'=>'DOCUMENTO','as'=>'DOC','id'=>'0','lst'=>'1|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'DOCUMENTO','label' => 'DOCUMENTO','rules' => 'trim|required|max_length[100]')),
array('tipo'=>'lbl','attr'=> array('text'=>'DOCUMENTO:','for'=>'DOCUMENTO','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'DOCUMENTO','DOCUMENTO','placeholder' => 'Escribe Direccion','maxlength' => '100',
'size' => '3'            ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
),
array('campo'=>'FECHA','as'=>'FECHA','id'=>'0','lst'=>'1|1|1','esp'=>'-D FECHA A|FD|0|D-',
array('tipo'=>'rls','attr'=> array('field' => 'FECHA','label' => 'FECHA','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'FECHA:','for'=>'FECHA','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'FECHA','FECHA','placeholder' => 'Escribe Direccion','maxlength' => '20',
'size' => '10'            ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','onkeypress'=>'return numero(event);'))
),
array('campo'=>'TN','as'=>'TN','id'=>'0','lst'=>'1|0|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'TN','label' => 'Ton','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'TON:','for'=>'TN','attr'=>array())),
array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'TN','opcion'=>array(''=>''),'attr'=>''))
),
array('campo'=>'TPCLIMA','as'=>'CL','id'=>'0','lst'=>'1|0|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'TPCLIMA','label' => 'Clima','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'CLIMA:','for'=>'TPCLIMA','attr'=>array())),
array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'TPCLIMA','opcion'=>array(''=>''),'attr'=>''))
),
array('campo'=>'PLACA','as'=>'PLACA','id'=>'0','lst'=>'1|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'PLACA','label' => 'PLACA','rules' => 'trim|required|max_length[30]')),
array('tipo'=>'lbl','attr'=> array('text'=>'PLACA:','for'=>'PLACA','attr'=>array())),
array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'PLACA','opcion'=>array(''=>''),'attr'=>''))
),
array('campo'=>'ZONA','as'=>'ZN','id'=>'0','lst'=>'1|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'ZONA','label' => 'Zona','rules' => '')),
array('tipo'=>'lbl','attr'=> array('text'=>'ZONA:','for'=>'ZONA','attr'=>array())),
array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'ZONA[]','opcion'=>array(''=>''),'attr'=>'id = "ZONA" multiple="multiple" class="mdb-select colorful-select dropdown-primary"'))
),
array('campo'=>'NDOC','as'=>'ND','id'=>'0','lst'=>'0|0|0','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'NDOC','label' => 'Numero Documento','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'NUM DOC:','for'=>'NDOC','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'NDOC','NDOC','placeholder' => 'Escribe Direccion','maxlength' => '10',
'size' => '3'            ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','onkeypress'=>'return numero(event);' ))
),
array('campo'=>'NBUL','as'=>'NB','id'=>'0','lst'=>'1|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'NBUL','label' => 'BULTOS','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'BULTOS:','for'=>'NBUL','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'NBUL','NBUL','placeholder' => 'Escribe Direccion','maxlength' => '10',
'size' => '3'            ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','onkeypress'=>'return numero(event);' ))
),
array('campo'=>'IDMSG','as'=>'IDMSG','id'=>'0','lst'=>'0|0|0','esp'=>'',
array('tipo'=>'rlsa','attr'=> array('field' => 'IDMSG','label' => 'IDmensaje','rules' => '')),
array('tipo'=>'lbl','attr'=> array('text'=>'ID MSG:','for'=>'IDMSG','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'IDMSG','IDMSG','placeholder' => 'Escribe Direccion','maxlength' => '10',
'size' => '3'            ,'style'       => 'width:100%'      ,'value'     => '' ))
),
array('campo'=>'USUCREA','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'-E USUARIO USU-',
array('tipo'=>'rlsa','attr'=> array('field' => 'USUCREA','label' => 'USUCREA','rules' => '')),
array('tipo'=>'lbl','attr'=> array('text'=>'USUCREA:','for'=>'USUCREA','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'USUCREA','USUCREA'  ,'placeholder' => 'Escribe Codigo',
'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '' ))
),
array('campo'=>'FCHCREA','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'-E FECHA A|FD|0|D-',
array('tipo'=>'rlsa','attr'=> array('field' => 'FCHCREA','label' => 'FCHCREA','rules' => '')),
array('tipo'=>'lbl','attr'=> array('text'=>'FCHCREA:','for'=>'FCHCREA','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'FCHCREA','FCHCREA'  ,'placeholder' => 'Escribe Codigo',
'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => ''))
),
array('campo'=>'USUMODIF','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'-E USUARIO USU-E USUARIO USU',
array('tipo'=>'rlsa','attr'=> array('field' => 'USUMODIF','label' => 'USUMODIF','rules' => '')),
array('tipo'=>'lbl','attr'=> array('text'=>'USUMODIF:','for'=>'USUMODIF','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'USUMODIF','USUMODIF'  ,'placeholder' => 'Escribe Codigo',
'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '' ))
),
array('campo'=>'FCHMODIF','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'-E FECHA A|FD|0|D-E FECHA A|FD|0|D',
array('tipo'=>'rlsa','attr'=> array('field' => 'FCHMODIF','label' => 'FCHMODIF','rules' => '')),
array('tipo'=>'lbl','attr'=> array('text'=>'FCHMODIF:','for'=>'FCHMODIF','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'FCHMODIF','FCHMODIF'  ,'placeholder' => 'Escribe Codigo',
'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '' ))
),
array('campo'=>'PROVAL','as'=>'PROVAL','id'=>'0','lst'=>'0|0|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'PROVAL','label' => 'PROC VALORES','rules' => 'trim|required|max_length[30]')),
array('tipo'=>'lbl','attr'=> array('text'=>'PR.VALORES:','for'=>'PROVAL','attr'=>array())),
array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'PROVAL','opcion'=>array(''=>''),'attr'=>''))
),
array('campo'=>'PROLIQ','as'=>'PROLIQ','id'=>'0','lst'=>'0|0|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'PROLIQ','label' => 'PROC LIQUID','rules' => 'trim|required|max_length[30]')),
array('tipo'=>'lbl','attr'=> array('text'=>'PR.LIQUID:','for'=>'PROLIQ','attr'=>array())),
array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'PROLIQ','opcion'=>array(''=>''),'attr'=>''))
),
array('campo'=>'PLACALQ','as'=>'LQ','id'=>'0','lst'=>'1|0|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'PLACALQ','label' => 'LIQUIDACION','rules' => 'trim|required|max_length[30]')),
array('tipo'=>'lbl','attr'=> array('text'=>'LIQUIDACION:','for'=>'PLACALQ','attr'=>array())),
array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'PLACALQ','opcion'=>array(''=>''),'attr'=>''))
),
array('campo'=>'PROITEM','as'=>'ITEM','id'=>'0','lst'=>'1|0|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'PROITEM','label' => 'PROC ITEM','rules' => 'trim|required|max_length[30]')),
array('tipo'=>'lbl','attr'=> array('text'=>'PR.ITEM:','for'=>'PROITEM','attr'=>array())),
array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'PROITEM','opcion'=>array(''=>''),'attr'=>''))
),
array('campo'=>'COSTO','as'=>'COSTO','id'=>'0','lst'=>'1|0|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'COSTO','label' => 'Costo','rules' => 'trim')),
array('tipo'=>'lbl','attr'=> array('text'=>'COSTO:','for'=>'COSTO','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'COSTO','COSTO','placeholder' => 'Escribe Direccion','maxlength' => '10',
'size' => '3'            ,'style'       => 'width:100%'      ,'value'     => '' ))
),
array('campo'=>'ESTADO','as'=>'EST','id'=>'0','lst'=>'1|1|1','esp'=>'-D CAMPO A-',
array('tipo'=>'rls','attr'=> array('field' => 'ESTADO','label' => 'Estado','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'ESTADO:','for'=>'ESTADO','attr'=>array())),
array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'ESTADO','opcion'=>array(''=>''),'attr'=>''))
),
array('campo'=>'OBSER','as'=>'OBSER','id'=>'0','lst'=>'0|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'OBSER','label' => 'OBSER','rules' => '')),
array('tipo'=>'lbl','attr'=> array('text'=>'RETIRO:','for'=>'OBSER','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'OBSER','OBSER'  ,'placeholder' => 'Escribe Codigo','maxlength' => '100',
'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
),
array('campo'=>'PESO','as'=>'PESO','id'=>'0','lst'=>'0|0|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'PESO','label' => 'PESO','rules' => 'trim')),
array('tipo'=>'lbl','attr'=> array('text'=>'PESO:','for'=>'PESO','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'PESO','PESO','placeholder' => 'Escribe Direccion','maxlength' => '10',
'size' => '3'            ,'style'       => 'width:100%'      ,'value'     => '' ))
)

),
'btn'=>array(                  
array('title'=>'Actualiza','procesoa'=>"add_person('N','N');carga('".base_url()."empresa/actualizar/",'procesob'=>"','contenidom');",'id'=>'lnk_act','men'=>'a'),                    
array('title'=>'Elimina','procesoa'=>"if (eliminar()== true) { carga('".base_url()."empresa/eliminar/",'procesob'=>"','filtro');}",'id'=>'lnk_eli','men'=>'e')                       
));

$filtroo = array('prm'=>'GUIA|sp_grb_GUIA|GUIA',
'cmp'=>array(
array('campo'=>'IDCLI','as'=>'IDCLI','id'=>'0','lst'=>'0|0|0','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'IDCLI','label' => 'PROC CLIENTE','rules' => 'trim|required|max_length[30]')),
array('tipo'=>'lbl','attr'=> array('text'=>'Cliente:','for'=>'IDCLI','attr'=>array())),
array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'IDCLI','opcion'=>array(''=>''),'attr'=>''))
),
array('campo'=>'IGUIA','as'=>'Codigo','id'=>'1','lst'=>'0|0|0','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'IGUIA','label' => 'Codigo','rules' => 'trim|required|strip_tags|xss_clean|min_length[3]')),
array('tipo'=>'lbl','attr'=> array('text'=>'Codigo:','for'=>'IGUIA','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'IGUIA','IGUIA'  ,'placeholder' => 'Escribe Codigo','maxlength' => '12',
'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','onblur'=>'rev();'  ))
),
array('campo'=>'FDESDE','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'D FECHA I|FD|N30|D--',
array('tipo'=>'rlsa','attr'=> array('field' => 'FDESDE','label' => 'FDESDE','rules' => '')),
array('tipo'=>'lbl','attr'=> array('text'=>'Desde:','for'=>'FDESDE','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'FDESDE','FDESDE'  ,'placeholder' => 'Escribe Codigo','maxlength' => '12',
'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '', 'class' => 'fecha' ))
),
array('campo'=>'FHASTA','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'D FECHA F|FD|30|D--',
array('tipo'=>'rlsa','attr'=> array('field' => 'FHASTA','label' => 'FHASTA','rules' => '')),
array('tipo'=>'lbl','attr'=> array('text'=>'Hasta:','for'=>'USUMODIF','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'FHASTA','FHASTA'  ,'placeholder' => 'Escribe Codigo','maxlength' => '12',
'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '' ))
),					

array('campo'=>'PROLIQ','as'=>'PROLIQ','id'=>'0','lst'=>'0|0|0','esp'=>'D CAMPO N--',
array('tipo'=>'rls','attr'=> array('field' => 'PROLIQ','label' => 'PROC LIQUID','rules' => 'trim|required|max_length[30]')),
array('tipo'=>'lbl','attr'=> array('text'=>'Proceso:','for'=>'PROLIQ','attr'=>array())),
array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'PROLIQ','opcion'=>array(''=>''),'attr'=>''))
)
));


$camposdeto = array(array('prm'=>'dGUIA|pr_con_dGUIA|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1 ',
'cmp'=>array(
array('campo'=>'IGUIA','as'=>'lista','id'=>'1','lst'=>'1|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'LISTA','label' => 'LISTA','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'LISTA:','for'=>'LISTA','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'LISTA','LISTA'  ,'placeholder' => 'Escribe Codigo','maxlength' => '3',
'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
),
array('campo'=>'SEC','as'=>'lista','id'=>'1','lst'=>'1|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'SEC','label' => 'SEC','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'SEC:','for'=>'SEC','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'SEC','SEC'  ,'placeholder' => 'Escribe Codigo','maxlength' => '3',
'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
),
array('campo'=>'FECHA','as'=>'FECHA','id'=>'0','lst'=>'1|1|1','esp'=>'-D FECHA A|FD|0|D-',
array('tipo'=>'rls','attr'=> array('field' => 'FECHA','label' => 'FECHA','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'FECHA:','for'=>'FECHA','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'FECHA','FECHA','placeholder' => 'Escribe Direccion','maxlength' => '20',
'size' => '10'            ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','onkeypress'=>'return numero(event);'))
),
array('campo'=>'TIPO','as'=>'TIPO','id'=>'1','lst'=>'1|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'TIPO','label' => 'TIPO','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'TIPO:','for'=>'TIPO','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'TIPO','TIPO'  ,'placeholder' => 'Escribe TIPO','maxlength' => '20',
'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
),
array('campo'=>'DOCUMEN','as'=>'DOCUMENTO','id'=>'0','lst'=>'1|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'DOCUMEN','label' => 'DOCUMEN','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'DOCUMENTO:','for'=>'DOCUMEN','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'DOCUMEN'  ,'DOCUMEN','placeholder' => 'Escribe DOCUMEN','maxlength' => '100',
'size' => '100'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
),
array('campo'=>'DESTINO','as'=>'DESTINO','id'=>'0','lst'=>'1|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'DESTINO','label' => 'DESTINO','rules' => 'trim|')),
array('tipo'=>'lbl','attr'=> array('text'=>'DESTINO:','for'=>'DESTINO','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'DESTINO'  ,'DESTINO','placeholder' => 'Escribe DESTINO','maxlength' => '100',
'size' => '100'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
),
array('campo'=>'NBULT','as'=>'NB','id'=>'0','lst'=>'1|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'NBUL','label' => 'BULTOS','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'BULTOS:','for'=>'NBUL','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'NBUL','NBUL','placeholder' => 'Escribe Direccion','maxlength' => '10',
'size' => '3'            ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','onkeypress'=>'return numero(event);' ))
),
array('campo'=>'TBULT','as'=>'TBUL','id'=>'0','lst'=>'1|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'TBUL','label' => 'TBUL','rules' => 'trim|')),
array('tipo'=>'lbl','attr'=> array('text'=>'TBUL:','for'=>'TBUL','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'TBUL'  ,'TBUL','placeholder' => 'Escribe TBUL','maxlength' => '100',
'size' => '100'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
),
array('campo'=>'VALOR','as'=>'VALOR','id'=>'0','lst'=>'1|0|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'VALOR','label' => 'VALOR','rules' => 'trim')),
array('tipo'=>'lbl','attr'=> array('text'=>'VALOR:','for'=>'VALOR','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'VALOR','VALOR','placeholder' => 'Escribe Direccion','maxlength' => '10',
'size' => '3'            ,'style'       => 'width:100%'      ,'value'     => '' ))
),
array('campo'=>'OBSER','as'=>'OBSER','id'=>'0','lst'=>'0|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'OBSER','label' => 'OBSER','rules' => '')),
array('tipo'=>'lbl','attr'=> array('text'=>'RETIRO:','for'=>'OBSER','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'OBSER','OBSER'  ,'placeholder' => 'Escribe Codigo','maxlength' => '100',
'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
),
array('campo'=>'IDGUIA','as'=>'IDGUIA','id'=>'0','lst'=>'1|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'IDGUIA','label' => 'IDGUIA','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'IDGUIA:','for'=>'IDGUIA','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'IDGUIA','IDGUIA'  ,'placeholder' => 'Escribe Codigo','maxlength' => '3',
'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
),	
array('campo'=>'UBICA','as'=>'UBICA','id'=>'0','lst'=>'0|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'UBICA','label' => 'UBICA','rules' => '')),
array('tipo'=>'lbl','attr'=> array('text'=>'RETIRO:','for'=>'UBICA','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'UBICA','UBICA'  ,'placeholder' => 'Escribe Codigo','maxlength' => '100',
'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
),
array('campo'=>'REFEREN','as'=>'REFEREN','id'=>'0','lst'=>'0|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'REFEREN','label' => 'REFEREN','rules' => '')),
array('tipo'=>'lbl','attr'=> array('text'=>'RETIRO:','for'=>'REFEREN','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'REFEREN','REFEREN'  ,'placeholder' => 'Escribe Codigo','maxlength' => '100',
'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
),
array('campo'=>'PROLIQ','as'=>'PROLIQ','id'=>'0','lst'=>'0|0|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'PROLIQ','label' => 'PROC LIQUID','rules' => 'trim|required|max_length[30]')),
array('tipo'=>'lbl','attr'=> array('text'=>'PR.LIQUID:','for'=>'PROLIQ','attr'=>array())),
array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'PROLIQ','opcion'=>array(''=>''),'attr'=>''))
),
array('campo'=>'PROASO','as'=>'LQ','id'=>'0','lst'=>'0|0|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'PROASO','label' => 'LIQUIDACION','rules' => 'trim|required|max_length[30]')),
array('tipo'=>'lbl','attr'=> array('text'=>'PR.ASOC:','for'=>'PROASO','attr'=>array())),
array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'PROASO','opcion'=>array(''=>''),'attr'=>''))
),
array('campo'=>'PROITEM','as'=>'ITEM','id'=>'0','lst'=>'0|0|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'PROITEM','label' => 'PROC ITEM','rules' => 'trim|required|max_length[30]')),
array('tipo'=>'lbl','attr'=> array('text'=>'PR.ITEM:','for'=>'PROITEM','attr'=>array())),
array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'PROITEM','opcion'=>array(''=>''),'attr'=>''))
),	
array('campo'=>'ESTADO','as'=>'Estado','id'=>'0','lst'=>'1|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'ESTADO','label' => 'ESTADO','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'ESTADO:','for'=>'ESTADO','attr'=>array())),
array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'ESTADO','opcion'=>array(''=>''),'attr'=>''))
),
array('campo'=>'USUCREA','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'-E USUARIO USU-',
array('tipo'=>'rlsa','attr'=> array('field' => 'USUCREA','label' => 'USUCREA','rules' => '')),
array('tipo'=>'lbl','attr'=> array('text'=>'USUCREA:','for'=>'USUCREA','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'USUCREA','USUCREA'  ,'placeholder' => 'Escribe Codigo',
'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '' ))
),
array('campo'=>'FCHCREA','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'-E FECHA A|FD|0|D-',
array('tipo'=>'rlsa','attr'=> array('field' => 'FCHCREA','label' => 'FCHCREA','rules' => '')),
array('tipo'=>'lbl','attr'=> array('text'=>'FCHCREA:','for'=>'FCHCREA','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'FCHCREA','FCHCREA'  ,'placeholder' => 'Escribe Codigo',
'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => ''))
),
array('campo'=>'USUMODIF','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'-E USUARIO USU-E USUARIO USU',
array('tipo'=>'rlsa','attr'=> array('field' => 'USUMODIF','label' => 'USUMODIF','rules' => '')),
array('tipo'=>'lbl','attr'=> array('text'=>'USUMODIF:','for'=>'USUMODIF','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'USUMODIF','USUMODIF'  ,'placeholder' => 'Escribe Codigo',
'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '' ))
),
array('campo'=>'FCHMODIF','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'-E FECHA A|FD|0|D-E FECHA A|FD|0|D',
array('tipo'=>'rlsa','attr'=> array('field' => 'FCHMODIF','label' => 'FCHMODIF','rules' => '')),
array('tipo'=>'lbl','attr'=> array('text'=>'FCHMODIF:','for'=>'FCHMODIF','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'FCHMODIF','FCHMODIF'  ,'placeholder' => 'Escribe Codigo',
'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '' ))
)

)));

$importao = array('prm'=>'GUIA|sp_grb_GUIA|GUIA',
'cmp'=>array(
array('campo'=>'ARCHGUIA','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'D FECHA F|FD|30|D--',
array('tipo'=>'rlsa','attr'=> array('field' => 'FHASTA','label' => 'FHASTA','rules' => '')),
array('tipo'=>'lbl','attr'=> array('text'=>'ARCHIVO:','for'=>'ARCHGUIA','attr'=>array())),
array('tipo'=>'ach','attr'=> array('name' => 'ARCHGUIA','ARCHGUIA'  ,'placeholder' => '','maxlength' => '50',
'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '' ))
),					

array('campo'=>'PROARCHGUIA','as'=>'PROCESO','id'=>'0','lst'=>'0|0|0','esp'=>'ARCHGUIA',
array('tipo'=>'rlsa','attr'=> array('field' => 'PROARCHGUIA','label' => 'PROC LIQUID','rules' => 'trim|required|max_length[30]')),
array('tipo'=>'lbla','attr'=> array('text'=>'Proceso:','for'=>'PROARCHGUIA','attr'=>array())),
array('tipo'=>'btn','attr'=> array('name'=>'PROARCHGUIA','id'=>'PROARCHGUIA','attr'=>''))
)
));

$camposboto = array(array('btnn'=>'0','title'=>'Guias Error ','tabla'=>'mensajes','where'=>array('PROCESO' => 'ERROR'),'prm'=>'mensajes|pr_con_rol_roles|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1|-E PROCESO DFAC-',
'cmp'=>array(
array('campo'=>'CODIGO','as'=>'CODIGO','id'=>'1','lst'=>'1|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'CODIGO','label' => 'CODIGO','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'CODIGO:','for'=>'CODIGO','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'CODIGO','CODIGO'  ,'placeholder' => 'Escribe CODIGO','maxlength' => '20',
'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
),
array('campo'=>'MENSAJE','as'=>'MENSAJE','id'=>'0','lst'=>'1|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'MENSAJE','label' => 'MENSAJE','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'MENSAJE |GUIA QX 2755444 N1, 39 1 - 0|GUIA RET 0 C0, 1 1 RETIRO-HOSPITAL 0:','for'=>'MENSAJE','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'MENSAJE','MENSAJE'  ,'placeholder' => 'Escribe MENSAJE','maxlength' => '20',
'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
),
array('campo'=>'USUARIO','as'=>'USUARIO','id'=>'0','lst'=>'1|0|0','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'USUARIO','label' => 'USUARIO','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'USUARIO:','for'=>'USUARIO','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'USUARIO','USUARIO'  ,'placeholder' => 'Escribe USUARIO','maxlength' => '20',
'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
),
array('campo'=>'FECHA','as'=>'FECHA','id'=>'0','lst'=>'1|0|0','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'FECHA','label' => 'FECHA','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'FECHA:','for'=>'FECHA','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'FECHA','FECHA'  ,'placeholder' => 'Escribe FECHA','maxlength' => '20',
'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
),
array('campo'=>'PROCESO','as'=>'PROCESO','id'=>'0','lst'=>'1|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'PROCESO','label' => 'PROCESO','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'PROCESO:','for'=>'PROCESO','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'PROCESO','PROCESO'  ,'placeholder' => 'Escribe PROCESO','maxlength' => '20',
'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required'))
),
array('campo'=>'RANGO','as'=>'RANGO','id'=>'0','lst'=>'0|0|0','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'RANGO','label' => 'RANGO','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'RANGO:','for'=>'RANGO','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'RANGO','RANGO'  ,'placeholder' => 'Escribe RANGO','maxlength' => '20',
'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
),
array('campo'=>'REFEREN','as'=>'REFEREN','id'=>'0','lst'=>'1|0|0','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'REFEREN','label' => 'REFEREN','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'REFEREN:','for'=>'REFEREN','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'REFEREN','REFEREN'  ,'placeholder' => 'Escribe REFEREN','maxlength' => '20',
'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
),
array('campo'=>'USUACT','as'=>'USUACT','id'=>'0','lst'=>'0|0|0','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'USUACT','label' => 'USUACT','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'USUACT:','for'=>'USUACT','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'USUACT','USUACT'  ,'placeholder' => 'Escribe USUACT','maxlength' => '20',
'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
),
array('campo'=>'FCHACT','as'=>'FCHACT','id'=>'0','lst'=>'0|0|0','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'FCHACT','label' => 'FCHACT','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'FCHACT:','for'=>'FCHACT','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'FCHACT','FCHACT'  ,'placeholder' => 'Escribe FCHACT','maxlength' => '20',
'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
),
array('campo'=>'USUPRO','as'=>'USUPRO','id'=>'0','lst'=>'0|0|0','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'USUPRO','label' => 'USUPRO','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'USUPRO:','for'=>'USUPRO','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'USUPRO','USUPRO'  ,'placeholder' => 'Escribe USUPRO','maxlength' => '20',
'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
),
array('campo'=>'FCHPRO','as'=>'FCHPRO','id'=>'0','lst'=>'0|0|0','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'FCHPRO','label' => 'FCHPRO','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'FCHPRO:','for'=>'FCHPRO','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'FCHPRO','FCHPRO'  ,'placeholder' => 'Escribe FCHPRO','maxlength' => '20',
'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
),
array('campo'=>'OPERADOR','as'=>'OPERADOR','id'=>'0','lst'=>'1|0|0','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'OPERADOR','label' => 'OPERADOR','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'OPERADOR:','for'=>'OPERADOR','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'OPERADOR','OPERADOR'  ,'placeholder' => 'Escribe OPERADOR','maxlength' => '20',
'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
),
array('campo'=>'DETALLE','as'=>'DETALLE','id'=>'0','lst'=>'0|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'DETALLE','label' => 'DETALLE','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'DETALLE:','for'=>'DETALLE','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'DETALLE','DETALLE'  ,'placeholder' => 'Escribe DETALLE','maxlength' => '20',
'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
)
),
'btn'=>array(		  
array('title'=>'Actualiza','procesoa'=>"add_person('N','N');carga('".base_url()."empresa/actualizar/",'procesob'=>"','contenidom');",'id'=>'lnk_act','men'=>'a'),                    
array('title'=>'Elimina','procesoa'=>"if (eliminar()== true) { carga('".base_url()."empresa/eliminar/",'procesob'=>"','filtro');}",'id'=>'lnk_eli','men'=>'e')				
)),
array('title'=>'OPERADORES','tabla'=>'dlista','where'=>array('LISTA' => '14'),'prm'=>'dlista|pr_con_rol_roles|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1 ',
'cmp'=>array(
array('campo'=>'LISTA','as'=>'lista','id'=>'1','lst'=>'0|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'LISTA','label' => 'LISTA','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'LISTA:','for'=>'LISTA','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'LISTA','LISTA'  ,'placeholder' => 'Escribe Codigo','maxlength' => '3',
'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
),
array('campo'=>'CODIGO','as'=>'CODIGO','id'=>'1','lst'=>'1|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'CODIGO','label' => 'CODIGO','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'CODIGO:','for'=>'CODIGO','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'CODIGO','CODIGO'  ,'placeholder' => 'Escribe Codigo','maxlength' => '20',
'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
),
array('campo'=>'NOMBRE','as'=>'FORMATOFAC','id'=>'0','lst'=>'1|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'NOMBRE','label' => 'NOMBRE','rules' => 'required')),
array('tipo'=>'lbl','attr'=> array('text'=>'NOMBRE:','for'=>'NOMBRE','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'NOMBRE'  ,'NOMBRE','placeholder' => 'Escribe Nombre','maxlength' => '100',
'size' => '100'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
),
array('campo'=>'NOMBRE1','as'=>'FECHAINI','id'=>'0','lst'=>'1|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'nombre1','label' => 'nombre1','rules' => 'trim|')),
array('tipo'=>'lbl','attr'=> array('text'=>'Nombre1:','for'=>'nombre1','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'NOMBRE1'  ,'NOMBRE1','placeholder' => 'Escribe Nombre','maxlength' => '100',
'size' => '100'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
),
array('campo'=>'NOMBRE2','as'=>'FECHAFIN','id'=>'0','lst'=>'1|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'nombre2','label' => 'nombre2','rules' => 'trim|')),
array('tipo'=>'lbl','attr'=> array('text'=>'Nombre2:','for'=>'nombre2','attr'=>array())),
array('tipo'=>'txt','attr'=> array('name' => 'NOMBRE2'  ,'NOMBRE2','placeholder' => 'Escribe Nombre','maxlength' => '100',
'size' => '100'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
),
array('campo'=>'ESTADO','as'=>'EST','id'=>'0','lst'=>'1|1|1','esp'=>'',
array('tipo'=>'rls','attr'=> array('field' => 'ESTADO','label' => 'ESTADO','rules' => 'trim|required')),
array('tipo'=>'lbl','attr'=> array('text'=>'ESTADO:','for'=>'ESTADO','attr'=>array())),
array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'ESTADO','opcion'=>array(''=>''),'attr'=>''))
)
),
'btn'=>array(		  
array('title'=>'Actualiza','procesoa'=>"add_person('N','N');carga('".base_url()."empresa/actualizar/",'procesob'=>"','contenidom');",'id'=>'lnk_act','men'=>'a'),                    
array('title'=>'Elimina','procesoa'=>"if (eliminar()== true) { carga('".base_url()."empresa/eliminar/",'procesob'=>"','filtro');}",'id'=>'lnk_eli','men'=>'e')				
))
);

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

return $config;
    }
