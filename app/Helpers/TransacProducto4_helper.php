<?php

function ConfigTransacc440101(){

    $tablao = 'hc.guia';
    $produc = '4';
    $transa = '440101';
    

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
$datoo = $produc . '-' . $transa . '|0|1|1|catalogo';

//=====================================================================================================================    
//$tablao = 'pq_pro_procesos.pr_con_guia|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1 ';

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
        'tabla' => $tablao,
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
        'title'    => 'detalle-guia',
        'tabla'    => 'hc.dguia',
        'where'    => [],
        'relacion' => ['IGUIA' => 'IGUIA'],
        'join'     => [],
        'sp'       => [],
        'prm' => 'dGUIA|pr_con_dGUIA|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1 ',
        'cmp' => []
    ]
];
// 0 CAMPO      1 ALIAS      2 TIPO   3 TAMANO 4 ID  5 LST    6 ESP  7 RULES         8VALUE  9  attr 
$camposdeto_campos = [
    [
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
    ]
];

//=====================================================================================================================
$camposboto = [
   // [
   //     'btnn' => '0',
   //     'title' => 'Guias Error',
   //     'tabla' => 'mensajes',
   //     'where' => ['PROCESO' => 'ERROR'],
   //     'prm' => 'mensajes|pr_con_rol_roles|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1|-E PROCESO DFAC-',
   //     'cmp' => [],
   //     'btn' => [
   //         ['title' => 'Actualiza', 'procesoa' => "add_person('N','N');carga('".base_url()."empresa/actualizar/", 'procesob' => "','contenidom');", 'id' => 'lnk_act', 'men' => 'a'],
   //         ['title' => 'Elimina', 'procesoa' => "if (eliminar() == true) { carga('".base_url()."empresa/eliminar/", 'procesob' => "','filtro');}", 'id' => 'lnk_eli', 'men' => 'e']
   //    ]
   // ],
    [
        'btnn' => '1',
        'title' => 'OPERADORES',
        'tabla' => 'hc.dlista',
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
    //[ // Primer bloque de campos
    //    ['CODIGO'   , 'CODIGO'      , 'TXT', '3', '0', '1|1|1|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="3" style="width:100%" required readonly'],
    //    ['MENSAJE'  , 'MENSAJE'     , 'TXT', '3', '0', '1|1|1|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="3" style="width:100%" required'],
    //    ['USUARIO'  , 'USUARIO'     , 'TXT', '3', '0', '1|0|0|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="30%" style="width:30%" required readonly'],
    //    ['FECHA'    , 'FECHA'       , 'TXT', '3', '0', '1|0|0|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="30%" style="width:30%" required readonly'],
    //    ['PROCESO'  , 'PROCESO'     , 'TXT', '3', '0', '1|1|1|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="100%" style="width:100%" required'],
    //    ['RANGO'    , 'RANGO'       , 'TXT', '3', '0', '0|0|0|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="30%" style="width:30%" required readonly'],
    //    ['REFEREN'  , 'REFEREN'     , 'TXT', '3', '0', '1|0|0|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="30%" style="width:30%" required readonly'],
    //    ['USUACT'   , 'USUACT'      , 'TXT', '3', '0', '0|0|0|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="30%" style="width:30%" required readonly'],
    //    ['FCHACT'   , 'FCHACT'      , 'TXT', '3', '0', '0|0|0|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="30%" style="width:30%" required readonly'],
    //    ['USUPRO'   , 'USUPRO'      , 'TXT', '3', '0', '0|0|0|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="30%" style="width:30%" required readonly'],
    //    ['FCHPRO'   , 'FCHPRO'      , 'TXT', '3', '0', '0|0|0|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="30%" style="width:30%" required readonly'],
    //    ['OPERADOR' , 'OPERADOR'    , 'TXT', '3', '0', '1|0|0|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="30%" style="width:30%" required readonly'],
    //    ['DETALLE'  , 'DETALLE'     , 'TXT', '3', '0', '0|1|1|0|0|0|0|0|0|' , '', 'trim|required', '', 'size="30%" style="width:30%" required readonly']
    //],
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
    

    
