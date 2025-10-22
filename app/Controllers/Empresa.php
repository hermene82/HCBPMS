<?php

namespace App\Controllers;

use App\Models\UsersModel;
use Config\Services;

class Empresa extends BaseController
{
	public $dato;
	public $datos;
	public $data;
	public $id;     
	
	public $structo;
	public $camposdeto;
	public $camposboto;
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
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// index carga transaccion
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
    public function index()//: string
    {		
        $indice = service('uri')->getSegment(3);
        $this->_param($indice);		
		$this->___index();        
    }

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// inicio transaccion carga lista  -- pendeinte
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
		function ___index(){
			$data = [];
			$data['car']  = $this->cargarDatosCatalogo();
			$data['deff'] = [$this->cargarParametrosCampos()]; //campos x defecto
			$data['bemp'] = $this->cargarConsultaBotones();
			$data['emp']  = $this->procesarConsulta();
			$data['config'] = $this->config;
            $this->descripcionCatalogo($data['car'],$data['emp']);
			view('empresa/emp_lst', $data);				
		}

		function descripcionCatalogo(array $arrayA, array &$arrayB)
		{
			$catConfig = $this->config->r_combo ?? [];

			// 1. Construir el mapa de catálogos: [CAT] => [codigo => nombre]
			$catalogos = [];

			foreach ($arrayA as $catalogoTipo) {
				foreach ($catalogoTipo as $cat => $items) {
					foreach ($items as $item) {
						$codigo = (string) $item['DDIC_LISTA'];
						$nombre = $item['DDIC_NOMBRE'];
						$catalogos[$cat][$codigo] = $nombre;
					}
				}
			}

			// 2. Recorrer configuración y aplicar a $arrayB
			foreach ($catConfig as $definicion) {
				if (!empty($definicion['ver']) && $definicion['ver'] == '1' && !empty($definicion['campo']) && !empty($definicion['cat'])) {
					$campo = $definicion['campo']; // Campo de $arrayB (ej. IDPRODUCTO)
					$cat   = $definicion['cat'];   // Catálogo (ej. PRODUCTO)

					foreach ($arrayB as &$registro) {
						if (isset($registro[$campo])) {
							$valor = (string) $registro[$campo];

							if (isset($catalogos[$cat][$valor])) {
								$registro[$campo] = $valor . '-' . $catalogos[$cat][$valor];
							}
						}
					}
				}
			}
		}


	private function cargarDatosCatalogo()
    {
        $arr = [];
        $cat = $this->config->r_combo ?? [];

        foreach ($cat as $elem) {
            if (is_array($elem) && !empty($elem['cat'])) {
                $arr[] = [$elem['cat'] => ''];
            }
        }

        if (!empty($arr)) {
            emp_catalogo($arr);
        }

        return $arr;
    }

    private function cargarParametrosCampos()
    {
        $arrprm = [];
        $campos = $this->config->r_filtros['cmp'] ?? '';
        
		if (is_array($campos)){
        foreach ($campos as $campo) {
            $_prm = explode('-', $campo['esp']);
            $arrprm[$campo['campo']] = $this->datoD($_prm[0]);
        }

        return $arrprm;
	    }
    }

    private function cargarConsultaBotones()
    {
        $arrb = [];
        $cat = $this->config->r_camposbot ?? '';
		
		if (is_array($cat)){
			if (isset($cat)) {

        foreach ($cat as $elem) {
            if (is_array($elem)) {
                $consul = 0;

                if (!empty($elem['where']) && is_array($elem['where'])) {
                    $consul = 1;
                    $arrb[] = [$elem['tabla'] => r_emp($elem['where'], $elem['tabla'])];
                }

                if (!empty($elem['tabla']) && !$consul) {
                    $arrb[] = [$elem['tabla'] => r_empo('', $elem['tabla'])];
                }
            }
        }

        return $arrb;
	    }}
    }

