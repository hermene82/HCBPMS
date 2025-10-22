
<?php
	$_index  = "";
	$_campos = $config->r_campos;
	
	$botos  =  $config->r_boto;
	$botosd =  $config->r_camposbot;
	
	$param  = $_campos['prm'];
	$campos = $_campos['cmp'];
	$btn    = $_campos['btn'];

	//print_r($btn); exit;
	
	$accion   = "con";
	$comilla  = "'";
	$comillaD = '"';
	$coma = ",";
	
	$_dato   =  explode("|",$config->r_dato);
	
	$dato   =  $_dato[0];

	//print_r($dato);
	//exit;
	//$_SESSION["dato"] = $dato;
	
	$i=0;
?>

<?php 
    // agreaga botones
    if (isset($botos)) {
	if (is_array($botos)) {  
	foreach ($botos as $bot){ ?>
	<div class="btn-group">
		<a class="btn btn-outline-primary" title= "<?= $bot['title'] ?>" href="javaScript:;" onclick="<?= $bot['proceso'] ?>"><img src="<?= $bot['imagen'] ?>" alt="enviar" height="42" width="42" /></a>              
		<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"></button>
		<div class="dropdown-menu">
			<input id="txtdar" type="text">
			<input id="txtdarr" type="text">
			<input id="txtdarr" type="date">
			
		</div>
	</div> 		
<?php }}}  ?>

<?php if (isset($botosd)) {
	//echo print_r ($botosd,true);
	if (is_array($botosd)) { 
	$ir=0; ?>
	<?php foreach ($botosd as $bot){?>
		<div class="btn-group">              
			<button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"><?= $bot['title'] ?></button>
			<?php
				$bparam  = $bot['prm'];
				$bcampos = $bot['cmp'];
				$bbtn    = $bot['btn'];
				$bbtnn   = '1';
				if (isset($bot['btnn'])) {
				    $bbtnn   =  $bot['btnn'];
				}
			?>				  
			
			<div class="dropdown-menu">
				<?php if (isset($bemp)) {?>
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id = "detrTable">
						<thead>
							<tr>
								<th width = "10" ></th>
								<th width = "10" >No</th>
								<?php if (isset($bcampos)) { foreach ($bcampos as $campo){
									$lista = explode("|",$campo['lst']);
									if ($lista[0] == 1) {?>
									<th><?= $campo['as'] ?></th>
								<?php }}}?>
								<th width = "30"></th>
							</tr>
						</thead>
						<tbody>
							<?php $i=0;//echo print_r ($bemp,true); ?>
							<?php //echo print_r ('HOLA',true); ?>
							<?php //echo print_r ($bot['tabla'],true); ?>
							
							<?php if(is_array($bemp[$ir][$bot['tabla']]) || is_object($bemp[$ir][$bot['tabla']])){ ?>
							<?php foreach($bemp[$ir][$bot['tabla']] as $em ){ ?>
								<?php $i++;
									$_index = ""; 
									if (isset($bcampos)) { foreach ($bcampos as $campo){
										if ($campo['id'] == 1) {
											//echo print_r($campo['campo'],true);
											//echo print_r($em,true);
											//echo print_r($em[$campo['campo']],true);
											$_index .= $em[$campo['campo']].'--';
										}
									}}
									
								?>
								<tr id="tr$id">
									<td> </td>
									<th><?= $i; ?></th>
									<?php if (isset($bcampos)) { foreach ($bcampos as $campo){
										$lista = explode("|",$campo['lst']);                      
										if ($lista[0] == 1) { ?>
										<th><?= $em[$campo['campo']]; ?></th>
									<?php }}} ?>
									<td>
										<?php if (is_array($bbtn)) { foreach ($bbtn as $bt){ ?>
											
											<a title= "<?= $bt['title'] ?>" href="javaScript:;" onclick="<?= $bt['procesoa'].$dato.'/'.$i.'/'.$_index.'/B'.'/'.$ir.$bt['procesob'] ?>" id = "<?= $bt['id'] ?>" > <?= $bt['men'] ?> </a>
											
											
										<?php }}?>
										
									</td>
								</tr>
							<?php } ?>
							<?php } ?>
						</tbody>
						
						
					</table>
					<?php }  else {?>
					<p><?= 'No existen Registros'; ?></p>
				<?php  } ?>
				<?php if ($bbtnn == '1'){ ?>
				<li>
				
					<a href="javaScript:;" onclick="add_person();carga('<?= base_url() ?>empresa/nuevo/<?= $dato.'/0/'.$_index.'/B/'.$ir ?>','contenidom');" class="lnk_btn" >Crear Registro  </a>
				
				</li>
				<?php  } ?>
			</div>
		</div> 
		
		<?php $ir++;
		}?>
		
<?php  }} ?>




<?php $i=0;// </li></ul> ?>



