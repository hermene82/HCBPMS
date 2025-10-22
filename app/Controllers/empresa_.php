<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class empresa extends CMS_Controller{
		public $dato;
		public $datos;
		public $data;
		public $id;     
		
		public $botoo;
		public $comboo;
		public $datoo ;
		public $tablao;
		public $camposo;
		public $filtroo;
		public $indexo;
		public $acciono;
		public $importao;
		public $_fill;
		public $lcampo;
		public $lvalor;
		public $comi = "'";
		
		//public $validation_txt = 'trim|regex_match[[a-zA-Z]|\s]|xss_clean';
		public $validation_txt = 'trim';
		
		//public $consulta;
		
		function __construct(){
			parent::__construct();
			//echo 'jluio...constructor';
			//echo print_r($this->config->item('r_tabla'),true);
			//echo print_r($this->tablao,true);
			//$this->config->set_item('r_tabla', $this->config->item('r_tabla'));
			//echo print_r($this->config->item('r_tabla'),true);
			$this->load->helper('form');
			$this->load->model('empresa_model');
			$this->load->library('form_validation');
			$this->load->library('excel');
			
			//$this->config->set_item('r_index','0|0');
			//    $consulta = $this->empresa_model->emp();
			//    $this->data['emp'] = $consulta;
			//    $this->datos = $consulta->result_array();
			//    $this->config->set_item('r_datos', $this->datos);
			//$this->config->set_item('r_combo', $this->comboo);
			//$this->config->set_item('r_dato', $this->datoo);
			//    $this->config->set_item('r_tabla', $this->tablao);
			//$this->config->set_item('r_campos', $this->camposo);
			//$i = $this->uri->segment(2);
			//echo $i;
			//echo "Actualmente estas en la pagina: ".$ruta = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
			//$actual = $_SERVER['REQUEST_URI'];
			//echo"http://dom.dominio.com".$actual;
		}
		
		function __destruct() {
			//echo print_r($this->tablao,true);
			//echo 'chao';
			//$this->config->set_item('r_index',$this->indexo);
		}
		
		function index(){
			//echo "Actualmente estas en la pagina: ".$ruta = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
			//echo print_r($this->config->item('r_tabla'),true);
			//$consulta = $this->empresa_model->emp();
			//$data['emp'] = $consulta;
			$this->load->view('empresa/emp_cab');
			$this->load->view('empresa/emp_ind');
			//$this->load->view('empresa/emp_lst',$data);
			$this->load->view('empresa/emp_pie');
			//echo print_r($this->config->item('r_tabla'),true);
			//echo 'ref';
		}
		
		
		function ini(){
			//echo print_r($this->tablao,true);
			//$consulta = $this->empresa_model->emp();
			//$data['emp'] = $consulta;
			$this->load->view('empresa/emp_cab');
			$this->load->view('empresa/emp_ind');
			//$this->load->view('empresa/emp_lst',$data);
		}
		
		function fill() {
			$indice = $this->uri->segment(3);
			if ($indice == 'ABCDE'){
				$indice = 'CLIENTE';
			}
			
			$this->_param('_'.$indice);
			
			$id = $this->input->post('id');			
			
			if($id){
				//echo 'id'.$id;
				$dat = explode("|",$id);
				//echo 'dat'.$dat[1];
				$cmp = $dat[0];
				//echo 'cmp'.$cmp;
				
				$cat =  $this->config->item('r_combo');
				if (isset($cat)) {
					foreach ($cat as $elem) {
						if (is_array($elem)) {                         
							if ($elem['campo'] === $cmp) {
								$arr = $this->empresa_model->cat($elem['cat'],null);
							}
						}
					}             
				}
				
				$rgs = explode(";",$dat[1]);
				
				$count = count($rgs);                 
				for ($i = 0; $i < $count -1; $i++) {
					//echo print_r($rgs);
					$val = explode("-",$rgs[$i]);
					
					$this->lcampo = $val[0];
					$this->lvalor = $val[1];
					//echo 'cmplcmp'.$val[0];
					//echo 'cmplval'.$val[1];
					
					//var_dump($arr);
					
					//var_dump($this->lvalor);
					
					$newo = array_filter($arr, function ($var) {
						return ($var[$this->lcampo] == $this->lvalor);
					});
					//echo print_r($newo);
					$arr = $newo;  
					
				}
				
				echo '<option value="" selected >seleccione item</option>';	
				foreach ($newo as $carl) {
					echo '<option value="'. $carl['DDIC_LISTA'] .'">'. $carl['DDIC_NOMBRE'] .'</option>';
				}
				
				}  else {
				echo '<option value="" selectec >seleccione item</option>';
			}
		}
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// btn crea registo envia pantalla campos
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function nuevo(){
			$this->config->set_item('r_accion', 'nue');
			$indice = $this->uri->segment(3);
			
			$this->_param('_'.$indice);
			$i = $this->uri->segment(4);
			$_indexc = $this->uri->segment(5);
			$_det = $this->uri->segment(6);
			$_deti = $this->uri->segment(7);
			$_ubic_det = $this->uri->segment(8);
						
			$_dato   =  explode("|",$this->config->item('r_dato'));
			$_ubic   =  $_dato[4]."|".$i."|".$_indexc;

			if ($_det == 'D') {
			    //echo print_r ('paso x D',true);
				$cmp_val = explode("--",$_indexc);
				array_pop($cmp_val);
				
				$sd = explode(",",$this->config->item('r_indexdet'));
				$cam_ind =  explode("|",$sd[$_deti]);
				array_pop($cam_ind);
				
				$count_i = count($cmp_val);
				$count_f = count($cam_ind);
				
				if ($count_f > $count_i){ 
					for ($i = $count_i+1; $i <= $count_f; $i++) {
						unset($cam_ind[$i-1]);				
					}
				}
				
				$dat = array_combine($cam_ind,$cmp_val);
				//echo print_r ($dat,true);
				
				$this->id = $dat;
				
				$_campos =  $this->config->item('r_camposdet'); 
				$campos = $_campos[$_deti]['cmp'];		  
			}else{
				if ($_det == 'B') {
					//echo print_r ('paso x B',true);
					$_campos =  $this->config->item('r_camposbot');
					$campos = $_campos[$_deti]['cmp'];
					}else{
					//echo print_r ('paso x ',true);
					$_campos =  $this->config->item('r_campos');
					$campos = $_campos['cmp'];
				}
			}  
			
			$iddato = '';
			if (isset($dat)) {
				if (is_array($dat)){		
					if (isset($campos)) {
						foreach ($campos as $campo) {                     
							if ($campo['id']== 1) { 
								if (array_key_exists($campo['campo'],$dat)){
									$iddato = $iddato . '|' . $dat[$campo['campo']] ; 
									//$iddato = $iddato . $dat[$campo['campo']] ; 
								}
							}
						}
			}}}
					
			$arrprm=array();
			
			if (is_array($_campos)){
				//$campos = $_campos['cmp'];
				if (isset($campos)) {
					foreach ($campos as $campo) {
						$_prm = explode('-',$campo['esp']);					
						
						if (count($_prm)> 1) { 
							
							if ($_det == 'D') {
								$_prm[1] = $_prm[1].'|'. $campo['campo'] . $iddato;
							}
							
							$arrprm[$campo['campo']] = $this->datoD($_prm[1]);
						}
					}
			}}
						
			if (isset($dat)) {
				if (is_array($dat)){
					//$campos = $_campos['cmp'];
					if (isset($campos)) {
						foreach ($campos as $campo) {                     
							if ($campo['id']== 1) { 
								if (array_key_exists($campo['campo'],$dat)){
									$arrprm[$campo['campo']] =$dat[$campo['campo']] ;
								}
							}
						}
			}}}
								
								$arrdf[] = $arrprm;  
								
								$data['def'] = $arrdf;
								$data['emp'] = null;			
								
								$cat =  $this->config->item('r_combo');
								if (isset($cat)) {
									foreach ($cat as $elem) {
										if (is_array($elem)) {                         
											if ($elem['cat'] != '') {
												$arr[] = array($elem['cat'] => '');
											}
										}
									}
								$this->empresa_model->emp_catalogo($arr);   
								$data['car'] = $arr;
								} 
				
								$data['indexc'] = $_indexc;
								$data['det'] = $_det;
								$data['deti'] = $_deti;
								$data['ubic'] = $_ubic;
								$data['ubic_det'] = $_ubic_det;

								//$this->load->view('empresa/emp_cab');
								$this->load->view('empresa/emp_nue',$data);
								$this->load->view('empresa/emp_cam');
								//$this->load->view('empresa/emp_pie');
		}

		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// btn filtros para consulta -- pendiente
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function filtro(){
			//echo 'nuevo';
			$indice = $this->uri->segment(3);
			if ($indice == 'ABCDE'){
				$indice = 'CLIENTE';
			}		
			//echo $indice;
			$this->_param('_'.$indice);
			//echo print_r($this->tablao,true);
			//echo print_r($this->config->item('r_tabla'),true);
			//$this->ini();
			$data['emp'] = null;
			//$d = $_REQUEST;
			//echo print_r($d);
			
			$cat =  $this->config->item('r_combo');
			if (isset($cat)) {
				foreach ($cat as $elem) {
					if (is_array($elem)) {                         
						if ($elem['cat'] != '') {
							$arr[] = array($elem['cat'] => '');
						}
					}
				}
			$this->empresa_model->emp_catalogo($arr);   
			$data['car'] = $arr;
			} 
			
			//$this->load->view('empresa/emp_cab');
			$this->load->view('empresa/emp_nue_f',$data);
			$this->load->view('empresa/emp_cam_f');
			//$this->load->view('empresa/emp_pie');
		}
		
		
		function import()
		{
			//echo 'importar--------';
			//echo print_r($_REQUEST,true);
			//echo print_r($_FILES,true);
			
			if(isset($_FILES["file-0"]["name"]))
			{
				echo 'importar--------1';	
				$path = $_FILES["file-0"]["tmp_name"];
				$object = PHPExcel_IOFactory::load($path);
				echo 'importar--------3';	
				foreach($object->getWorksheetIterator() as $worksheet)
				{
					echo 'importar--------4';	
					$highestRow = $worksheet->getHighestRow();
					$highestColumn = $worksheet->getHighestColumn();
					
					$indice = '_guia' ;
					$this->_param($indice);
					
					// formato
					$tabla = ""; 
					//$regc[] = array();	
					// CABECERA
					// trae datos
					foreach($formato as $cat ){
						$pos = strpos($cat['NOMBRE1'],'-');				 
						if ($pos === false) {				    
							$_cell = explode(',',$cat['NOMBRE1']);
							//echo print_r($_cell);
							$col =$_cell[1];
							$row =$_cell[0];
							//array_push($regc,substr($cat['NOMBRE2'],strpos($cat['NOMBRE2'],'.')) => $worksheet->getCellByColumnAndRow($col, $row)->getValue());
							$regc[substr($cat['NOMBRE2'],strpos($cat['NOMBRE2'],'.')+1)] = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
							$tabla = substr($cat['NOMBRE2'],0,strpos($cat['NOMBRE2'],'.'));	   	          						
						}}
						// datos del document
						IF (trim($regc['DOCUMENTO']) != ''){   
							//SI HAY DATO EN CELDA
							$Rdata = $regc;
							//unset($Rdata['FECHA']);
							$Rdata['FECHA'] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($Rdata['FECHA']));   				   
							//echo 'Rdata';
							//echo print_r($Rdata);
							
							$GUIA = $this->empresa_model->r_emp($Rdata,$tabla);
							//echo 'tr';
							//echo print_r($GUIA);
							if($GUIA -> num_rows() == 0){	   			   
								//SI EXISTE GUIA
								
								$tr  = $this->empresa_model->catalogo('TRA',null);
								
								$rtr = array_filter( $tr, function( $e ) use ($Rdata) {
									return $e['NOMBRE2'] == $Rdata['PLACA'];
								});
								
								//echo 'rtr';
								//echo print_r($rtr);
								
								$_tr = explode('|',$rtr[0]['NOMBRE1']);
								$rAD['TRANSP']= $rtr[0]['CODIGO'];
								$rAD['TN']= $_tr[2];
								$rAD['TPCLIMA']=  $_tr[3];
								$rAD['PROLIQ'] = 'N';
								$rAD['PROVAL'] = 'S';
								$rAD['PROITEM'] = 'L01';
								$rAD['PLACALQ'] = $Rdata['PLACA'];
								
								//echo 'rAD';
								//echo print_r($rAD);
								
								// traer campos
								
								$_campos =  $this->config->item('r_campos');
								$campos = $_campos['cmp'];
								if (isset($campos)) {
									foreach ($campos as $campo) {    
										$r_cab[$campo['campo']] = "";
										//array_push($r_cab,$campo['campo']=>"");
									}}  
									
									//echo 'r_cab';
									//echo print_r($r_cab);
									$cdata = $r_cab;//array_merge($cdata,$r_cab);
									$cdata = array_merge($cdata,$rAD);
									$cdata = array_merge($cdata,$regc);
									
									
									//datos x esp y x def
									
									if (isset($campos)) {
										foreach ($campos as $campo) {
											$_prm = explode('-',$campo['esp']);
											if (count($_prm)> 1) { 
												$arrprm_esp[$campo['campo']] = $this->datoD($_prm[1]);
												if (trim($arrprm_esp[$campo['campo']]) == ''){
													unset ($arrprm_esp[$campo['campo']]);
												}							 
											}
										}
									}
									//echo 'r_cab';
									//echo print_r($r_cab);
									
									$cdata = array_merge($cdata,$arrprm_esp);
									
									
									if (isset($campos)) {
										foreach ($campos as $campo) {
											$_prm = explode('-',$campo['esp']);                      
											if (count($_prm)>1){
												if ($_prm[1]!=''){ 
													if (!array_key_exists($campo['campo'], $arrprm_esp)){
														$arrprm_espo[$campo['campo']] = $this->datoD($_prm[1],'E'); 
														if (trim($arrprm_espo[$campo['campo']]) == ''){
															unset ($arrprm_espo[$campo['campo']]);
														}	 						 
													}}}
										}
									}
									
									$cdata = array_merge($cdata,$arrprm_espo);
									
									//datos x def				
									
									//if (isset($campos)) {
									//	foreach ($campos as $campo) {                     
									//			 if ($campo['id']== 1) { 
									//				 if (array_key_exists($campo['campo'],$dat)){
									//					 $arrprm_def[$campo['campo']] =$dat[$campo['campo']] ;
									//				 }
									//			 }
									//	}
									//}
									
									//$cdata = array_merge($cdata,$arrprm_def); 
									
									//echo print_r($cdata); 	
									
									
									
									// DETALLE
									//inicio detalle
									foreach($formato as $cat ){
										$pos = strpos($cat['NOMBRE1'],'-');				 
										if ($pos != false) {	
											//$cat['NOMBRE1'] = str_replace(".","",$cat['NOMBRE1']);					
											$_cell = explode(',',str_replace("-","",$cat['NOMBRE1']));						
											$row_i =$_cell[0];				        
											$tbd = substr($cat['NOMBRE2'],0,strpos($cat['NOMBRE2'],'.'));	   	          
										}}
										
										// trae campos
										
										$_campos =  $this->config->item('r_camposdet');
										$campos = $_campos['cmp'];
										if (isset($campos)) {
											foreach ($campos as $campo) {  
												$r_det[$campo['campo']] = "";
												//array_push($r_det,$campo['campo']=>"");
											}}  
											
											
											// traer datos
											$iteracion = 0;
											$bultos = 0;
											$valorr = 0;
											for($row=$row_i; $row<=$highestRow; $row++)
											{			
												foreach($formato as $cat ){
													$pos = strpos($cat['NOMBRE1'],'-');				 
													if ($pos != false) {				    
														$_cell = explode(',',str_replace("-","",$cat['NOMBRE1']));
														$col =$_cell[1];
														//$row =$_cell[1];
														//array_push($regd,substr($cat['NOMBRE2'],strpos($cat['NOMBRE2'],'.')) => $worksheet->getCellByColumnAndRow($col, $row)->getValue());								   	         
														$regd[substr($cat['NOMBRE2'],strpos($cat['NOMBRE2'],'.')+1)] = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
														
														$ddata = array_merge($r_det,$regd);							
														$ddata = array_merge($ddata,$arrprm_esp);
														$ddata = array_merge($ddata,$arrprm_espo);
													}}
													
													// traer campos
													$iteracion = $iteracion + 1;
													$sec['SEC'] = $iteracion;
													$ddata = array_merge($ddata,$sec);
													$bultos = $bultos + $ddata['NBULT'];
													$valorr = $valorr + $ddata['VALOR'];
													//$data[] = $ddata;	
													
													//$tabla = $tbd;
													
													//echo print_r($data); 	
													unset($ddata['IDGUIA']);
													//unset($ddata['TIPO']);
													//unset($ddata['TBULT']);
													//unset($ddata['OBSER']);
													//unset($ddata['UBICA']);
													//unset($ddata['REFEREN']);
													//unset($ddata['PROASO']);
													//unset($ddata['PROLIQ']);	
													//unset($ddata['PROITEM']);	
													//unset($ddata['USUCREA']);	
													//unset($ddata['FCHCREA']);
													//unset($ddata['USUMODIF']);
													//unset($ddata['FCHMODIF']);
													//unset($ddata['FECHA']);
													
													
													$ddata['FECHA'] =  date('Y/m/d', strtotime(str_replace("/","-",$ddata['FECHA'])));
													$ddata['FCHCREA'] =  date('Y/m/d', strtotime(str_replace("/","-",$ddata['FCHCREA'])));
													$ddata['FCHMODIF'] =  date('Y/m/d', strtotime(str_replace("/","-",$ddata['FCHMODIF'])));
													
													$this->empresa_model->crear_emp($ddata,$tbd);
													//$err = $this->empresa_model->errBase();
													
													//if (isset($err)) {
													//	echo "|1|".$err;
													//}
													//else{
													//	echo "|0|";
													//}
													
											}
											
											$cdata['FECHA'] =  date('Y/m/d', strtotime(str_replace("/","-",$cdata['FECHA'])));
											$cdata['FCHCREA'] =  date('Y/m/d', strtotime(str_replace("/","-",$cdata['FCHCREA'])));
											$cdata['FCHMODIF'] =  date('Y/m/d', strtotime(str_replace("/","-",$cdata['FCHMODIF'])));
											
											$cdata['COSTO'] = 	$valorr * 0.025	;	 
											$cdata['NBUL']	= $bultos;
											// enviar cab insert
											$this->empresa_model->crear_emp($cdata,$tabla);	
											
							} // SI EXISTE GUIA
						} // SI HAY DATO EN CELDA
						
				}
				
				echo 'importar--------6';	
				//echo print_r($data,true);
				//$this->excel_import_model->insert($data);
				echo 'Data Imported successfully';
			} 
		}
		
		
		function consfiltro(){
			$indice = $this->uri->segment(3);
			if ($indice == 'ABCDE'){
				$indice = 'CLIENTE';
			}		 
			//echo 'consfiltro'.$indice;
			$this->_param('_'.$indice);
			
			if (!$this->input->is_ajax_request()){
				//echo "|0|no ajax";
				//redirect ('404');
				}else{
				//echo ' ajax';
				$rules = [];
				
				$_campos =  $this->config->item('r_filtros');
				$campos = $_campos['cmp'];
				
				if (isset($campos)) {
					foreach ($campos as $campo) {
						foreach ($campo as $elem) {
							if (is_array($elem)) {
								if ($elem['tipo'] == 'rls') {
									array_push($rules, $elem['attr']);
								}
							}
						}
					}}
					
					//$this->form_validation->set_error_delimiters('<div>','</div>');
					//$this->form_validation->set_rules($rules);
					$FCHA = (new DateTime('now'))->format('Y-m-d H:i:s');
					$arrd[] = array('USUCREA'=>'USU','USUMODIF'=>'USU','FCHCREA'=>''.$FCHA,'FCHMODIF'=>''.$FCHA);
					
					//if($this->form_validation->run() == TRUE)
					//{
					
					
					$data = $_REQUEST;
					unset($data['url']);
					//$dat = $data;
					
					if (isset($campos)) {
						foreach ($campos as $rc => $campo) {
							foreach ($data as $rd => $dt ) {
								foreach ($campo as $elem) {
									if (is_array($elem)) {
										if ($elem['tipo'] == 'cbo' and strtoupper($rd) == strtoupper($campo['campo'])) {
											if (strpos($elem['attr']['attr'],'multiple="multiple"') !== false) {
												$cdat = $data[$rd];
												$data[$rd] = implode("||",$cdat);
											}
										}
									}
								}
							}
						}
					}
					
					$arrdf[] = $data;
					
					$data['deff'] = $arrdf;
					
					
					//----------------------------------------------------------------------------------
					$w_dato ='';
					if (isset($campos)) {
						foreach ($campos as $rc => $campo) {
							foreach ($data as $rd => $dt ) {
								//foreach ($campo as $elem) {
								//if (is_array($elem)) {
								if (strtoupper($rd) == strtoupper($campo['campo'])) {
									//if (strpos($elem['attr']['attr'],'multiple="multiple"') !== false) {
									if (trim($data[$rd]) == ''){
										$w_dato = $w_dato.'| '; 
										} else {                                             
										$w_dato = $w_dato.'|'.$data[$rd];        
									}                                 
									//}
								}
								//}
								//}
							}
						}
					}
					//--------------------------------------------------------------------------------------                 
					
					//echo print_r($arrd);
					//echo print_r($data);
					//$data =Array_push($dataO);
					/////$tabla =  $this->config->item('r_tabla');
					//echo print_r($tabla);
					//echo print_r($data);
					//echo print_r($dat);
					
					////$this->empresa_model->crear_emp($data,$tabla);
					////$err = $this->empresa_model->errBase();
									
					$cat =  $this->config->item('r_combo');
					if (isset($cat)) {
						foreach ($cat as $elem) {
							if (is_array($elem)) {                         
								if ($elem['cat'] != '') {
									$arr[] = array($elem['cat'] => '');
								}
							}
						}
					$this->empresa_model->emp_catalogo($arr);   
					$data['car'] = $arr;
					} 
	
					
					$_tab = explode('|',$this->config->item('r_tabla')) ;
					//echo print_r($_tab);
					$_par = explode(',',$_tab[1]);
					
					$pro = explode('.',$_tab[0]); 
					$paq = $pro[0];
					$prc = $pro[1];
					
					//$_acc = explode('|',$this->config->item('r_dato')) ;
					
					$FCHAI = $this->fecha('I|FD|-30|D');   
					$FCHAF = $this->fecha('F|FD|30|D');        
					
					//$w_dato = '| |'.$FCHAI.'|'.$FCHAF.'|N';
					//$w_dato = '| | | | '; 
					//echo 'nnnnnnnnnn'.$w_dato;
					
					$count = count($_par);
					$params = [];  
					
					for ($i = 0; $i < $count; $i++) {
						$_dat = explode(' ',$_par[$i]); 
						if ($_dat[1] == 'OCI_B_CURSOR'){
							$cursor = $this->db->get_cursor();  
							$arrrd[] = array('name'=>':'.$_dat[0],  'value'=>&$cursor ,  'type'=>OCI_B_CURSOR, 'length'=>$_dat[2]);     
							}else{         
							$arrrd[] = array('name'=>':'.$_dat[0],  'value'=>$w_dato ,  'type'=>SQLT_CHR, 'length'=>$_dat[2]);
						}        
					}
					
					$params= $arrrd;
					//echo print_r($params);
					
					$consulta = $this->empresa_model->emp_sprcursor($paq,$prc,$params,$cursor);
					//echo print_r($consulta,true);
					$data['emp'] = $consulta;
					$this->load->view('empresa/emp_lst',$data);
					
					//$err = $this->empresa_model->errBase();
					
					//if (isset($err)) {
					//    //echo "|1|".$err;
					//}
					//else{
					//    //echo "|0|";
					//}
					
					
					//$json['success'] = '1';
					//$json['message'] = "ok";
					//echo "Registro Grabado con exito";
					//echo json_encode(array('st'=>0,'msg'=>'Registro Grabado con exito'));
					//echo "|0|";
					//return false;
					//}
					//else
					//{
					//$json['success'] = '0';
					//$json['message'] = validation_errors();
					
					//echo json_encode(array('st'=>1,'msg'=>'ERROR: <br />'. validation_errors()));
					//////echo "|1|".validation_errors();
					//return true;
					//}
			}
			//$data = null;
			//$data = null;//$_REQUEST;
			//unset($data['url']);
			
			//$this->load->view('empresa/emp_nue',$data);
			//$this->load->view('empresa/emp_cam');
			//return false;
			
		}
		
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// btn graba registo envia request crea registro -- nuevo
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
		function recibirdatos(){
			
			$indice = $this->uri->segment(3);	
			$this->_param('_'.$indice);
            $_indexc = $this->uri->segment(5);
			$_det = $this->uri->segment(6);
			$_deti = $this->uri->segment(7);
			
			if (!$this->input->is_ajax_request()){
				//echo "|0|no ajax";
				//redirect ('404');
			}else{
				//echo ' ajax';
				$rules = [];
				$_campos =  $this->config->item('r_campos');

				if ($_det == 'D') {

					$cmp_val = explode("--",$_indexc);
					array_pop($cmp_val);
					
					$sd = explode(",",$this->config->item('r_indexdet'));
					$cam_ind =  explode("|",$sd[$_deti]);
					array_pop($cam_ind);
					
					$count_i = count($cmp_val);
					$count_f = count($cam_ind);
					
					if ($count_f > $count_i){ 
						for ($i = $count_i+1; $i <= $count_f; $i++) {
							unset($cam_ind[$i-1]);				
						}
					}
					
					$dat = array_combine($cam_ind,$cmp_val);
					echo print_r ($dat,true);	

					$_campos =  $this->config->item('r_camposdet'); 
					$campos = $_campos[$_deti]['cmp'];
					$___prm = explode("|",$_campos[$_deti]['prm']);					
				}else{					
					$campos = $_campos['cmp'];
					$___prm = explode("|",$_campos['prm']);				 
				}  
							
				// reglas aplicadas al formulario //////////////////////////////////////////////////////////////////
				if (isset($campos)) {
					foreach ($campos as $campo) {
						$lista = explode("|",$campo['lst']);
						if ($lista[1] == 1) {
							foreach ($campo as $elem) {
								if (is_array($elem)) {
									if ($elem['tipo'] == 'rls') {
										array_push($rules, $elem['attr']);
									}
								}
						}}
				}}      

				// valida reglas aplicadas al formulario //////////////////////////////////////////////////////////////////	
				$this->form_validation->set_error_delimiters('<div class = "alert alert-danger">','</div>');
				$this->form_validation->set_rules($rules);
					
					if($this->form_validation->run() == TRUE){
						$data = $_REQUEST;
						unset($data['url']);
                        //echo print_r($data,true);
						
						// datos indices sino existe agrega ///////////////////////////////////////////////////
						if (is_array($dat)){
							foreach ($dat as $items => $items_value){
								if (!array_key_exists($items, $data)){
									$data[$items] = $items_value;
						}}}
					
						// datos especiales //////////////////////////////////////////////////////////////////	
						if (is_array($_campos)){
							if (isset($campos)) {
								foreach ($campos as $campo) {
									$_prm = explode('-',$campo['esp']);                      
									if (count($_prm)>1){
										if ($_prm[1]!=''){ 
											
											$pos = strpos($_prm[1], 'SECUENCIA');
											if ($pos != false) {
												$_prm[1] = $_prm[1].'|'.$campo['campo'];
											}
											
											if (!array_key_exists($campo['campo'], $data)){
												//echo 'recibir';
												$data[$campo['campo']] = $this->datoD($_prm[1],'E');                         
											}}}
								}
						}}
						
						//echo print_r($data,true);

						//combo multiple //////////////////////////////////////////////////////////////////
						 if (isset($campos)){
								foreach ($campos as $rc => $campo) {
									foreach ($data as $rd => $dt ) {
										foreach ($campo as $elem) {
											if (is_array($elem)) {
												if ($elem['tipo'] == 'cbo' and strtoupper($rd) == strtoupper($campo['campo'])) {
													if (strpos($elem['attr']['attr'],'multiple="multiple"') !== false) {
														$cdat = $data[$rd];
														$data[$rd] = implode("|",$cdat);
														//echo 'paso x multiple';
													}
												}
											}
										}
									}
								}
						    }
							//echo print_r($data,true);

							$dat = $data;        
							$tabla = $___prm[4]; //$this->config->item('r_tabla');
							
                            // validacion de creacion x query o sp //////////////////////////////////////
							$_struct =  $this->config->item('r_struct');
							if ($_det == 'D') {
								$ritem = intval(preg_replace('/[^0-9]+/', '', $_deti), 10);
								$dat_struct = $_struct->{$ritem + 1};   			
							}else{
								$dat_struct = $_struct->{0};   						 
							}
							$mdat_struct = explode("|",$dat_struct->metodo);  
							if ($mdat_struct[1] == "1") { /// index 1 para ingreso
                                $respuesta = $this->empresa_model->emp_sp($data,$dat_struct->base.".ingreso_".$dat_struct->nombre);
							}else{
								$respuesta = $this->empresa_model->crear_emp($data,$tabla);
							}		
								
							// valida si existen procesos a ejecutar despues de grabar los datos /////////////
							if (isset($___prm[3])){
								if (count($___prm[3])>0){ 
									$Pprm = explode('-',$___prm[3]);
									if (count($Pprm)>1){
										if ($Pprm[1]!=''){ 
											// id ----------------------------------------
											if (is_array($_campos)){
												if (isset($campos)) {
													foreach ($campos as $campo) {                     
														if ($campo['id']==0){
															unset($dat[$campo['campo']]);                           
														}
													}
												}}                
												$_xml = $this->Axml($dat);
												//echo print_r($Pprm[1],true);
												//echo print_r($_xml,true);
												$_rsp = $this->datoP($Pprm[1].'|'.$_xml,'E'); 
												//echo print_r($_rsp,true);
							}}}}
										
										
										//echo print_r($_xml,true);   
										
										echo json_encode($respuesta);
										//$json['success'] = '1';
										//$json['message'] = "ok";
										//echo "Registro Grabado con exito";
										//echo json_encode(array('st'=>0,'msg'=>'Registro Grabado con exito'));
										//echo "|0|";
										//return false;
					}
					else
					{
						$data = $_REQUEST;
						//echo print_r($data,true);
						
						//$json['success'] = '0';
						//$json['message'] = validation_errors();
						
						//echo json_encode(array('st'=>1,'msg'=>'ERROR: <br />'. validation_errors()));
						//echo "|1|".validation_errors();
						echo validation_errors();
						//return true;
					}
			}
			//$data = null;
			//$data = null;//$_REQUEST;
			//unset($data['url']);
			
			//$this->load->view('empresa/emp_nue',$data);
			//$this->load->view('empresa/emp_cam');
			//return false;
			
		}
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// carga detalle lista boton detalle grid
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
		function detalle(){
			
			$indice = $this->uri->segment(3);
			$this->_param('_'.$indice);
			
			$i = $this->uri->segment(4);
			$_index = $this->uri->segment(5);
			$_camposd =  $this->config->item('r_camposdet');
			$_dato   =  explode("|",$this->config->item('r_dato'));
			
			echo 'item i:';
			echo print_r($i,true);

			$_ubic   =  $_dato[4]."|".$i."|".$_index;

			$i--;

			if (isset($_camposd)) {
				if (is_array($_camposd)) {
					
					$count = count($_camposd);
					
					//$dat = array();
					//$consulta = array();
					
					
					
					for ($r = 0; $r <= $count -1; $r++) {	
						
						$_param = explode("|",$_camposd[$r]['prm']);
						
						$tabla = $_param[4];  //"dlista" ;//$this->config->item('r_tabla');
						
						//echo print_r($tabla,true);
						$cmp_val = explode("--",$_index);
						array_pop($cmp_val);
						
						//$cam_ind =  explode("|",$this->config->item('r_index'));
						
						$sd = explode(",",$this->config->item('r_indexdet'));
						
						//print_r ($sd,true);
						//echo print_r ($consulta,tru
						//$cam_ind =  explode("|",$this->config->item('r_indexdet'));
						$cam_ind =  explode("|",$sd[$r]);
						array_pop($cam_ind);
						
						$count_i = count($cmp_val);
						$count_f = count($cam_ind);
						
						if ($count_f > $count_i){ 
							for ($i = $count_i+1; $i <= $count_f; $i++) {
								//				echo "0003*|i"; //echo print_r ($i,true);
								unset($cam_ind[$i-1]);				
							}
						}
						//echo "0003*|count_i"; //echo print_r ($count_i,true);
						//echo "0003*|count_f"; //echo print_r ($count_f,true);
						
						//echo "0003*|index"; //echo print_r ($_index,true);
						//echo "0003*|val"; //echo print_r ($cmp_val,true);
						//echo "0003*|ind"; //echo print_r ($cam_ind,true);
						$dat[$r] = array_combine($cam_ind,$cmp_val);
						$this->id = $dat[$r];
						$consulta[$r]  = $this->empresa_model->r_emp($this->id,$tabla);
						//echo "0003*|"; //echo print_r ($dat,true);
						
					}           
					
					$data['id'] = $dat; 
					$data['emp'] = $consulta;
					//echo print_r ($consulta,true);
					//$data['def'] = null;
					$data['ubic_det'] = $_ubic;
					
					$this->load->view('empresa/emp_dlst',$data);
					
					
				}}       
		}
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// btn actualizar registo envia pantalla campos
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
		function actualizar(){
			echo 'actualizar...';
			$this->config->set_item('r_accion', 'mod');
			
			$indice = $this->uri->segment(3);
			
			$this->_param('_'.$indice);			
			$i = $this->uri->segment(4);
			
			$_indexc = $this->uri->segment(5);
			$_index = $this->uri->segment(5);			
			$_det = $this->uri->segment(6); 
			$_r = $this->uri->segment(7);
			$_ubic_det = $this->uri->segment(8);
			//echo print_r($_index,true);
			//echo print_r($_det,true);
			//echo print_r($_r,true);

			$_dato   =  explode("|",$this->config->item('r_dato'));
			
			//echo 'item i:';
			//echo print_r($i,true);

			$_ubic   =  $_dato[4]."|".$i."|".$_index;
			
			$i--;
			
			
			if ($_det == 'D') {
			    //echo print_r('paso x D',true);
				$_campos =  $this->config->item('r_camposdet'); 
				$sd = explode(",",$this->config->item('r_indexdet'));
				$cam_ind =  explode("|",$sd[$_r]);
				//echo print_r($this->config->item('r_indexdet'),true);   
				$campos = $_campos[$_r]['cmp'];
				$___prm = explode("|",$_campos[$_r]['prm']);
				}else{
				if ($_det == 'B') {
					echo print_r('paso x B',true);
					$_campos =  $this->config->item('r_camposbot'); 
					$sd = explode(",",$this->config->item('r_indexbot'));
					$cam_ind =  explode("|",$sd[$_r]);
					//echo print_r($this->config->item('r_indexdet'),true);   
					$campos = $_campos[$_r]['cmp'];
					$___prm = explode("|",$_campos[$_r]['prm']);							
					}else{
					echo print_r('paso x',true);
					$_campos =  $this->config->item('r_campos');
					$cam_ind =  explode("|",$this->config->item('r_index'));
					$campos = $_campos['cmp'];
					$___prm = explode("|",$_campos['prm']);	
				}}  
				
				$tabla =  $___prm[4];
				
				//if (isset($campos)) {
				//    foreach ($campos as $rc => $campo) {
				//        foreach ($dat as $rd => $dt ) {
				//        if ($campo['id'] == 0 and $rd == strtoupper($campo['campo']) ) {
				//            unset($dat[$rd]);
				//        }}
				//    }
				//}
				
				$cmp_val = explode("--",$_index);
				array_pop($cmp_val);
				array_pop($cam_ind);
				
				//echo "0002*|";. //echo print_r ($cam_ind,true);
				$dat = array_combine($cam_ind,$cmp_val);
				//echo "0003*|"; //echo print_r ($dat,true);
				echo print_r($dat,true);
				echo print_r($tabla,true);
				
				$this->id = $dat;
				$consulta  = $this->empresa_model->r_emp($this->id,$tabla);
				$data['emp'] = $consulta;
				//echo print_r ($consulta,true);
				$data['def'] = null;
				
				$cat =  $this->config->item('r_combo');
				if (isset($cat)) {
					foreach ($cat as $elem) {
						if (is_array($elem)) {                         
							if ($elem['cat'] != '') {
								$arr[] = array($elem['cat'] => '');
							}
						}
					}
                $this->empresa_model->emp_catalogo($arr);   
				$data['car'] = $arr;
				} 

				$data['indexc'] = $_indexc;
				$data['det'] = $_det;
				$data['deti'] = $_r;
				$data['ubic'] = $_ubic;
				$data['ubic_det'] = $_ubic_det;

				$this->load->view('empresa/emp_mod',$data);
				$this->load->view('empresa/emp_cam');
				//$this->load->view('empresa/emp_pie');
				
		}
		
		function actualizar_id(){
			
			$indice = $this->uri->segment(3);
			
			if ($indice == 'ABCDE'){
				$indice = 'CLIENTE';
			}
			
			$this->_param('_'.$indice);
			
			$data = $_REQUEST;
			unset($data['url']);
			$dat = $data;
			
			$_campos =  $this->config->item('r_campos');
			$campos = $_campos['cmp'];
			
			$tabla =  $this->config->item('r_tabla');
			
			if (isset($campos)) {
				foreach ($campos as $campo) {
					foreach ($dat as $rd => $dt ) {
						//if ($campo['id'] == 0 and strtoupper($rd) == strtoupper($campo['campo']) ) {
						if ($campo['id'] == 0 and ($rd) == ($campo['campo']) ) {
							unset($dat[$rd]);
						}}
				}
			}
			$this->id = $dat;
			
			//echo print_r ($this->id,true);
			//echo print_r ($tabla,true);
			
			$consulta  = $this->empresa_model->r_emp($this->id,$tabla);
			
			if($consulta -> num_rows() > 0)
			{$data['emp'] = $consulta;}
			else
			{return false; }
			
			$cat =  $this->config->item('r_combo');
			if (isset($cat)) {
				foreach ($cat as $elem) {
					if (is_array($elem)) {                         
						if ($elem['cat'] != '') {
							$arr[] = array($elem['cat'] => '');
						}
					}
				}
			$this->empresa_model->emp_catalogo($arr);   
			$data['car'] = $arr;
			} 
			
			//$this->load->view('empresa/emp_mod',$data);
			//$this->load->view('empresa/emp_cam');
			
			//$this->load->view('empresa/emp_pie');
		}
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// btn graba registo envia request actualiza registro -- actualizar
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
		function Modificardatos(){
			//echo "Modificardatos";
			$indice = $this->uri->segment(3);
						
			$this->_param('_'.$indice);
			//echo "det";
			$_det = $this->uri->segment(6);
			////echo "deti";
			$_deti = $this->uri->segment(7);

			//echo print_r($this->uri->segment(3).'|',true);
			//echo print_r($this->uri->segment(4).'|',true);
			//echo print_r($this->uri->segment(5).'|',true);
            //echo print_r($this->uri->segment(6).'|',true);
			//echo print_r($this->uri->segment(7).'|',true);
			//echo print_r($_det,true);
			//echo print_r($_deti,true);
			
			$data = $_REQUEST;
			unset($data['url']);
			$dat = $data;			
			
			if ($_det == 'D') {
				$_campos =  $this->config->item('r_camposdet'); 
				$sd = explode(",",$this->config->item('r_indexdet'));				
				$cam_ind =  explode("|",$sd[$_deti]);			
				$campos = $_campos[$_deti]['cmp'];
				$___prm = explode("|",$_campos[$_deti]['prm']);			
				}else{
				if ($_det == 'B') {
				$_campos =  $this->config->item('r_camposbot'); 
				$sd = explode(",",$this->config->item('r_indexbot'));				
				$cam_ind =  explode("|",$sd[$_deti]);			
				$campos = $_campos[$_deti]['cmp'];
				$___prm = explode("|",$_campos[$_deti]['prm']);	
				}else{
				$_campos =  $this->config->item('r_campos');
				$cam_ind =  explode("|",$this->config->item('r_index'));
				$campos = $_campos['cmp'];	
				$___prm = explode("|",$_campos['prm']);
		    }}  
			
			//echo print_r($_campos,true);
			// datos especiales ----------------------------------------
			//if (is_array($_campos)){
			//   $campos = $_campos['cmp'];
			if (isset($campos)) {
				foreach ($campos as $campo) {
					$_prm = explode('-',$campo['esp']);                      
					if (count($_prm)>=2){
						if ($_prm[2]!=''){ 
							if (!array_key_exists($campo['campo'], $data)){
								$data[$campo['campo']] = $this->datoD($_prm[1],'E');                         
							}}}
				}
			}//}        
			
			if (isset($campos)) {
				foreach ($campos as $campo) {
					foreach ($dat as $rd => $dt ) {
						if ($campo['id'] == 0 and strtoupper($rd) == strtoupper($campo['campo']) ) {
						//if ($campo['id'] == 0 and ($rd) == ($campo['campo']) ) {
							unset($dat[$rd]);
						}}
				}
			}
			
			$this->id = $dat;
			// multiple jhc 2022 no va esta validando mal
			if (isset($campos)) {
				foreach ($campos as $rc => $campo) {
					foreach ($data as $rd => $dt ) {
						foreach ($campo as $elem) {
							if (is_array($elem)) {
								//if ($elem['tipo'] == 'cbo' and strtoupper($rd) == strtoupper($campo['campo'])) {
								if ($elem['tipo'] == 'cbo' and ($rd) == ($campo['campo'])) {
									//echo 'aquiiiiii';
									//echo print_r($elem['attr']['attr'],true);
									if (strpos($elem['attr']['attr'],'multiple="multiple"') !== false) {								 
										//echo 'x multiple';
										$cdat = $data[$rd];
										$data[$rd] = implode("|",$cdat);
									}
								}
							}
						}
					}
				}
			}
			
			
			
			$tabla =  $___prm[4];
			
            
			//$tabla =  $this->config->item('r_tabla');
			//echo print_r($tabla,true);
			//echo print_r($data,true);
			//echo print_r($this->id,true);
			
			//$respuesta = $this->empresa_model->actualizar_emp($this->id,$data,$tabla);
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////revisar
			$_struct =  $this->config->item('r_struct');
			if ($_det == 'D') {
				$ritem = intval(preg_replace('/[^0-9]+/', '', $_deti), 10);
				$dat_struct = $_struct->{$ritem + 1};   			
			}else{
				$dat_struct = $_struct->{0};   						 
			}
			$mdat_struct = explode("|",$dat_struct->metodo);  
			if ($mdat_struct[1] == "1") { /// index 1 para ingreso
				$respuesta = $this->empresa_model->emp_sp($data,$dat_struct->base.".actualiza_".$dat_struct->nombre);
			}else{
				$respuesta = $this->empresa_model->actualizar_emp($this->id,$data,$tabla);
			}
			
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////revisar
			$_structpr =  $this->config->item('r_structpr');
			$mdat_structpr = explode("|",$dat_structpr->metodo);
            if ($mdat_struct[1] == "1") { /// index 1 para ingreso
				$respuesta = $this->empresa_model->emp_sp($data,$dat_struct->base.".actualiza_".$dat_struct->nombre);
			}

            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////revisar
			echo json_encode($respuesta);
			
			//if ($respuesta->errCodigo == "0" ){
			//	echo "<div class = 'alert alert-success' >TRANSACCION EXITOSA</div>";
			    
			//}else{
			//	echo "<div class = 'alert alert-danger' > Error: ". $respuesta->errCodigo . " - " . $respuesta->errMenssa . "</div>";
			//}

			//$this->___index();
			
		}
		
		function eliminar(){
			
			$indice = $this->uri->segment(3);
			
			if ($indice == 'ABCDE'){
				$indice = 'CLIENTE';
			}
			
			$this->_param('_'.$indice);
			
			$i = $this->uri->segment(4);
			$_det = $this->uri->segment(6);
			$_deti = $this->uri->segment(7);  		
			
			$_index = $this->uri->segment(5);
			
			$cam_ind =  explode("|",$this->config->item('r_index'));
			$_campos =  $this->config->item('r_campos');
			if ($_det == 'D') {
				$_campos =  $this->config->item('r_camposdet'); 
				$sd = explode(",",$this->config->item('r_indexdet'));
				
				$cam_ind =  explode("|",$sd[$_deti]);
				//$cam_ind =  explode("|",$this->config->item('r_indexdet'));
				//echo print_r($this->config->item('r_indexdet'),true); 
				$campos = $_campos[$_deti]['cmp'];
				$___prm = explode("|",$_campos[$_deti]['prm']);
				
				}else{
				$campos = $_campos['cmp'];
				$___prm = explode("|",$_campos['prm']);
				
			} 
			
			
			$tabla = $___prm[3]; 
			//$tabla =  $this->config->item('r_tabla');
			
			$cmp_val = explode("--",$_index);
			array_pop($cmp_val);
			
			//$cam_ind =  explode("|",$this->config->item('r_index'));
			array_pop($cam_ind);
			
			$dat = array_combine($cam_ind,$cmp_val);
			
			$this->id = $dat;
			
			$PRO ='N';
			//echo print_r($this->id ,true);
			//echo print_r($this->id['SEC'],true);
			
			if ($indice=='factura' && ($tabla == 'factura' || $tabla == 'facdetalle')){
			    $idFac = array('SEC'=>$this->id['SEC']);
				//echo print_r($this->id ,true);
			   	$consulta  = $this->empresa_model->r_emp($idFac,'factura'); 
				foreach($consulta->result() as $rfac){
					$PRO =  $rfac->ESTPRO;
					if ($PRO=='S'){
					echo $this->msgAlert('D','Transaccion No permitida Factura '.$rfac->NUMERO.' en estado Procesado');
					}
					if ($PRO=='N' && $tabla == 'factura'){
					   
					   $respuesta = $this->empresa_model->eliminar_emp($idFac,'facdetalle');

					   if ($respuesta->errCodigo == "0" ){
						echo $this->msgAlert('OK','');
					   }else{
						echo "<div class = 'alert alert-danger' > Error: ". $respuesta->errCodigo . " - " . $respuesta->errMenssa . "</div>'";
					   }
					}
				} 
			}
			
			if ($PRO=='N'){
			//echo 'ELIMINA';
			$respuesta = $this->empresa_model->eliminar_emp($this->id,$tabla);
			if ($respuesta->errCodigo == "0" ){
				echo $this->msgAlert('OK','');
			}else{
				echo "<div class = 'alert alert-danger' > Error: ". $respuesta->errCodigo . " - " . $respuesta->errMenssa . "</div>'";
			}

			
			
			
			
			//$this->empresas();
			$this->___index(); 
			}
			
			
		}
		
		function msgAlert($tipo,$mensaje){
		$rsp = "";
		if ($tipo == 'D'){
		$rsp ="<div class = 'alert alert-danger alert-dismissible fade show' role='alert'> <strong>Error: </strong> ".$mensaje."<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>'";
		}
		if ($tipo == 'OK'){
		$rsp ="<div class = 'alert alert-success alert-dismissible fade show' role='alert'> Transaccion Exitosa ".$mensaje."<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>'";
		}
		return $rsp;    
		}
		
		function Pguias(){
			//echo "1234";
			$w_desde = 'A';
			$w_hasta = 'B';
			$w_proceso = 'C';
			$w_usuario = 'JULIO';
			$w_err = 'D';
			$w_errmsg = 'JULIO';
			
			$params = array(array('name'=>':DESDE',  'value'=>$w_desde ,  'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':HASTA',  'value'=>$w_hasta ,  'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':PROCESO','value'=>$w_proceso ,'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':USUARIO','value'=>$w_usuario ,'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':ERR',    'value'=>$w_err ,    'type'=>SQLT_CHR, 'length'=>40),
			array('name'=>':ERRMSG', 'value'=>$w_errmsg,  'type'=>SQLT_CHR, 'length'=>4000)
			);
			
			$this->empresa_model->emp_sprc('pq_pro_procesos','pr_pro_msg_guia',$params);
			
			$this->Procdatos();
			
			$this->empresas();
			//$err = $this->empresa_model->errBase();
			
			//if (isset($err)) {
			//    //echo "|1|".$err;
			//}
			//else{
			//    //echo "|0|";
			//}
		}
		
		function array_to_xml($array, &$xml_user_info) {
			foreach($array as $key => $value) {
				if(is_array($value)) {
					if(!is_numeric($key)){
						$subnode = $xml_user_info->addChild("$key");
						$this->array_to_xml($value, $subnode);
						}else{
						$subnode = $xml_user_info->addChild("R$key");
						$this->array_to_xml($value, $subnode);
					}
					}else {
					$xml_user_info->addChild("$key",htmlspecialchars("$value"));
				}
			}
		}
		
		function Pdatos(){
			
			$consulta = $this->empresa_model->catalogo('OPERADORES',null);
			
			foreach($consulta as $cat ){
				if  ($cat['CODIGO'] != 'FCH'){
					
					$cliente  =  $cat['CODIGO']; //$cat['NOMBRE1'];
					$fechaa   =  str_replace("/","-",$cat['NOMBRE2']);
					$fechaFin =  date('Y-m-d', strtotime($fechaa));
					
					
					$dataA = array('peticion' => array('agencia' => '',
					'canal' => '',
					'fechaHora' => '',
					'hostName' => '',
					'idMensaje' => '',
					'idUsuario' => '',
					'ip' => '',
					'localidad' => '',
					'macAddress' => '',
					'token' => '',
					'proceso' => 'CONS',
					'fechaFin' => $fechaFin,
					'fechaInicio' => '',
					'cliente' => $cliente
					));
					
					$xmlRq = new SimpleXMLElement('<RQ/>');
					//array_walk_recursive($array, array ($xmlRs, 'addChild'));
					$this->array_to_xml($dataA,$xmlRq);                                           
					
					$dataRQ = $xmlRq->asXML();        		
					
					//$url = 'https://hc-home.000webhostapp.com/hdocs/api/prmsg.php';			
					$url = 'https://hc-cargo-ec.com/hdocs/api/prmsg.php';				
					//url inicializa
					$ch = curl_init();			
					curl_setopt($ch,CURLOPT_URL, $url);
					//url verificar ssl false
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					//a true, obtendremos una respuesta de la url, en otro caso, 
					//true si es correcto, false si no lo es
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					//establecemos el verbo http que queremos utilizar para la petición
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
					//enviamos el array data
					curl_setopt($ch, CURLOPT_POSTFIELDS,$dataRQ);
					//obtenemos la respuesta
					$respuesta = curl_exec($ch);
					
					if($errno = curl_errno($ch)) {
						$error_message = curl_strerror($errno);
						echo "cURL error ({$errno}):\n {$error_message}";
					}
					
					//var_dump (curl_getinfo ($ch));
					
					// Se cierra el recurso CURL y se liberan los recursos del sistema
					curl_close($ch);
					if(!$respuesta) {
						echo "Intente mas tarde";	
						
						//return false;
						}else{				                
						$params = array(array('name'=>':i_xml_doc',  'value'=>$respuesta ,  'type'=>OCI_B_CLOB, 'length'=>-1));
						$this->empresa_model->emp_sprc('pq_pro_procesos','sp_pro_xml_msj',$params);
						
						
					}        
				}}
				$this->empresas();  	
				
		}	
		
		function Procdatos(){
			
			$consulta = $this->empresa_model->catalogo('OPERADORES',null);
			
			foreach($consulta as $cat ){
				if  ($cat['CODIGO'] != 'FCH'){
					
					$cliente  =  $cat['CODIGO'];//$cat['NOMBRE1'];
					$fechaa   =  str_replace("/","-",$cat['NOMBRE2']);
					$fechaFin =  date('Y-m-d', strtotime($fechaa));
					
					
					
					$dataA = array('peticion' => array('agencia' => '',
					'canal' => '',
					'fechaHora' => '',
					'hostName' => '',
					'idMensaje' => '',
					'idUsuario' => '',
					'ip' => '',
					'localidad' => '',
					'macAddress' => '',
					'token' => '',
					'proceso' => 'PROC',
					'fechaFin' => $fechaFin,
					'fechaInicio' => '',
					'cliente' => $cliente
					));
					
					$xmlRq = new SimpleXMLElement('<RQ/>');
					//array_walk_recursive($array, array ($xmlRs, 'addChild'));
					$this->array_to_xml($dataA,$xmlRq);                                           
					
					$dataRQ = $xmlRq->asXML();        		
					
					//$url = 'https://hc-home.000webhostapp.com/hdocs/api/prmsg.php';			
					$url = 'https://hc-cargo-ec.com/hdocs/api/prmsg.php';				
					
					//url inicializa
					$ch = curl_init();			
					curl_setopt($ch,CURLOPT_URL, $url);
					//url verificar ssl false
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					//a true, obtendremos una respuesta de la url, en otro caso, 
					//true si es correcto, false si no lo es
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					//establecemos el verbo http que queremos utilizar para la petición
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
					//enviamos el array data
					curl_setopt($ch, CURLOPT_POSTFIELDS,$dataRQ);
					//obtenemos la respuesta
					$respuesta = curl_exec($ch);
					
					if($errno = curl_errno($ch)) {
						$error_message = curl_strerror($errno);
						echo "cURL error ({$errno}):\n {$error_message}";
					}
					
					//var_dump (curl_getinfo ($ch));
					
					// Se cierra el recurso CURL y se liberan los recursos del sistema
					curl_close($ch);
					if(!$respuesta) {
						echo "Intente mas tarde";	
						
						//return false;
						}else{				                
						echo $respuesta;     
					}        
				}} 
		}
			
		function Edatos(){
			
			$consulta = $this->empresa_model->catalogo('ENVIODATOS',null);
			echo print_r($consulta,true);
			foreach($consulta as $cat ){
				
				$params = [];
				$cursor = $this->db->get_cursor();
				$arrd[] = array('name'=>':i_codigo','value'=>$cat['CODIGO'] ,  'type'=>SQLT_CHR, 'length'=>-1);                                                  
				$arrd[] = array('name'=>':r_curso','value'=>&$cursor ,  'type'=>OCI_B_CURSOR, 'length'=>-1);                             
				
				$params= $arrd;                      
				$consultar = $this->empresa_model->emp_sprcursor('PQ_PRO_PROCESOS','sp_pro_xml_subida',$params,$cursor);
				
				//echo print_r($consulta,true); 
				foreach($consultar as $em ){
					
					$rsp = $em['XML_DOC'] ;      
				}
				
				
				if (isset($rsp)) {                       
					
					$dataRQ = $rsp;  
					//echo print_r($dataRQ,true);	
					
					//$url = 'https://hc-home.000webhostapp.com/hdocs/api/tabla.php';			
					$url = 'https://hc-cargo-ec.com/hdocs/api/tabla.php';				
					
					//url inicializa
					$ch = curl_init();			
					curl_setopt($ch,CURLOPT_URL, $url);
					//url verificar ssl false
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					//a true, obtendremos una respuesta de la url, en otro caso, 
					//true si es correcto, false si no lo es
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					//establecemos el verbo http que queremos utilizar para la petición
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
					//enviamos el array data
					curl_setopt($ch, CURLOPT_POSTFIELDS,$dataRQ);
					//obtenemos la respuesta
					$respuesta = curl_exec($ch);
					
					if($errno = curl_errno($ch)) {
						$error_message = curl_strerror($errno);
						echo "cURL error ({$errno}):\n {$error_message}";
					}
					
					//var_dump (curl_getinfo ($ch));
					
					// Se cierra el recurso CURL y se liberan los recursos del sistema
					curl_close($ch);
					
					
					if(!$respuesta) {
						echo "Intente mas tarde";	
						
						//return false;
						}else{	
						
						echo $respuesta;
						
					} 
				}
				unset ($params);
				unset ($consultar);
				unset ($arrd);
				unset ($cursor);
				unset ($em);	
				unset ($rsp);
			}	
		}
			
		function Pcontrol(){
			$id = array('empresa'=>'1');
			$tabla = 'ROL_PARAMETROS';
			$consulta  = $this->empresa_model->r_emp($id,$tabla);
			
			echo print_r($consulta,true); 
			
			foreach($consulta->result() as $cat ){
				$cliente  =  '';
				$fechaa   =  str_replace("/","-",$cat->FCHPAG);
				//$fechaa   = '20'.substr($fechaa, 6, 2).'-'.substr($fechaa, 3, 2).'-'.substr($fechaa, 0, 2); 
				$fechaFin =  date('Y-m-d', strtotime($fechaa. "+15 days"));    
			} 
			
			$dataA = array('peticion' => array('agencia' => '',
			'canal' => '',
			'fechaHora' => '',
			'hostName' => '',
			'idMensaje' => '',
			'idUsuario' => '',
			'ip' => '',
			'localidad' => '',
			'macAddress' => '',
			'token' => '',
			'proceso' => 'CONS',
			'fechaFin' => $fechaFin,
			'fechaInicio' => '',
			'cliente' => $cliente
			));
			
			$xmlRq = new SimpleXMLElement('<RQ/>');
			//array_walk_recursive($array, array ($xmlRs, 'addChild'));
			$this->array_to_xml($dataA,$xmlRq);                                           
			
			$dataRQ = $xmlRq->asXML();        		
			
			//$url = 'https://hc-home.000webhostapp.com/hdocs/api/prctrl.php';
			$url = 'https://hc-cargo-ec.com/hdocs/api/prctrl.php';				
			
            //url inicializa
            $ch = curl_init();			
			curl_setopt($ch,CURLOPT_URL, $url);
            //url verificar ssl false
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            //a true, obtendremos una respuesta de la url, en otro caso, 
            //true si es correcto, false si no lo es
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //establecemos el verbo http que queremos utilizar para la petición
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            //enviamos el array data
            curl_setopt($ch, CURLOPT_POSTFIELDS,$dataRQ);
            //obtenemos la respuesta
            $respuesta = curl_exec($ch);
			
			if($errno = curl_errno($ch)) {
				$error_message = curl_strerror($errno);
				echo "cURL error ({$errno}):\n {$error_message}";
			}
			
			//var_dump (curl_getinfo ($ch));
			
            // Se cierra el recurso CURL y se liberan los recursos del sistema
            curl_close($ch);
            if(!$respuesta) {
				echo "Intente mas tarde";	
				
                //return false;
				}else{				                
				$params = array(array('name'=>':i_xml_doc',  'value'=>$respuesta ,  'type'=>OCI_B_CLOB, 'length'=>-1));
				$this->empresa_model->emp_sprc('pq_pro_procesos','sp_pro_xml_ctrl',$params);
				
				$this->empresas();       
			}        
		}
		
		function Procontrol(){
			$id = array('empresa'=>'1');
			$tabla = 'ROL_PARAMETROS';
			$consulta  = $this->empresa_model->r_emp($id,$tabla);
			
			echo print_r($consulta,true); 
			
			foreach($consulta->result() as $cat ){
				$cliente  =  '';
				$fechaa   =  str_replace("/","-",$cat->FCHPAG);
				echo $fechaa;
				//$fechaa   = '20'.substr($fechaa, 6, 2).'-'.substr($fechaa, 3, 2).'-'.substr($fechaa, 0, 2); 
				$fechaFin =  date('Y-m-d', strtotime($fechaa. "+15 days"));
				$fechaIni =  date('Y-m-d', strtotime($fechaa));		  
			} 
			
			$dataA = array('peticion' => array('agencia' => '',
			'canal' => '',
			'fechaHora' => '',
			'hostName' => '',
			'idMensaje' => '',
			'idUsuario' => '',
			'ip' => '',
			'localidad' => '',
			'macAddress' => '',
			'token' => '',
			'proceso' => 'PROC',
			'fechaFin' => $fechaFin,
			'fechaInicio' => $fechaIni,
			'cliente' => $cliente
			));
			
			$xmlRq = new SimpleXMLElement('<RQ/>');
			//array_walk_recursive($array, array ($xmlRs, 'addChild'));
			$this->array_to_xml($dataA,$xmlRq);                                           
			
			$dataRQ = $xmlRq->asXML();        		
			
			//$url = 'https://hc-home.000webhostapp.com/hdocs/api/prctrl.php';		
			$url = 'https://hc-cargo-ec.com/hdocs/api/prctrl.php';						
			
            //url inicializa
            $ch = curl_init();			
			curl_setopt($ch,CURLOPT_URL, $url);
            //url verificar ssl false
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            //a true, obtendremos una respuesta de la url, en otro caso, 
            //true si es correcto, false si no lo es
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //establecemos el verbo http que queremos utilizar para la petición
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            //enviamos el array data
            curl_setopt($ch, CURLOPT_POSTFIELDS,$dataRQ);
            //obtenemos la respuesta
            $respuesta = curl_exec($ch);
			
			if($errno = curl_errno($ch)) {
				$error_message = curl_strerror($errno);
				echo "cURL error ({$errno}):\n {$error_message}";
			}
			
			//var_dump (curl_getinfo ($ch));
			
            // Se cierra el recurso CURL y se liberan los recursos del sistema
            curl_close($ch);
            if(!$respuesta) {
				echo "Intente mas tarde";	
				
                //return false;
				}else{				                
				//$params = array(array('name'=>':i_xml_doc',  'value'=>$respuesta ,  'type'=>OCI_B_CLOB, 'length'=>-1));
				//$this->empresa_model->emp_sprc('pq_pro_procesos','sp_pro_xml_ctrl',$params);
				
				$this->empresas();       
			}        
		}	 
		
		function Pcosto(){
			//echo "1234";
			$w_desde = 'A';
			$w_hasta = 'B';
			$w_proceso = 'C';
			$w_usuario = 'JULIO';
			$w_err = 'D';
			$w_errmsg = 'JULIO';
			
			$params = array(array('name'=>':DESDE',  'value'=>$w_desde ,  'type'=>SQLT_CHR, 'length'=>-1),
            array('name'=>':HASTA',  'value'=>$w_hasta ,  'type'=>SQLT_CHR, 'length'=>-1),
            array('name'=>':PROCESO','value'=>$w_proceso ,'type'=>SQLT_CHR, 'length'=>-1),
            array('name'=>':USUARIO','value'=>$w_usuario ,'type'=>SQLT_CHR, 'length'=>-1),
            array('name'=>':ERR',    'value'=>$w_err ,    'type'=>SQLT_CHR, 'length'=>40),
            array('name'=>':ERRMSG', 'value'=>$w_errmsg,  'type'=>SQLT_CHR, 'length'=>4000)
			);
			
			$this->empresa_model->emp_sprc('pq_pro_procesos','PR_PRO_COSTO_GUIA',$params);
			
			$this->empresas();
			//$err = $this->empresa_model->errBase();
			
			//if (isset($err)) {
			//    //echo "|1|".$err;
			//}
			//else{
			//    //echo "|0|";
			//}
		}
		
		function Preporte(){
			//echo "1234";
			$w_i_placalq = 'T';
			
			$params = array(array('name'=>':i_placalq',  'value'=>$w_i_placalq ,  'type'=>SQLT_CHR, 'length'=>-1),
			
			);
			
			$this->empresa_model->emp_sprc('pq_pro_procesos','PR_RPT_EGUIA',$params);
			
			//$page = file_get_contents( base_url().'reporte/reporte.php');
			
			$_url = explode('/',base_url()) ;
			
			//$page = file_get_contents('http://'.$_url[2].'/reporte/reporte.php');				
			
			$page = file_get_contents('../reporte/reporte.php');
			
			echo $page ;
			//$err = $this->empresa_model->errBase();
			
			//if (isset($err)) {
			//    //echo "|1|".$err;
			//}
			//else{
			//    //echo "|0|";
			//}
		}
		
		function Preportedif(){
			//echo "1234";
			$movil = $this->uri->segment(3);
			
			$w_i_placalq = 'T';
			
			$params = array(array('name'=>':i_placalq',  'value'=>$w_i_placalq ,  'type'=>SQLT_CHR, 'length'=>-1),
			
			);
			
			$this->empresa_model->emp_sprc('pq_pro_procesos','PR_RPT_GUIA_DIF',$params);
			
			//$page = file_get_contents( base_url().'reporte/reporte.php');
			
			$_url = explode('/',base_url()) ;
			
			//$page = file_get_contents('http://'.$_url[2].'/reporte/reporte.php');
			
			$di = (new DateTime('now'))->format('d');
			$ma = (new DateTime('now'))->format('m');
			$an = (new DateTime('now'))->format('Y');
			
			$nombre = 'DIFARE'.$di.$ma.$an.'.pdf'; 	
			$fichero = '../reporte'.$nombre;
			if (file_exists($fichero)) {
				unlink($fichero);
			}
			
			$i = 1;
			$r = 0;
			while ($i <= 10) {
				
				//$actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
				//echo $actual_link.'    --';
				
				if (!file_exists($fichero)) {
					//$page = file_get_contents('../reporte/reportedif.php?id='.$nombre);
					$url = 'http://192.168.100.14/reporte/reportedif.php?id='.$nombre;
					//$url = '../reporte/reportedif.php?id='.$nombre;
					//echo $url;
					$ch = curl_init();
					curl_setopt($ch,CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					//Si lo deseamos podemos recuperar la salida de la ejecución de la URL
					$resultado = curl_exec($ch);
					//echo $i.$resultado; 
					//cerrar conexión
					curl_close($ch);
					}else{
					$r = 1;
				}
				
				$i++;  
			}
			
			//echo $i.'--';
			//echo $r.'--';
			
			//if ($r <= 0 ){
			//	echo 'PROBLEMAS AL GENERAR ARCHIVO , FAVOR INTENTARLO MAS TARDE...';
			//}else{
			//$page = file_get_contents('../reporte/reportevista.php?id='.$nombre);
			//$page = file_get_contents('../reporte/reportevista.php');
            //echo $page ;
			//}
			
			$url = 'http://192.168.100.14/reporte/reportevista.php?id='.$nombre.'&mo='.$movil;
			//$url = '../reporte/reportedif.php?id='.$nombre;
			//echo $url;
			$chvista = curl_init();
			curl_setopt($chvista,CURLOPT_URL, $url);
			curl_setopt($chvista, CURLOPT_RETURNTRANSFER, true);
			//Si lo deseamos podemos recuperar la salida de la ejecución de la URL
			$res = curl_exec($chvista);
			echo $res; 
			//cerrar conexión
			curl_close($chvista);
			
			
			//echo $page ;
			//$err = $this->empresa_model->errBase();
			
			//if (isset($err)) {
			//    //echo "|1|".$err;
			//}
			//else{
			//    //echo "|0|";
			//}
		}
		
		function cellColor($cells,$color){

			$this->excel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'startcolor' => array(
					 'rgb' => $color
				)
			));
		}
		
		function cellImagen($cells,$ruta){
		    $objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath($ruta);
			$objDrawing->setCoordinates($cells);
			$objDrawing->setWidth(50);
			$objDrawing->setHeight(50);
			$objDrawing->setOffsetX(10);
            $objDrawing->setOffsetY(-13);

			$objDrawing->setWorksheet($this->excel->getActiveSheet()); 
		}
		function cabReporte($cells){
		$r = intval(preg_replace('/[^0-9]+/', '', $cells), 10); 
		$file_imagen = '../reporte/logoqx.png';
		
		$s = $r +1;
		$this->cellImagen('B'.$s,$file_imagen);
		$arrRows = array(0 =>array('A'=>'','B'=>'DETALLE DE DOCUMENTO DE TRANSPORTE','C'=>'','D'=>'','E'=>'','F'=>'Codigo : QX.UNSL.02.R.29'),
		                 1 =>array('A'=>'','B'=>'','C'=>'','D'=>'','E'=>'','F'=>'Version : 09'),
						 3 =>array('A'=>'','B'=>'ANEXO DEL PROCEDIMIENTO DE ENTREGA','C'=>'','D'=>'','E'=>'','F'=>'Pagina : 1 de 1')
						 );
	    $this->excel->getActiveSheet()->fromArray($arrRows,'',$cells);
		
		$s = $r +1;
		$this->excel->getActiveSheet()->mergeCells('C'.$r.':F'.$s);
		$s = $r +2;
		$this->excel->getActiveSheet()->mergeCells('B'.$r.':B'.$s);
		$this->excel->getActiveSheet()->mergeCells('C'.$s.':F'.$s);

		//$styleArray = array(
		//	'borders' => array(
		//		'diagonal' => array(
		//			'style' => PHPExcel_Style_Border::BORDER_THICK,
		//			'color' => array('argb' => 'FFFF0000'),
		//		),
		//		'diagonaldirection' => PHPExcel_Style_Borders::DIAGONAL_DOWN,
		//	),
		//);
		//$objPHPExcel->getActiveSheet()->getStyle('A1:B2')->applyFromArray($styleArray);
		
		//$objPHPExcel->getActiveSheet()->mergeCells('A1:B2');
		
		$borders = array(
			  'borders' => array(
				'allborders' => array(
				  'style' => PHPExcel_Style_Border::BORDER_THIN,
				  'color' => array('argb' => 'FF000000'),
				)
			  ),
			);
		
		$s = $r +2;	
		$this->excel->getActiveSheet()->getStyle($cells.':G'.$s)->applyFromArray($borders);
		
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(17);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(17);
		
		$Titulo1 = [
			'font' => [
				'bold'  =>  true,
				'color' => array('rgb' => '000000'),
				'size'  =>  12,
				'name'  =>  'Arial'
			],
			'alignment' => [
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			]
		];
		
		$this->excel->getActiveSheet()->getStyle('C'.$r)->applyFromArray($Titulo1);
		
		$Titulo2 = [
			'font' => [
				'bold'  => false,
				'color' => array('rgb' => '000000'),
				'size'  => 8,
				'name'  => 'Arial'
			],
			'alignment' => [
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			]
		];
		
		$s = $r +2;
		$this->excel->getActiveSheet()->getStyle('C'.$s)->applyFromArray($Titulo2);
		
		$Titulo3 = [
			'font' => [
				'bold'  => true,
				'color' => array('rgb' => '000000'),
				'size'  => 5,
				'name'  => 'Arial'
			],
			'alignment' => [
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			]
		];
		
		$s = $r +2;
		$this->excel->getActiveSheet()->getStyle('G'.$r.':G'.$s)->applyFromArray($Titulo3);
		
		}
		
		function cabReporteTrans($cells,$arrRows){
		$r = intval(preg_replace('/[^0-9]+/', '', $cells), 10); 
	    $this->excel->getActiveSheet()->fromArray($arrRows,'',$cells);
		
		$this->excel->getActiveSheet()->mergeCells('B'.$r.':C'.$r);
		$this->excel->getActiveSheet()->mergeCells('D'.$r.':E'.$r);
		$s = $r +1;
		$this->excel->getActiveSheet()->mergeCells('B'.$s.':C'.$s);
		$this->excel->getActiveSheet()->mergeCells('D'.$s.':E'.$s);
		$this->cellColor('B'.$r.':C'.$s,'9C9C9C');
		
		$Titulo4 = [
			'font' => [
				'bold'  => true,
				'color' => array('rgb' => '000000'),
				'size'  => 8,
				'name'  => 'Arial'
			]
		];
		$this->excel->getActiveSheet()->getStyle('B'.$r.':C'.$s)->applyFromArray($Titulo4);
		$borders = array(
			  'borders' => array(
				'allborders' => array(
				  'style' => PHPExcel_Style_Border::BORDER_THIN,
				  'color' => array('argb' => 'FF000000'),
				)
			  ),
			);
		
		$s = $r +1;	
		$this->excel->getActiveSheet()->getStyle($cells.':E'.$s)->applyFromArray($borders);
		}
		
		function detReporteH($cells){
		$r = intval(preg_replace('/[^0-9]+/', '', $cells), 10);
		$arrHeader = array('DIA','FECHA','GUIAS DE TRANSPORTE','','No. DE BULTOS','TARIFA');
		$this->excel->getActiveSheet()->fromArray($arrHeader,'',$cells);
		
		$this->excel->getActiveSheet()->mergeCells('D'.$r.':E'.$r);
		$borders = array(
			  'borders' => array(
				'allborders' => array(
				  'style' => PHPExcel_Style_Border::BORDER_THIN,
				  'color' => array('argb' => 'FF000000'),
				)
			  ),
			);
		$this->excel->getActiveSheet()->getStyle($cells.':G'.$r)->applyFromArray($borders);
		
		$Titulo5 = [
			'font' => [
				'bold'  => true,
				'color' => array('rgb' => '000000'),
				'size'  => 8,
				'name'  => 'Arial'
			],
			'alignment' => [
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			]
		];
		$this->excel->getActiveSheet()->getStyle($cells.':G'.$r)->applyFromArray($Titulo5);
		$this->cellColor($cells.':G'.$r,'9C9C9C');
		
		}
		
		function detReporte($cells,$arrRows,$j){
		$r = intval(preg_replace('/[^0-9]+/', '', $cells), 10);
	    $this->excel->getActiveSheet()->fromArray($arrRows ,'',$cells);
		
		$s = $r + $j ;
		for ($ir = $r; $ir <= $s; $ir++) {
		$this->excel->getActiveSheet()->mergeCells('B'.$ir.':E'.$ir);
		}
		
		$s = $r + $j ;
		$borders = array(
			  'borders' => array(
				'allborders' => array(
				  'style' => PHPExcel_Style_Border::BORDER_THIN,
				  'color' => array('argb' => 'FF000000'),
				)
			  ),
			);	
		$this->excel->getActiveSheet()->getStyle($cells.':G'.$s)->applyFromArray($borders);
		$this->excel->getActiveSheet()->getStyle('G'.$r.':G'.$s)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
		
		}
		
		
		function detReportet($cells,$arrRows,$j){
		$r = intval(preg_replace('/[^0-9]+/', '', $cells), 10);
	    $this->excel->getActiveSheet()->fromArray($arrRows ,'',$cells);
		
		$s = $r + $j ;
		for ($ir = $r; $ir <= $s; $ir++) {
		$this->excel->getActiveSheet()->mergeCells('B'.$ir.':E'.$ir);
		}
		
		$s = $r + $j ;
		$borders = array(
			  'borders' => array(
				'allborders' => array(
				  'style' => PHPExcel_Style_Border::BORDER_THIN,
				  'color' => array('argb' => 'FF000000'),
				)
			  ),
			);	
		$this->excel->getActiveSheet()->getStyle($cells.':G'.$s)->applyFromArray($borders);
		
		$TituloD = [
			'font' => [
				'bold'  => false,
				'color' => array('rgb' => '000000'),
				'size'  => 8,
				'name'  => 'Arial'
			],
			'alignment' => [
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			]
		];
		
		$this->excel->getActiveSheet()->getStyle($cells.':G'.$s)->applyFromArray($TituloD);
		$this->excel->getActiveSheet()->getStyle('G'.$r.':G'.$s)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
		
		}
		
		function detReportej($cells,$arrRows,$j){
		$r = intval(preg_replace('/[^0-9]+/', '', $cells), 10);
		//$arrHeader = array('DIA','FECHA','GUIAS DE TRANSPORTE','No. DE BULTOS','TARIFA');
		//$this->excel->getActiveSheet()->fromArray($arrHeader,'',$cells);   
	    $this->excel->getActiveSheet()->fromArray($arrRows ,'',$cells);
		
		//$s = $r + $j ;
		//for ($ir = $r; $ir <= $s; $ir++) {
		//$this->excel->getActiveSheet()->mergeCells('D'.$ir.':E'.$ir);
		//}
		
		$s = $r + $j -1 ;
		$this->excel->getActiveSheet()->mergeCells('B'.$r.':B'.$s);
		$this->excel->getActiveSheet()->mergeCells('C'.$r.':C'.$s);
		//$this->excel->getActiveSheet()->mergeCells('F'.$r.':F'.$s);
		
		$s = $r + $j ;
		$borders = array(
			  'borders' => array(
				'allborders' => array(
				  'style' => PHPExcel_Style_Border::BORDER_THIN,
				  'color' => array('argb' => 'FF000000'),
				)
			  ),
			);
		$this->excel->getActiveSheet()->getStyle($cells.':C'.($s-1))->applyFromArray($borders);
		$this->excel->getActiveSheet()->getStyle('F'.$r.':F'.($s-1))->applyFromArray($borders);
		
		$borderso = array(
			  'borders' => array(
				'outline' => array(
				  'style' => PHPExcel_Style_Border::BORDER_THIN,
				  'color' => array('argb' => 'FF000000'),
				)
			  ),
			);
		
		$z = $r ;
		$s = $s -1;
		$this->excel->getActiveSheet()->getStyle('G'.$z.':G'.$s)->applyFromArray($borderso);
		
		
		for ($ir = $r; $ir <= $s; $ir++) {
		//$this->excel->getActiveSheet()->mergeCells('D'.$ir.':E'.$ir);
		$this->excel->getActiveSheet()->getStyle('D'.$ir.':E'.$ir)->applyFromArray($borderso);
		}
		
		//$this->excel->getActiveSheet()->getStyle('D'.$z.':E'.$s)->applyFromArray($borderso);
		
		$TituloD = [
			'font' => [
				'bold'  => false,
				'color' => array('rgb' => '000000'),
				'size'  => 8,
				'name'  => 'Arial'
			],
			'alignment' => [
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			]
		];
		
		$this->excel->getActiveSheet()->getStyle($cells.':G'.$s)->applyFromArray($TituloD);
		$this->excel->getActiveSheet()->getStyle('G'.$r.':G'.$s)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
		}
		
		function pieReporte($cells){
		$r = intval(preg_replace('/[^0-9]+/', '', $cells), 10);
		$arrHeader = array('ELABORADO POR','','','REVISADO POR','','');
		$this->excel->getActiveSheet()->fromArray($arrHeader,'',$cells);
		$this->excel->getActiveSheet()->mergeCells('B'.$r.':D'.$r);
		$this->excel->getActiveSheet()->mergeCells('E'.$r.':G'.$r);
		
		$s = $r + 1;
		$arrHeader = array('Firma GMP','','','Firma GMP','','');
		$this->excel->getActiveSheet()->fromArray($arrHeader,'','B'.$s);
		
		$borders = array(
			  'borders' => array(
				'allborders' => array(
				  'style' => PHPExcel_Style_Border::BORDER_THIN,
				  'color' => array('argb' => 'FF000000'),
				)
			  ),
			);
		$this->excel->getActiveSheet()->getStyle($cells.':G'.$r)->applyFromArray($borders);
		
		$Titulo5 = [
			'font' => [
				'bold'  => true,
				'color' => array('rgb' => '000000'),
				'size'  => 8,
				'name'  => 'Arial'
			],
			'alignment' => [
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			]
		];
		$this->excel->getActiveSheet()->getStyle($cells.':G'.$r)->applyFromArray($Titulo5);
		$this->cellColor($cells.':G'.$r,'9C9C9C');
		
		$borderso = array(
			  'borders' => array(
				'outline' => array(
				  'style' => PHPExcel_Style_Border::BORDER_THIN,
				  'color' => array('argb' => 'FF000000'),
				)
			  ),
			);
		$s = $r + 3;	
		$this->excel->getActiveSheet()->getStyle($cells.':D'.$s)->applyFromArray($borderso);
		$this->excel->getActiveSheet()->getStyle('E'.$r.':G'.$s)->applyFromArray($borderso);
		
		}
		
		function Preporteqx(){
			$movil = $this->uri->segment(3);
			$w_i_placalq = 'T';
			
			$params = array(array('name'=>':i_placalq',  'value'=>$w_i_placalq ,  'type'=>SQLT_CHR, 'length'=>-1),
			
			);
			
			$this->empresa_model->emp_sprc('pq_pro_procesos','PR_RPT_EGUIA',$params);
			
			$_url = explode('/',base_url()) ;
			
			$di = (new DateTime('now'))->format('d');
			$ma = (new DateTime('now'))->format('m');
			$an = (new DateTime('now'))->format('Y');
			
			$nombre = 'QX'.$di.$ma.$an.'.xls'; 	
			$fichero = '../reporte/'.$nombre;
			if (file_exists($fichero)) {
				unlink($fichero);
			}
			//$ficheroo = 'C:\\inetpub\\wwwroot\\reporte\\'.$nombre;
			
			//$ficheroo = 'C:\\inetpub\\wwwroot\\reporte\\QX03072023.xls';
			$ficheroo = 'C:\\inetpub\\wwwroot\\reporte\\QX03072023.xls';
			//$ficheroo = 'C:/inetpub/wwwroot/reporte'.'/'.$nombre;
			
			
//$this->load->library('excel');
//$file_name = 'Demo.XLS';
$file_name = $fichero;



//$arrHeader = array('Name', 'Mobile');
//$arrRows = array(0=>array('Name'=>'Jayant','Mobile'=>54545), 1=>array('Name'=>'Jayant1', 'Mobile'=>44454), 2=>array('Name'=>'Jayant2','Mobile'=>111222), 3=>array('Name'=>'Jayant3', 'Mobile'=>99999));

//$this->excel->getActiveSheet()->fromArray($arrHeader,'','A1');
//$this->excel->getActiveSheet()->fromArray($arrRows);
//$this->cellColor('A1:C1', 'F28A8C');
//$this->cellImagen('A2',$file_imagen);
$this->excel->getActiveSheet()->setShowGridlines(false);
$i = 1;
$j = 0;
$r = "B";
            $NOMBRE = '';
			$DETALLE = '';
            $id = '';
			$tabla = 'RPT_GUIA';
			$consulta  = $this->empresa_model->r_empo($id,$tabla);
			
			//echo print_r($consulta,true); 
			
			foreach($consulta->result() as $cat ){
			
			    $j = $j + 1;
				
				//if ($NOMBRE != $cat->NOMBRE){
				//}
				
				if ($cat->SEC == 1 or $cat->SEC == 32 or $cat->SEC == 63 or $cat->SEC == 94){ 
				$i = $i + 1;
				$arrRows = array(0 =>array('A'=>'NOMBRE DEL TRANSPORTISTA','B'=>'','C'=>$cat->NOMBRE,'D'=>'','E'=>''),
		                         1 =>array('A'=>'ZONA DE TRANSPORTE','B'=>'','C'=>$cat->ZONA,'D'=>'','E'=>'')
						        );				
				$this->cabReporte($r.$i);
				$i = $i + 4;
				$this->cabReporteTrans($r.$i,$arrRows);
				$i = $i + 1;
				$i = $i + 1;
				$i = $i + 1;

				   $this->detReporteH($r.$i);
				   $i = $i + 1;
				   $j = $j - 1;
				}
				
				if ($cat->MUESTRA == 'S'){
				    //$i = $i + 1;
					//$j = $j - 1;
				}
				
				if (isset($det)) {
				if ($DETALLE != $cat->DIA.$cat->FECHA and count($det) > 0) {
					$this->detReportej($r.$i,$det,$j);
					unset($det);
					$i = $i + $j;
					$j = 0;
				}}
				
				$VALOR = $cat->VALOR;
				if ($VALOR == '0'){
					$VALOR = '';
				}
								
				$FchDoc = "";
				if (strlen($cat->FECHA) > 0) {
				    $FchDoc = date('d/M/Y', strtotime($cat->FECHA));
					$FchDoc = str_replace("Apr","Abr",$FchDoc);
				}
				
				if ($cat->MUESTRA == 'S'){
				    $i = $i + 1;
					$j = 0;
					//$j = $j - 1;
				}//else{
					
		        if ($cat->MUESTRA == 'T'){
				    $det[] = array('A'=>$cat->GUIAS,'B'=>'','C'=>'','D'=>$cat->TON,'E'=>$cat->BULTOS,'F'=>$VALOR);
				}else{
					$det[] = array('A'=>$cat->DIA,'B'=>$FchDoc,'C'=>$cat->GUIAS,'D'=>$cat->TON,'E'=>$cat->BULTOS,'F'=>$VALOR);
				}
				
				if ($cat->SEC == 31 or $cat->SEC == 62 or $cat->SEC == 93 or $cat->SEC == 124){ 
				    //echo print_r($det,true); 
					
					//$i = $i + 1;
					if ($cat->MUESTRA == 'T'){
					$this->detReportet($r.$i,$det,$j);
					}else{
					if ($cat->MUESTRA != 'S'){
				    //$this->detReporte($r.$i,$det,$j);
					$j = $j + 1;
					$this->detReportej($r.$i,$det,$j);
					}
					}
					
					if ($cat->MUESTRA == 'S'){
					   $i = $i - 1;
					}
					//$i = $i + 1;
				    unset($det);
					$i = $i + $j;
					$j = 0;
					
					$i = $i + 2;
					$this->pieReporte($r.$i);
					$i = $i + 5;
				}
				//}
				$NOMBRE = $cat->NOMBRE ;
				$DETALLE = $cat->DIA.$cat->FECHA ;
			
			} 

$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
$objWriter->save($file_name);

$this->excel->disconnectWorksheets();// Good to disconnect
$this->excel->garbageCollect(); // Add this too
unset($objWriter, $this->excel);

$xlApp = new COM("Excel.Application");
//echo $ficheroo;
//$strPath = realpath(basename(getenv($_SERVER["SCRIPT_NAME"])));
//echo $strPath;
$xlBook = $xlApp->Workbooks->Open($ficheroo);  
//$xlSheet1 = $xlBook->Worksheets(1);  
//$xlApp->Application->Visible = False;  

//$excel = new COM("excel.application") or die("Unable to instanciate excel"); 
//$excel->DisplayAlerts = 0; 
//$excel->Workbooks->Open("C:\\revapp\\QX03072023.xls"); 

//$x1 = $xlApp->ActiveSheet->Range("C2")->Left;  
//$y1 = $xlApp->ActiveSheet->Range("C2")->Top;  
//$x2 = $xlApp->ActiveSheet->Range("E2")->Left;  
//$y2 = $xlApp->ActiveSheet->Range("E2")->Top;  
  
//$xlApp->ActiveSheet->Range("C2:E2")->Select();  
//$xlApp->ActiveSheet->Shapes->AddLine($x1, $y1, $x2, $y2)->Select();

//$xlBook->SaveAs($file_name); //*** Save to Path ***//  
  
//*** Close & Quit ***//  
//$xlApp->Application->Quit();  
//$xlApp = null;  
//$xlBook = null;  
//$xlSheet1 = null;  

			//$i = 1;
			//$r = 0;
			//while ($i <= 10) {
			
				
			//	if (!file_exists($fichero)) {
					
			//		$url = 'http://192.168.100.14/reporte/reporteqx.php?id='.$nombre;
				
			//		$ch = curl_init();
			//		curl_setopt($ch,CURLOPT_URL, $url);
			//		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			//		//Si lo deseamos podemos recuperar la salida de la ejecución de la URL
			//		$resultado = curl_exec($ch);
			//		//echo $i.$resultado; 
			//		//cerrar conexión
			//		curl_close($ch);
			//		}else{
			//		break;
			//		$r = 1;
			//	}
			//	sleep(1);	
			//	$i++;  
			//}
			
			$url = 'http://192.168.100.14/reporte/reportevista.php?id='.$nombre.'&mo='.$movil;
			
			$chvista = curl_init();
			curl_setopt($chvista,CURLOPT_URL, $url);
			curl_setopt($chvista, CURLOPT_RETURNTRANSFER, true);
			//Si lo deseamos podemos recuperar la salida de la ejecución de la URL
			$res = curl_exec($chvista);
			echo $res; 
			//cerrar conexión
			curl_close($chvista);
			
			
			
		}
		
		function Preporteun(){
			
			$movil = $this->uri->segment(3);
			
			$w_i_placalq = 'T';
			$params = array(array('name'=>':i_placalq',  'value'=>$w_i_placalq ,  'type'=>SQLT_CHR, 'length'=>40),);
			$this->empresa_model->emp_sprc('pq_pro_procesos','PR_RPT_GUIA_UN',$params);
			
			$di = (new DateTime('now'))->format('d');
			$ma = (new DateTime('now'))->format('m');
			$an = (new DateTime('now'))->format('Y');
			
			$nombre = 'UN'.$di.$ma.$an.'.pdf'; 	
			$fichero = '../reporte/'.$nombre;
			
			if (file_exists($fichero)) {
				unlink($fichero);
			}
			
			$i = 1;
			while ($i <= 10) {					
				if (!file_exists($fichero)) {
					$url = 'http://192.168.100.14/reporte/reporteun.php?id='.$nombre;
					$ch = curl_init();
					curl_setopt($ch,CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$resultado = curl_exec($ch);
					curl_close($ch);
				}else{ break; }
				sleep(1);	
				$i++;  
			}		
			$r = json_decode($resultado, true);
			//echo print_r($r,true);
			if ($r['errmssg'] == '0000'){ 					    
				if (file_exists($fichero)) {
					$url = 'http://192.168.100.14/reporte/reportevista.php?id='.$nombre.'&mo='.$movil;				
					$chvista = curl_init();
					curl_setopt($chvista,CURLOPT_URL, $url);
					curl_setopt($chvista,CURLOPT_RETURNTRANSFER, true);
					$res = curl_exec($chvista);
					curl_close($chvista);
					echo $res; 								               
					}else{
					echo 'PROBLEMAS AL GENERAR ARCHIVO , FAVOR INTENTARLO MAS TARDE...';
				}							   												
				}else{
				//echo print_r($r,true);
				echo 'PROBLEMAS AL GENERAR ARCHIVO , FAVOR INTENTARLO MAS TARDE...';						
			}													
		}
		
		
		function Psrifac(){
			$movil = $this->uri->segment(3);	
			$_index = $this->uri->segment(5);
			$cmp_val = explode("--",$_index);
			
			$_parm = $cmp_val[0];	
			
			$rsp = 'em=0&tp=0&do=0&st=S&us=PROSRIFAC&id='.$_parm;					   
			
			if (isset($rsp)) { 		  
				echo $rsp;
				$url = 'http://192.168.100.14/fe/proceso.php?'.$rsp;
				//$url = '../reporte/reportedif.php?id='.$nombre;
				echo $url;
				$chvista = curl_init();
				curl_setopt($chvista,CURLOPT_URL, $url);
				curl_setopt($chvista, CURLOPT_RETURNTRANSFER, true);
				//Si lo deseamos podemos recuperar la salida de la ejecución de la URL
				$res = curl_exec($chvista);
				echo $res; 
				//cerrar conexión
				curl_close($chvista);
			}
			
		}
		
		
		function Preportefac(){
			$movil = $this->uri->segment(3);
			
			$_index = $this->uri->segment(5);
			$rsp = ' ';
			$cmp_val = explode("--",$_index);
			$_parm = $cmp_val[0];
			
			echo $_parm;
			echo 'consume';		
			
			$url = 'http://192.168.100.14/fe/facTmp.php?id='.$_parm;
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			//Si lo deseamos podemos recuperar la salida de la ejecución de la URL
			$resultado = curl_exec($ch);
			echo $resultado; 
			//cerrar conexión
			curl_close($ch);
			
			
			try {
				echo 'respuesdta';
				$resultado = trim($resultado);
				echo $resultado;
				$rf = json_decode($resultado,true);
				echo 'json';
				echo print_r($rf,true);
				echo 'm uestra json';
				if ($rf['errCodigo'] == '0'){
					echo 'valida';	
					$nombre = $rf['respuesta'];
					sleep(30);
					$url = 'http://192.168.100.14/reporte/reportevista.php?id='.$nombre.'&mo='.$movil;
					//$url = '../reporte/reportedif.php?id='.$nombre;
					//echo $url;
					$chvista = curl_init();
					curl_setopt($chvista,CURLOPT_URL, $url);
					curl_setopt($chvista, CURLOPT_RETURNTRANSFER, true);
					//Si lo deseamos podemos recuperar la salida de la ejecución de la URL
					$res = curl_exec($chvista);
					echo $res; 
					//cerrar conexión
					curl_close($chvista);
				}
				} catch (Exception $err) {
				echo '90001';
				echo 'linea:'.$err->getLine().'error:'.$err->getMessage();
			}
			
			echo 'fin pro fact';
			//echo $page ;
			//$err = $this->empresa_model->errBase();
			
			//if (isset($err)) {
			//    //echo "|1|".$err;
			//}
			//else{
			//    //echo "|0|";
			//}
		}
		
		
		function Pfactura(){
			//echo "1234";
			$w_desde = 'A';
			$w_hasta = 'B';
			$w_proceso = 'C';
			$w_usuario = 'JULIO';
			$w_err = 'D';
			$w_errmsg = 'JULIO';
			
			$params = array(array('name'=>':DESDE',  'value'=>$w_desde ,  'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':HASTA',  'value'=>$w_hasta ,  'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':PROCESO','value'=>$w_proceso ,'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':USUARIO','value'=>$w_usuario ,'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':ERR',    'value'=>$w_err ,    'type'=>SQLT_CHR, 'length'=>40),
			array('name'=>':ERRMSG', 'value'=>$w_errmsg,  'type'=>SQLT_CHR, 'length'=>4000)
			);
			
			$this->empresa_model->emp_sprc('pq_pro_procesos','PR_PRO_FACTURA_GUIA',$params);
			
			$this->sucursal();
			//$err = $this->empresa_model->errBase();
			
			//if (isset($err)) {
			//    //echo "|1|".$err;
			//}
			//else{
			//    //echo "|0|";
			//}
		}
		
		function Proles(){
			//echo "1234";
			$w_desde = 'A';
			$w_hasta = 'B';
			$w_proceso = 'C';
			$w_usuario = 'JULIO';
			$w_err = 'D';
			$w_errmsg = 'JULIO';
			
			$params = array(array('name'=>':DESDE',  'value'=>$w_desde ,  'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':HASTA',  'value'=>$w_hasta ,  'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':PROCESO','value'=>$w_proceso ,'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':USUARIO','value'=>$w_usuario ,'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':ERR',    'value'=>$w_err ,    'type'=>SQLT_CHR, 'length'=>40),
			array('name'=>':ERRMSG', 'value'=>$w_errmsg,  'type'=>SQLT_CHR, 'length'=>4000)
			);
			
			$this->empresa_model->emp_sprc('pq_pro_roles','PR_PRO_ROLES',$params);
			
			$this->rol();
			//$err = $this->empresa_model->errBase();
			
			//if (isset($err)) {
			//    //echo "|1|".$err;
			//}
			//else{
			//    //echo "|0|";
			//}
		}
		
		function Prcierre(){
			//echo "1234";
			$w_desde = 'A';
			$w_hasta = 'B';
			$w_proceso = 'C';
			$w_usuario = 'JULIO';
			$w_err = 'D';
			$w_errmsg = 'JULIO';
			
			$params = array(array('name'=>':DESDE',  'value'=>$w_desde ,  'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':HASTA',  'value'=>$w_hasta ,  'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':PROCESO','value'=>$w_proceso ,'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':USUARIO','value'=>$w_usuario ,'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':ERR',    'value'=>$w_err ,    'type'=>SQLT_CHR, 'length'=>40),
			array('name'=>':ERRMSG', 'value'=>$w_errmsg,  'type'=>SQLT_CHR, 'length'=>4000)
			);
			
			$this->Procontrol();
			$this->empresa_model->emp_sprc('pq_pro_roles','PR_PRO_ROLES_fin',$params);
			//$this->Procdatos();
			
			$this->rol();
			//$err = $this->empresa_model->errBase();
			
			//if (isset($err)) {
			//    //echo "|1|".$err;
			//}
			//else{
			//    //echo "|0|";
			//}
		}
		
	    function cncierre(){
			//echo "1234";
			$w_empresa = '22';
			$w_periodo = '2018';
			$w_usuario = 'JULIO';
			
			$params = array(array('name'=>':i_param',  'value'=>$w_empresa.'|'.$w_periodo.'|'.$w_usuario , 'type'=>SQLT_CHR, 'length'=>30),
			array('name'=>':r_curso', 'value'=>$w_errmsg,  'type'=>OCI_B_CURSOR, 'length'=>-1)
			);
			
			$this->empresa_model->emp_sprc('pq_pro_cncmpr','PR_PRO_CMPR',$params);       
			
			$this->contabilidad();
		}
		
		
		function Pcierre(){
			//echo "1234";
			$w_desde = 'A';
			$w_hasta = 'B';
			$w_proceso = 'C';
			$w_usuario = 'JULIO';
			$w_err = 'D';
			$w_errmsg = 'JULIO';
			
			$params = array(array('name'=>':DESDE',  'value'=>$w_desde ,  'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':HASTA',  'value'=>$w_hasta ,  'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':PROCESO','value'=>$w_proceso ,'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':USUARIO','value'=>$w_usuario ,'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':ERR',    'value'=>$w_err ,    'type'=>SQLT_CHR, 'length'=>40),
			array('name'=>':ERRMSG', 'value'=>$w_errmsg,  'type'=>SQLT_CHR, 'length'=>4000)
			);
			
			$respuesta = $this->empresa_model->emp_sprc('pq_pro_procesos','PR_PRO_FACTURA_fin',$params);
			
			if(!$respuesta){   
				echo 'errorbase';
				
				$err = $this->empresa_model->errBase();
				echo print_r($err,true);
			}
			
			$this->sucursal();
			
			if (isset($err)) {
				//echo "|1|".$err;
				echo "|1|<div class = 'alert alert-danger' >". $err ."</div>'";
			}
			else{
				echo "|0|<div class = 'alert alert-success' >TRANSACCION EXITOSA</div>'";
			}
			
			
			//$err = $this->empresa_model->errBase();
			
			//if (isset($err)) {
			//    //echo "|1|".$err;
			//}
			//else{
			//    //echo "|0|";
			//}
		}
		
		
		function rol(){
			//echo 'aqui empresa';
			$indice = '_rol' ;
			$this->_param($indice);
			$_acc = explode('|',$this->config->item('r_dato')) ;
			//if ($_acc[1] == 1 ) {
            //$this->__index();
            //echo $_acc[0];
			//$this->__filtros($_acc[0]);
			//}elseif( $_acc[2] == 1 )  {
			$this->___index();
			//}elseif( $_acc[3] == 1 )  {
			//$this->__index();
			//}
			
			
		}
		
		function cliente(){
			echo 'aqui CLIENTE';
			$indice = '_cliente' ;
			$this->_param($indice);
			$_acc = explode('|',$this->config->item('r_dato')) ;
			//if ($_acc[1] == 1 ) {
            //$this->__index();
            //echo $_acc[0];
			//$this->__filtros($_acc[0]);
			//}elseif( $_acc[2] == 1 )  {
			$this->___index();
			//}elseif( $_acc[3] == 1 )  {
			//$this->__index();
			//}
			
			
		}
		
		
		function empresas(){
			//echo 'aqui empresa';
			$indice = '_guia' ;
			$this->_param($indice);
			$_acc = explode('|',$this->config->item('r_dato')) ;
			//if ($_acc[1] == 1 ) {
            //$this->__index();
            //echo $_acc[0];
			//$this->__filtros($_acc[0]);
			//}elseif( $_acc[2] == 1 )  {
			$this->___index();
			//}elseif( $_acc[3] == 1 )  {
			//$this->__index();
			//}
			
			
		}
		
		function Preportebl(){
			
			$nombre = 'BALANCE.pdf'; 	
			$fichero = '../reporte/'.$nombre;
			if (file_exists($fichero)) {
				unlink($fichero);
			}
			
			$i = 1;
			$r = 0;
			while ($i <= 10) {
				
				if (!file_exists($fichero)) {		
					$url = 'http://192.168.100.14/reporte/reportebl.php?id=BAL';
					$ch = curl_init();
					curl_setopt($ch,CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					
					$resultado = curl_exec($ch);
					curl_close($ch);
					}else{
					break;
					$r = 1;
				}
				sleep(1);	
				$i++;  
			}
			
			
			$url = 'http://192.168.100.14/reporte/reportevista.php?id='.$nombre;
			$chvista = curl_init();
			curl_setopt($chvista,CURLOPT_URL, $url);
			curl_setopt($chvista, CURLOPT_RETURNTRANSFER, true);
			//Si lo deseamos podemos recuperar la salida de la ejecución de la URL
			$res = curl_exec($chvista);
			echo $res; 
			//cerrar conexión
			curl_close($chvista);				
		}
		
		function Preporters(){
			
			$nombre = 'BALANCE'.'.pdf'; 	
			$fichero = '../reporte/'.$nombre;
			if (file_exists($fichero)) {
				unlink($fichero);
			}
			
			$i = 1;
			$r = 0;
			while ($i <= 10) {
				
				if (!file_exists($fichero)) {		
					$url = 'http://192.168.100.14/reporte/reportebl.php?id=RES';
					$ch = curl_init();
					curl_setopt($ch,CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					
					$resultado = curl_exec($ch);
					curl_close($ch);
					}else{
					break;
					$r = 1;
				}
				sleep(1);	
				$i++;  
			}
			
			
			$url = 'http://192.168.100.14/reporte/reportevista.php?id='.$nombre;
			$chvista = curl_init();
			curl_setopt($chvista,CURLOPT_URL, $url);
			curl_setopt($chvista, CURLOPT_RETURNTRANSFER, true);
			//Si lo deseamos podemos recuperar la salida de la ejecución de la URL
			$res = curl_exec($chvista);
			echo $res; 
			//cerrar conexión
			curl_close($chvista);				
		}
		
		
		function datoP($_parm,$_std = 'P'){
			$acc = explode(' ',$_parm);
			$rsp = ' ';
			$count = count($acc);
			
			
			if (is_array($acc) and $count == 3){
				$std = $acc[0];
				$ind = $acc[1];
				$prm = $acc[2];
				
				if ($_std == $std){
					
					if ( $ind == 'PROCESO' ){
						$params = [];
						$cursor = $this->db->get_cursor();
						$arrd[] = array('name'=>':i_param','value'=>$prm ,  'type'=>SQLT_CHR, 'length'=>500);                                                  
						$arrd[] = array('name'=>':r_curso','value'=>&$cursor ,  'type'=>OCI_B_CURSOR, 'length'=>-1);                             
						
						$params= $arrd;                      
						$consulta = $this->empresa_model->emp_sprcursor('PQ_PRO_PROCESOS','PR_PRO_PENDIENTE',$params,$cursor);
						echo print_r($consulta,true);
						foreach($consulta as $em ){
							if ($em['ERR']== 0 ){
								$rsp = '';
								}else{
								$rsp = $em['ERR'].' - '.$em['MSG'] ;      
							}
						} 
						
					} 
					
					
					
				}}
				return $rsp;
		}
		
		//-D CAMPO 0-
		function datoD($_parm,$_std = 'D'){
			$acc = explode(' ',$_parm);
			$rsp = ' ';
			$count = count($acc);
			//echo print_r($acc,true); 
			//echo print_r($count,true);
			
			
			if (is_array($acc) and $count == 3){
				$std = $acc[0];
				$ind = $acc[1];
				$prm = $acc[2];
				
				//echo print_r($prm,true);
				//echo print_r($ind,true);			
				
				//echo '04';
				if ($_std == $std){
					//echo '05';
					if ( $ind == 'CAMPO' ){
						$rsp = $prm ;   
					} 
					
					if ( $ind == 'FECHA' ){
						$prm = str_replace("N","-",$prm);
						$rsp = $this->fecha($prm) ;   
					} 
					
					if ( $ind == 'USUARIO' ){
						$rsp = 'JULIO' ;   
					} 
					//echo '01';
					if ( $ind == 'SECUENCIA' ){
						//echo '02';
						//// $params = [];
						////     $cursor = $this->db->get_cursor();
						////     $arrd[] = array('name'=>':i_param','value'=>$prm ,  'type'=>SQLT_CHR, 'length'=>20);                                                  
						////     $arrd[] = array('name'=>':r_curso','value'=>&$cursor ,  'type'=>OCI_B_CURSOR, 'length'=>-1);                             
						
						////  $params= $arrd;                      
						////  $consulta = $this->empresa_model->emp_sprcursor('PQ_PRO_PROCESOS','PR_CON_SECUENCIAS',$params,$cursor);
					    //echo print_r($prm,true);
						
						$consulta = $this->empresa_model->emp_sprcursor_sec($prm);
						//echo print_r($consulta,true);
						foreach($consulta as $em ){
							$rsp = $em['SECUENCIA'] ;      
						} 
						
					}
					//echo '03';			
					
					
					
				}}
				return $rsp;
		}
		
		
		function Axml($dat){
			$_xml = '';
			foreach($dat as $key => $val){
				$_xml .= '<' . $key . '>' . $val . '</' . $key . ">\n";
			}
			$_xml = '<R>'.$_xml.'</R>';
			return $_xml;
		}
		
		//--------------------------------------------------------------------------------
		public function recibirWs($comprobante,$tipoAmbiente=1){
			$url=""; 
			switch($tipoAmbiente){
				case 1:
				$url= CompelConfiguracion::$WsdlPruebaRecepcionComprobante;
				break; 
				case 2:
				$url= CompelConfiguracion::$WsdlProduccionRecepcionComprobante;
				break;
			}
			
			$params=array("xml"=>$comprobante);
			$client=new SoapClient($url);
			$result=$client->validarComprobante($params);
			
			if($result){
				if($result->RespuestaRecepcionComprobante){
					$result->isRecibida =$result->RespuestaRecepcionComprobante->estado==="RECIBIDA"?true:false;
					if($result->RespuestaRecepcionComprobante->comprobantes){ if(isset($result->RespuestaRecepcionComprobante->comprobantes->comprobante)){
						$comprobantes=$result->RespuestaRecepcionComprobante->comprobantes->comprobante;
						$result->RespuestaRecepcionComprobante->comprobantes =array();
						if(is_array($comprobantes)){
							$result->RespuestaRecepcionComprobante->comprobantes =$comprobantes;
							}else{
							$result->RespuestaRecepcionComprobante->comprobantes[0]=$comprobantes;
						}
						
						$result->RespuestaRecepcionComprobante->mensajesWs   =array();
						$result->RespuestaRecepcionComprobante->mensajesDb   =array();
						
						for($idxComprobante=0;$idxComprobante<count($result->RespuestaRecepcionComprobante->comprobantes);$idxComprobante++){
							$comprobante=$result->RespuestaRecepcionComprobante->comprobantes[$idxComprobante]; if($comprobante->mensajes){ if(isset($comprobante->mensajes->mensaje)){
								$mensajes=$comprobante->mensajes->mensaje;
								
								$comprobante->mensajes =array();
								if(is_array($mensajes)){
									$comprobante->mensajes =$mensajes;
									}else{
									$comprobante->mensajes[0]=$mensajes;
								}
							}
							
							for($idxMensaje=0;$idxMensaje<count($comprobante->mensajes);$idxMensaje++){
								$item=$comprobante->mensajes[$idxMensaje];
								$informacionAdicional=isset($item->informacionAdicional)?"\n".$item->informacionAdicional :"";
								$mensaje=$item->mensaje;
								$identificador=$item->identificador;
								$tipo=$item->tipo;
								$mensajeDB=trim("({$tipo}-{$identificador}){$mensaje}{$informacionAdicional}");
								$mensajesWs=trim("({$tipo}-{$identificador}){$mensaje}{$informacionAdicional}");
								array_push($result->RespuestaRecepcionComprobante->mensajesDb,$mensajeDB);
								array_push($result->RespuestaRecepcionComprobante->mensajesWs,$mensajesWs);
								$comprobante->mensajes[$idxMensaje]=(array)$comprobante->mensajes[$idxMensaje];
							}
							}
							
							$result->RespuestaRecepcionComprobante->comprobantes[$idxComprobante]=(array)$result->RespuestaRecepcionComprobante->comprobantes[$idxComprobante];
						}
					}
					
					$isRecibida=$result->isRecibida;
					$result=(array)$result->RespuestaRecepcionComprobante;
					$result["isRecibida"]=$isRecibida;
					}
				}
			}
			
			return$result;
		}
		
		
		public function autorizarWs($claveAcceso,$tipoAmbiente=1){
			
			$url=""; 
			switch($tipoAmbiente){ 
				case 1:
				$url= CompelConfiguracion::$WsdlPruebaAutorizacionComprobante;
				break; 
				case 2:
				$url= CompelConfiguracion::$WsdlProduccionAutorizacionComprobante;
				break;
			}
			
			$params=array("claveAccesoComprobante"=>$claveAcceso);
			$client=new SoapClient($url);
			$result=$client->autorizacionComprobante($params);
			
			if($result){
				if($result->RespuestaAutorizacionComprobante){
					$result->isAutorizado =false;
					if($result->RespuestaAutorizacionComprobante->autorizaciones){ 
						if(isset($result->RespuestaAutorizacionComprobante->autorizaciones->autorizacion)){
							$autorizaciones=$result->RespuestaAutorizacionComprobante->autorizaciones->autorizacion;
							$result->RespuestaAutorizacionComprobante->autorizaciones =array();
							if(is_array($autorizaciones)){
								$result->RespuestaAutorizacionComprobante->autorizaciones=$autorizaciones;
								
								}else{
								$result->RespuestaAutorizacionComprobante->autorizaciones[0]=$autorizaciones;
							}
							
							$result->RespuestaAutorizacionComprobante->mensajesWs   =array();
							$result->RespuestaAutorizacionComprobante->mensajesDb   =array();
							
							$numeroComprobantes=$result->RespuestaAutorizacionComprobante->numeroComprobantes;
							array_push($result->RespuestaAutorizacionComprobante->mensajesDb,"Número de comprobantes enviados:{$numeroComprobantes}");
							array_push($result->RespuestaAutorizacionComprobante->mensajesWs,"Número de comprobantes enviados:{$numeroComprobantes}");
							
							$result->RespuestaAutorizacionComprobante->ultimoComprobanteEnviado=null;
							$result->RespuestaAutorizacionComprobante->ultimoComprobanteEnviadoFecha =null;
							for($idxAutorizacion=0;$idxAutorizacion<count($result->RespuestaAutorizacionComprobante->autorizaciones);$idxAutorizacion++){
								$autorizacion=$result->RespuestaAutorizacionComprobante->autorizaciones[$idxAutorizacion];
								
								$autorizacion->fechaAutorizacion =date("Y-m-d H:i:s", strtotime($autorizacion->fechaAutorizacion));
								
								//EE: Convertir en array los mensajes 
								if($autorizacion->mensajes){ if(isset($autorizacion->mensajes->mensaje)){
									$mensajes=$autorizacion->mensajes->mensaje;
									$autorizacion->mensajes =array();
									if(is_array($mensajes)){
										$autorizacion->mensajes =$mensajes;
										}else{
										$autorizacion->mensajes[0]=$mensajes;
									}
									
								}
								
								if(!is_array($autorizacion->mensajes))$autorizacion->mensajes=(array)$autorizacion->mensajes;
								
								$autorizacion->mensajesDb =array();
								$autorizacion->mensajesWs =array();
								for($idxMensaje=0;$idxMensaje<count($autorizacion->mensajes);$idxMensaje++){
									$item=$autorizacion->mensajes[$idxMensaje];
									$noEnvio=$idxAutorizacion+1;
									$informacionAdicional=isset($item->informacionAicional)?"\n".$item->informacionAdicional :"";
									$mensaje=$item->mensaje;
									$identificador=$item->identificador;
									$tipo=$item->tipo;
									$mensajeDB=trim("[{$autorizacion->fechaAutorizacion}]: ({$tipo}-{$identificador}) {$mensaje}{$informacionAdicional}");
									$mensajesWs=trim("[{$autorizacion->fechaAutorizacion}]: ({$tipo}-{$identificador}) {$mensaje}{$informacionAdicional}"); array_push($autorizacion->mensajesDb,$mensajeDB); array_push($autorizacion->mensajesWs,$mensajesWs); array_push($result->RespuestaAutorizacionComprobante->mensajesDb, trim("Envio {$noEnvio}$mensajeDB"));
									array_push($result->RespuestaAutorizacionComprobante->mensajesWs, trim("Envio {$noEnvio}$mensajesWs"));
									$autorizacion->mensajes[$idxMensaje]=(array)$autorizacion->mensajes[$idxMensaje];
								}
								}
								
								//EE: Último envío
								if(is_null($result->RespuestaAutorizacionComprobante->ultimoComprobanteEnviado)){
									$result->RespuestaAutorizacionComprobante->ultimoComprobanteEnviado=(array)$autorizacion;
									$result->RespuestaAutorizacionComprobante->ultimoComprobanteEnviadoFecha =$autorizacion->fechaAutorizacion;
									}else{
									if($autorizacion->fechaAutorizacion >$result->RespuestaAutorizacionComprobante->ultimoComprobanteEnviadoFecha){
										$result->RespuestaAutorizacionComprobante->ultimoComprobanteEnviado=(array)$autorizacion;
										$result->RespuestaAutorizacionComprobante->ultimoComprobanteEnviadoFecha =$autorizacion->fechaAutorizacion;
									}
								}
								
								$isAutorizado=$autorizacion->estado =="AUTORIZADO"&&!$result->isAutorizado ?true:false;
								if($isAutorizado){
									$result->isAutorizado =true;
									$result->RespuestaAutorizacionComprobante->comprobanteAutorizado=$this->obtenerComprobanteAutorizado($autorizacion);
									$result->RespuestaAutorizacionComprobante->fechaAutorizacion=$autorizacion->fechaAutorizacion;
									$result->RespuestaAutorizacionComprobante->numeroAutorizacion=$autorizacion->numeroAutorizacion;
								}
								
								$result->RespuestaAutorizacionComprobante->autorizaciones[$idxAutorizacion]=(array)$result->RespuestaAutorizacionComprobante->autorizaciones[$idxAutorizacion];
							}
						}
					}
					$isAutorizado=$result->isAutorizado;
					$result=(array)$result->RespuestaAutorizacionComprobante;
					$result["isAutorizado"]=$isAutorizado;
				}
			}
			
			return$result;
		}
		
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// inicio transaccion carga lista  -- pendeinte
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
		function ___index(){
			
			$_campos =  $this->config->item('r_filtros');
			$arrprm=array();
			
			if (is_array($_campos)){
				//llena catalogo para filtro /////////////////////////////////////////////////////////////
				$cat =  $this->config->item('r_combo');
				if (isset($cat)) {
					foreach ($cat as $elem) {
						if (is_array($elem)) {                         
							if ($elem['cat'] != '') {
								$arr[] = array($elem['cat'] => '');
							}
						}
					}
                $this->empresa_model->emp_catalogo($arr);   
				$data['car'] = $arr;
				} 
                //echo print_r($arr,true);
				
				//------------------------------------------------------------------------------------------         
				$campos = $_campos['cmp'];
				if (isset($campos)) {
					foreach ($campos as $campo) {
						$_prm = explode('-',$campo['esp']);
						$arrprm[$campo['campo']] = $this->datoD($_prm[0]);
						
					}
			}}
				
				//-------r_camposbot-----------------------------------------------------------------------------------  
				
				$cat =  $this->config->item('r_camposbot');
				if (is_array($cat)){
					if (isset($cat)) {
						foreach ($cat as $elem) {
						    $consul= 0;
							if (is_array($elem)) {
							   
							    if (isset($elem['where'])) {
								    if (is_array($elem['where'])) {
									    $consul= 1;
									    $arrb[] = array($elem['tabla'] => $this->empresa_model->r_emp($elem['where'],$elem['tabla']));
									}
								}
							
								if ($elem['tabla'] != '' && $consul == 0 ) {
									//echo 'camposbot:tabla:';
									//echo print_r($elem['tabla'],true);
									$arrb[] = array($elem['tabla'] => $this->empresa_model->r_empo('',$elem['tabla']));
								}
							}
						}
						$data['bemp'] = $arrb;
					} 
				}
				
				
				$arrdf[] = $arrprm;                
				$data['deff'] = $arrdf;
				
				$_tab = explode('|',$this->config->item('r_tabla')) ;
				$_par = explode(',',$_tab[1]);
				
				$pro = explode('.',$_tab[0]); 
				$paq = $pro[0];
				$prc = $pro[1];
				
				
				$w_dato = '| | | | ';
				$count = count($arrprm);
				if ($count > 0 ) {
					$w_dato =''; 
					foreach ($campos as $campo) {
						
						$w_dato = $w_dato.'|'.$arrprm[$campo['campo']];
						
					}
				}            
				
				
				//echo print_r($w_dato,true);  
				
				$count = count($_par);
				$params = [];  
				
				for ($i = 0; $i < $count; $i++) {
					$_dat = explode(' ',$_par[$i]); 
					if ($_dat[1] == 'OCI_B_CURSOR'){
						$cursor = $this->db->get_cursor();  
						$arrd[] = array('name'=>':'.$_dat[0],  'value'=>&$cursor ,  'type'=>OCI_B_CURSOR, 'length'=>$_dat[2]);     
						}else{         
						$arrd[] = array('name'=>':'.$_dat[0],  'value'=>$w_dato ,  'type'=>SQLT_CHR, 'length'=>$_dat[2]);
					}        
				}
				
				$params= $arrd;
				
				//$consulta = $this->empresa_model->emp_sprcursor($paq,$prc,$params,$cursor);
				$consulta = $this->empresa_model->emp();
								
				//echo print_r($consulta,true);
				$data['emp'] = $consulta;
				$this->load->view('empresa/emp_lst',$data);
		}
		
		function fecha($refe){
			
			
			$_re = explode('|',$refe);
			$_f = (new DateTime('now'));
			
			if ($_re[0]== 'I'){ 
				
				$ma = (new DateTime('now'))->format('m');
				$an = (new DateTime('now'))->format('Y');
				$hr = (new DateTime('now'))->format('H:i:s');
				
				$_f = new \DateTime( $an.'-'.$ma.'-01 '.$hr);       
			}                
			
			if ($_re[0]== 'F'){ 
				$_f = (new DateTime('now'))->add(new \DateInterval('P1M'));
				
				$ma = (new DateTime('now'))->format('m');
				$an = (new DateTime('now'))->format('Y');
				$hr = (new DateTime('now'))->format('H:i:s');   
				$_f = new \DateTime( $an.'-'.$ma.'-01 '.$hr);  
				
				$_f = $_f->add(new \DateInterval('P1M'));             
				$_f = $_f->sub(new \DateInterval('P1D'));
			}
			
			
			$_r=0;
			$_r=intval($_re[2]);
			
			if ($_r > 0) {
				$_r = abs($_r);
				$_a = $_r.$_re[3];
				
				$_f = $_f->add(new \DateInterval('P'.$_a));    
				}else{
				$_r = abs($_r);
				$_a = $_r.$_re[3];
				
				$_f = $_f->sub(new \DateInterval('P'.$_a)); 
			} 
			
			if ($_re[1]== 'FD'){
				//$_f = $_f->format('Y/m/d');          
				//$_f = $_f->format('d/m/Y');          
				$_f = $_f->format('Y-m-d');          
			}
			
			
			if ($_re[1]== 'FDT'){
				//$_f = $_f->format('Y/m/d H:i:s');  
				$_f = $_f->format('d/m/Y H:i:s');          
			}
			
			return $_f;             
		}    
		
		
		function __index(){
		
			$response = $this->empresa_model->emp();
			$consulta = '';
			if ($response->errCodigo == "0" ){
				$consulta =  json_decode(json_encode($response->respuesta),true);
			}

			//echo print_r($consulta,true);
			$data['emp'] = $consulta;
			$this->load->view('empresa/emp_lst',$data);
		}
		
		
		function __filtros($indice){
			//echo 'hola';
			$this->filtro();
			//$this->load->view('empresa/nuevo');
		}
		
		
		function sucursal(){
			//echo 'aqui sucursal';
			
			$indice = '_factura' ;
			$this->_param($indice);
			$this->___index();
		}
		
		function contabilidad(){
			
			//echo 'aqui sucursal';
			$indice = '_cncmpr' ;
			$this->_param($indice);
			$this->___index();
		}	
		
		function ocp(){
			//echo 'aqui sucursal';
			
			$indice = '_orcmpr' ;
			$this->_param($indice);
			$this->___index();
		}
		
		function banco(){
			//echo 'aqui sucursal';
			
			$indice = '_bncmpr' ;
			$this->_param($indice);
			$this->___index();
		}
		
		function proveedor(){
			//echo 'aqui sucursal';
			
			$indice = '_prcmpr' ;
			$this->_param($indice);
			$this->___index();
		}	
		
		function catalogo(){
			//echo 'aqui sucursal';
			
			$indice = '_clista' ;
			$this->_param($indice);
			$this->___index();
		}
		
		function _param($indice){
			//echo $indice;
			if (strtoupper($indice) == strtoupper('_guia')) {
				
				$this->structo = array(array('base'=>'factura','nombre'=>'factura','metodo'=>'0|0|0|0','join'=>''),
				                       array('base'=>'factura','nombre'=>'facdetalle','metodo'=>'0|0|0|0','join'=>array('sec'=>'sec'))  
			    ); 
				
				$this->botoo  = array  (array('title'=>'Datos','proceso'=>"carga('".base_url()."empresa/Pdatos','filtro');",'contene'=>'ESTEMP','imagen'=>'../guia/application/views/empresa/images/Ppull.png'),
				array('title'=>'Guias','proceso'=>"carga('".base_url()."empresa/Pguias','filtro');",'contene'=>'ESTEMP','imagen'=>'../guia/application/views/empresa/images/pguias.png'),
				array('title'=>'Costo','proceso'=>"carga('".base_url()."empresa/Pcosto','filtro');",'contene'=>'ESTEMP','imagen'=>'../guia/application/views/empresa/images/pcosto.png'),
				array('title'=>'reporte','proceso'=>"add_person('N','S');cargaRpt('".base_url()."empresa/Preporteqx','contenidom');",'contene'=>'ESTEMP','imagen'=>'../guia/application/views/empresa/images/reportes.png'),
				array('title'=>'Unidas','proceso'=>"add_person('N','S');cargaRpt('".base_url()."empresa/Preporteun','contenidom');",'contene'=>'ESTEMP','imagen'=>'../guia/application/views/empresa/images/reportes.png'),
				array('title'=>'Difare','proceso'=>"add_person('N','S');cargaRpt('".base_url()."empresa/Preportedif','contenidom');",'contene'=>'ESTEMP','imagen'=>'../guia/application/views/empresa/images/reportes.png')
				);
				$this->comboo = array(array('dato'=>'Guia','campo'=>'ESTADO','cat'=>'BAI','nom'=>'julio'),
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
				$this->datoo  = 'GUIA|1|1|1';
				
				$this->tablao = 'pq_pro_procesos.pr_con_guia|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1 ';
				$this->camposo = array('prm'=>'GUIA|sp_grb_GUIA|GUIA|-E PROCESO GUIA-',
                'cmp'=>array(
				array('campo'=>'IGUIA','as'=>'ID','id'=>'1','lst'=>'0|0|1','esp'=>'-E SECUENCIA GUIA-',
				array('tipo'=>'rlsa','attr'=> array('field' => 'IGUIA','label' => 'CODIGO','rules' => '')),
				array('tipo'=>'lbl','attr'=> array('text'=>'CODIGO:','for'=>'IGUIA','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'IGUIA','id' => 'IGUIA'  ,'placeholder' => 'Escribe Codigo','maxlength' => '3',
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
				array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'IDCLI','opcion'=>array(''=>''),'attr'=>'id= "IDCLI" onchange ="cambioss('.$this->comi.'TIPO|IDCLI-NOMBRE1@ZONA|IDCLI-NOMBRE2'.$this->comi.','.$this->comi.'GUIA'.$this->comi.');"'))
				),
				array('campo'=>'TIPO','as'=>'TIPO','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'TIPO','label' => 'TIPO','rules' => 'trim|required|max_length[30]')),
				array('tipo'=>'lbl','attr'=> array('text'=>'TIPO:','for'=>'TIPO','attr'=>array())),
				array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'TIPO','opcion'=>array(''=>''),'attr'=>'id = "TIPO"'))
				),
				array('campo'=>'DOCUMENTO','as'=>'DOC','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'DOCUMENTO','label' => 'DOCUMENTO','rules' => 'trim|required|max_length[100]')),
				array('tipo'=>'lbl','attr'=> array('text'=>'DOCUMENTO:','for'=>'DOCUMENTO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'DOCUMENTO','id' => 'DOCUMENTO','placeholder' => 'Escribe Direccion','maxlength' => '100',
				'size' => '3'            ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
				),
				array('campo'=>'FECHA','as'=>'FECHA','id'=>'0','lst'=>'1|1|1','esp'=>'-D FECHA A|FD|0|D-',
				array('tipo'=>'rls','attr'=> array('field' => 'FECHA','label' => 'FECHA','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'FECHA:','for'=>'FECHA','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'FECHA','id' => 'FECHA','placeholder' => 'Escribe Direccion','maxlength' => '20',
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
				array('tipo'=>'txt','attr'=> array('name' => 'NDOC','id' => 'NDOC','placeholder' => 'Escribe Direccion','maxlength' => '10',
				'size' => '3'            ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','onkeypress'=>'return numero(event);' ))
				),
				array('campo'=>'NBUL','as'=>'NB','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'NBUL','label' => 'BULTOS','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'BULTOS:','for'=>'NBUL','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'NBUL','id' => 'NBUL','placeholder' => 'Escribe Direccion','maxlength' => '10',
				'size' => '3'            ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','onkeypress'=>'return numero(event);' ))
				),
				array('campo'=>'IDMSG','as'=>'IDMSG','id'=>'0','lst'=>'0|0|0','esp'=>'',
				array('tipo'=>'rlsa','attr'=> array('field' => 'IDMSG','label' => 'IDmensaje','rules' => '')),
				array('tipo'=>'lbl','attr'=> array('text'=>'ID MSG:','for'=>'IDMSG','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'IDMSG','id' => 'IDMSG','placeholder' => 'Escribe Direccion','maxlength' => '10',
				'size' => '3'            ,'style'       => 'width:100%'      ,'value'     => '' ))
				),
				array('campo'=>'USUCREA','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'-E USUARIO USU-',
				array('tipo'=>'rlsa','attr'=> array('field' => 'USUCREA','label' => 'USUCREA','rules' => '')),
				array('tipo'=>'lbl','attr'=> array('text'=>'USUCREA:','for'=>'USUCREA','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'USUCREA','id' => 'USUCREA'  ,'placeholder' => 'Escribe Codigo',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '' ))
				),
				array('campo'=>'FCHCREA','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'-E FECHA A|FD|0|D-',
				array('tipo'=>'rlsa','attr'=> array('field' => 'FCHCREA','label' => 'FCHCREA','rules' => '')),
				array('tipo'=>'lbl','attr'=> array('text'=>'FCHCREA:','for'=>'FCHCREA','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'FCHCREA','id' => 'FCHCREA'  ,'placeholder' => 'Escribe Codigo',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => ''))
				),
				array('campo'=>'USUMODIF','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'-E USUARIO USU-E USUARIO USU',
				array('tipo'=>'rlsa','attr'=> array('field' => 'USUMODIF','label' => 'USUMODIF','rules' => '')),
				array('tipo'=>'lbl','attr'=> array('text'=>'USUMODIF:','for'=>'USUMODIF','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'USUMODIF','id' => 'USUMODIF'  ,'placeholder' => 'Escribe Codigo',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '' ))
				),
				array('campo'=>'FCHMODIF','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'-E FECHA A|FD|0|D-E FECHA A|FD|0|D',
				array('tipo'=>'rlsa','attr'=> array('field' => 'FCHMODIF','label' => 'FCHMODIF','rules' => '')),
				array('tipo'=>'lbl','attr'=> array('text'=>'FCHMODIF:','for'=>'FCHMODIF','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'FCHMODIF','id' => 'FCHMODIF'  ,'placeholder' => 'Escribe Codigo',
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
				array('tipo'=>'txt','attr'=> array('name' => 'COSTO','id' => 'COSTO','placeholder' => 'Escribe Direccion','maxlength' => '10',
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
				array('tipo'=>'txt','attr'=> array('name' => 'OBSER','id' => 'OBSER'  ,'placeholder' => 'Escribe Codigo','maxlength' => '100',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
				),
				array('campo'=>'PESO','as'=>'PESO','id'=>'0','lst'=>'0|0|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'PESO','label' => 'PESO','rules' => 'trim')),
				array('tipo'=>'lbl','attr'=> array('text'=>'PESO:','for'=>'PESO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'PESO','id' => 'PESO','placeholder' => 'Escribe Direccion','maxlength' => '10',
				'size' => '3'            ,'style'       => 'width:100%'      ,'value'     => '' ))
				)
				
                ),
                'btn'=>array(                  
				array('title'=>'Actualiza','procesoa'=>"add_person('N','N');carga('".base_url()."empresa/actualizar/",'procesob'=>"','contenidom');",'id'=>'lnk_act','men'=>'a'),                    
				array('title'=>'Elimina','procesoa'=>"if (eliminar()== true) { carga('".base_url()."empresa/eliminar/",'procesob'=>"','filtro');}",'id'=>'lnk_eli','men'=>'e')                       
                ));
				$this->filtroo = array('prm'=>'GUIA|sp_grb_GUIA|GUIA',
                'cmp'=>array(
				array('campo'=>'IDCLI','as'=>'IDCLI','id'=>'0','lst'=>'0|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'IDCLI','label' => 'PROC CLIENTE','rules' => 'trim|required|max_length[30]')),
				array('tipo'=>'lbl','attr'=> array('text'=>'Cliente:','for'=>'IDCLI','attr'=>array())),
				array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'IDCLI','opcion'=>array(''=>''),'attr'=>''))
				),
				array('campo'=>'IGUIA','as'=>'Codigo','id'=>'1','lst'=>'0|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'IGUIA','label' => 'Codigo','rules' => 'trim|required|strip_tags|xss_clean|min_length[3]')),
				array('tipo'=>'lbl','attr'=> array('text'=>'Codigo:','for'=>'IGUIA','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'IGUIA','id' => 'IGUIA'  ,'placeholder' => 'Escribe Codigo','maxlength' => '12',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','onblur'=>'rev();'  ))
				),
				array('campo'=>'FDESDE','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'D FECHA I|FD|N30|D--',
				array('tipo'=>'rlsa','attr'=> array('field' => 'FDESDE','label' => 'FDESDE','rules' => '')),
				array('tipo'=>'lbl','attr'=> array('text'=>'Desde:','for'=>'FDESDE','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'FDESDE','id' => 'FDESDE'  ,'placeholder' => 'Escribe Codigo','maxlength' => '12',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '', 'class' => 'fecha' ))
				),
				array('campo'=>'FHASTA','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'D FECHA F|FD|30|D--',
				array('tipo'=>'rlsa','attr'=> array('field' => 'FHASTA','label' => 'FHASTA','rules' => '')),
				array('tipo'=>'lbl','attr'=> array('text'=>'Hasta:','for'=>'USUMODIF','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'FHASTA','id' => 'FHASTA'  ,'placeholder' => 'Escribe Codigo','maxlength' => '12',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '' ))
				),					
				
				array('campo'=>'PROLIQ','as'=>'PROLIQ','id'=>'0','lst'=>'0|0|0','esp'=>'D CAMPO N--',
				array('tipo'=>'rls','attr'=> array('field' => 'PROLIQ','label' => 'PROC LIQUID','rules' => 'trim|required|max_length[30]')),
				array('tipo'=>'lbl','attr'=> array('text'=>'Proceso:','for'=>'PROLIQ','attr'=>array())),
				array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'PROLIQ','opcion'=>array(''=>''),'attr'=>''))
				)
                ));
				
				
				$this->camposdeto = array(array('prm'=>'dGUIA|pr_con_dGUIA|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1 ',
				'cmp'=>array(
                array('campo'=>'IGUIA','as'=>'lista','id'=>'1','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'LISTA','label' => 'LISTA','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'LISTA:','for'=>'LISTA','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'LISTA','id' => 'LISTA'  ,'placeholder' => 'Escribe Codigo','maxlength' => '3',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
                ),
				array('campo'=>'SEC','as'=>'lista','id'=>'1','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'SEC','label' => 'SEC','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'SEC:','for'=>'SEC','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'SEC','id' => 'SEC'  ,'placeholder' => 'Escribe Codigo','maxlength' => '3',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
                ),
				array('campo'=>'FECHA','as'=>'FECHA','id'=>'0','lst'=>'1|1|1','esp'=>'-D FECHA A|FD|0|D-',
				array('tipo'=>'rls','attr'=> array('field' => 'FECHA','label' => 'FECHA','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'FECHA:','for'=>'FECHA','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'FECHA','id' => 'FECHA','placeholder' => 'Escribe Direccion','maxlength' => '20',
				'size' => '10'            ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','onkeypress'=>'return numero(event);'))
				),
                array('campo'=>'TIPO','as'=>'TIPO','id'=>'1','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'TIPO','label' => 'TIPO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'TIPO:','for'=>'TIPO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'TIPO','id' => 'TIPO'  ,'placeholder' => 'Escribe TIPO','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
                ),
                array('campo'=>'DOCUMEN','as'=>'DOCUMENTO','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'DOCUMEN','label' => 'DOCUMEN','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'DOCUMENTO:','for'=>'DOCUMEN','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'DOCUMEN'  ,'id' => 'DOCUMEN','placeholder' => 'Escribe DOCUMEN','maxlength' => '100',
				'size' => '100'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
                ),
                array('campo'=>'DESTINO','as'=>'DESTINO','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'DESTINO','label' => 'DESTINO','rules' => 'trim|')),
				array('tipo'=>'lbl','attr'=> array('text'=>'DESTINO:','for'=>'DESTINO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'DESTINO'  ,'id' => 'DESTINO','placeholder' => 'Escribe DESTINO','maxlength' => '100',
				'size' => '100'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
                ),
				array('campo'=>'NBULT','as'=>'NB','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'NBUL','label' => 'BULTOS','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'BULTOS:','for'=>'NBUL','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'NBUL','id' => 'NBUL','placeholder' => 'Escribe Direccion','maxlength' => '10',
				'size' => '3'            ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','onkeypress'=>'return numero(event);' ))
                ),
                array('campo'=>'TBULT','as'=>'TBUL','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'TBUL','label' => 'TBUL','rules' => 'trim|')),
				array('tipo'=>'lbl','attr'=> array('text'=>'TBUL:','for'=>'TBUL','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'TBUL'  ,'id' => 'TBUL','placeholder' => 'Escribe TBUL','maxlength' => '100',
				'size' => '100'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
                ),
				array('campo'=>'VALOR','as'=>'VALOR','id'=>'0','lst'=>'1|0|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'VALOR','label' => 'VALOR','rules' => 'trim')),
				array('tipo'=>'lbl','attr'=> array('text'=>'VALOR:','for'=>'VALOR','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'VALOR','id' => 'VALOR','placeholder' => 'Escribe Direccion','maxlength' => '10',
				'size' => '3'            ,'style'       => 'width:100%'      ,'value'     => '' ))
				),
				array('campo'=>'OBSER','as'=>'OBSER','id'=>'0','lst'=>'0|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'OBSER','label' => 'OBSER','rules' => '')),
				array('tipo'=>'lbl','attr'=> array('text'=>'RETIRO:','for'=>'OBSER','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'OBSER','id' => 'OBSER'  ,'placeholder' => 'Escribe Codigo','maxlength' => '100',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
				),
                array('campo'=>'IDGUIA','as'=>'IDGUIA','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'IDGUIA','label' => 'IDGUIA','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'IDGUIA:','for'=>'IDGUIA','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'IDGUIA','id' => 'IDGUIA'  ,'placeholder' => 'Escribe Codigo','maxlength' => '3',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
                ),	
				array('campo'=>'UBICA','as'=>'UBICA','id'=>'0','lst'=>'0|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'UBICA','label' => 'UBICA','rules' => '')),
				array('tipo'=>'lbl','attr'=> array('text'=>'RETIRO:','for'=>'UBICA','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'UBICA','id' => 'UBICA'  ,'placeholder' => 'Escribe Codigo','maxlength' => '100',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
				),
				array('campo'=>'REFEREN','as'=>'REFEREN','id'=>'0','lst'=>'0|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'REFEREN','label' => 'REFEREN','rules' => '')),
				array('tipo'=>'lbl','attr'=> array('text'=>'RETIRO:','for'=>'REFEREN','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'REFEREN','id' => 'REFEREN'  ,'placeholder' => 'Escribe Codigo','maxlength' => '100',
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
				array('tipo'=>'txt','attr'=> array('name' => 'USUCREA','id' => 'USUCREA'  ,'placeholder' => 'Escribe Codigo',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '' ))
				),
                array('campo'=>'FCHCREA','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'-E FECHA A|FD|0|D-',
				array('tipo'=>'rlsa','attr'=> array('field' => 'FCHCREA','label' => 'FCHCREA','rules' => '')),
				array('tipo'=>'lbl','attr'=> array('text'=>'FCHCREA:','for'=>'FCHCREA','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'FCHCREA','id' => 'FCHCREA'  ,'placeholder' => 'Escribe Codigo',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => ''))
				),
                array('campo'=>'USUMODIF','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'-E USUARIO USU-E USUARIO USU',
				array('tipo'=>'rlsa','attr'=> array('field' => 'USUMODIF','label' => 'USUMODIF','rules' => '')),
				array('tipo'=>'lbl','attr'=> array('text'=>'USUMODIF:','for'=>'USUMODIF','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'USUMODIF','id' => 'USUMODIF'  ,'placeholder' => 'Escribe Codigo',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '' ))
				),
                array('campo'=>'FCHMODIF','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'-E FECHA A|FD|0|D-E FECHA A|FD|0|D',
				array('tipo'=>'rlsa','attr'=> array('field' => 'FCHMODIF','label' => 'FCHMODIF','rules' => '')),
				array('tipo'=>'lbl','attr'=> array('text'=>'FCHMODIF:','for'=>'FCHMODIF','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'FCHMODIF','id' => 'FCHMODIF'  ,'placeholder' => 'Escribe Codigo',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '' ))
				)
				
				)));
				
				$this->importao = array('prm'=>'GUIA|sp_grb_GUIA|GUIA',
                'cmp'=>array(
				array('campo'=>'ARCHGUIA','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'D FECHA F|FD|30|D--',
				array('tipo'=>'rlsa','attr'=> array('field' => 'FHASTA','label' => 'FHASTA','rules' => '')),
				array('tipo'=>'lbl','attr'=> array('text'=>'ARCHIVO:','for'=>'ARCHGUIA','attr'=>array())),
				array('tipo'=>'ach','attr'=> array('name' => 'ARCHGUIA','id' => 'ARCHGUIA'  ,'placeholder' => '','maxlength' => '50',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '' ))
				),					
				
				array('campo'=>'PROARCHGUIA','as'=>'PROCESO','id'=>'0','lst'=>'0|0|0','esp'=>'ARCHGUIA',
				array('tipo'=>'rlsa','attr'=> array('field' => 'PROARCHGUIA','label' => 'PROC LIQUID','rules' => 'trim|required|max_length[30]')),
				array('tipo'=>'lbla','attr'=> array('text'=>'Proceso:','for'=>'PROARCHGUIA','attr'=>array())),
				array('tipo'=>'btn','attr'=> array('name'=>'PROARCHGUIA','id'=>'PROARCHGUIA','attr'=>''))
				)
                ));
				
				$this->camposboto = array(array('btnn'=>'0','title'=>'Guias Error ','tabla'=>'mensajes','where'=>array('PROCESO' => 'ERROR'),'prm'=>'mensajes|pr_con_rol_roles|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1|-E PROCESO DFAC-',
				'cmp'=>array(
				array('campo'=>'CODIGO','as'=>'CODIGO','id'=>'1','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'CODIGO','label' => 'CODIGO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'CODIGO:','for'=>'CODIGO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'CODIGO','id' => 'CODIGO'  ,'placeholder' => 'Escribe CODIGO','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'MENSAJE','as'=>'MENSAJE','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'MENSAJE','label' => 'MENSAJE','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'MENSAJE |GUIA QX 2755444 N1, 39 1 - 0|GUIA RET 0 C0, 1 1 RETIRO-HOSPITAL 0:','for'=>'MENSAJE','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'MENSAJE','id' => 'MENSAJE'  ,'placeholder' => 'Escribe MENSAJE','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
				),
				array('campo'=>'USUARIO','as'=>'USUARIO','id'=>'0','lst'=>'1|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'USUARIO','label' => 'USUARIO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'USUARIO:','for'=>'USUARIO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'USUARIO','id' => 'USUARIO'  ,'placeholder' => 'Escribe USUARIO','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'FECHA','as'=>'FECHA','id'=>'0','lst'=>'1|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'FECHA','label' => 'FECHA','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'FECHA:','for'=>'FECHA','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'FECHA','id' => 'FECHA'  ,'placeholder' => 'Escribe FECHA','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'PROCESO','as'=>'PROCESO','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'PROCESO','label' => 'PROCESO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'PROCESO:','for'=>'PROCESO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'PROCESO','id' => 'PROCESO'  ,'placeholder' => 'Escribe PROCESO','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required'))
				),
				array('campo'=>'RANGO','as'=>'RANGO','id'=>'0','lst'=>'0|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'RANGO','label' => 'RANGO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'RANGO:','for'=>'RANGO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'RANGO','id' => 'RANGO'  ,'placeholder' => 'Escribe RANGO','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'REFEREN','as'=>'REFEREN','id'=>'0','lst'=>'1|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'REFEREN','label' => 'REFEREN','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'REFEREN:','for'=>'REFEREN','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'REFEREN','id' => 'REFEREN'  ,'placeholder' => 'Escribe REFEREN','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'USUACT','as'=>'USUACT','id'=>'0','lst'=>'0|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'USUACT','label' => 'USUACT','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'USUACT:','for'=>'USUACT','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'USUACT','id' => 'USUACT'  ,'placeholder' => 'Escribe USUACT','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'FCHACT','as'=>'FCHACT','id'=>'0','lst'=>'0|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'FCHACT','label' => 'FCHACT','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'FCHACT:','for'=>'FCHACT','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'FCHACT','id' => 'FCHACT'  ,'placeholder' => 'Escribe FCHACT','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'USUPRO','as'=>'USUPRO','id'=>'0','lst'=>'0|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'USUPRO','label' => 'USUPRO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'USUPRO:','for'=>'USUPRO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'USUPRO','id' => 'USUPRO'  ,'placeholder' => 'Escribe USUPRO','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'FCHPRO','as'=>'FCHPRO','id'=>'0','lst'=>'0|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'FCHPRO','label' => 'FCHPRO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'FCHPRO:','for'=>'FCHPRO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'FCHPRO','id' => 'FCHPRO'  ,'placeholder' => 'Escribe FCHPRO','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'OPERADOR','as'=>'OPERADOR','id'=>'0','lst'=>'1|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'OPERADOR','label' => 'OPERADOR','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'OPERADOR:','for'=>'OPERADOR','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'OPERADOR','id' => 'OPERADOR'  ,'placeholder' => 'Escribe OPERADOR','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'DETALLE','as'=>'DETALLE','id'=>'0','lst'=>'0|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'DETALLE','label' => 'DETALLE','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'DETALLE:','for'=>'DETALLE','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'DETALLE','id' => 'DETALLE'  ,'placeholder' => 'Escribe DETALLE','maxlength' => '20',
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
				array('tipo'=>'txt','attr'=> array('name' => 'LISTA','id' => 'LISTA'  ,'placeholder' => 'Escribe Codigo','maxlength' => '3',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
                ),
                array('campo'=>'CODIGO','as'=>'CODIGO','id'=>'1','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'CODIGO','label' => 'CODIGO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'CODIGO:','for'=>'CODIGO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'CODIGO','id' => 'CODIGO'  ,'placeholder' => 'Escribe Codigo','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
                ),
                array('campo'=>'NOMBRE','as'=>'FORMATOFAC','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'NOMBRE','label' => 'NOMBRE','rules' => 'required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'NOMBRE:','for'=>'NOMBRE','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'NOMBRE'  ,'id' => 'NOMBRE','placeholder' => 'Escribe Nombre','maxlength' => '100',
				'size' => '100'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
                ),
                array('campo'=>'NOMBRE1','as'=>'FECHAINI','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'nombre1','label' => 'nombre1','rules' => 'trim|')),
				array('tipo'=>'lbl','attr'=> array('text'=>'Nombre1:','for'=>'nombre1','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'NOMBRE1'  ,'id' => 'NOMBRE1','placeholder' => 'Escribe Nombre','maxlength' => '100',
				'size' => '100'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
                ),
                array('campo'=>'NOMBRE2','as'=>'FECHAFIN','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'nombre2','label' => 'nombre2','rules' => 'trim|')),
				array('tipo'=>'lbl','attr'=> array('text'=>'Nombre2:','for'=>'nombre2','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'NOMBRE2'  ,'id' => 'NOMBRE2','placeholder' => 'Escribe Nombre','maxlength' => '100',
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
				
				$this->structo = json_decode(json_encode($this->structo, JSON_FORCE_OBJECT));

				$this->config->set_item('r_struct', $this->structo);
				$this->config->set_item('r_boto', $this->botoo);
				$this->config->set_item('r_combo', $this->comboo);
				$this->config->set_item('r_dato', $this->datoo);
				$this->config->set_item('r_tabla', $this->tablao);
				$this->config->set_item('r_campos', $this->camposo);
				$this->config->set_item('r_filtros', $this->filtroo);
				$this->config->set_item('r_camposdet', $this->camposdeto);
				$this->config->set_item('r_camposbot', $this->camposboto);
				$this->config->set_item('r_importa', $this->importao);
				
			}
			
			if (strtoupper($indice) == strtoupper('_clista')) {

				$this->structo = array(array('base'=>'admin','nombre'=>'clista','metodo'=>'0|0|0|0','join'=>''),
				                       array('base'=>'admin','nombre'=>'dlista','metodo'=>'0|0|0|0','join'=>array('lista'=>'lista'))  
                ); 
				
				$this->botoo  = array(array('title'=>'Datos','proceso'=>"carga('".base_url()."empresa/Edatos','filtro');",'contene'=>'ESTEMP','imagen'=>'../guia/application/views/empresa/images/Ppush.png')); 
				$this->comboo = array(array('dato'=>'clista','campo'=>'estado','cat'=>'BAI','nom'=>'julio'));            
				
				$this->datoo  = 'clista|0|1|1|catalogo';
				$this->tablao = 'pq_pro_procesos.pr_con_clista|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1|admin.clista';            
				$this->camposo = array('prm'=>'clista|sp_grb_clista|clista||admin.clista',
				'cmp'=>array(
                array('campo'=>'LISTA','as'=>'lista','id'=>'1','lst'=>'1|0|1','esp'=>'-E SECUENCIA admin.clista-',
				array('tipo'=>'rls','attr'=> array('field' => 'LISTA','label' => 'LISTA','rules' => 'required|'.$this->validation_txt)),
				array('tipo'=>'lbl','attr'=> array('text'=>'LISTA:','for'=>'LISTA','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'LISTA','id' => 'LISTA'  ,'placeholder' => ' ','maxlength' => '3',
				'size' => '15'           ,'style'       => 'width:100%'      ,'value'     => '','readonly'=>'readonly' ))
                ),
                array('campo'=>'NOMBRE','as'=>'Nombre','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'NOMBRE','label' => 'NOMBRE','rules' => 'required|'.$this->validation_txt)),
				array('tipo'=>'lbl','attr'=> array('text'=>'NOMBRE:','for'=>'NOMBRE','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'NOMBRE'  ,'id' => 'NOMBRE','placeholder' => ' ','maxlength' => '100',
				'size' => '15'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
                ),
				
                array('campo'=>'DESCRIP','as'=>'Descripcion','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'DESCRIP','label' => 'DESCRIP','rules' => 'required|'.$this->validation_txt)),
				array('tipo'=>'lbl','attr'=> array('text'=>'DESCRIP:','for'=>'DESCRIP','attr'=>array())),
				array('tipo'=>'txta','attr'=> array('name' => 'DESCRIP'  ,'id' => 'DESCRIP','placeholder' => ' ','maxlength' => '100',
				'size' => '15','rows' => '1','style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
                ),
                array('campo'=>'ESTADO','as'=>'Estado','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'ESTADO','label' => 'ESTADO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'ESTADO:','for'=>'ESTADO','attr'=>array())),
				array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'ESTADO','opcion'=>array(''=>''),'attr'=>''))
                )
				
				),
				'btn'=>array(                  
				array('title'=>'Actualiza','procesoa'=>"add_person('N','N');carga('".base_url()."empresa/actualizar/",'procesob'=>"','contenidom');",'id'=>'lnk_act','men'=>'a'),                    
				array('title'=>'Elimina','procesoa'=>"if (eliminar()== true) { carga('".base_url()."empresa/eliminar/",'procesob'=>"','filtro');}",'id'=>'lnk_eli','men'=>'e')                       
				));
				$this->filtroo = '';
				$this->importao = '';
				
				$this->camposdeto = array(array('prm'=>'dlista|pr_con_dlista|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1||admin.dlista',
				'cmp'=>array(
                array('campo'=>'LISTA','as'=>'lista','id'=>'1','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'LISTA','label' => 'LISTA','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'LISTA:','for'=>'LISTA','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'LISTA','id' => 'LISTA'  ,'placeholder' => 'Escribe Codigo','maxlength' => '3',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
                ),
                array('campo'=>'CODIGO','as'=>'codigo','id'=>'1','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'CODIGO','label' => 'CODIGO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'CODIGO:','for'=>'CODIGO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'CODIGO','id' => 'CODIGO'  ,'placeholder' => 'Escribe Codigo','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
                ),
                array('campo'=>'NOMBRE','as'=>'Nombre','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'NOMBRE','label' => 'NOMBRE','rules' => 'required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'NOMBRE:','for'=>'NOMBRE','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'NOMBRE'  ,'id' => 'NOMBRE','placeholder' => 'Escribe Nombre','maxlength' => '100',
				'size' => '100'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
                ),
                array('campo'=>'NOMBRE1','as'=>'Nombre1','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'nombre1','label' => 'nombre1','rules' => 'trim|')),
				array('tipo'=>'lbl','attr'=> array('text'=>'Nombre1:','for'=>'nombre1','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'NOMBRE1'  ,'id' => 'NOMBRE1','placeholder' => 'Escribe Nombre','maxlength' => '100',
				'size' => '100'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
                ),
                array('campo'=>'NOMBRE2','as'=>'Nombre2','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'nombre2','label' => 'nombre2','rules' => 'trim|')),
				array('tipo'=>'lbl','attr'=> array('text'=>'Nombre2:','for'=>'nombre2','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'NOMBRE2'  ,'id' => 'NOMBRE2','placeholder' => 'Escribe Nombre','maxlength' => '100',
				'size' => '100'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
                ),
                array('campo'=>'ESTADO','as'=>'Estado','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'ESTADO','label' => 'ESTADO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'ESTADO:','for'=>'ESTADO','attr'=>array())),
				array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'ESTADO','opcion'=>array(''=>''),'attr'=>''))
                )
				
				)));
				
				$this->camposboto = '';
				$this->structo = json_decode(json_encode($this->structo, JSON_FORCE_OBJECT));
				
				$this->config->set_item('r_struct', $this->structo);
				$this->config->set_item('r_camposbot', $this->camposboto);
				$this->config->set_item('r_boto', $this->botoo);
				$this->config->set_item('r_combo', $this->comboo);
				$this->config->set_item('r_dato', $this->datoo);
				$this->config->set_item('r_tabla', $this->tablao);
				$this->config->set_item('r_campos', $this->camposo);
				$this->config->set_item('r_filtros', $this->filtroo);
				$this->config->set_item('r_camposdet', $this->camposdeto);
				$this->config->set_item('r_importa', $this->importao);
			}
			
			
			if (strtoupper($indice) == strtoupper('_factura')) {
				
				$this->structo = array(array('base'=>'factura','nombre'=>'factura','metodo'=>'0|1|0|0','join'=>'','bsnpro'=>'N',
				                             'structpro'=>''
											),
				                       array('base'=>'factura','nombre'=>'facdetalle','metodo'=>'0|1|0|0','join'=>array('sec'=>'sec'),'bsnpro'=>'N',
									         'structpro'=>array(array('base'=>'factura','nombre'=>'calcula_facdetalle','metodo'=>'0|0|1|1','param'=>'sec|secitem'),
											                   array('base'=>'factura','nombre'=>'calcula_facdetalle','metodo'=>'|||','param'=>''),
											                   array('base'=>'factura','nombre'=>'calcula_facdetalle','metodo'=>'|||','param'=>'')  
					                                          )
											),
									   array('base'=>'factura','nombre'=>'SRLOG','metodo'=>'0|||','join'=>array('sec'=>'sec'),'bsnpro'=>'N',
									         'structpro'=>''
											 )  
                );
				
				
				$this->botoo  = array  (array('title'=>'Facturar','proceso'=>"carga('".base_url()."empresa/Pfactura','filtro');",'contene'=>'ESTEMP','imagen'=>'../guia/application/views/empresa/images/pguias.png'),
				array('title'=>'Cerrar','proceso'=>"carga('".base_url()."empresa/Pcierre','filtro');",'contene'=>'ESTEMP','imagen'=>'../guia/application/views/empresa/images/pro.png')
				);
				$this->comboo = array(array('dato'=>'clista','campo'=>'ESTADO','cat'=>'BAI','nom'=>'julio'),
				array('dato'=>'Guia','campo'=>'EMPRESA','cat'=>'EMPRESA','nom'=>'julio'),
				array('dato'=>'Guia','campo'=>'SUCURSAL','cat'=>'SUCUR','nom'=>'julio'),
				array('dato'=>'Guia','campo'=>'CLIENTE','cat'=>'CLIENTE','nom'=>'julio'),
				array('dato'=>'Guia','campo'=>'ESTPRO','cat'=>'BSN','nom'=>'julio'),
				array('dato'=>'Guia','campo'=>'ESFE','cat'=>'BSN','nom'=>'julio'),
				array('dato'=>'Guia','campo'=>'TIPO','cat'=>'TPDOC','nom'=>'julio'),
				array('dato'=>'Guia','campo'=>'ITEM','cat'=>'ITEM','nom'=>'julio')
				
				);
				
				$this->datoo  = 'factura|1|1|1|factura.factura';            
				$this->tablao = 'pq_pro_procesos.pr_con_factura|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1|factura.factura';            
				$this->camposo = array('prm'=>'factura|sp_grb_factura|factura||factura.factura',
				'cmp'=>array(
				
                array('campo'=>'SEC','as'=>'SEC','id'=>'1','lst'=>'0|0|1','esp'=>'-E CAMPO 0-',
				array('tipo'=>'rls','attr'=> array('field' => 'SEC','label' => 'SEC','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'SEC:','for'=>'sec','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'SEC','id' => 'SEC'  ,'placeholder' => 'Escribe Codigo','maxlength' => '5',
				'size' => '5'           ,'style'       => 'width:10%'      ,'value'     => '','required'=>'required' ))
                ),
				array('campo'=>'EMPRESA','as'=>'EMPRESA','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'EMPRESA','label' => 'EMPRESA','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'EMPRESA:','for'=>'EMPRESA','attr'=>array())),
				array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'EMPRESA','opcion'=>array(''=>''),'attr'=>'id = "EMPRESA"'))
                ),
				array('campo'=>'SUCURSAL','as'=>'SUCURSAL','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'SUCURSAL','label' => 'SUCURSAL','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'SUCURSAL:','for'=>'SUCURSAL','attr'=>array())),
				array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'SUCURSAL','opcion'=>array(''=>''),'attr'=>'id = "SUCURSAL"'))
                ),
				array('campo'=>'CLIENTE','as'=>'CLIENTE','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'CLIENTE','label' => 'CLIENTE','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'CLIENTE:','for'=>'CLIENTE','attr'=>array())),
				array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'CLIENTE','opcion'=>array(''=>''),'attr'=>'id = "CLIENTE"'))
                ),
                array('campo'=>'REFER','as'=>'REFER','id'=>'0','lst'=>'1|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'REFER','label' => 'REFER','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'REFER:','for'=>'REFER','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'REFER'  ,'id' => 'REFER','placeholder' => 'Escribe Nombre','maxlength' => '100',
				'size' => '50'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
                ),
				
                array('campo'=>'FCHEMISION','as'=>'FECHA','id'=>'0','lst'=>'1|0|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'FCHEMISION','label' => 'FCHEMISION','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'FCHEMISION:','for'=>'FCHEMISION','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'FCHEMISION'  ,'id' => 'FCHEMISION','placeholder' => 'Escribe Nombre','maxlength' => '100',
				'size' => '50'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
                ),
				
                array('campo'=>'TIPO','as'=>'TIPO','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'TIPO','label' => 'TIPO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'TIPO:','for'=>'TIPO','attr'=>array())),
				array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'TIPO','opcion'=>array(''=>''),'attr'=>'id = "TIPO"'))
                ),
                array('campo'=>'NUMERO','as'=>'NUMERO','id'=>'0','lst'=>'1|0|1','esp'=>'-D CAMPO 0-',
				array('tipo'=>'rls','attr'=> array('field' => 'NUMERO','label' => 'NUMERO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'NUMERO:','for'=>'NUMERO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'NUMERO'  ,'id' => 'NUMERO','placeholder' => 'Escribe Nombre','maxlength' => '100',
				'size' => '50'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
                ),
                array('campo'=>'TOTAL','as'=>'TOTAL','id'=>'0','lst'=>'1|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'TOTAL','label' => 'TOTAL','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'TOTAL:','for'=>'TOTAL','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'TOTAL'  ,'id' => 'TOTAL','placeholder' => 'Escribe Nombre','maxlength' => '100',
				'size' => '50'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
                ),				
                array('campo'=>'SALDO','as'=>'SALDO','id'=>'0','lst'=>'1|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'SALDO','label' => 'SALDO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'SALDO:','for'=>'SALDO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'SALDO'  ,'id' => 'SALDO','placeholder' => 'Escribe Nombre','maxlength' => '100',
				'size' => '50'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
                ),
                array('campo'=>'ESTPRO','as'=>'PRO','id'=>'0','lst'=>'1|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'ESTPRO','label' => 'ESTPRO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'ESTPRO:','for'=>'ESTPRO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'ESTPRO'  ,'id' => 'ESTPRO','placeholder' => 'Escribe Nombre','maxlength' => '100',
				'size' => '50'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
                ),
				
                array('campo'=>'ESTADO','as'=>'EST','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'ESTADO','label' => 'ESTADO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'ESTADO:','for'=>'ESTADO','attr'=>array())),
				array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'ESTADO','opcion'=>array(''=>''),'attr'=>''))
                )
				
				),
				'btn'=>array(
				array('title'=>'Imprime','procesoa'=>"add_person('N','N');carga('".base_url()."empresa/Preportefac/",'procesob'=>"','contenidom');",'id'=>'lnk_imp','men'=>'i'), 		  
				array('title'=>'Actualiza','procesoa'=>"add_person('N','N');carga('".base_url()."empresa/actualizar/",'procesob'=>"','contenidom');",'id'=>'lnk_act','men'=>'a'),                    
				array('title'=>'Elimina','procesoa'=>"if (eliminar()== true) { carga('".base_url()."empresa/eliminar/",'procesob'=>"','filtro');}",'id'=>'lnk_eli','men'=>'e'),
				array('title'=>'Sri','procesoa'=>"carga('".base_url()."empresa/Psrifac/",'procesob'=>"','filtro');",'id'=>'lnk_sri','men'=>'s')
				//array('title'=>'Cerrar','proceso'=>"carga('".base_url()."empresa/Pcierre','filtro');",'contene'=>'ESTEMP','imagen'=>'../guia/application/views/empresa/images/pro.png')					
				));
				
                $this->filtroo = array('prm'=>'GUIA|sp_grb_GUIA|GUIA',
                'cmp'=>array(
				array('campo'=>'EMPRESA','as'=>'EMPRESA','id'=>'0','lst'=>'0|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'EMPRESA','label' => 'PROC CLIENTE','rules' => 'trim|required|max_length[30]')),
				array('tipo'=>'lbl','attr'=> array('text'=>'Empresa:','for'=>'EMPRESA','attr'=>array())),
				array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'EMPRESA','opcion'=>array(''=>''),'attr'=>''))
				),
				array('campo'=>'CLIENTE','as'=>'CLIENTE','id'=>'0','lst'=>'0|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'CLIENTE','label' => 'PROC CLIENTE','rules' => 'trim|required|max_length[30]')),
				array('tipo'=>'lbl','attr'=> array('text'=>'Cliente:','for'=>'CLIENTE','attr'=>array())),
				array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'CLIENTE','opcion'=>array(''=>''),'attr'=>''))
				),
				array('campo'=>'NUMERO','as'=>'Codigo','id'=>'1','lst'=>'0|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'NUMERO','label' => 'Codigo','rules' => 'trim|required|strip_tags|xss_clean|min_length[3]')),
				array('tipo'=>'lbl','attr'=> array('text'=>'Codigo:','for'=>'NUMERO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'NUMERO','id' => 'NUMERO'  ,'placeholder' => 'Escribe Codigo','maxlength' => '12',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','onblur'=>'rev();'  ))
				),
				array('campo'=>'FDESDE','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'D FECHA I|FD|N30|D--',
				array('tipo'=>'rlsa','attr'=> array('field' => 'FDESDE','label' => 'FDESDE','rules' => '')),
				array('tipo'=>'lbl','attr'=> array('text'=>'Desde:','for'=>'FDESDE','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'FDESDE','id' => 'FDESDE'  ,'placeholder' => 'Escribe Codigo','maxlength' => '12',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '', 'class' => 'fecha' ))
				),
				array('campo'=>'FHASTA','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'D FECHA F|FD|30|D--',
				array('tipo'=>'rlsa','attr'=> array('field' => 'FHASTA','label' => 'FHASTA','rules' => '')),
				array('tipo'=>'lbl','attr'=> array('text'=>'Hasta:','for'=>'USUMODIF','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'FHASTA','id' => 'FHASTA'  ,'placeholder' => 'Escribe Codigo','maxlength' => '12',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '' ))
				),
				
				array('campo'=>'ESTPRO','as'=>'ESTPRO','id'=>'0','lst'=>'0|0|0','esp'=>'D CAMPO N--',
				array('tipo'=>'rls','attr'=> array('field' => 'ESTPRO','label' => 'PROC LIQUID','rules' => 'trim|required|max_length[30]')),
				array('tipo'=>'lbl','attr'=> array('text'=>'Proceso:','for'=>'ESTPRO','attr'=>array())),
				array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'ESTPRO','opcion'=>array(''=>''),'attr'=>''))
				)
                ));
				
				$this->importao = '';		
				
				$this->camposdeto = array(array('prm'=>'facdetalle|pr_con_rol_roles|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1||factura.facdetalle',
				'cmp'=>array(
                array('campo'=>'SEC','as'=>'SEC','id'=>'1','lst'=>'1|0|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'SEC','label' => 'SEC','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'SEC:','for'=>'SEC','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'SEC','id' => 'SEC'  ,'placeholder' => 'Escribe Codigo','maxlength' => '3',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
                ),
                array('campo'=>'SECITEM','as'=>'SECITEM','id'=>'1','lst'=>'1|0|1','esp'=>'-E CAMPO 0-',
				array('tipo'=>'rls','attr'=> array('field' => 'SECITEM','label' => 'SECITEM','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'SECITEM:','for'=>'SECITEM','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'SECITEM','id' => 'SECITEM'  ,'placeholder' => 'Escribe Codigo','maxlength' => '3',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
                ),
                array('campo'=>'ITEM','as'=>'ITEM','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'ITEM','label' => 'ITEM','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'ITEM:','for'=>'ITEM','attr'=>array())),
				array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'ITEM','opcion'=>array(''=>''),'attr'=>'id = "ITEM"'))
                ),
                array('campo'=>'DESCRIPCION','as'=>'DESCRIPCION','id'=>'0','lst'=>'1|0|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'DESCRIPCION','label' => 'DESCRIPCION','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'DESCRIPCION:','for'=>'DESCRIPCION','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'DESCRIPCION'  ,'id' => 'DESCRIPCION','placeholder' => 'Escribe Nombre','maxlength' => '100',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
                ),
                array('campo'=>'CANTIDAD','as'=>'CANTIDAD','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'CANTIDAD','label' => 'CANTIDAD','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'CANTIDAD:','for'=>'CANTIDAD','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'CANTIDAD'  ,'id' => 'CANTIDAD','placeholder' => 'Escribe Nombre','maxlength' => '100',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
                ),
                array('campo'=>'PRECIO','as'=>'PRECIO','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'PRECIO','label' => 'PRECIO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'PRECIO:','for'=>'PRECIO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'PRECIO'  ,'id' => 'PRECIO','maxlength' => '100',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
                ),
                array('campo'=>'TOTAL','as'=>'TOTAL','id'=>'0','lst'=>'1|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'TOTAL','label' => 'TOTAL','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'TOTAL:','for'=>'VALOR','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'TOTAL'  ,'id' => 'TOTAL','placeholder' => 'Escribe Nombre','maxlength' => '100',
				'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
                )
				
				)),
				array('prm'=>'SRLOG|pr_con_rol_roles|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1||factura.srlog',
				'cmp'=>array(
				array('campo'=>'ID','as'=>'ID','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'ID','label' => 'ID','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'ID:','for'=>'ID','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'ID','id' => 'ID'  ,'placeholder' => 'Escribe ID','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'SEC','as'=>'SEC','id'=>'1','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'SEC','label' => 'SEC','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'SEC:','for'=>'SEC','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'SEC','id' => 'SEC'  ,'placeholder' => 'Escribe SEC','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'FECHA','as'=>'FECHA','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'FECHA','label' => 'FECHA','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'FECHA:','for'=>'FECHA','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'FECHA','id' => 'FECHA'  ,'placeholder' => 'Escribe FECHA','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'DOCUMENTO','as'=>'DOCUMENTO','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'DOCUMENTO','label' => 'DOCUMENTO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'DOCUMENTO:','for'=>'DOCUMENTO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'DOCUMENTO','id' => 'DOCUMENTO'  ,'placeholder' => 'Escribe DOCUMENTO','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'ESTADO','as'=>'ESTADO','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'ESTADO','label' => 'ESTADO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'ESTADO:','for'=>'ESTADO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'ESTADO','id' => 'ESTADO'  ,'placeholder' => 'Escribe ESTADO','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'PROCESO','as'=>'PROCESO','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'PROCESO','label' => 'PROCESO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'PROCESO:','for'=>'PROCESO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'PROCESO','id' => 'PROCESO'  ,'placeholder' => 'Escribe PROCESO','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'DETALLE','as'=>'DETALLE','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'DETALLE','label' => 'DETALLE','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'DETALLE:','for'=>'DETALLE','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'DETALLE','id' => 'DETALLE'  ,'placeholder' => 'Escribe DETALLE','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				)
				
				))		
				);
				
				
				$this->camposboto = array(array('title'=>'Documentos ','tabla'=>'factura.documentos','prm'=>'documentos|pr_con_rol_roles|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1|-E PROCESO DFAC-',
				'cmp'=>array(
				array('campo'=>'SECUENCIAL','as'=>'SEC','id'=>'1','lst'=>'0|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'SECUENCIAL','label' => 'SECUENCIAL','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'SECUENCIAL:','for'=>'SECUENCIAL','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'SECUENCIAL','id' => 'SECUENCIAL'  ,'placeholder' => 'Escribe SECUENCIAL','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'EMPRESA','as'=>'EMPRESA','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'EMPRESA','label' => 'EMPRESA','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'EMPRESA:','for'=>'EMPRESA','attr'=>array())),
				array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'EMPRESA','opcion'=>array(''=>''),'attr'=>'id = "EMPRESA"'))
                ),
				array('campo'=>'DESCRIPCION','as'=>'DESCRIPCION','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'DESCRIPCION','label' => 'DESCRIPCION','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'DESCRIPCION:','for'=>'DESCRIPCION','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'DESCRIPCION','id' => 'DESCRIPCION'  ,'placeholder' => 'Escribe DESCRIPCION','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'REFEREN','as'=>'REFEREN','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'REFEREN','label' => 'REFEREN','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'REFEREN:','for'=>'REFEREN','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'REFEREN','id' => 'REFEREN'  ,'placeholder' => 'Escribe REFEREN','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'ESFE','as'=>'FE','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'ESFE','label' => 'ESFE','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'ESFE:','for'=>'ESFE','attr'=>array())),
				array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'ESFE','opcion'=>array(''=>''),'attr'=>'id = "ESFE"'))
				),
				array('campo'=>'TIPO','as'=>'TIPO','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'TIPO','label' => 'TIPO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'TIPO:','for'=>'TIPO','attr'=>array())),
				array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'TIPO','opcion'=>array(''=>''),'attr'=>'id = "TIPO"'))
				),
				array('campo'=>'ESTAB','as'=>'ESTAB','id'=>'0','lst'=>'0|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'ESTAB','label' => 'ESTAB','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'ESTAB:','for'=>'ESTAB','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'ESTAB','id' => 'ESTAB'  ,'placeholder' => 'Escribe ESTAB','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'PTOEM','as'=>'PTOEM','id'=>'0','lst'=>'0|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'PTOEM','label' => 'PTOEM','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'PTOEM:','for'=>'PTOEM','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'PTOEM','id' => 'PTOEM'  ,'placeholder' => 'Escribe PTOEM','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'DESDE','as'=>'DESDE','id'=>'0','lst'=>'0|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'DESDE','label' => 'DESDE','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'DESDE:','for'=>'DESDE','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'DESDE','id' => 'DESDE'  ,'placeholder' => 'Escribe DESDE','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'HASTA','as'=>'HASTA','id'=>'0','lst'=>'0|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'HASTA','label' => 'HASTA','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'HASTA:','for'=>'HASTA','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'HASTA','id' => 'HASTA'  ,'placeholder' => 'Escribe HASTA','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'AUTORIZACION','as'=>'AUTORIZACION','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'AUTORIZACION','label' => 'AUTORIZACION','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'AUTORIZACION:','for'=>'AUTORIZACION','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'AUTORIZACION','id' => 'AUTORIZACION'  ,'placeholder' => 'Escribe AUTORIZACION','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'FCHAUT','as'=>'FCHAUT','id'=>'0','lst'=>'0|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'FCHAUT','label' => 'FCHAUT','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'FCHAUT:','for'=>'FCHAUT','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'FCHAUT','id' => 'FCHAUT'  ,'placeholder' => 'Escribe FCHAUT','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'FCHCADUCA','as'=>'EXPIRA','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'FCHCADUCA','label' => 'FCHCADUCA','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'FCHCADUCA:','for'=>'FCHCADUCA','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'FCHCADUCA','id' => 'FCHCADUCA'  ,'placeholder' => 'Escribe FCHCADUCA','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'ESTADO','as'=>'ESTADO','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'ESTADO','label' => 'ESTADO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'ESTADO:','for'=>'ESTADO','attr'=>array())),
				array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'ESTADO','opcion'=>array(''=>''),'attr'=>'id = "ESTADO"'))
				),
				array('campo'=>'USUCREA','as'=>'USUCREA','id'=>'0','lst'=>'0|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'USUCREA','label' => 'USUCREA','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'USUCREA:','for'=>'USUCREA','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'USUCREA','id' => 'USUCREA'  ,'placeholder' => 'Escribe USUCREA','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'FCHCREA','as'=>'FCHCREA','id'=>'0','lst'=>'0|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'FCHCREA','label' => 'FCHCREA','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'FCHCREA:','for'=>'FCHCREA','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'FCHCREA','id' => 'FCHCREA'  ,'placeholder' => 'Escribe FCHCREA','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'USUACT','as'=>'USUACT','id'=>'0','lst'=>'0|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'USUACT','label' => 'USUACT','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'USUACT:','for'=>'USUACT','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'USUACT','id' => 'USUACT'  ,'placeholder' => 'Escribe USUACT','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'FCHACT','as'=>'FCHACT','id'=>'0','lst'=>'0|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'FCHACT','label' => 'FCHACT','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'FCHACT:','for'=>'FCHACT','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'FCHACT','id' => 'FCHACT'  ,'placeholder' => 'Escribe FCHACT','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				) 				
				),
				'btn'=>array(		  
				array('title'=>'Actualiza','procesoa'=>"add_person('N','N');carga('".base_url()."empresa/actualizar/",'procesob'=>"','contenidom');",'id'=>'lnk_act','men'=>'a'),                    
				array('title'=>'Elimina','procesoa'=>"if (eliminar()== true) { carga('".base_url()."empresa/eliminar/",'procesob'=>"','filtro');}",'id'=>'lnk_eli','men'=>'e')				
				)),
				array('title'=>'Parametros FE ','tabla'=>'factura.parametros_fe','prm'=>'parametros_fe|pr_con_rol_roles|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1 ',
				'cmp'=>array(
				array('campo'=>'EMPRESA','as'=>'EMPRESA','id'=>'1','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'EMPRESA','label' => 'EMPRESA','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'EMPRESA:','for'=>'EMPRESA','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'EMPRESA','id' => 'EMPRESA'  ,'placeholder' => 'Escribe EMPRESA','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'CTP_AMBIENTE','as'=>'AMBIENTE','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'CTP_AMBIENTE','label' => 'CTP_AMBIENTE','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'AMBIENTE:','for'=>'CTP_AMBIENTE','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'CTP_AMBIENTE','id' => 'CTP_AMBIENTE'  ,'placeholder' => 'Escribe CTP_AMBIENTE','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
				),
				array('campo'=>'NQN_INTENTOS','as'=>'INTENTOS','id'=>'0','lst'=>'0|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'NQN_INTENTOS','label' => 'NQN_INTENTOS','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'INTENTOS:','for'=>'NQN_INTENTOS','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'NQN_INTENTOS','id' => 'NQN_INTENTOS'  ,'placeholder' => 'Escribe NQN_INTENTOS','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
				),
				array('campo'=>'BSN_CONFIRMACION','as'=>'BSN_CONFIRMACION','id'=>'0','lst'=>'0|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'BSN_CONFIRMACION','label' => 'BSN_CONFIRMACION','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'BSN_CONFIRMACION:','for'=>'BSN_CONFIRMACION','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'BSN_CONFIRMACION','id' => 'BSN_CONFIRMACION'  ,'placeholder' => 'Escribe BSN_CONFIRMACION','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'BSN_ADJUNTO_XML','as'=>'BSN_ADJUNTO_XML','id'=>'0','lst'=>'0|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'BSN_ADJUNTO_XML','label' => 'BSN_ADJUNTO_XML','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'BSN_ADJUNTO_XML:','for'=>'BSN_ADJUNTO_XML','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'BSN_ADJUNTO_XML','id' => 'BSN_ADJUNTO_XML'  ,'placeholder' => 'Escribe BSN_ADJUNTO_XML','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'BSN_GENERA_ARCH_AUT','as'=>'BSN_GENERA_ARCH_AUT','id'=>'0','lst'=>'0|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'BSN_GENERA_ARCH_AUT','label' => 'BSN_GENERA_ARCH_AUT','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'BSN_GENERA_ARCH_AUT:','for'=>'BSN_GENERA_ARCH_AUT','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'BSN_GENERA_ARCH_AUT','id' => 'BSN_GENERA_ARCH_AUT'  ,'placeholder' => 'Escribe BSN_GENERA_ARCH_AUT','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'BSN_CONTINGENCIA','as'=>'BSN_CONTINGENCIA','id'=>'0','lst'=>'0|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'BSN_CONTINGENCIA','label' => 'BSN_CONTINGENCIA','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'BSN_CONTINGENCIA:','for'=>'BSN_CONTINGENCIA','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'BSN_CONTINGENCIA','id' => 'BSN_CONTINGENCIA'  ,'placeholder' => 'Escribe BSN_CONTINGENCIA','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'DFM_DESDE_CONTINGENCIA','as'=>'DFM_DESDE_CONTINGENCIA','id'=>'0','lst'=>'0|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'DFM_DESDE_CONTINGENCIA','label' => 'DFM_DESDE_CONTINGENCIA','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'DFM_DESDE_CONTINGENCIA:','for'=>'DFM_DESDE_CONTINGENCIA','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'DFM_DESDE_CONTINGENCIA','id' => 'DFM_DESDE_CONTINGENCIA'  ,'placeholder' => 'Escribe DFM_DESDE_CONTINGENCIA','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'DFM_HASTA_CONTINGENCIA','as'=>'DFM_HASTA_CONTINGENCIA','id'=>'0','lst'=>'0|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'DFM_HASTA_CONTINGENCIA','label' => 'DFM_HASTA_CONTINGENCIA','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'DFM_HASTA_CONTINGENCIA:','for'=>'DFM_HASTA_CONTINGENCIA','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'DFM_HASTA_CONTINGENCIA','id' => 'DFM_HASTA_CONTINGENCIA'  ,'placeholder' => 'Escribe DFM_HASTA_CONTINGENCIA','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'ESTADO','as'=>'ESTADO','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'ESTADO','label' => 'ESTADO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'ESTADO:','for'=>'ESTADO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'ESTADO','id' => 'ESTADO'  ,'placeholder' => 'Escribe ESTADO','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
				),
				array('campo'=>'FIRMA_DIR','as'=>'FIRMA_DIR','id'=>'0','lst'=>'1|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'FIRMA_DIR','label' => 'FIRMA_DIR','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'FIRMA_DIR:','for'=>'FIRMA_DIR','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'FIRMA_DIR','id' => 'FIRMA_DIR'  ,'placeholder' => 'Escribe FIRMA_DIR','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
				),
				array('campo'=>'FIRMA_PSS','as'=>'FIRMA_PSS','id'=>'0','lst'=>'0|1|1','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'FIRMA_PSS','label' => 'FIRMA_PSS','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'FIRMA_PSS:','for'=>'FIRMA_PSS','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'FIRMA_PSS','id' => 'FIRMA_PSS'  ,'placeholder' => 'Escribe FIRMA_PSS','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
				),
				array('campo'=>'USUCREA','as'=>'USUCREA','id'=>'0','lst'=>'0|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'USUCREA','label' => 'USUCREA','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'USUCREA:','for'=>'USUCREA','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'USUCREA','id' => 'USUCREA'  ,'placeholder' => 'Escribe USUCREA','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'FCHCREA','as'=>'FCHCREA','id'=>'0','lst'=>'0|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'FCHCREA','label' => 'FCHCREA','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'FCHCREA:','for'=>'FCHCREA','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'FCHCREA','id' => 'FCHCREA'  ,'placeholder' => 'Escribe FCHCREA','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'USUACT','as'=>'USUACT','id'=>'0','lst'=>'0|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'USUACT','label' => 'USUACT','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'USUACT:','for'=>'USUACT','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'USUACT','id' => 'USUACT'  ,'placeholder' => 'Escribe USUACT','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				),
				array('campo'=>'FCHACT','as'=>'FCHACT','id'=>'0','lst'=>'0|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'FCHACT','label' => 'FCHACT','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'FCHACT:','for'=>'FCHACT','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'FCHACT','id' => 'FCHACT'  ,'placeholder' => 'Escribe FCHACT','maxlength' => '20',
				'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
				)
				),
				'btn'=>array(		  
				array('title'=>'Actualiza','procesoa'=>"add_person('N','N');carga('".base_url()."empresa/actualizar/",'procesob'=>"','contenidom');",'id'=>'lnk_act','men'=>'a'),                    
				array('title'=>'Elimina','procesoa'=>"if (eliminar()== true) { carga('".base_url()."empresa/eliminar/",'procesob'=>"','filtro');}",'id'=>'lnk_eli','men'=>'e')				
				))		
				);

				$this->structo = json_decode(json_encode($this->structo, JSON_FORCE_OBJECT));
				//$this->structpro = json_decode(json_encode($this->structpro, JSON_FORCE_OBJECT));
				
				//$this->config->set_item('r_structpr', $this->structpro);
				$this->config->set_item('r_struct', $this->structo);
				$this->config->set_item('r_boto', $this->botoo);
				$this->config->set_item('r_camposbot', $this->camposboto);
				$this->config->set_item('r_combo', $this->comboo);
				$this->config->set_item('r_dato', $this->datoo);
				$this->config->set_item('r_tabla', $this->tablao);
				$this->config->set_item('r_campos', $this->camposo);
				$this->config->set_item('r_filtros', $this->filtroo); 
				$this->config->set_item('r_camposdet', $this->camposdeto);
				$this->config->set_item('r_importa', $this->importao);		
			}
			
			
			if (strtoupper($indice) == strtoupper('_rol')) {
				
				$this->botoo  = array  (array('title'=>'Datos','proceso'=>"carga('".base_url()."empresa/Pcontrol','filtro');",'contene'=>'ESTEMP','imagen'=>'../guia/application/views/empresa/images/Ppull.png'),
				array('title'=>'Roless','proceso'=>"carga('".base_url()."empresa/Proles','filtro');",'contene'=>'ESTEMP','imagen'=>'../guia/application/views/empresa/images/pguias.png'),
				array('title'=>'Cerrar','proceso'=>"carga('".base_url()."empresa/Prcierre','filtro');",'contene'=>'ESTEMP','imagen'=>'../guia/application/views/empresa/images/pro.png')
				);
				$this->comboo = array(array('dato'=>'clista','campo'=>'estado','cat'=>'BAI','nom'=>'julio'));
				$this->datoo  = 'rol|0|1|1';
				//$this->tablao = 'factura';
				$this->tablao = 'pq_pro_roles.pr_con_tot_roles|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1 ';
				$this->camposo = array('prm'=>'rol_roles|sp_grb_factura|rol',
				'cmp'=>array(
				array('campo'=>'CODCLI','as'=>'COD','id'=>'1','lst'=>'1|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'CODCLI','label' => 'CODCLI','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'CODCLI:','for'=>'CODCLI','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'CODCLI','id' => 'CODCLI'  ,'placeholder' => 'Escribe Codigo','maxlength' => '5',
				'size' => '5'           ,'style'       => 'width:10%'      ,'value'     => '','required'=>'required' ))
				),
				array('campo'=>'NOMBRE','as'=>'NOMBRE','id'=>'0','lst'=>'1|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'NOMBRE','label' => 'NOMBRE','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'NOMBRE:','for'=>'NOMBRE','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'NOMBRE'  ,'id' => 'NOMBRE','placeholder' => 'Escribe Nombre','maxlength' => '100',
				'size' => '50'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
				),
				
				array('campo'=>'CARGO','as'=>'CARGO','id'=>'0','lst'=>'1|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'CARGO','label' => 'CARGO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'CARGO:','for'=>'CARGO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'CARGO'  ,'id' => 'CARGO','placeholder' => 'Escribe Nombre','maxlength' => '100',
				'size' => '50'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
				),
				
				array('campo'=>'DLAB','as'=>'DIA','id'=>'0','lst'=>'1|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'DLAB','label' => 'DLAB','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'DLAB:','for'=>'DLAB','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'DLAB'  ,'id' => 'tipo','placeholder' => 'Escribe Nombre','maxlength' => '100',
				'size' => '50'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
				),
				array('campo'=>'PESO','as'=>'PESO','id'=>'0','lst'=>'1|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'PESO','label' => 'PESO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'DLAB:','for'=>'DLAB','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'PESO'  ,'id' => 'PESO','placeholder' => 'Escribe Nombre','maxlength' => '100',
				'size' => '50'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
				),
				
				array('campo'=>'SALARIO','as'=>'SALARIO','id'=>'0','lst'=>'1|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'SALARIO','label' => 'SALARIO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'SALARIO:','for'=>'SALARIO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'SALARIO'  ,'id' => 'SALARIO','placeholder' => 'Escribe Nombre','maxlength' => '100',
				'size' => '50'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
				),
				
				array('campo'=>'INGRESO','as'=>'INGRESO','id'=>'0','lst'=>'1|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'INGRESO','label' => 'INGRESO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'INGRESO:','for'=>'INGRESO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'INGRESO'  ,'id' => 'INGRESO','placeholder' => 'Escribe Nombre','maxlength' => '100',
				'size' => '50'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
				),
				array('campo'=>'EGRESO','as'=>'EGRESO','id'=>'0','lst'=>'1|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'EGRESO','label' => 'EGRESO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'EGRESO:','for'=>'EGRESO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'EGRESO'  ,'id' => 'EGRESO','placeholder' => 'Escribe Nombre','maxlength' => '100',
				'size' => '50'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
				),
				array('campo'=>'RECIBIR','as'=>'COSTO','id'=>'0','lst'=>'1|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'RECIBIR','label' => 'RECIBIR','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'ESTPRO:','for'=>'RECIBIR','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'RECIBIR'  ,'id' => 'RECIBIR','placeholder' => 'Escribe Nombre','maxlength' => '100',
				'size' => '50'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
				),
				array('campo'=>'PERIODO','as'=>'PERIODO','id'=>'0','lst'=>'1|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'PERIODO','label' => 'PERIODO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'PERIODO:','for'=>'PERIODO','attr'=>array())),
				array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'PERIODO','opcion'=>array(''=>''),'attr'=>''))
				),
				array('campo'=>'PROCESO','as'=>'PROCESO','id'=>'1','lst'=>'1|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'PROCESO','label' => 'PROCESO','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'PROCESO:','for'=>'PROCESO','attr'=>array())),
				array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'PROCESO','opcion'=>array(''=>''),'attr'=>''))
				)
				
				),
				'btn'=>'');
				
				$this->camposdeto = array(array('prm'=>'rol_roles|pr_con_rol_roles|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1 ',
				'cmp'=>array(
				array('campo'=>'SEC','as'=>'SEC','id'=>'0','lst'=>'1|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'SEC','label' => 'SEC','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'SEC:','for'=>'SEC','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'SEC','id' => 'SEC'  ,'placeholder' => 'Escribe Codigo','maxlength' => '3',
				'size' => '3'           ,'style'       => 'width:3%'      ,'value'     => '','required'=>'required' ))
				),
				array('campo'=>'CODCLI','as'=>'CODCLI','id'=>'1','lst'=>'1|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'CODCLI','label' => 'CODCLI','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'CODCLI:','for'=>'CODCLI','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'CODCLI','id' => 'CODCLI'  ,'placeholder' => 'Escribe Codigo','maxlength' => '3',
				'size' => '3'           ,'style'       => 'width:3%'      ,'value'     => '','required'=>'required' ))
				),
				array('campo'=>'TPPAG','as'=>'TIPO','id'=>'0','lst'=>'1|0|0','esp'=>'',
				array('tipo'=>'rls','attr'=> array('field' => 'TPPAG','label' => 'TPPAG','rules' => 'trim|required')),
				array('tipo'=>'lbl','attr'=> array('text'=>'TPPAG:','for'=>'TIPO','attr'=>array())),
				array('tipo'=>'txt','attr'=> array('name' => 'TPPAG'  ,'id' => 'TPPAG','placeholder' => 'Escribe Nombre','maxlength' => '100',
			'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'FECHA','as'=>'FECHA','id'=>'0','lst'=>'1|0|0','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FECHA','label' => 'FECHA','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FECHA:','for'=>'FECHA','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FECHA'  ,'id' => 'FECHA','placeholder' => 'Escribe Nombre','maxlength' => '100',
			'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'FACTOR','as'=>'FACTOR','id'=>'0','lst'=>'1|0|0','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FACTOR','label' => 'FACTOR','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FACTOR:','for'=>'FACTOR','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FACTOR'  ,'id' => 'FACTOR','placeholder' => 'Escribe Nombre','maxlength' => '100',
			'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'VALOR','as'=>'VALOR','id'=>'0','lst'=>'1|0|0','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'VALOR','label' => 'VALOR','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'VALOR:','for'=>'VALOR','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'VALOR'  ,'id' => 'VALOR','placeholder' => 'Escribe Nombre','maxlength' => '100',
			'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'VALORR','as'=>'VALORR','id'=>'0','lst'=>'1|0|0','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'VALORR','label' => 'VALORR','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'VALORR:','for'=>'VALOR','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'VALORR'  ,'id' => 'VALORR','placeholder' => 'Escribe Nombre','maxlength' => '100',
			'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'ESTADO','as'=>'ESTADO','id'=>'0','lst'=>'1|0|0','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'ESTADO','label' => 'ESTADO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'ESTADO:','for'=>'VALOR','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'ESTADO'  ,'id' => 'ESTADO','placeholder' => 'Escribe Nombre','maxlength' => '100',
			'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'PERIODO','as'=>'PERIODO','id'=>'0','lst'=>'1|0|0','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'PERIODO','label' => 'PERIODO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'PERIODO:','for'=>'PERIODO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'PERIODO'  ,'id' => 'PERIODO','placeholder' => 'Escribe Nombre','maxlength' => '100',
			'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'PROCESO','as'=>'PROCESO','id'=>'1','lst'=>'1|0|0','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'PROCESO','label' => 'PROCESO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'PROCESO:','for'=>'PROCESO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'PROCESO'  ,'id' => 'PROCESO','placeholder' => 'Escribe Nombre','maxlength' => '100',
			'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'DIAS','as'=>'DIAS','id'=>'0','lst'=>'1|0|0','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'DIAS','label' => 'DIAS','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'DIAS:','for'=>'DIAS','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'DIAS'  ,'id' => 'DIAS','placeholder' => 'Escribe Nombre','maxlength' => '100',
			'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'OBSER','as'=>'OBSER','id'=>'0','lst'=>'1|0|0','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'OBSER','label' => 'OBSER','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'OBSER:','for'=>'OBSER','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'OBSER'  ,'id' => 'OBSER','placeholder' => 'Escribe Nombre','maxlength' => '100',
			'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			)
			
			)));
			
			
			
			$this->filtroo = '';
			$this->importao = '';
			
			$this->config->set_item('r_struct', $this->structo);
			$this->config->set_item('r_boto', $this->botoo);
			$this->config->set_item('r_combo', $this->comboo);
			$this->config->set_item('r_dato', $this->datoo);
			$this->config->set_item('r_tabla', $this->tablao);
			$this->config->set_item('r_campos', $this->camposo);
			$this->config->set_item('r_filtros', $this->filtroo); 
			$this->config->set_item('r_camposdet', $this->camposdeto);
			$this->config->set_item('r_importa', $this->importao);		
			}
			
			
			if (strtoupper($indice) == strtoupper('_cliente')) {
			
			$this->botoo  = "";
			$this->comboo = array(  array('dato'=>'Guia','campo'=>'TPCLI','cat'=>'TPCLI','nom'=>'julio'),
			array('dato'=>'Guia','campo'=>'TPNUC','cat'=>'TIPOID','nom'=>'julio'),
			array('dato'=>'Guia','campo'=>'ESTADO','cat'=>'BAI','nom'=>'julio'),
			array('dato'=>'Guia','campo'=>'TPPERS','cat'=>'TPPERS','nom'=>'julio'),
			array('dato'=>'Guia','campo'=>'APORTE','cat'=>'BSN','nom'=>'julio'),
			array('dato'=>'Guia','campo'=>'CARGO','cat'=>'CARGO','nom'=>'julio'),
			array('dato'=>'Guia','campo'=>'DEPART','cat'=>'DEPART','nom'=>'julio')
			);
			$this->datoo  = 'CLIENTE|0|1|1|cliente';
			$this->tablao = 'pq_pro_procesos.pr_con_CLIENTE|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1|admin.cliente';
			
			$this->camposo = array('prm'=>'CLIENTE|sp_grb_CLIENTE|CLIENTE||admin.cliente',
			'cmp'=>array(
			array('campo'=>'CODIGO','as'=>'COD','id'=>'1','lst'=>'1|0|1','esp'=>'-E SECUENCIA admin.cliente-',					
			array('tipo'=>'rls','attr'=> array('field' => 'CODIGO','label' => 'CODIGO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'CODIGO:','for'=>'CODIGO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'CODIGO','id' => 'CODIGO'  ,'placeholder' => 'Escribe Codigo','maxlength' => '3',
			'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'TPNUC','as'=>'TID','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'TPNUC','label' => 'TIPO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'TPNUC:','for'=>'TPNUC','attr'=>array())),
			array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'TPNUC','opcion'=>array(''=>''),'attr'=>''))
			),
			array('campo'=>'NUC','as'=>'ID','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'NUC','label' => 'ID','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'NUC:','for'=>'NUC','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'NUC','id' => 'NUC','placeholder' => 'Escribe Direccion','maxlength' => '100',
			'size' => '3'            ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'NOMBRE','as'=>'NOMBRE','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'NOMBRE','label' => 'NOMBRE','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'NOMBRE:','for'=>'NOMBRE','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'NOMBRE','id' => 'NOMBRE','placeholder' => 'Escribe Direccion','maxlength' => '100',
			'size' => '3'            ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'DIREC','as'=>'DIRECCION','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'DIREC','label' => 'DIREC','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'DIREC:','for'=>'DIREC','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'DIREC','id' => 'DIREC','placeholder' => 'Escribe Direccion','maxlength' => '100',
			'size' => '3'            ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'TELEF','as'=>'TELF','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'TELEF','label' => 'TELEF','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'TELEF:','for'=>'TELEF','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'TELEF','id' => 'TELEF','placeholder' => 'Escribe Direccion','maxlength' => '100',
			'size' => '3'            ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'CORREO','as'=>'CORREO','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'CORREO','label' => 'CORREO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'CORREO:','for'=>'CORREO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'CORREO','id' => 'CORREO','placeholder' => 'Escribe Direccion','maxlength' => '100',
			'size' => '3'            ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'CORREOF','as'=>'CORREOF','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'CORREOF','label' => 'CORREOF','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'CORREOF:','for'=>'CORREOF','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'CORREOF','id' => 'CORREOF','placeholder' => 'Escribe Direccion','maxlength' => '100',
			'size' => '3'            ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'CORREOL','as'=>'CORREOL','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'CORREOL','label' => 'CORREOL','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'CORREOL:','for'=>'CORREOL','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'CORREOL','id' => 'CORREOL','placeholder' => 'Escribe Direccion','maxlength' => '100',
			'size' => '3'            ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'TPPERS','as'=>'TPE','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'TPPERS','label' => 'TPPERS','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'TPPERS:','for'=>'TPPERS','attr'=>array())),
			array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'TPPERS','opcion'=>array(''=>''),'attr'=>''))
			),
			array('campo'=>'TPCLI','as'=>'TCL','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'TPCLI','label' => 'TPCLI','rules' => '')),
			array('tipo'=>'lbl','attr'=> array('text'=>'TPCLI:','for'=>'TPCLI','attr'=>array())),
			array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'TPCLI[]','opcion'=>array(''=>''),'attr'=>'multiple="multiple" class="mdb-select colorful-select dropdown-primary"'))
			),
			array('campo'=>'COMERCIAL','as'=>'COMERCIAL','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'COMERCIAL','label' => 'COMERCIAL','rules' => '')),
			array('tipo'=>'lbl','attr'=> array('text'=>'COMERCIAL:','for'=>'COMERCIAL','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'COMERCIAL','id' => 'COMERCIAL','placeholder' => 'Escribe Direccion','maxlength' => '100',
			'size' => '3'            ,'style'       => 'width:100%'      ,'value'     => '' ))
			),
			array('campo'=>'REFTRAN','as'=>'REF','id'=>'0','lst'=>'1|0|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'REFTRAN','label' => 'REFTRAN','rules' => '')),
			array('tipo'=>'lbl','attr'=> array('text'=>'REFTRAN:','for'=>'REFTRAN','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'REFTRAN','id' => 'REFTRAN','placeholder' => 'Escribe Direccion','maxlength' => '100',
			'size' => '3'            ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),					
			array('campo'=>'USUCREA','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'-E USUARIO USU-',
			array('tipo'=>'rlsa','attr'=> array('field' => 'USUCREA','label' => 'USUCREA','rules' => '')),
			array('tipo'=>'lbl','attr'=> array('text'=>'USUCREA:','for'=>'USUCREA','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'USUCREA','id' => 'USUCREA'  ,'placeholder' => 'Escribe Codigo',
			'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '' ))
			),
			array('campo'=>'FCHCREA','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'-E FECHA A|FD|0|D-',
			array('tipo'=>'rlsa','attr'=> array('field' => 'FCHCREA','label' => 'FCHCREA','rules' => '')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FCHCREA:','for'=>'FCHCREA','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FCHCREA','id' => 'FCHCREA'  ,'placeholder' => 'Escribe Codigo',
			'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => ''))
			),
			array('campo'=>'USUACT','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'-E USUARIO USU-E USUARIO USU',
			array('tipo'=>'rlsa','attr'=> array('field' => 'USUMODIF','label' => 'USUMODIF','rules' => '')),
			array('tipo'=>'lbl','attr'=> array('text'=>'USUMODIF:','for'=>'USUMODIF','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'USUMODIF','id' => 'USUMODIF'  ,'placeholder' => 'Escribe Codigo',
			'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '' ))
			),
			array('campo'=>'FCHACT','as'=>'usuario','id'=>'0','lst'=>'0|0|0','esp'=>'-E FECHA A|FD|0|D-E FECHA A|FD|0|D',
			array('tipo'=>'rlsa','attr'=> array('field' => 'FCHMODIF','label' => 'FCHMODIF','rules' => '')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FCHMODIF:','for'=>'FCHMODIF','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FCHMODIF','id' => 'FCHMODIF'  ,'placeholder' => 'Escribe Codigo',
			'size' => '3'           ,'style'       => 'width:100%'      ,'value'     => '' ))
			),                                        
			array('campo'=>'ESTADO','as'=>'EST','id'=>'0','lst'=>'1|1|1','esp'=>'-D CAMPO A-',
			array('tipo'=>'rls','attr'=> array('field' => 'ESTADO','label' => 'Estado','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'ESTADO:','for'=>'ESTADO','attr'=>array())),
			array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'ESTADO','opcion'=>array(''=>''),'attr'=>''))
			)
			
			),
			'btn'=>array(                  
			array('title'=>'Actualiza','procesoa'=>"add_person('N','N');carga('".base_url()."empresa/actualizar/",'procesob'=>"','contenidom');",'id'=>'lnk_act','men'=>'a'),                    
			array('title'=>'Elimina','procesoa'=>"if (eliminar()== true) { carga('".base_url()."empresa/eliminar/",'procesob'=>"','filtro');}",'id'=>'lnk_eli','men'=>'e')                       
			));
			
			$this->camposdeto = array(array('prm'=>'rol_cliente|pr_con_ROL_CLIENTE|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1|admin.rol_cliente',
			'cmp'=>array(				
			array('campo'=>'CODCLI','as'=>'COD','id'=>'1','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'CODCLI','label' => 'CODCLI','rules' => '')),
			array('tipo'=>'lbl','attr'=> array('text'=>'CODCLI:','for'=>'CODCLI','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'CODCLI','id' => 'CODCLI'  ,'placeholder' => 'Escribe CODCLI','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'SEC','as'=>'SEC','id'=>'1','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'SEC','label' => 'SEC','rules' => '')),
			array('tipo'=>'lbl','attr'=> array('text'=>'SEC:','for'=>'SEC','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'SEC','id' => 'SEC'  ,'placeholder' => 'Escribe SEC','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'EMPRESA','as'=>'EMP','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'EMPRESA','label' => 'EMPRESA','rules' => '')),
			array('tipo'=>'lbl','attr'=> array('text'=>'EMPRESA:','for'=>'EMPRESA','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'EMPRESA','id' => 'EMPRESA'  ,'placeholder' => 'Escribe EMPRESA','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'SUCURSAL','as'=>'SUC','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'SUCURSAL','label' => 'SUCURSAL','rules' => '')),
			array('tipo'=>'lbl','attr'=> array('text'=>'SUCURSAL:','for'=>'SUCURSAL','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'SUCURSAL','id' => 'SUCURSAL'  ,'placeholder' => 'Escribe SUCURSAL','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'DEPART','as'=>'DEPART','id'=>'0','lst'=>'1|1|1','esp'=>'-D CAMPO LOG-',
			array('tipo'=>'rls','attr'=> array('field' => 'DEPART','label' => 'DEPART','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'DEPART:','for'=>'DEPART','attr'=>array())),
			array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'DEPART','opcion'=>array(''=>''),'attr'=>''))						
			),
			array('campo'=>'CARGO','as'=>'CARGO','id'=>'0','lst'=>'1|1|1','esp'=>'-D CAMPO N-',
			array('tipo'=>'rls','attr'=> array('field' => 'CARGO','label' => 'CARGO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'CARGO:','for'=>'CARGO','attr'=>array())),
			array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'CARGO','opcion'=>array(''=>''),'attr'=>''))							  				
			),
			array('campo'=>'SALARIO','as'=>'SALARIO','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'SALARIO','label' => 'SALARIO','rules' => '')),
			array('tipo'=>'lbl','attr'=> array('text'=>'SALARIO:','for'=>'SALARIO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'SALARIO','id' => 'SALARIO'  ,'placeholder' => 'Escribe SALARIO','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'FCHING','as'=>'FCHING','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FCHING','label' => 'FCHING','rules' => '')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FCHING:','for'=>'FCHING','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FCHING','id' => 'FCHING'  ,'placeholder' => 'Escribe FCHING','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'FCHSAL','as'=>'FCHSAL','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FCHSAL','label' => 'FCHSAL','rules' => '')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FCHSAL:','for'=>'FCHSAL','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FCHSAL','id' => 'FCHSAL'  ,'placeholder' => 'Escribe FCHSAL','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'CTABANCO','as'=>'CTA BCO','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'CTABANCO','label' => 'CTABANCO','rules' => '')),
			array('tipo'=>'lbl','attr'=> array('text'=>'CTABANCO:','for'=>'CTABANCO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'CTABANCO','id' => 'CTABANCO'  ,'placeholder' => 'Escribe CTABANCO','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'ESTADO','as'=>'EST','id'=>'0','lst'=>'1|1|1','esp'=>'-D CAMPO A-',
			array('tipo'=>'rls','attr'=> array('field' => 'ESTADO','label' => 'Estado','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'ESTADO:','for'=>'ESTADO','attr'=>array())),
			array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'ESTADO','opcion'=>array(''=>''),'attr'=>''))							  
			),
			array('campo'=>'USUCREA','as'=>'USUCREA','id'=>'0','lst'=>'0|0|0','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'USUCREA','label' => 'USUCREA','rules' => '')),
			array('tipo'=>'lbl','attr'=> array('text'=>'USUCREA:','for'=>'USUCREA','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'USUCREA','id' => 'USUCREA'  ,'placeholder' => 'Escribe USUCREA','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'FCHCREA','as'=>'FCHCREA','id'=>'0','lst'=>'0|0|0','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FCHCREA','label' => 'FCHCREA','rules' => '')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FCHCREA:','for'=>'FCHCREA','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FCHCREA','id' => 'FCHCREA'  ,'placeholder' => 'Escribe FCHCREA','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'USUACT','as'=>'USUACT','id'=>'0','lst'=>'0|0|0','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'USUACT','label' => 'USUACT','rules' => '')),
			array('tipo'=>'lbl','attr'=> array('text'=>'USUACT:','for'=>'USUACT','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'USUACT','id' => 'USUACT'  ,'placeholder' => 'Escribe USUACT','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'FCHACT','as'=>'FCHACT','id'=>'0','lst'=>'0|0|0','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FCHACT','label' => 'FCHACT','rules' => '')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FCHACT:','for'=>'FCHACT','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FCHACT','id' => 'FCHACT'  ,'placeholder' => 'Escribe FCHACT','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:30%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'REFER','as'=>'REFER','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'REFER','label' => 'REFER','rules' => '')),
			array('tipo'=>'lbl','attr'=> array('text'=>'REFER:','for'=>'REFER','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'REFER','id' => 'REFER'  ,'placeholder' => 'Escribe REFER','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required' ))
			),
			array('campo'=>'APORTE','as'=>'AP','id'=>'0','lst'=>'1|1|1','esp'=>'-D CAMPO N-',
			array('tipo'=>'rls','attr'=> array('field' => 'APORTE','label' => 'APORTE','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'APORTE:','for'=>'APORTE','attr'=>array())),
			array('tipo'=>'cbo','attr'=> array('select'=>'','for'=>'APORTE','opcion'=>array(''=>''),'attr'=>''))							  				
			)
			)));
			
			
			$this->filtroo = '';            
			//$this->camposdeto = '';  
			$this->importao = '';
			
			$this->config->set_item('r_struct', $this->structo);
			$this->config->set_item('r_boto', $this->botoo);
			$this->config->set_item('r_combo', $this->comboo);
			$this->config->set_item('r_dato', $this->datoo);
			$this->config->set_item('r_tabla', $this->tablao);
			$this->config->set_item('r_campos', $this->camposo);
			$this->config->set_item('r_filtros', $this->filtroo);
			$this->config->set_item('r_camposdet', $this->camposdeto);
			$this->config->set_item('r_importa', $this->importao);
			}
			// contabilidad
			
			if (strtoupper($indice) == strtoupper('_cncmpr')) {
			
			$this->botoo  = array(array('title'=>'Cerrar','proceso'=>"carga('".base_url()."empresa/cncierre','filtro');",'contene'=>'ESTEMP','imagen'=>'../guia/application/views/empresa/images/pro.png'),
			array('title'=>'reporte general','proceso'=>"add_person('N','S');carga('".base_url()."empresa/Preportebl','contenidom');",'contene'=>'ESTEMP','imagen'=>'../guia/application/views/empresa/images/reportes.png'),
			array('title'=>'reporte resultado','proceso'=>"add_person('N','S');carga('".base_url()."empresa/Preporters','contenidom');",'contene'=>'ESTEMP','imagen'=>'../guia/application/views/empresa/images/reportes.png')); 
			$this->comboo = array(array('dato'=>'clista','campo'=>'estado','cat'=>'BAI','nom'=>'julio'));
			
			$this->datoo  = 'cncmpr|0|1|1';
			$this->tablao = 'pq_pro_cncmpr.pr_con_cncmpr|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1 ';
			$this->camposo = array('prm'=>'cncmpr|sp_grb_cncmpr|cncmpr',
			'cmp'=>array(
			
			array('campo'=>'EMPRESA','as'=>'EMPRESA','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'EMPRESA','label' => 'EMPRESA','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'EMPRESA:','for'=>'EMPRESA','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'EMPRESA','id' => 'EMPRESA'  ,'placeholder' => 'Escribe EMPRESA','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'NUM','as'=>'NUM','id'=>'1','lst'=>'1|0|1','esp'=>'-E SECUENCIA CNCMPR-',
			array('tipo'=>'rls','attr'=> array('field' => 'NUM','label' => 'NUM','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'NUM:','for'=>'NUM','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'NUM','id' => 'NUM'  ,'placeholder' => 'Escribe NUM','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'DESCRIP','as'=>'DESCRIP','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'DESCRIP','label' => 'DESCRIP','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'DESCRIP:','for'=>'DESCRIP','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'DESCRIP','id' => 'DESCRIP'  ,'placeholder' => 'Escribe DESCRIP','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'FECHA','as'=>'FECHA','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FECHA','label' => 'FECHA','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FECHA:','for'=>'FECHA','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FECHA','id' => 'FECHA'  ,'placeholder' => 'Escribe FECHA','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'MODULO','as'=>'MODULO','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'MODULO','label' => 'MODULO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'MODULO:','for'=>'MODULO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'MODULO','id' => 'MODULO'  ,'placeholder' => 'Escribe MODULO','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'REFEREN','as'=>'REFEREN','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'REFEREN','label' => 'REFEREN','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'REFEREN:','for'=>'REFEREN','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'REFEREN','id' => 'REFEREN'  ,'placeholder' => 'Escribe REFEREN','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'TIPO','as'=>'TIPO','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'TIPO','label' => 'TIPO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'TIPO:','for'=>'TIPO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'TIPO','id' => 'TIPO'  ,'placeholder' => 'Escribe TIPO','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'ESTADO','as'=>'ESTADO','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'ESTADO','label' => 'ESTADO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'ESTADO:','for'=>'ESTADO','attr'=>array())),
			array('tipo'=>'cbo','attr'=> array('name' => 'ESTADO','id' => 'ESTADO'  ,'placeholder' => 'Escribe ESTADO','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'ERR','as'=>'ERR','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'ERR','label' => 'ERR','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'ERR:','for'=>'ERR','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'ERR','id' => 'ERR'  ,'placeholder' => 'Escribe ERR','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'MSJ','as'=>'MSJ','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'MSJ','label' => 'MSJ','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'MSJ:','for'=>'MSJ','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'MSJ','id' => 'MSJ'  ,'placeholder' => 'Escribe MSJ','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'USUCRE','as'=>'USUCRE','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'USUCRE','label' => 'USUCRE','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'USUCRE:','for'=>'USUCRE','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'USUCRE','id' => 'USUCRE'  ,'placeholder' => 'Escribe USUCRE','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'FCHCRE','as'=>'FCHCRE','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FCHCRE','label' => 'FCHCRE','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FCHCRE:','for'=>'FCHCRE','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FCHCRE','id' => 'FCHCRE'  ,'placeholder' => 'Escribe FCHCRE','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'USUMOD','as'=>'USUMOD','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'USUMOD','label' => 'USUMOD','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'USUMOD:','for'=>'USUMOD','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'USUMOD','id' => 'USUMOD'  ,'placeholder' => 'Escribe USUMOD','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'FCHMOD','as'=>'FCHMOD','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FCHMOD','label' => 'FCHMOD','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FCHMOD:','for'=>'FCHMOD','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FCHMOD','id' => 'FCHMOD'  ,'placeholder' => 'Escribe FCHMOD','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'ID','as'=>'ID','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'ID','label' => 'ID','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'ID:','for'=>'ID','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'ID','id' => 'ID'  ,'placeholder' => 'Escribe ID','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			)
			
			),
			'btn'=>array(                  
			array('title'=>'Actualiza','procesoa'=>"add_person('N','N');carga('".base_url()."empresa/actualizar/",'procesob'=>"','contenidom');",'id'=>'lnk_act','men'=>'a'),                    
			array('title'=>'Elimina','procesoa'=>"if (eliminar()== true) { carga('".base_url()."empresa/eliminar/",'procesob'=>"','filtro');}",'id'=>'lnk_eli','men'=>'e')                       
			));
			$this->filtroo = '';
			$this->importao = '';
			
			$this->camposdeto = array(array('prm'=>'cndetalle|pr_con_cndetalle|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1 ',
			'cmp'=>array(
			array('campo'=>'EMPRESA','as'=>'EMPRESA','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'EMPRESA','label' => 'EMPRESA','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'EMPRESA:','for'=>'EMPRESA','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'EMPRESA','id' => 'EMPRESA'  ,'placeholder' => 'Escribe EMPRESA','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'NUM','as'=>'NUM','id'=>'1','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'NUM','label' => 'NUM','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'NUM:','for'=>'NUM','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'NUM','id' => 'NUM'  ,'placeholder' => 'Escribe NUM','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'SEC','as'=>'SEC','id'=>'1','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'SEC','label' => 'SEC','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'SEC:','for'=>'SEC','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'SEC','id' => 'SEC'  ,'placeholder' => 'Escribe SEC','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'CUENTA','as'=>'CUENTA','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'CUENTA','label' => 'CUENTA','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'CUENTA:','for'=>'CUENTA','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'CUENTA','id' => 'CUENTA'  ,'placeholder' => 'Escribe CUENTA','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'CENTRO','as'=>'CENTRO','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'CENTRO','label' => 'CENTRO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'CENTRO:','for'=>'CENTRO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'CENTRO','id' => 'CENTRO'  ,'placeholder' => 'Escribe CENTRO','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'TCOSTO','as'=>'TCOSTO','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'TCOSTO','label' => 'TCOSTO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'TCOSTO:','for'=>'TCOSTO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'TCOSTO','id' => 'TCOSTO'  ,'placeholder' => 'Escribe TCOSTO','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'DREFER','as'=>'DREFER','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'DREFER','label' => 'DREFER','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'DREFER:','for'=>'DREFER','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'DREFER','id' => 'DREFER'  ,'placeholder' => 'Escribe DREFER','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'DEBE','as'=>'DEBE','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'DEBE','label' => 'DEBE','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'DEBE:','for'=>'DEBE','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'DEBE','id' => 'DEBE'  ,'placeholder' => 'Escribe DEBE','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'HABER','as'=>'HABER','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'HABER','label' => 'HABER','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'HABER:','for'=>'HABER','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'HABER','id' => 'HABER'  ,'placeholder' => 'Escribe HABER','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'DDESCRIP','as'=>'DDESCRIP','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'DDESCRIP','label' => 'DDESCRIP','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'DDESCRIP:','for'=>'DDESCRIP','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'DDESCRIP','id' => 'DDESCRIP'  ,'placeholder' => 'Escribe DDESCRIP','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'DFECHA','as'=>'DFECHA','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'DFECHA','label' => 'DFECHA','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'DFECHA:','for'=>'DFECHA','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'DFECHA','id' => 'DFECHA'  ,'placeholder' => 'Escribe DFECHA','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'ESTADO','as'=>'ESTADO','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'ESTADO','label' => 'ESTADO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'ESTADO:','for'=>'ESTADO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'ESTADO','id' => 'ESTADO'  ,'placeholder' => 'Escribe ESTADO','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'USUCRE','as'=>'USUCRE','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'USUCRE','label' => 'USUCRE','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'USUCRE:','for'=>'USUCRE','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'USUCRE','id' => 'USUCRE'  ,'placeholder' => 'Escribe USUCRE','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'FCHCRE','as'=>'FCHCRE','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FCHCRE','label' => 'FCHCRE','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FCHCRE:','for'=>'FCHCRE','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FCHCRE','id' => 'FCHCRE'  ,'placeholder' => 'Escribe FCHCRE','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'USUMOD','as'=>'USUMOD','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'USUMOD','label' => 'USUMOD','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'USUMOD:','for'=>'USUMOD','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'USUMOD','id' => 'USUMOD'  ,'placeholder' => 'Escribe USUMOD','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'FCHMOD','as'=>'FCHMOD','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FCHMOD','label' => 'FCHMOD','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FCHMOD:','for'=>'FCHMOD','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FCHMOD','id' => 'FCHMOD'  ,'placeholder' => 'Escribe FCHMOD','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			)
			
			)));
			
			$this->config->set_item('r_struct', $this->structo);
			$this->config->set_item('r_boto', $this->botoo);
			$this->config->set_item('r_combo', $this->comboo);
			$this->config->set_item('r_dato', $this->datoo);
			$this->config->set_item('r_tabla', $this->tablao);
			$this->config->set_item('r_campos', $this->camposo);
			$this->config->set_item('r_filtros', $this->filtroo);
			$this->config->set_item('r_camposdet', $this->camposdeto);
			$this->config->set_item('r_importa', $this->importao);
			
			
			}
			
			if (strtoupper($indice) == strtoupper('_bncmpr')) {
			
			$this->botoo  = ''; 
			$this->comboo = array(array('dato'=>'bncmpr','campo'=>'estado','cat'=>'BAI','nom'=>'julio'));
			
			$this->datoo  = 'bncmpr|0|1|1';
			$this->tablao = 'pq_pro_cncmpr.pr_con_bncmpr|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1 ';
			$this->camposo = array('prm'=>'bncmpr|sp_grb_bncmpr|bncmpr',
			'cmp'=>array(
			
			array('campo'=>'EMPRESA','as'=>'EMPRESA','id'=>'1','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'EMPRESA','label' => 'EMPRESA','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'EMPRESA:','for'=>'EMPRESA','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'EMPRESA','id' => 'EMPRESA'  ,'placeholder' => 'Escribe EMPRESA','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'NUM','as'=>'NUM','id'=>'0','lst'=>'1|0|1','esp'=>'-E SECUENCIA CLISTA-',
			array('tipo'=>'rls','attr'=> array('field' => 'NUM','label' => 'NUM','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'NUM:','for'=>'NUM','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'NUM','id' => 'NUM'  ,'placeholder' => 'Escribe NUM','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'CTABAN','as'=>'CTABAN','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'CTABAN','label' => 'CTABAN','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'CTABAN:','for'=>'CTABAN','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'CTABAN','id' => 'CTABAN'  ,'placeholder' => 'Escribe CTABAN','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'TIPMOV','as'=>'TIPMOV','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'TIPMOV','label' => 'TIPMOV','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'TIPMOV:','for'=>'TIPMOV','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'TIPMOV','id' => 'TIPMOV'  ,'placeholder' => 'Escribe TIPMOV','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'NUMMOV','as'=>'NUMMOV','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'NUMMOV','label' => 'NUMMOV','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'NUMMOV:','for'=>'NUMMOV','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'NUMMOV','id' => 'NUMMOV'  ,'placeholder' => 'Escribe NUMMOV','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'FCHMOV','as'=>'FCHMOV','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FCHMOV','label' => 'FCHMOV','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FCHMOV:','for'=>'FCHMOV','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FCHMOV','id' => 'FCHMOV'  ,'placeholder' => 'Escribe FCHMOV','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'DESMOV','as'=>'DESMOV','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'DESMOV','label' => 'DESMOV','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'DESMOV:','for'=>'DESMOV','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'DESMOV','id' => 'DESMOV'  ,'placeholder' => 'Escribe DESMOV','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'REFMOV','as'=>'REFMOV','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'REFMOV','label' => 'REFMOV','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'REFMOV:','for'=>'REFMOV','attr'=>array())),
			array('tipo'=>'cbo','attr'=> array('name' => 'REFMOV','id' => 'REFMOV'  ,'placeholder' => 'Escribe REFMOV','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'VALMOV','as'=>'VALMOV','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'VALMOV','label' => 'VALMOV','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'VALMOV:','for'=>'VALMOV','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'VALMOV','id' => 'VALMOV'  ,'placeholder' => 'Escribe VALMOV','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'ESTMOV','as'=>'ESTMOV','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'ESTMOV','label' => 'ESTMOV','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'ESTMOV:','for'=>'ESTMOV','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'ESTMOV','id' => 'ESTMOV'  ,'placeholder' => 'Escribe ESTMOV','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'VALTOT','as'=>'VALTOT','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'VALTOT','label' => 'VALTOT','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'VALTOT:','for'=>'VALTOT','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'VALTOT','id' => 'VALTOT'  ,'placeholder' => 'Escribe VALTOT','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'MOVSEL','as'=>'MOVSEL','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'MOVSEL','label' => 'MOVSEL','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'MOVSEL:','for'=>'MOVSEL','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'MOVSEL','id' => 'MOVSEL'  ,'placeholder' => 'Escribe MOVSEL','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'FCHSEL','as'=>'FCHSEL','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FCHSEL','label' => 'FCHSEL','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FCHSEL:','for'=>'FCHSEL','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FCHSEL','id' => 'FCHSEL'  ,'placeholder' => 'Escribe FCHSEL','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'NUMSEL','as'=>'NUMSEL','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'NUMSEL','label' => 'NUMSEL','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'NUMSEL:','for'=>'NUMSEL','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'NUMSEL','id' => 'NUMSEL'  ,'placeholder' => 'Escribe NUMSEL','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'CLIENTE','as'=>'CLIENTE','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'CLIENTE','label' => 'CLIENTE','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'CLIENTE:','for'=>'CLIENTE','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'CLIENTE','id' => 'CLIENTE'  ,'placeholder' => 'Escribe CLIENTE','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'REFER','as'=>'REFER','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'REFER','label' => 'REFER','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'REFER:','for'=>'REFER','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'REFER','id' => 'REFER'  ,'placeholder' => 'Escribe REFER','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'ESTADO','as'=>'ESTADO','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'ESTADO','label' => 'ESTADO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'ESTADO:','for'=>'ESTADO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'ESTADO','id' => 'ESTADO'  ,'placeholder' => 'Escribe ESTADO','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'USUCRE','as'=>'USUCRE','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'USUCRE','label' => 'USUCRE','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'USUCRE:','for'=>'USUCRE','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'USUCRE','id' => 'USUCRE'  ,'placeholder' => 'Escribe USUCRE','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'FCHCRE','as'=>'FCHCRE','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FCHCRE','label' => 'FCHCRE','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FCHCRE:','for'=>'FCHCRE','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FCHCRE','id' => 'FCHCRE'  ,'placeholder' => 'Escribe FCHCRE','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'USUMOD','as'=>'USUMOD','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'USUMOD','label' => 'USUMOD','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'USUMOD:','for'=>'USUMOD','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'USUMOD','id' => 'USUMOD'  ,'placeholder' => 'Escribe USUMOD','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'FCHMOD','as'=>'FCHMOD','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FCHMOD','label' => 'FCHMOD','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FCHMOD:','for'=>'FCHMOD','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FCHMOD','id' => 'FCHMOD'  ,'placeholder' => 'Escribe FCHMOD','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'ESTPRO','as'=>'ESTPRO','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'ESTPRO','label' => 'ESTPRO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'ESTPRO:','for'=>'ESTPRO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'ESTPRO','id' => 'ESTPRO'  ,'placeholder' => 'Escribe ESTPRO','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'CNCMPR','as'=>'CNCMPR','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'CNCMPR','label' => 'CNCMPR','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'CNCMPR:','for'=>'CNCMPR','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'CNCMPR','id' => 'CNCMPR'  ,'placeholder' => 'Escribe CNCMPR','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'ELECTRONICO','as'=>'ELECTRONICO','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'ELECTRONICO','label' => 'ELECTRONICO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'ELECTRONICO:','for'=>'ELECTRONICO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'ELECTRONICO','id' => 'ELECTRONICO'  ,'placeholder' => 'Escribe ELECTRONICO','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			)
			
			),
			'btn'=>array(                  
			array('title'=>'Actualiza','procesoa'=>"add_person('N','N');carga('".base_url()."empresa/actualizar/",'procesob'=>"','contenidom');",'id'=>'lnk_act','men'=>'a'),                    
			array('title'=>'Elimina','procesoa'=>"if (eliminar()== true) { carga('".base_url()."empresa/eliminar/",'procesob'=>"','filtro');}",'id'=>'lnk_eli','men'=>'e')                       
			));
			$this->filtroo = '';
			$this->importao = '';
			$this->camposdeto = '';
			
			$this->config->set_item('r_struct', $this->structo);
			$this->config->set_item('r_boto', $this->botoo);
			$this->config->set_item('r_combo', $this->comboo);
			$this->config->set_item('r_dato', $this->datoo);
			$this->config->set_item('r_tabla', $this->tablao);
			$this->config->set_item('r_campos', $this->camposo);
			$this->config->set_item('r_filtros', $this->filtroo);
			$this->config->set_item('r_camposdet', $this->camposdeto);
			$this->config->set_item('r_importa', $this->importao);
			}
			
			if (strtoupper($indice) == strtoupper('_prcmpr')) {
			
			$this->botoo  = ''; 
			$this->comboo = array(array('dato'=>'prcmpr','campo'=>'estado','cat'=>'BAI','nom'=>'julio'));
			
			$this->datoo  = 'prcmpr|0|1|1';
			$this->tablao = 'pq_pro_cncmpr.pr_con_prcmpr|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1 ';
			$this->camposo = array('prm'=>'prcmpr|sp_grb_prcmpr|prcmpr',
			'cmp'=>array(
			array('campo'=>'EMPRESA','as'=>'EMPRESA','id'=>'1','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'EMPRESA','label' => 'EMPRESA','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'EMPRESA:','for'=>'EMPRESA','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'EMPRESA','id' => 'EMPRESA'  ,'placeholder' => 'Escribe EMPRESA','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'SUCURSAL','as'=>'SUCURSAL','id'=>'0','lst'=>'1|0|1','esp'=>'-E SECUENCIA CLISTA-',
			array('tipo'=>'rls','attr'=> array('field' => 'SUCURSAL','label' => 'SUCURSAL','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'SUCURSAL:','for'=>'SUCURSAL','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'SUCURSAL','id' => 'SUCURSAL'  ,'placeholder' => 'Escribe SUCURSAL','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'CODIGO','as'=>'CODIGO','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'CODIGO','label' => 'CODIGO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'CODIGO:','for'=>'CODIGO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'CODIGO','id' => 'CODIGO'  ,'placeholder' => 'Escribe CODIGO','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'FECEMI','as'=>'FECEMI','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FECEMI','label' => 'FECEMI','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FECEMI:','for'=>'FECEMI','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FECEMI','id' => 'FECEMI'  ,'placeholder' => 'Escribe FECEMI','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'FECVEN','as'=>'FECVEN','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FECVEN','label' => 'FECVEN','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FECVEN:','for'=>'FECVEN','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FECVEN','id' => 'FECVEN'  ,'placeholder' => 'Escribe FECVEN','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'FECCON','as'=>'FECCON','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FECCON','label' => 'FECCON','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FECCON:','for'=>'FECCON','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FECCON','id' => 'FECCON'  ,'placeholder' => 'Escribe FECCON','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'TIPCTE','as'=>'TIPCTE','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'TIPCTE','label' => 'TIPCTE','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'TIPCTE:','for'=>'TIPCTE','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'TIPCTE','id' => 'TIPCTE'  ,'placeholder' => 'Escribe TIPCTE','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'PROV','as'=>'PROV','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'PROV','label' => 'PROV','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'PROV:','for'=>'PROV','attr'=>array())),
			array('tipo'=>'cbo','attr'=> array('name' => 'PROV','id' => 'PROV'  ,'placeholder' => 'Escribe PROV','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'PRO_NFAC','as'=>'PRO_NFAC','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'PRO_NFAC','label' => 'PRO_NFAC','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'PRO_NFAC:','for'=>'PRO_NFAC','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'PRO_NFAC','id' => 'PRO_NFAC'  ,'placeholder' => 'Escribe PRO_NFAC','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'TIPORETE','as'=>'TIPORETE','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'TIPORETE','label' => 'TIPORETE','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'TIPORETE:','for'=>'TIPORETE','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'TIPORETE','id' => 'TIPORETE'  ,'placeholder' => 'Escribe TIPORETE','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'NRETE','as'=>'NRETE','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'NRETE','label' => 'NRETE','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'NRETE:','for'=>'NRETE','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'NRETE','id' => 'NRETE'  ,'placeholder' => 'Escribe NRETE','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'NRETEFTE','as'=>'NRETEFTE','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'NRETEFTE','label' => 'NRETEFTE','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'NRETEFTE:','for'=>'NRETEFTE','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'NRETEFTE','id' => 'NRETEFTE'  ,'placeholder' => 'Escribe NRETEFTE','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'DESCRIPCION','as'=>'DESCRIPCION','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'DESCRIPCION','label' => 'DESCRIPCION','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'DESCRIPCION:','for'=>'DESCRIPCION','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'DESCRIPCION','id' => 'DESCRIPCION'  ,'placeholder' => 'Escribe DESCRIPCION','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'MONEDA','as'=>'MONEDA','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'MONEDA','label' => 'MONEDA','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'MONEDA:','for'=>'MONEDA','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'MONEDA','id' => 'MONEDA'  ,'placeholder' => 'Escribe MONEDA','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'CMPR','as'=>'CMPR','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'CMPR','label' => 'CMPR','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'CMPR:','for'=>'CMPR','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'CMPR','id' => 'CMPR'  ,'placeholder' => 'Escribe CMPR','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'TIPO','as'=>'TIPO','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'TIPO','label' => 'TIPO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'TIPO:','for'=>'TIPO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'TIPO','id' => 'TIPO'  ,'placeholder' => 'Escribe TIPO','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'CUENTA','as'=>'CUENTA','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'CUENTA','label' => 'CUENTA','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'CUENTA:','for'=>'CUENTA','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'CUENTA','id' => 'CUENTA'  ,'placeholder' => 'Escribe CUENTA','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'TIPODOC','as'=>'TIPODOC','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'TIPODOC','label' => 'TIPODOC','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'TIPODOC:','for'=>'TIPODOC','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'TIPODOC','id' => 'TIPODOC'  ,'placeholder' => 'Escribe TIPODOC','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'FECVALIDEZ','as'=>'FECVALIDEZ','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FECVALIDEZ','label' => 'FECVALIDEZ','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FECVALIDEZ:','for'=>'FECVALIDEZ','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FECVALIDEZ','id' => 'FECVALIDEZ'  ,'placeholder' => 'Escribe FECVALIDEZ','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'NUMSERIE','as'=>'NUMSERIE','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'NUMSERIE','label' => 'NUMSERIE','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'NUMSERIE:','for'=>'NUMSERIE','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'NUMSERIE','id' => 'NUMSERIE'  ,'placeholder' => 'Escribe NUMSERIE','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'PROVINCIA','as'=>'PROVINCIA','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'PROVINCIA','label' => 'PROVINCIA','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'PROVINCIA:','for'=>'PROVINCIA','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'PROVINCIA','id' => 'PROVINCIA'  ,'placeholder' => 'Escribe PROVINCIA','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'TOTAL','as'=>'TOTAL','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'TOTAL','label' => 'TOTAL','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'TOTAL:','for'=>'TOTAL','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'TOTAL','id' => 'TOTAL'  ,'placeholder' => 'Escribe TOTAL','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'ABONO','as'=>'ABONO','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'ABONO','label' => 'ABONO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'ABONO:','for'=>'ABONO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'ABONO','id' => 'ABONO'  ,'placeholder' => 'Escribe ABONO','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'SALDO','as'=>'SALDO','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'SALDO','label' => 'SALDO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'SALDO:','for'=>'SALDO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'SALDO','id' => 'SALDO'  ,'placeholder' => 'Escribe SALDO','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'TIPO_OP','as'=>'TIPO_OP','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'TIPO_OP','label' => 'TIPO_OP','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'TIPO_OP:','for'=>'TIPO_OP','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'TIPO_OP','id' => 'TIPO_OP'  ,'placeholder' => 'Escribe TIPO_OP','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'TIPO_RETFTE','as'=>'TIPO_RETFTE','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'TIPO_RETFTE','label' => 'TIPO_RETFTE','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'TIPO_RETFTE:','for'=>'TIPO_RETFTE','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'TIPO_RETFTE','id' => 'TIPO_RETFTE'  ,'placeholder' => 'Escribe TIPO_RETFTE','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'ELECTRONICO','as'=>'ELECTRONICO','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'ELECTRONICO','label' => 'ELECTRONICO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'ELECTRONICO:','for'=>'ELECTRONICO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'ELECTRONICO','id' => 'ELECTRONICO'  ,'placeholder' => 'Escribe ELECTRONICO','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'ESTADO','as'=>'ESTADO','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'ESTADO','label' => 'ESTADO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'ESTADO:','for'=>'ESTADO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'ESTADO','id' => 'ESTADO'  ,'placeholder' => 'Escribe ESTADO','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'USUCRE','as'=>'USUCRE','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'USUCRE','label' => 'USUCRE','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'USUCRE:','for'=>'USUCRE','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'USUCRE','id' => 'USUCRE'  ,'placeholder' => 'Escribe USUCRE','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'FCHCRE','as'=>'FCHCRE','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FCHCRE','label' => 'FCHCRE','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FCHCRE:','for'=>'FCHCRE','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FCHCRE','id' => 'FCHCRE'  ,'placeholder' => 'Escribe FCHCRE','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'USUMOD','as'=>'USUMOD','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'USUMOD','label' => 'USUMOD','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'USUMOD:','for'=>'USUMOD','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'USUMOD','id' => 'USUMOD'  ,'placeholder' => 'Escribe USUMOD','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'FCHMOD','as'=>'FCHMOD','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FCHMOD','label' => 'FCHMOD','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FCHMOD:','for'=>'FCHMOD','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FCHMOD','id' => 'FCHMOD'  ,'placeholder' => 'Escribe FCHMOD','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'PROCESO','as'=>'PROCESO','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'PROCESO','label' => 'PROCESO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'PROCESO:','for'=>'PROCESO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'PROCESO','id' => 'PROCESO'  ,'placeholder' => 'Escribe PROCESO','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'REFER','as'=>'REFER','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'REFER','label' => 'REFER','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'REFER:','for'=>'REFER','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'REFER','id' => 'REFER'  ,'placeholder' => 'Escribe REFER','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			)
			
			),
			'btn'=>array(                  
			array('title'=>'Actualiza','procesoa'=>"add_person('N','N');carga('".base_url()."empresa/actualizar/",'procesob'=>"','contenidom');",'id'=>'lnk_act','men'=>'a'),                    
			array('title'=>'Elimina','procesoa'=>"if (eliminar()== true) { carga('".base_url()."empresa/eliminar/",'procesob'=>"','filtro');}",'id'=>'lnk_eli','men'=>'e')                       
			));
			$this->filtroo = '';
			$this->importao = '';
			
			$this->camposdeto = '';
			
			$this->config->set_item('r_struct', $this->structo);
			$this->config->set_item('r_boto', $this->botoo);
			$this->config->set_item('r_combo', $this->comboo);
			$this->config->set_item('r_dato', $this->datoo);
			$this->config->set_item('r_tabla', $this->tablao);
			$this->config->set_item('r_campos', $this->camposo);
			$this->config->set_item('r_filtros', $this->filtroo);
			$this->config->set_item('r_camposdet', $this->camposdeto);
			$this->config->set_item('r_importa', $this->importao);
			}
			
			if (strtoupper($indice) == strtoupper('_orcmpr')) {
			
			$this->botoo  = ''; 
			$this->comboo = array(array('dato'=>'orcmpr','campo'=>'estado','cat'=>'BAI','nom'=>'julio'));
			
			$this->datoo  = 'orcmpr|0|1|1';
			$this->tablao = 'pq_pro_cncmpr.pr_con_orcmpr|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1 ';
			$this->camposo = array('prm'=>'orcmpr|sp_grb_orcmpr|orcmpr',
			'cmp'=>array(
			
			array('campo'=>'EMPRESA','as'=>'EMPRESA','id'=>'1','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'EMPRESA','label' => 'EMPRESA','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'EMPRESA:','for'=>'EMPRESA','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'EMPRESA','id' => 'EMPRESA'  ,'placeholder' => 'Escribe EMPRESA','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'SEC','as'=>'SEC','id'=>'0','lst'=>'1|0|1','esp'=>'-E SECUENCIA CLISTA-',
			array('tipo'=>'rls','attr'=> array('field' => 'SEC','label' => 'SEC','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'SEC:','for'=>'SEC','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'SEC','id' => 'SEC'  ,'placeholder' => 'Escribe SEC','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'TIPO','as'=>'TIPO','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'TIPO','label' => 'TIPO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'TIPO:','for'=>'TIPO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'TIPO','id' => 'TIPO'  ,'placeholder' => 'Escribe TIPO','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'CLIENTE','as'=>'CLIENTE','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'CLIENTE','label' => 'CLIENTE','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'CLIENTE:','for'=>'CLIENTE','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'CLIENTE','id' => 'CLIENTE'  ,'placeholder' => 'Escribe CLIENTE','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'FECHA','as'=>'FECHA','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FECHA','label' => 'FECHA','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FECHA:','for'=>'FECHA','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FECHA','id' => 'FECHA'  ,'placeholder' => 'Escribe FECHA','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'VALOR','as'=>'VALOR','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'VALOR','label' => 'VALOR','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'VALOR:','for'=>'VALOR','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'VALOR','id' => 'VALOR'  ,'placeholder' => 'Escribe VALOR','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'SALDO','as'=>'SALDO','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'SALDO','label' => 'SALDO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'SALDO:','for'=>'SALDO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'SALDO','id' => 'SALDO'  ,'placeholder' => 'Escribe SALDO','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'DESCRIP','as'=>'DESCRIP','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'DESCRIP','label' => 'DESCRIP','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'DESCRIP:','for'=>'DESCRIP','attr'=>array())),
			array('tipo'=>'cbo','attr'=> array('name' => 'DESCRIP','id' => 'DESCRIP'  ,'placeholder' => 'Escribe DESCRIP','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'REFEREN','as'=>'REFEREN','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'REFEREN','label' => 'REFEREN','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'REFEREN:','for'=>'REFEREN','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'REFEREN','id' => 'REFEREN'  ,'placeholder' => 'Escribe REFEREN','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'ESTADO','as'=>'ESTADO','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'ESTADO','label' => 'ESTADO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'ESTADO:','for'=>'ESTADO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'ESTADO','id' => 'ESTADO'  ,'placeholder' => 'Escribe ESTADO','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'USUCRE','as'=>'USUCRE','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'USUCRE','label' => 'USUCRE','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'USUCRE:','for'=>'USUCRE','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'USUCRE','id' => 'USUCRE'  ,'placeholder' => 'Escribe USUCRE','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'FCHCRE','as'=>'FCHCRE','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FCHCRE','label' => 'FCHCRE','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FCHCRE:','for'=>'FCHCRE','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FCHCRE','id' => 'FCHCRE'  ,'placeholder' => 'Escribe FCHCRE','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'USUMOD','as'=>'USUMOD','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'USUMOD','label' => 'USUMOD','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'USUMOD:','for'=>'USUMOD','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'USUMOD','id' => 'USUMOD'  ,'placeholder' => 'Escribe USUMOD','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'FCHMOD','as'=>'FCHMOD','id'=>'0','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FCHMOD','label' => 'FCHMOD','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FCHMOD:','for'=>'FCHMOD','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FCHMOD','id' => 'FCHMOD'  ,'placeholder' => 'Escribe FCHMOD','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			)
			
			),
			'btn'=>array(                  
			array('title'=>'Actualiza','procesoa'=>"add_person('N','N');carga('".base_url()."empresa/actualizar/",'procesob'=>"','contenidom');",'id'=>'lnk_act','men'=>'a'),                    
			array('title'=>'Elimina','procesoa'=>"if (eliminar()== true) { carga('".base_url()."empresa/eliminar/",'procesob'=>"','filtro');}",'id'=>'lnk_eli','men'=>'e')                       
			));
			$this->filtroo = '';
			$this->importao = '';
			
			$this->camposdeto = array(array('prm'=>'orcmprdet|pr_con_orcmprdet|param SQLT_CHR -1 ,r_curso OCI_B_CURSOR -1 ',
			'cmp'=>array(
			
			array('campo'=>'EMPRESA','as'=>'EMPRESA','id'=>'1','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'EMPRESA','label' => 'EMPRESA','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'EMPRESA:','for'=>'EMPRESA','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'EMPRESA','id' => 'EMPRESA'  ,'placeholder' => 'Escribe EMPRESA','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'NUC','as'=>'NUC','id'=>'1','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'NUC','label' => 'NUC','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'NUC:','for'=>'NUC','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'NUC','id' => 'NUC'  ,'placeholder' => 'Escribe NUC','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'SEC','as'=>'SEC','id'=>'1','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'SEC','label' => 'SEC','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'SEC:','for'=>'SEC','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'SEC','id' => 'SEC'  ,'placeholder' => 'Escribe SEC','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'MODULO','as'=>'MODULO','id'=>'1','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'MODULO','label' => 'MODULO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'MODULO:','for'=>'MODULO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'MODULO','id' => 'MODULO'  ,'placeholder' => 'Escribe MODULO','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'TIPO','as'=>'TIPO','id'=>'1','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'TIPO','label' => 'TIPO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'TIPO:','for'=>'TIPO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'TIPO','id' => 'TIPO'  ,'placeholder' => 'Escribe TIPO','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'SECDOC','as'=>'SECDOC','id'=>'1','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'SECDOC','label' => 'SECDOC','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'SECDOC:','for'=>'SECDOC','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'SECDOC','id' => 'SECDOC'  ,'placeholder' => 'Escribe SECDOC','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'VALOR','as'=>'VALOR','id'=>'1','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'VALOR','label' => 'VALOR','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'VALOR:','for'=>'VALOR','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'VALOR','id' => 'VALOR'  ,'placeholder' => 'Escribe VALOR','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'SALDO','as'=>'SALDO','id'=>'1','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'SALDO','label' => 'SALDO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'SALDO:','for'=>'SALDO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'SALDO','id' => 'SALDO'  ,'placeholder' => 'Escribe SALDO','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'DESCRIP','as'=>'DESCRIP','id'=>'1','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'DESCRIP','label' => 'DESCRIP','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'DESCRIP:','for'=>'DESCRIP','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'DESCRIP','id' => 'DESCRIP'  ,'placeholder' => 'Escribe DESCRIP','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'REFEREN','as'=>'REFEREN','id'=>'1','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'REFEREN','label' => 'REFEREN','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'REFEREN:','for'=>'REFEREN','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'REFEREN','id' => 'REFEREN'  ,'placeholder' => 'Escribe REFEREN','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'ESTADO','as'=>'ESTADO','id'=>'1','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'ESTADO','label' => 'ESTADO','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'ESTADO:','for'=>'ESTADO','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'ESTADO','id' => 'ESTADO'  ,'placeholder' => 'Escribe ESTADO','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'USUCRE','as'=>'USUCRE','id'=>'1','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'USUCRE','label' => 'USUCRE','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'USUCRE:','for'=>'USUCRE','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'USUCRE','id' => 'USUCRE'  ,'placeholder' => 'Escribe USUCRE','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'FCHCRE','as'=>'FCHCRE','id'=>'1','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FCHCRE','label' => 'FCHCRE','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FCHCRE:','for'=>'FCHCRE','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FCHCRE','id' => 'FCHCRE'  ,'placeholder' => 'Escribe FCHCRE','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'USUMOD','as'=>'USUMOD','id'=>'1','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'USUMOD','label' => 'USUMOD','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'USUMOD:','for'=>'USUMOD','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'USUMOD','id' => 'USUMOD'  ,'placeholder' => 'Escribe USUMOD','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			),
			array('campo'=>'FCHMOD','as'=>'FCHMOD','id'=>'1','lst'=>'1|1|1','esp'=>'',
			array('tipo'=>'rls','attr'=> array('field' => 'FCHMOD','label' => 'FCHMOD','rules' => 'trim|required')),
			array('tipo'=>'lbl','attr'=> array('text'=>'FCHMOD:','for'=>'FCHMOD','attr'=>array())),
			array('tipo'=>'txt','attr'=> array('name' => 'FCHMOD','id' => 'FCHMOD'  ,'placeholder' => 'Escribe FCHMOD','maxlength' => '20',
			'size' => '20'           ,'style'       => 'width:100%'      ,'value'     => '','required'=>'required','readonly'=>'readonly' ))
			)
			
			)));
			
			
			$this->config->set_item('r_struct', $this->structo);
			$this->config->set_item('r_boto', $this->botoo);
			$this->config->set_item('r_combo', $this->comboo);
			$this->config->set_item('r_dato', $this->datoo);
			$this->config->set_item('r_tabla', $this->tablao);
			$this->config->set_item('r_campos', $this->camposo);
			$this->config->set_item('r_filtros', $this->filtroo);
			$this->config->set_item('r_camposdet', $this->camposdeto);
			$this->config->set_item('r_importa', $this->importao);
			}
			
			
			//$this->acciono  = '00';
			//$this->config->set_item('r_accion', $this->acciono);
			
			$this->_index();
			}
			
			function _index(){
			
			$_campos =  $this->config->item('r_campos');
			$campos = $_campos['cmp'];
			$this->indexo = "";
			if (isset($campos)) {
			//echo 'si hay campos';
			foreach ($campos as $rc => $campo) {
			if ($campo['id'] == 1) {
			$this->indexo = $this->indexo.$campo['campo'].'|';
			}
			}
			}
			$this->config->set_item('r_index',$this->indexo);
			
			
			$_camposd =  $this->config->item('r_camposdet');
			if (is_array($_camposd)) {
			$this->indexdeto = "";
			$count = count($_camposd);                 
			for ($r = 0; $r <= $count -1; $r++) { 		
			$camposd = $_camposd[$r]['cmp'];	
			if (isset($camposd)) {
			//echo 'si hay campos';
			foreach ($camposd as $rc => $campod) {
			if ($campod['id'] == 1) {
			$this->indexdeto = $this->indexdeto.$campod['campo'].'|';
			}
			}
			}
			$this->indexdeto = $this->indexdeto.',';
			}
			$this->config->set_item('r_indexdet',$this->indexdeto);
			}
			
			
			$_camposd =  $this->config->item('r_camposbot');
			if (is_array($_camposd)) {
			$this->indexdeto = "";
			$count = count($_camposd);                 
			for ($r = 0; $r <= $count -1; $r++) { 		
			$camposd = $_camposd[$r]['cmp'];	
			if (isset($camposd)) {
			//echo 'si hay campos';
			foreach ($camposd as $rc => $campod) {
			if ($campod['id'] == 1) {
			$this->indexdeto = $this->indexdeto.$campod['campo'].'|';
			}
			}
			}
			$this->indexdeto = $this->indexdeto.',';
			}
			$this->config->set_item('r_indexbot',$this->indexdeto);
			}
			}
			
			}
			?>									