    private function procesarConsulta()
    {
        $_tab = explode('|', $this->config->r_tabla);
        $_par = explode(',', $_tab[1] ?? '');

        $pro = explode('.', $_tab[0] ?? '');
        $paq = $pro[0] ?? '';
        $prc = $pro[1] ?? '';

        $arrprm = $this->cargarParametrosCampos();
        $w_dato = (is_array($arrprm) && count($arrprm) > 0) ? implode('|', array_values($arrprm)) : '| | | |';
         
        return emp($_tab[0]);		
    }

	public function obtenerNuevoContenido()
	{
		// Recuperamos las variables de sesión
		$productoId = session()->get('productoId') ?? 'No disponible';
		$productoName = session()->get('productoName') ?? 'No disponible';
		$moduloId = session()->get('moduloId') ?? 'No disponible';
		$moduloName = session()->get('moduloName') ?? 'No disponible';
		$transaccionName = session()->get('transaccionName') ?? 'No disponible';
		$transaccionIn = session()->get('transaccionIn') ?? 'No disponible';

		// Creamos el nuevo contenido
		$nuevoContenido = [
			'productoId' => $productoId,
			'productoName' => $productoName,
			'moduloId' => $moduloId,
			'moduloName' => $moduloName,
			'transaccionName' => $transaccionName,
			'transaccionIn' => $transaccionIn
		];

		// Retornamos la respuesta en formato JSON
		return $this->response->setJSON($nuevoContenido);
	}

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// carga detalle lista boton detalle grid +-
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
		function detalle() {
			// Obtener los segmentos de la URI
			$indice = service('uri')->getSegment(3);
			$this->_param($indice);
			$i = service('uri')->getSegment(4);
			$_index = service('uri')->getSegment(5);
		
			// Obtener los valores de la configuración
			$_camposd = $this->config->r_camposdet;
			$_dato = explode("|", $this->config->r_dato);
		
			// Construir la ubicación del detalle
			$_ubic = $_dato[4] . "|" . $i . "|" . $_index;
			$i--; // Decrementar el índice
		
			// Verificar si existen campos de detalle
			if (isset($_camposd) && is_array($_camposd)) {
				$dat = [];
				$consulta = [];
		
				// Iterar sobre los campos de detalle
				foreach ($_camposd as $r => $campo) {
					$_param = explode("|", $campo['prm']);
					$tabla = $_param[4]; // Obtiene el nombre de la tabla
		
					// Dividir el índice
					$cmp_val = explode("--", $_index);
					array_pop($cmp_val);
		
					// Obtener los índices de detalle
					$sd = explode(",", $this->config->r_indexdet);
					$cam_ind = explode("|", $sd[$r]);
					array_pop($cam_ind);
		
					// Ajustar los índices si es necesario
					$this->ajustarIndices($cmp_val, $cam_ind);
		
					// Combinar los valores con los índices
					$dat[$r] = array_combine($cam_ind, $cmp_val);
					$this->id = $dat[$r];
		
					// Realizar la consulta
					$consulta[$r] = r_emp($this->id, $tabla);
				}
		
				// Preparar los datos para la vista
				$data = [
					'id' => $dat,
					'emp' => $consulta,
					'ubic_det' => $_ubic,
					'config' => $this->config
				];
		
				// Cargar la vista
				view('empresa/emp_dlst', $data);
			}
		}
		
