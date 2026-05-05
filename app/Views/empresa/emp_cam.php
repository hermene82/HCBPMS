<?php
if (isset($ubic)) {
    $ubica = $ubic;
}
if (isset($ubic_det)) {
    $ubica_det = $ubic_det;
}
$indexca = '';
if (isset($indexc)) {
    $indexca = $indexc;
}

if (isset($det)) {
    //echo $det;
    if ($det == 'D'){		
    $_campos =  $config->r_camposdet;
	$param  = $_campos[$deti]['prm'];
    $campos = $_campos[$deti]['cmp'];
    }else{
	if ($det == 'B'){
    $_campos =  $config->r_camposbot;
	$param  = $_campos[$deti]['prm'];
    $campos = $_campos[$deti]['cmp'];
    }else{
	$_campos =  $config->r_campos;	
    $param  = $_campos['prm'];
    $campos = $_campos['cmp'];
	}}
	
}else{
$_campos =  $config->r_campos;	
$param  = $_campos['prm'];
$campos = $_campos['cmp'];		
}

$_dato   =  explode("|",$config->r_dato);
$dato   =  $_dato[0];

$accion =  $config->r_accion;
$comilla = "'";

if ($accion == 'mod'){
   $acc = 2 ;
}

if ($accion == 'nue'){
   $acc = 1 ;
}

if (isset($emp)) {
    //$accion =  'mod';
    //echo print_r($emp,true); exit;
    foreach ($emp as $em) {
        //echo print_r($em,true);
		//echo print_r($campos,true);
        foreach ($em as $key => $rdo) {
            foreach ($campos as $rc => $campo){
                //if (strtoupper($campo['campo']) == $key) {
                if (strtoupper($campo['campo']) ==strtoupper($key)) {
                    foreach ($campo as $re => $elem){
                        if (is_array($elem) and $elem['tipo'] == 'txt'){
                            //echo "-".$rdo;
                            $campos[$rc][$re]['attr']['value'] = $rdo;
                        }
                        if (is_array($elem) and $elem['tipo'] == 'txta'){
                            //echo "-".$rdo;
                            $campos[$rc][$re]['attr']['value'] = $rdo;
                        } 
                        if (is_array($elem) and $elem['tipo'] == 'cbo'){
                            if (strpos($rdo,"|") === false ){
                                //echo $rdo;
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

if (isset($def)) {
    //$accion =  'mod';
    //echo print_r($emp,true);
    foreach ($def as $em) {
        //echo print_r($em,true);
        foreach ($em as $key => $rdo) {
            foreach ($campos as $rc => $campo){
                if (strtoupper($campo['campo']) == strtoupper($key)) {
                    foreach ($campo as $re => $elem){
                        if (is_array($elem) and $elem['tipo'] == 'txt'){
                            $campos[$rc][$re]['attr']['value'] = $rdo;
                        }
                        if (is_array($elem) and $elem['tipo'] == 'txta'){
                            $campos[$rc][$re]['attr']['value'] = $rdo;
                        }
                        if (is_array($elem) and $elem['tipo'] == 'cbo'){
                            $campos[$rc][$re]['attr']['select'] = $rdo;
                        }

                    }
                }
            }
        }
    }
}



$cat =  $config->r_combo;
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
							   
							   if (isset($elem['fill'])){
								   
								   $this->_fill = explode("|",$elem['fill']);
								   $this->lcampo = $this->_fill[0];
								   //echo $this->lcampo;
								   //echo $this->_fill[1];
								   //echo print_r($carl,true);
								    foreach ($campos as $rc => $campoo){
										//echo print_r($campoo['campo']);    
										if (strtoupper($campoo['campo']) == $this->_fill[1]) {
											foreach ($campoo as $re => $elemm){
												if (is_array($elemm) and $elemm['tipo'] == 'txt'){
													$this->lvalor = $campos[$rc][$re]['attr']['value'];
												}
												if (is_array($elemm) and $elemm['tipo'] == 'txta'){
													$this->lvalor = $campos[$rc][$re]['attr']['value'];
												}
												if (is_array($elemm) and $elemm['tipo'] == 'cbo'){
													$this->lvalor = $campos[$rc][$re]['attr']['select'];
												}

											}
										}
									}
									//echo print_r($this->lvalor,true);
								   //echo print_r($campos,true);
								   //echo print_r($c,true);
								   $new = array_filter($c, function ($var) {
											//return ($var['NOMBRE1'] == 'CarEnquiry');
											return ($var[$this->lcampo] == $this->lvalor);
										});
										
								$c = $new ;   
							   }
                               
                               //echo print_r('aqui 124356',true);
                               //echo print_r($c,true);

                               if (is_array($c)) {
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
                               }}
                           }

                       }
                   }
               }
            }
        }
    }
}
//echo print_r($campos,true);
//echo $acc;

?>

<?php
//<fieldset class="field_set_main"  >
//<ul>
 //<div class="field"> ?>
<div class="form-grid"> 
<form id = "form" autocomplete="off">   
<?php foreach ($campos as $campo){ 
      //echo print_r($campo);
      //echo print_r($campo['lst']);
      $lista = explode("|",$campo['lst']);
      //echo print_r($lista,true);
       if ($lista[$acc] == 1) { ?> 
               

	<div class="form-group has-float-label"> 
	<?php foreach ($campo as $elem){?>
        <?php if (is_array($elem)) { 
              if ( $acc == 1 and $elem['tipo'] == 'txt'){
                 if ($elem['attr']['value']== '' ) {
                     unset($elem['attr']['readonly']); 
                 }}   
            
            ?>
            <?php if ($elem['tipo'] == 'txt' ) { 
			array_push($elem,$elem['attr']['class']='form-control-lg')?>
            <?= form_input($elem['attr'])?>
            <?= ''//form_error("'".$elem['attr']['name']."'");?>
            <?php } ?>
            <?php if ($elem['tipo'] == 'txta' ) {
			array_push($elem,$elem['attr']['class']='form-control-lg')?>
            <?= form_textarea($elem['attr'])?>
            <?= '' //form_error("'".$elem['attr']['name']."'");?>
            <?php } ?>

            <?php if ($elem['tipo'] == 'cbo' ) { 
			array_push($elem,$elem['attr']['class']='selectpicker-lg')?>
                <?= form_dropdown($elem['attr']['for'],$elem['attr']['opcion'],$elem['attr']['select'],'class="selectpicker w-100" data-width="100%" style="width:100%" '.$elem['attr']['attr'])?>
            <?php } ?>
            <?php if ($elem['tipo'] == 'lbl' ) {
			array_push($elem,$elem['attr']['class']='ph-area-lg')	?>
            <?= form_label($elem['attr']['text'],$elem['attr']['for'],$elem['attr']['attr'])?>
            <?php } ?>

        <?php } ?>
    <?php } ?>
    </div> 
		
<?php }} ?>
</form>
<?php //</div> 
//</ul>
//</fieldset>
?>
</div>
<div id = "grb_btn">
    <?= form_button('opgraba','Grabar','onClick = "graba(event,'.$comilla. $accion .$comilla.','.$comilla. $dato .$comilla.','.$comilla. $det .$comilla.','.$comilla. $deti .$comilla.','.$comilla. $ubica .$comilla.','.$comilla. $ubica_det .$comilla.','.$comilla. $indexca .$comilla.')" class="lnk_btn" ' )?>
</div>
<?= '' //form_close()?>

<div id = "mensajefin"></div>
<?php   exit; ?>