<?php 
	$_camposf =  $config->r_filtros;
	
	if (isset($_camposf)) {
		if (is_array($_camposf)) {
			
		?>
		
		<button type="button" class="btn btn-labeled btn-warning" data-toggle="collapse" data-target="#demo">Filtrar</button>
		
	<?php }} ?>
	
	<?php 
		$_camposf =  $config->r_importa;
		
		if (isset($_camposf)) {
			if (is_array($_camposf)) {
				
			?>
			
			<button type="button" class="btn btn-labeled btn-primary" data-toggle="collapse" data-target="#demo2">Importar</button>
			
		<?php }} ?>
		
		
		<?php
			
			$_camposf =  $config->r_filtros;
			
			if (isset($_camposf)) {
				if (is_array($_camposf)) {
					
					$camposf = $_camposf['cmp'];
					
				?>
				
				
				<?php
				    //echo print_r($car, true);
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
												$lst= array(''=>'TODOS');
												//$lst = array();
												//echo '881111|';
												//echo print_r($key, true);
												//echo print_r($c, true);
												if (strtoupper($elem['cat']) == strtoupper($key)) {
													foreach ($c as $carl) {
														$r = array($carl['DDIC_LISTA'] => $carl['DDIC_NOMBRE']);
														$lst = $lst + $r;
													}
													foreach ($camposf as $rc => $campo) {
														if (strtoupper($campo['campo']) == strtoupper($elem['campo'])) {
															foreach ($campo as $re => $elemt) {
																if (is_array($elemt) and $elemt['tipo'] == 'cbo') {
																	$camposf[$rc][$re]['attr']['opcion'] = ($lst);
																	
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
					
					if (isset($deff)) {
						//$accion =  'mod';
						//echo print_r($deff,true);
						foreach ($deff as $em) {
							//echo print_r($em,true);
							foreach ($em as $key => $rdo) {
								foreach ($camposf as $rc => $campo){
									if (strtoupper($campo['campo']) == $key) {
										foreach ($campo as $re => $elem){
											if (is_array($elem) and $elem['tipo'] == 'txt'){
												$camposf[$rc][$re]['attr']['value'] = $rdo;
											}
											if (is_array($elem) and $elem['tipo'] == 'cbo'){
												$camposf[$rc][$re]['attr']['select'] = $rdo;
											}
											
										}
									}
								}
							}
						}
					}
					
					//echo print_r($camposf,true);
				?>
				<?= form_open('','id = "formf" border="0"')?>
				
				<fieldset class="field_set_main"  >
					<ul><li><div class="field">
						
						<div id="demo" class="collapse">
							<div class="card">
								<div class="card-body d-flex justify-content-between align-items-center">
									<?php foreach ($camposf as $campo){ ?>
										<?php foreach ($campo as $elem){ ?>
											<?php if (is_array($elem)) { ?>
												<?php if ($elem['tipo'] == 'lbl' ) { ?>
													<?= form_label($elem['attr']['text'],$elem['attr']['for'],$elem['attr']['attr'])?>
												<?php } ?>
												<?php if ($elem['tipo'] == 'txt' ) { ?>
													<?= form_input($elem['attr'])?>
													
												<?php } ?>
												<?php if ($elem['tipo'] == 'cbo' ) { ?>
													<?= form_dropdown($elem['attr']['for'],$elem['attr']['opcion'],$elem['attr']['select'],$elem['attr']['attr'])?>
												<?php } ?>
												
											<?php } ?> &nbsp;
										<?php } ?>    
									<?php } ?>
									
									<?= form_button('opconsulta','Consultar','onClick = "consultar(event,'.$comilla. $accion .$comilla.','.$comilla. $dato .$comilla.')" class="btn btn-light" ' )?> 			    
									
									<?= form_close()?>
									
								</li></ul>
						</fieldset>
						
					</div>
					</div>
					</div>
					
					
					
				<?php  }} ?>
				
		</div>
		
		<?php
			
			$_camposf =  $config->r_importa;
			
			if (isset($_camposf)) {
				if (is_array($_camposf)) {
					
					$camposf = $_camposf['cmp'];
					
				?>
				
				
				<?php
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
												$lst= array(''=>'TODOS');
												//$lst = array();
												//echo '881111|';
												//echo print_r($key, true);
												//echo print_r($c, true);
												if (strtoupper($elem['cat']) == strtoupper($key)) {
													foreach ($c as $carl) {
														$r = array($carl['DDIC_LISTA'] => $carl['DDIC_NOMBRE']);
														$lst = $lst + $r;
													}
													foreach ($camposf as $rc => $campo) {
														if (strtoupper($campo['campo']) == strtoupper($elem['campo'])) {
															foreach ($campo as $re => $elemt) {
																if (is_array($elemt) and $elemt['tipo'] == 'cbo') {
																	$camposf[$rc][$re]['attr']['opcion'] = ($lst);
																	
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
					
					if (isset($deff)) {
						//$accion =  'mod';
						//echo print_r($deff,true);
						foreach ($deff as $em) {
							//echo print_r($em,true);
							foreach ($em as $key => $rdo) {
								foreach ($camposf as $rc => $campo){
									if (strtoupper($campo['campo']) == $key) {
										foreach ($campo as $re => $elem){
											if (is_array($elem) and $elem['tipo'] == 'txt'){
												$camposf[$rc][$re]['attr']['value'] = $rdo;
											}
											if (is_array($elem) and $elem['tipo'] == 'cbo'){
												$camposf[$rc][$re]['attr']['select'] = $rdo;
											}
											
										}
									}
								}
							}
						}
					}
					
					//echo print_r($camposf,true);
				?>
				<?= form_open('','id = "formarch" method="post" enctype="multipart/form-data" border="0"')?>
				
				<fieldset class="field_set_main"  >
					<ul><li><div class="field">
						
						<div id="demo2" class="collapse">
							<div class="card">
								<div class="card-body d-flex justify-content-between align-items-center">
									<?php foreach ($camposf as $campo){ ?>
										<?php foreach ($campo as $elem){ ?>
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
												<?php if ($elem['tipo'] == 'ach' ) { ?>
													<?= form_upload($elem['attr'])?>
												<?php } ?>
												<?php if ($elem['tipo'] == 'btn' ) { 
													$especial = "importar(event".$coma.$comilla. $accion .$comilla.$coma.$comilla. $dato .$comilla.$coma.$comilla. $campo['esp'] .$comilla.")";
													//$array = array('onClick'=> $especial);
													//$attrbtn = array_combine($elem['attr'],$array);
													//echo print_r($array,true);
													//echo print_r($attrbtn,true);
													//echo print_r($elem['attr'],true);
													
												?>
												<?= form_button($elem['attr'],$campo['as'],'onClick = "'. $especial .'"; ');			
												?>
												<?php } ?>
												
											<?php } ?> &nbsp;
										<?php } ?>    
									<?php } ?>
									
									<?= form_close()?>
									
								</li></ul>
						</fieldset>
						
					</div>
					</div>
					</div>
					
					
					
				<?php  }} ?>
				
		</div>
		
		
		
		<?php if (isset($emp)) {?>
			<table cellpadding="0" cellspacing="0" border="0" class="display" id = "myTable">
				<thead>
					<tr>
						<th width = "10" ></th>
						<th width = "10" >No</th>
						<?php if (isset($campos)) { foreach ($campos as $campo){
							$lista = explode("|",$campo['lst']);
							if ($lista[0] == 1) {?>
							<th><?= $campo['as'] ?></th>
						<?php }}}?>
						<th width = "30"></th>
					</tr>
				</thead>
				<tbody>
					
					<?php foreach($emp as $em ){ ?>
						<?php $i++;
							$_index = ""; 
							if (isset($campos)) { foreach ($campos as $campo){
								if ($campo['id'] == 1) {
									//echo print_r($campo['campo'],true);
									//echo print_r($em,true);
									//echo print_r($em[$campo['campo']],true);
									//$_index .= $em[strtolower($campo['campo'])].'--';
									//$_index .= $em[strtolower($campo['campo'])].'--';
									$_index .= isset($em[strtolower($campo['campo'])]) ? $em[strtolower($campo['campo'])] . '--' : (isset($em[strtoupper($campo['campo'])]) ? $em[strtoupper($campo['campo'])] . '--' : '--');
								}
							}}
							
						?>
						<tr id="tr$id">
							<td class="details-control"><a href="javaScript:;" onclick="cargadet('<?= base_url() ?>empresa/detalle/<?= $dato.'/'.$i.'/'.$_index ?>','contenido','<?= $i-1 ?>');" id="lnk_det" >d</a></td>
							<th><?= $i; ?></th>
							<?php if (isset($campos)) { foreach ($campos as $campo){
								$lista = explode("|",$campo['lst']);                      
								if ($lista[0] == 1) { ?>
								<th><?= isset($em[strtolower($campo['campo'])]) ? $em[strtolower($campo['campo'])] : (isset($em[strtoupper($campo['campo'])]) ? $em[strtoupper($campo['campo'])] : ''); ?></th>
							<?php }}}?>
							<td>
								<?php if (is_array($btn)) { foreach ($btn as $bt){ ?>
									
									<a title= "<?= $bt['title'] ?>" href="javaScript:;" onclick="<?= $bt['procesoa'].$dato.'/'.$i.'/'.$_index.$bt['procesob'] ?>" id = "<?= $bt['id'] ?>" > <?= $bt['men'] ?> </a>
									
									
								<?php }}?>
								
							</td>
						</tr>
					<?php }  ?>
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
			<?php }  else {?>
			<p><?= 'No existen Registros'; ?></p>
		<?php  } ?>
		<ul><li></li></ul>
		<ul><li>
			<a href="javaScript:;" onclick="add_person();carga('<?= base_url() ?>empresa/nuevo/<?= $dato ?>','contenidom');" class="lnk_btn" >Crear Registro  </a>
			
		</li></ul>

		<?php  exit; ?>