		/**
		 * Ajusta los índices de los valores si el número de índices es diferente al número de valores.
		 *
		 * @param array $cmp_val Los valores del índice
		 * @param array $cam_ind Los índices de detalle
		 */
		private function ajustarIndices(&$cmp_val, &$cam_ind) {
			$count_i = count($cmp_val);
			$count_f = count($cam_ind);
		
			// Si el número de índices es mayor que el número de valores, eliminar los índices adicionales
			if ($count_f > $count_i) {
				$cam_ind = array_slice($cam_ind, 0, $count_i);
			}
		}

	    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// btn crea registo envia pantalla campos
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function nuevo(){
			
			$indice = service('uri')->getSegment(3);			
			$this->_param($indice);
			$this->config->r_accion = 'nue';

			$totSegmento = service('uri')->getTotalSegments();
            
			$i = ($totSegmento >= 4) ? service('uri')->getSegment(4):'0';
			$_indexc = ($totSegmento >= 5) ? service('uri')->getSegment(5):'0';
			$_det = ($totSegmento >= 6) ? service('uri')->getSegment(6):'0';
			$_deti = ($totSegmento >= 7) ? service('uri')->getSegment(7):'0';			            
			$_ubic_det =  ($totSegmento >= 8) ? service('uri')->getSegment(8):'0';
						
			$_ubic   =  $indice."|".$i."|".$_indexc;

			if ($_det == 'D') {
			    //echo print_r ('paso x D',true);
				$cmp_val = explode("--",$_indexc);
				array_pop($cmp_val);
				
				$sd = explode(",",$this->config->r_indexdet);
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
				
				$_campos =  $this->config->r_camposdet; 
				$campos = $_campos[$_deti]['cmp'];		  
			}else{
				if ($_det == 'B') {
					//echo print_r ('paso x B',true);
					$_campos =  $this->config->r_camposbot;
					$campos = $_campos[$_deti]['cmp'];
					}else{
					//echo print_r ('paso x ',true);
					$_campos =  $this->config->r_campos;
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
								$data['car'] = $this->cargarDatosCatalogo();				
								$data['indexc'] = $_indexc;
								$data['det'] = $_det;
								$data['deti'] = $_deti;
								$data['ubic'] = $_ubic;
								$data['ubic_det'] = $_ubic_det;
								$data['config'] = $this->config;

								view('empresa/emp_cam',$data);

		}

				//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// btn graba registo envia request crea registro -- nuevo
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
		function recibirdatos() {
			//
			$dat = '';
               
			// Obtener la instancia del servicio de validación
			$validation = Services::validation();
		
			$indice = service('uri')->getSegment(3);                
			$this->_param($indice);
		
			$_indexc = service('uri')->getSegment(5);
			$_det = service('uri')->getSegment(6);
			$_deti = service('uri')->getSegment(7);
		
			// Verificar si la solicitud es AJAX
			if (!$this->request->isAJAX()) {
				// Si no es una solicitud AJAX, redirigir o mostrar un error
				// redirect('404');
				echo "|0|no ajax"; exit;
			}
		
			// Inicializar las reglas de validación
			$rules = [];
			$originalRules = [];
			$_campos =  $this->config->r_campos;
		
			if ($_det == 'D') {
				$cmp_val = explode("--", $_indexc);
				array_pop($cmp_val);
		
				$sd = explode(",", $this->config->r_indexdet);
				$cam_ind = explode("|", $sd[$_deti]);
				array_pop($cam_ind);
		
				$count_i = count($cmp_val);
				$count_f = count($cam_ind);
		
				if ($count_f > $count_i) {
					for ($i = $count_i + 1; $i <= $count_f; $i++) {
						unset($cam_ind[$i - 1]);
					}
				}
		
				$dat = array_combine($cam_ind, $cmp_val);
				echo print_r($dat, true);  // Para depurar los datos de los campos
		
				$_campos =  $this->config->r_camposdet;
				$campos = $_campos[$_deti]['cmp'];
				$___prm = explode("|", $_campos[$_deti]['prm']);
			} else {
				$campos = $_campos['cmp'];
				$___prm = explode("|", $_campos['prm']);
			}
		
			// Validación de las reglas del formulario
			if (isset($campos)) {
				foreach ($campos as $campo) {
					$lista = explode("|", $campo['lst']);
					if ($lista[1] == 1) {
						foreach ($campo as $elem) {
							if (is_array($elem)) {
								if ($elem['tipo'] == 'rls') {
									array_push($originalRules, $elem['attr']);
								}
							}
						}
					}
				}
			}

			foreach ($originalRules as $rule) {
				// Usamos el campo 'field' como clave y 'rules' como valor
				$rules[$rule['field']] = $rule['rules'];
			}
		
			// Obtener los datos del formulario enviado por AJAX
			$data = $this->request->getPost();  // Usar getPost en lugar de $_REQUEST
			unset($data['url']);  // Eliminar 'url' si está presente en los datos
		
			// Depuración de los datos recibidos
			//return json_encode(['errCodigo' => '0', 'errMenssa' => 'Datos recibidos correctamente','formData' => $rules]);
			//print_r($rules, true); echo ' rules aqui2'; exit;
		
			// Configurar las reglas de validación
			$validation->setRules($rules);
		
			// Validar los datos del formulario
			if ($this->request->getMethod() === 'post' && $validation->run($this->request->getPost(), null)) {
		
				// Procesar los datos si la validación es exitosa
				if (is_array($dat)) {
					foreach ($dat as $items => $items_value) {
						if (!array_key_exists($items, $data)) {
							$data[$items] = $items_value;
						}
					}
				}
		
				// Procesar datos especiales (campos adicionales)
				if (is_array($_campos)) {
					if (isset($campos)) {
						foreach ($campos as $campo) {
							$_prm = explode('-', $campo['esp']);
							if (count($_prm) > 1) {
								if ($_prm[1] != '') {
									$pos = strpos($_prm[1], 'SECUENCIA');
									if ($pos !== false) {
										$_prm[1] = $_prm[1] . '|' . $campo['campo'];
									}
		
									if (!array_key_exists($campo['campo'], $data)) {
										$data[$campo['campo']] = $this->datoD($_prm[1], 'E');
									}
								}
							}
						}
					}
				}
		
				// Procesar combos múltiples
				if (isset($campos)) {
					foreach ($campos as $rc => $campo) {
						foreach ($data as $rd => $dt) {
							foreach ($campo as $elem) {
								if (is_array($elem)) {
									if ($elem['tipo'] == 'cbo' && strtoupper($rd) == strtoupper($campo['campo'])) {
										if (strpos($elem['attr']['attr'], 'multiple="multiple"') !== false) {
											$cdat = $data[$rd];
											$data[$rd] = implode("|", $cdat);
										}
									}
								}
							}
						}
					}
				}
		
				// Procesar la creación de los datos
				$dat = $data;
				$tabla = $___prm[4];
		
				// Validación de creaciones a través de consultas o procedimientos almacenados
				$_struct =  $this->config->r_struct;
				if ($_det == 'D') {
					$ritem = intval(preg_replace('/[^0-9]+/', '', $_deti), 10);
					$dat_struct = $_struct->{$ritem + 1};
				} else {
					$dat_struct = $_struct->{0};
				}
		
				$mdat_struct = explode("|", $dat_struct->metodo);
				if ($mdat_struct[1] == "1") {
					$respuesta = emp_sp($data, $dat_struct->base . ".ingreso_" . $dat_struct->nombre);
				} else {
					$respuesta = crear_emp($data, $tabla);
				}
		
				// Procesar procesos después de grabar los datos
				if (isset($___prm[3]) && is_array($___prm[3]) ) {
					if (count($___prm[3]) > 0) {
						$Pprm = explode('-', $___prm[3]);
						if (count($Pprm) > 1) {
							if ($Pprm[1] != '') {
								// Procesar XML si es necesario
								$_xml = $this->Axml($dat);
							}
						}
					}
				}
		
				// Devolver la respuesta
				echo json_encode($respuesta);
		
			} else {
				// En caso de error en la validación
				echo view('empresa/emp_err', ['validation' => $validation]);
			}
		}
		
		function Axml($dat){
			$_xml = '';
			foreach($dat as $key => $val){
				$_xml .= '<' . $key . '>' . $val . '</' . $key . ">\n";
			}
			$_xml = '<R>'.$_xml.'</R>';
			return $_xml;
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
						$consulta = emp_sprcursor('PQ_PRO_PROCESOS','PR_PRO_PENDIENTE',$params,$cursor);
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

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// btn actualizar registo envia pantalla campos
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
		function actualizar(){

			$indice = service('uri')->getSegment(3);			
			$this->_param($indice);	
			$this->config->r_accion = 'mod';				
			
			$totSegmento = service('uri')->getTotalSegments();
			
            $i = ($totSegmento >= 4) ? service('uri')->getSegment(4):'0';			
			$_indexc = ($totSegmento >= 5) ? service('uri')->getSegment(5):'0';
			$_index = ($totSegmento >= 5) ? service('uri')->getSegment(5):'0';			
			$_det = ($totSegmento >= 6) ? service('uri')->getSegment(6):'0'; 
			$_deti = ($totSegmento >= 7) ? service('uri')->getSegment(7):'0';
			$_ubic_det = ($totSegmento >= 8) ? service('uri')->getSegment(8):'0';	

			$_ubic   =  $indice."|".$i."|".$_index;			
			$i--;
            			
			$camposConfig = $this->getCamposConfig($_det, $_deti);
										
				$tabla = $camposConfig['tabla'];
				$cam_ind = $camposConfig['cam_ind'];
						
				$cmp_val = explode("--",$_index);
				array_pop($cmp_val);
				array_pop($cam_ind);
				$this->id = array_combine($cam_ind,$cmp_val);
											
				$data['emp'] = r_emp($this->id,$tabla);
				$data['def'] = null;								
				$data['car'] = $this->cargarDatosCatalogo();
				$data['indexc'] = $_indexc;
				$data['det'] = $_det;
				$data['deti'] = $_deti;
				$data['ubic'] = $_ubic;
				$data['ubic_det'] = $_ubic_det;
                $data['config'] = $this->config;				

				View('empresa/emp_cam',$data);				
				
		}

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// btn graba registo envia request actualiza registro -- actualizar
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
		function Modificardatos(){
			
			$indice = service('uri')->getSegment(3);										
			$this->_param($indice);

			$_det = service('uri')->getSegment(6);
			$_deti = service('uri')->getSegment(7);
			
			$data = $_REQUEST;
			unset($data['url']);
			$dat = $data;			
			
			if ($_det == 'D') {
				$_campos =  $this->config->r_camposdet; 
				$sd = explode(",",$this->config->r_indexdet);				
				$cam_ind =  explode("|",$sd[$_deti]);			
				$campos = $_campos[$_deti]['cmp'];
				$___prm = explode("|",$_campos[$_deti]['prm']);			
				}else{
				if ($_det == 'B') {
				$_campos =  $this->config->r_camposbot; 
				$sd = explode(",",$this->config->r_indexbot);				
				$cam_ind =  explode("|",$sd[$_deti]);			
				$campos = $_campos[$_deti]['cmp'];
				$___prm = explode("|",$_campos[$_deti]['prm']);
				$___prm[4] = explode("|",$_campos[$_deti]['tabla']);	
				}else{
				$_campos =  $this->config->r_campos;
				$cam_ind =  explode("|",$this->config->r_index);
				$campos = $_campos['cmp'];	
				$___prm = explode("|",$_campos['prm']);
				$___prm[4] = $_campos['tabla'];
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
            //exit;

			
			//$respuesta = $this->empresa_model->actualizar_emp($this->id,$data,$tabla);
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////revisar
			$_struct =  $this->config->r_struct;
			if ($_det == 'D') {
				$ritem = intval(preg_replace('/[^0-9]+/', '', $_deti), 10);
				$dat_struct = $_struct->{$ritem + 1};   			
			}else{
				$dat_struct = $_struct->{0};   						 
			}
			$mdat_struct = explode("|",$dat_struct->metodo);  
			if ($mdat_struct[1] == "1") { /// index 1 para ingreso
				$respuesta = emp_sp($data,$dat_struct->base.".actualiza_".$dat_struct->nombre);
			}else{
				$respuesta = actualizar_emp($this->id,$data,$tabla);
			}
			
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////revisar
			//$_structpr =  $this->config->r_structpr;
			//$mdat_structpr = explode("|",$dat_structpr->metodo);
            if ($mdat_struct[1] == "1") { /// index 1 para ingreso
				$respuesta = emp_sp($data,$dat_struct->base.".actualiza_".$dat_struct->nombre);
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

		// Función para obtener la configuración de campos según el valor de $_det
		private function getCamposConfig($_det, $_deti) {
			$camposConfig = [];
			if ($_det == 'D') {
				$camposCon['campos'] = $this->config->r_camposdet;
				$sd = explode(",", $this->config->r_indexdet);
				$cam_ind = explode("|", $sd[$_deti]);
				$camposConfig['campos'] = $camposCon['campos'][$_deti]['cmp'];
				$camposConfig['prm'] = explode("|", $camposCon['campos'][$_deti]['prm']);
				$camposConfig['tabla'] = $camposCon['campos'][$_deti]['tabla'];
			} elseif ($_det == 'B') {
				$camposCon['campos'] = $this->config->r_camposbot;
				$sd = explode(",", $this->config->r_indexbot);
				$cam_ind = explode("|", $sd[$_deti]);
				$camposConfig['campos'] = $camposCon['campos'][$_deti]['cmp'];
				$camposConfig['prm'] = explode("|", $camposCon['campos'][$_deti]['prm']);
			    $camposConfig['tabla'] = $camposCon['campos'][$_deti]['tabla'];
			} else {				
				$camposCon['campos'] = $this->config->r_campos;
				$cam_ind = explode("|", $this->config->r_index);
				$camposConfig['campos'] = $camposCon['campos']['cmp'];
				$camposConfig['prm'] = explode("|", $camposCon['campos']['prm']);
				$camposConfig['tabla'] = $camposCon['campos']['tabla'];
			}            
			$camposConfig['cam_ind'] = $cam_ind;		
			return $camposConfig;
		}
		

		function eliminar(){
			
			$indice = service('uri')->getSegment(3);				
			$this->_param($indice);

			$totSegmento = service('uri')->getTotalSegments();
						
			$i = ($totSegmento >= 4) ? service('uri')->getSegment(4):'0';
			$_det = ($totSegmento >= 6) ? service('uri')->getSegment(6):'0';
			$_deti = ($totSegmento >= 7) ? service('uri')->getSegment(7):'0';				
			$_index = ($totSegmento >= 5) ? service('uri')->getSegment(5):'0';
			
			// Definir las variables en función de $_det
			$camposConfig = $this->getCamposConfig($_det, $_deti);
										
				$tabla = $camposConfig['tabla'];
				$cam_ind = $camposConfig['cam_ind'];
			
			$cmp_val = explode("--",$_index);
			array_pop($cmp_val);
			array_pop($cam_ind);
			$this->id = array_combine($cam_ind,$cmp_val);

			$PRO ='N';
			
			if ($indice=='factura' && ($tabla == 'factura' || $tabla == 'facdetalle')){
			    $idFac = array('SEC'=>$this->id['SEC']);
				//echo print_r($this->id ,true);
			   	$consulta  = r_emp($idFac,'factura'); 
				foreach($consulta->result() as $rfac){
					$PRO =  $rfac->ESTPRO;
					if ($PRO=='S'){
					echo $this->msgAlert('D','Transaccion No permitida Factura '.$rfac->NUMERO.' en estado Procesado');
					}
					if ($PRO=='N' && $tabla == 'factura'){
					   
					   $respuesta = eliminar_emp($idFac,'facdetalle');

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
			$respuesta = eliminar_emp($this->id,$tabla);

			//echo json_encode($respuesta);exit;

			if ($respuesta->errCodigo == "0" ){
				echo $this->msgAlert('OK','');
			}else{
				echo "<div class = 'alert alert-danger' > Error: ". $respuesta->errCodigo . " - " . $respuesta->errMenssa . "</div>'";
			}

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
						
						$consulta = emp_sprcursor_sec($prm);
						//echo print_r($consulta,true);
						foreach($consulta as $em ){
							$rsp = $em['SECUENCIA'] ;      
						} 
						
					}
					//echo '03';			
					
					
					
				}}
				return $rsp;
		}

		function fecha($refe){
			
			
			$_re = explode('|',$refe);
			$_f = new \DateTime('now');
			
			if ($_re[0]== 'I'){ 
				
				$ma = (new \DateTime('now'))->format('m');
				$an = (new \DateTime('now'))->format('Y');
				$hr = (new \DateTime('now'))->format('H:i:s');
				
				$_f = new \DateTime( $an.'-'.$ma.'-01 '.$hr);       
			}                
			
			if ($_re[0]== 'F'){ 
				$_f = (new \DateTime('now'))->add(new \DateInterval('P1M'));
				
				$ma = (new \DateTime('now'))->format('m');
				$an = (new \DateTime('now'))->format('Y');
				$hr = (new \DateTime('now'))->format('H:i:s');   
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



    public function create()
    {        
        $rules = [ 
            'user' => 'required|max_length[30]|is_unique[users.user]',
            'password' => 'required|max_length[50]|min_length[5]',
            'repassword' => 'matches[password]',
            'name' => 'required|max_length[100]',
            'email' => 'required|max_length[80]|valid_email|is_unique[users.email]'
        ];

        if(!$this->validate($rules)){            
           return redirect()->back()->withInput()->with('errors',$this->validator->listErrors());
        }

        $userModel = new UsersModel();
        $post = $this->request->getPost(['user','password','name','email']);
        $token = bin2hex(random_bytes(20));

        $userModel->insert([
            'user'=>$post['user'],
            'password'=>password_hash($post['password'],PASSWORD_DEFAULT),
            'name'=>$post['name'],
            'email'=>$post['email'],
            'active'=> 0,
            'activation_token'=>$token
        ]);

        $email = \config\Services::email();
        $email->setTo($post['email']);
        $email->setSubject('Activa tu cuenta');

        $url = base_url('activate-user/'.$token);
        $body = '<p>Hola '. $post['name'] .'</p>';
        $body .= '<p>Para continuar con el proceso de registro, has click en el siguiente link <a href='.$url.'>ActivaCuenta</a></p>';
        $body .= 'Gracias!';

        $email->setMessage($body);
        $email->send();
        
        $title = 'Registro existoso';
        $message = 'Revisa tu correo electronico para activar tu cuenta.';

        return $this->showMessage($title,$message);
    }

    private function showMessage($title,$message){
        $data = [
            'title'=> $title,
            'message'=> $message,
        ];
        return view('message',$data);
    }
    
		function _param($indice){

			try {
			helper('TransacProducto');			
			$this->config = (object) obtenerConfiguracionTransaccion($indice);
			//$this->config = json_decode(json_encode(obtenerConfiguracionTransaccion($indice)));
			//echo 'paso 000' ; 
			//print_r($this->config, true) ; exit;
            $this->_index();
			//print_r($this->config, true) ; exit;
		} catch (\Exception $e) {
			// Mensaje de error amigable
			log_message('error', 'Error en _param: ' . $e->getMessage());
			echo 'Ocurrió un error al cargar la configuración: ' . $e->getMessage();
			exit;
		}
			
        }

		function _index()
		{
			$this->config->r_index     = $this->buildIndexMultiple([$this->config->r_campos], false);
			$this->config->r_indexdet  = $this->buildIndexMultiple($this->config->r_camposdet);
			$this->config->r_indexbot  = $this->buildIndexMultiple($this->config->r_camposbot);
		}
		
		private function buildIndexMultiple($bloques, $agregarComas = true)
		{
			$resultado = "";		
			if (is_array($bloques)) {
				foreach ($bloques as $bloque) {
					if (isset($bloque['cmp']) && is_array($bloque['cmp'])) {
						foreach ($bloque['cmp'] as $campo) {
							if (isset($campo['id']) && $campo['id'] == 1) {
								$resultado .= $campo['campo'] . '|';
							}
						}
						if ($agregarComas) {
							$resultado .= ',';
						}
					}
				}
			}
		
			// Eliminar último carácter sobrante
			//if ($resultado !== '') {
			//	$ultimoCaracter = substr($resultado, -1);
			//	if ($ultimoCaracter === '|' || $ultimoCaracter === ',') {
			//		$resultado = substr($resultado, 0, -1);
			//	}
			//}

			return $resultado;
		}

}