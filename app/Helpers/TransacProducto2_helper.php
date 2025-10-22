<?php
//http://192.168.100.8/HCbpms/empresa/index/2-220101
function ConfigTransacc220101(){

    $tablao = 'admin.clista';

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
    
    $datoo = '2-220101|0|1|1|catalogo';
    
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
            'tabla' => 'admin.dlista',
            'prm' => 'dlista|pr_con_dlista|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1||admin.dlista', 
            'cmp' => []
        ]
    ];
    
    $camposdeto_campos = [
        [ 'LISTA'  , 'lista'  , 'TXT', '3' , '1',  '1|1|1|0|0|0|0|0|0|','', 'trim|required', '', 'size="3" style="width:100%" required readonly'],
        [ 'CODIGO' , 'codigo' , 'TXT', '3' , '1',  '1|1|1|0|0|0|0|0|0|','', 'trim|required', '', 'size="3" style="width:100%" required readonly'],
        [ 'NOMBRE' , 'Nombre' , 'TXT', '3' , '0',  '1|1|1|0|0|0|0|0|0|','', 'trim|required', '', 'size="3" style="width:100%" required readonly'],
        [ 'NOMBRE1', 'Nombre1', 'TXT', '3' , '0',  '1|1|1|0|0|0|0|0|0|','', 'trim|required', '', 'size="3" style="width:100%" required readonly'],
        [ 'NOMBRE2', 'Nombre2', 'TXT', '3' , '0',  '1|1|1|0|0|0|0|0|0|','', 'trim|required', '', 'size="3" style="width:100%" required readonly'],
        [ 'ESTADO' , 'Estado' , 'CBO', '3' , '0',  '1|1|1|0|0|1|BAI--|0|0|','', 'trim|required', '', 'size="3" style="width:100%" required readonly'],
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
