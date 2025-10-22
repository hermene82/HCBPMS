
<?php

if (isset($ubic_det)) {
    $ubic = $ubic_det;
}

$_index = "";
$_indexc = "";
$_campos =  $config->r_camposdet;

//echo print_r($_campos,true);

$count = count($_campos);                 
for ($r = 0; $r <= $count -1; $r++) {

$botos =  $config->r_boto;

$param  = $_campos[$r]['prm'];
$campos = $_campos[$r]['cmp'];
$accion = "con";
$comilla = "'";

$_dato   =  explode("|",$config->r_dato);

$dato   =  $_dato[0];

if (isset($id)) {
    foreach ($id[$r] as $key => $rdo) {
            $_indexc .= $rdo.'--'; 
    }
}

$i=0;
?>



<?php if (isset($emp)) { 

//echo print_r($emp,true);
?>
<div class="row">
 <div class="col-md-2"></div>
    <div class="col-md-8">
<table class="table table-striped" id = "detTable">
    <thead>
    <tr>
        <th width = "10" >No</th>
        <?php if (isset($campos)) { foreach ($campos as $campo){
                  $lista = explode("|",$campo['lst']);
                  if ($lista[0] == 1) {?>
                    <th data-sortable="true"><?= $campo['as'] ?></th>
        <?php }}}?>
        <th width = "30"></th>
    </tr>
    </thead>
    <tbody>

        <?php foreach($emp[$r] as $em ){ ?>
        <?php $i++;
              $_index = "";
              if (isset($campos)) { foreach ($campos as $campo){
                      foreach ($em as $key => $rdo) {
                      if (strtolower($campo['campo']) == $key) {

                     
                     if ($campo['id'] == 1) {
                         //echo print_r($campo['campo'],true);
                         //echo print_r($em,true);
                         //echo print_r($em[$campo['campo']],true);
                                              //$_index .= $em[$campo['campo']].'--';
                           $_index .= $rdo.'--';
                         
                     }
             }}}}           
           
         ?>
        <tr id="tr$id">
            <td><?= $i; ?></td>
            <?php if (isset($campos)) { foreach ($campos as $campo){
                      foreach ($em as $key => $rdo) {
                      if (strtolower($campo['campo']) == $key) {
                     $lista = explode("|",$campo['lst']);
                     if ($lista[0] == 1) { ?>
                        <td><?= $rdo; ?></td>
            <?php }}}}}?>
            <td>
                <a href="javaScript:;" onclick="add_person('N','N');carga('<?= base_url() ?>empresa/actualizar/<?= $dato.'/'.$i.'/'.$_index.'/D'.'/'.$r.'/'.$ubic ?>','contenidom');" id="lnk_act" >a</a>
                <a href="javaScript:;" onclick="if (eliminar()== true) { carga('<?= base_url() ?>empresa/eliminar/<?= $dato.'/'.$i.'/'.$_index.'/D'.'/'.$r.'/'.$ubic ?>','filtro');}" id="lnk_eli" >e</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <th></th>
        <?php if (isset($campos)) { foreach ($campos as $campo){
                  $lista = explode("|",$campo['lst']);
                  if ($lista[0] == 1) {?>
                    <th></th>
        <?php }}}?>
        <th></th>
    </tr>
    </tfoot>
    
</table>
    </div>
    <div class="col-md-2"></div>
<div>
<?php }  else {?>
    <p><?= 'No existen Registros'; ?></p>
<?php  } ?>
<ul><li>
    
         <a href="javaScript:;" onclick="add_person();carga('<?= base_url() ?>empresa/nuevo/<?= $dato.'/0/'.$_indexc.'/D/'.$r.'/'.$ubic ?>','contenidom');" class="lnk_btn" >Crear Registro  </a>
    
</li></ul>
<?php  } ?>
<?php  exit; ?>