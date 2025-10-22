<?php
$_campos =  $this->config->item('r_filtros');

$param  = $_campos['prm'];
$campos = $_campos['cmp'];

$_dato   =  explode("|",$this->config->item('r_dato'));
$dato   =  $_dato[0];

//$campos =  $this->config->item('r_campos');
//$dato   =  $this->config->item('r_dato');
//$accion =  $this->config->item('r_accion');
//echo '881111|';echo $this->config->item('r_accion');

$accion =  $this->config->item('r_accion');
$comilla = "'";
if (isset($emp)) {
    //$accion =  'mod';
    //echo print_r($emp,true);
    foreach ($emp->result() as $em) {
        //echo print_r($em,true);
        foreach ($em as $key => $rdo) {
            foreach ($campos as $rc => $campo){
                //if (strtoupper($campo['campo']) == $key) {
                if (($campo['campo']) == $key) {
                    foreach ($campo as $re => $elem){
                        if (is_array($elem) and $elem['tipo'] == 'txt'){
                            $campos[$rc][$re]['attr']['value'] = $rdo;
                        }
                        if (is_array($elem) and $elem['tipo'] == 'cbo'){
                            if (strpos($rdo,"|") === false ){
                                $campos[$rc][$re]['attr']['select'] = $rdo;
                            }else{
                                $campos[$rc][$re]['attr']['select'] = explode("|",$rdo);
                            }
                        }

                    }
                }
            }
        }
    }
}


$cat =  $this->config->item('r_combo');
if (isset($cat)) {
    foreach ($cat as $elem) {
        //echo '771111|';
        //echo print_r($elem, true);
        if (is_array($elem)) {
            if ($elem['cat'] != '') {
                if (isset($car)) {
                    foreach ($car as $care) {
                        foreach ($care as $key => $c) {
                            unset($lst);
                            $lst= array(''=>'seleccione item');
                            //$lst = array();
                            //echo '881111|';
                            //echo print_r($key, true);
                            //echo print_r($c, true);
                            if (strtoupper($elem['cat']) == strtoupper($key)) {
                                foreach ($c as $carl) {
                                    $r = array($carl['DDIC_LISTA'] => $carl['DDIC_NOMBRE']);
                                    $lst = $lst + $r;
                                }
                                foreach ($campos as $rc => $campo) {
                                    if (strtoupper($campo['campo']) == strtoupper($elem['campo'])) {
                                        foreach ($campo as $re => $elemt) {
                                            if (is_array($elemt) and $elemt['tipo'] == 'cbo') {
                                                $campos[$rc][$re]['attr']['opcion'] = ($lst);

                                            }
                                        }
                                    }
                                }
                            }

                        }
                    }
                }
            }
        }
    }
}



echo print_r($campos,true);
?>

<ul><div class="field">
<?php foreach ($campos as $campo){ ?>
    <li><?php foreach ($campo as $elem){ ?>
            <?php if (is_array($elem)) { ?>
                <?php if ($elem['tipo'] == 'lbl' ) { ?>
                    <?= form_label($elem['attr']['text'],$elem['attr']['for'],$elem['attr']['attr'])?>
                <?php } ?>
                <?php if ($elem['tipo'] == 'txt' ) { ?>
                    <?= form_input($elem['attr'])?>
                    <?= form_error("'".$elem['attr']['name']."'");?>
                <?php } ?>
                <?php if ($elem['tipo'] == 'cbo' ) { ?>
                    <?= form_dropdown($elem['attr']['for'],$elem['attr']['opcion'],$elem['attr']['select'],$elem['attr']['attr'])?>
                <?php } ?>

            <?php } ?>
        <?php } ?>
    </li>
<?php } ?></div>
</ul>


    <? echo $accion ?>
    <?= form_submit('opgraba','consultar','onClick = "graba(event)" class="lnk_btn" ' )?>



<?= form_close()?>
<div id = "mensaje"></div>