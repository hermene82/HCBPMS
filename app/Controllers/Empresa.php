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
			$data['config'] = $this->config;
			$data['car'] = $this->obtenerCatalogos();			
			$data['deff'] = [$this->cargarParametrosCampos()]; //campos x defecto			
			$data['emp']  = $this->cargarConsulta('');
			$data['bemp'] = $this->cargarConsulta('B');
			
			log_message('debug', '___index-data: ' . print_r($data, true));
			// Preparar índices para no armarlos en la vista
			$data['emp']  = $this->agregarIndex(
				$data['emp'],
				[$this->config->r_campos] ?? []
			);

			$data['bemp'] = $this->agregarIndex(
				$data['bemp'],
				$this->config->r_camposbot ?? []
			);

			// Preparar estructuras de filtros e importación
			$data['filtrosPreparados'] = $this->prepararCamposFormulario(
				$this->config->r_filtros ?? null,
				$data['car'],
				$data['deff']
			);

			$data['importaPreparado'] = $this->prepararCamposFormulario(
				$this->config->r_importa ?? null,
				$data['car'],
				$data['deff']
			);

			$this->descripcionCatalogo($data['car'],$data['emp']);
			$this->descripcionCatalogo($data['car'],$data['bemp']);
			
			//log_message('debug', '___index-data: ' . print_r($data, true));
			return view('empresa/emp_lst', $data);				
		}
	

		private function agregarIndex(array $bemp, array $camposbot): array
		{	
			if (!is_array($bemp) || count($bemp) === 0) {
				return [];
			}
			if (!is_array($camposbot) || count($camposbot)  === 0 ) {
				return [];
			}

			foreach ($camposbot as $ir => $botConfig) {
				$tabla  = $botConfig['tabla'] ?? null;
				$campos = $botConfig['cmp'] ?? [];

				if (
					!$tabla ||
					!isset($bemp[$ir]['tabla']) ||
					!isset($bemp[$ir]['datos']) ||
					!is_array($bemp[$ir]['datos'])
				) {
					continue;
				}

				// Validar que el bloque corresponda a la tabla esperada
				if ($bemp[$ir]['tabla'] !== $tabla) {
					continue;
				}

				foreach ($bemp[$ir]['datos'] as $j => $fila) {
					$index = '';

					foreach ($campos as $campo) {
						if (($campo['id'] ?? 0) == 1) {
							$nombreCampo = strtoupper($campo['campo'] ?? '');
							$index .= ($fila[$nombreCampo] ?? '') . '--';
						}
					}

					$bemp[$ir]['datos'][$j]['_INDEX'] = $index;
				}
			}
			return $bemp;
		}
		private function prepararCamposFormulario($estructura, array $catalogos, array $deff): array
		{
			if (!is_array($estructura) || !isset($estructura['cmp']) || !is_array($estructura['cmp'])) {
				return [];
			}

			$campos = $estructura['cmp'];

			foreach ($campos as $rc => $campo) {
				$nombreCampo = strtoupper($campo['campo'] ?? '');

				foreach ($campo as $re => $elem) {
					if (!is_array($elem) || !isset($elem['tipo'])) {
						continue;
					}

					if ($elem['tipo'] === 'cbo') {
						$campos[$rc][$re]['attr']['opcion'] = $this->obtenerOpcionesCampo(
							$nombreCampo,
							$catalogos
						);

						$campos[$rc][$re]['attr']['select'] = $this->obtenerValorDefault(
							$nombreCampo,
							$deff
						);
					}

					if ($elem['tipo'] === 'txt') {
						$campos[$rc][$re]['attr']['value'] = $this->obtenerValorDefault(
							$nombreCampo,
							$deff
						);
					}
				}
			}

			return $campos;
		}
		
		private function obtenerOpcionesCampo(string $nombreCampo, array $catalogos): array
		{
			$opciones = ['' => 'TODOS'];

			$comboConfig = $this->config->r_combo ?? [];

			foreach ($comboConfig as $combo) {
				$campoConfig = strtoupper($combo['campo'] ?? '');
				$catConfig   = strtoupper($combo['cat'] ?? '');

				if ($campoConfig !== $nombreCampo || $catConfig === '') {
					continue;
				}

				foreach ($catalogos as $grupo) {
					if (!is_array($grupo)) {
						continue;
					}

					foreach ($grupo as $nombreCatalogo => $items) {
						if (strtoupper($nombreCatalogo) !== $catConfig || !is_array($items)) {
							continue;
						}

						foreach ($items as $item) {
							$codigo = $item['DDIC_LISTA'] ?? '';
							$texto  = $item['DDIC_NOMBRE'] ?? '';
							$opciones[$codigo] = $texto;
						}

						return $opciones;
					}
				}
			}

			return $opciones;
		}

		private function obtenerValorDefault(string $nombreCampo, array $deff)
		{
			foreach ($deff as $fila) {
				if (!is_array($fila)) {
					continue;
				}

				foreach ($fila as $key => $valor) {
					if (strtoupper($key) === $nombreCampo) {
						return $valor;
					}
				}
			}

			return '';
		}
		
		private function obtenerCatalogos(): array
		{
			$session = session();
			$indice = service('uri')->getSegment(3) ?? ($this->config->r_dato ?? 'default');

			$key = 'catalogos_' . md5((string)$indice);

			$catalogos = $session->get($key);

			if (!is_array($catalogos) || empty($catalogos)) {
				$catalogos = $this->cargarDatosCatalogo();
				$session->set($key, $catalogos);
			}

			return $catalogos;
		}


		private function descripcionCatalogo(array $arrayA, array &$arrayB): void
		{
			$catConfig = $this->config->r_combo ?? [];

			// 1. Construir mapa de catálogos: [CAT][codigo] = nombre
			$catalogos = [];

			foreach ($arrayA as $catalogoTipo) {
				if (!is_array($catalogoTipo)) {
					continue;
				}

				foreach ($catalogoTipo as $cat => $items) {
					if (!is_array($items)) {
						continue;
					}

					foreach ($items as $item) {
						$codigo = (string) ($item['DDIC_LISTA'] ?? '');
						$nombre = $item['DDIC_NOMBRE'] ?? '';

						if ($codigo !== '') {
							$catalogos[strtoupper($cat)][$codigo] = $nombre;
						}
					}
				}
			}

			// 2. Recorrer bloques con nueva estructura: ['tabla' => ..., 'datos' => [...]]
			foreach ($arrayB as &$bloque) {
				if (!is_array($bloque)) {
					continue;
				}

				$tabla = $bloque['tabla'] ?? '';
				if ($tabla === '' || !isset($bloque['datos']) || !is_array($bloque['datos'])) {
					continue;
				}

				foreach ($catConfig as $definicion) {
					if (!is_array($definicion)) {
						continue;
					}

					$tablaConfig = $definicion['tabla'] ?? '';
					$campo       = strtoupper($definicion['campo'] ?? '');
					$cat         = strtoupper($definicion['cat'] ?? '');
					$ver         = $definicion['ver'] ?? '0';

					// Solo aplica si coincide la tabla y está visible
					if ($tablaConfig !== $tabla || $ver != '1' || $campo === '' || $cat === '') {
						continue;
					}

					foreach ($bloque['datos'] as &$registro) {
						if (!is_array($registro) || !array_key_exists($campo, $registro)) {
							continue;
						}

						$valor = (string) $registro[$campo];

						if ($valor !== '' && isset($catalogos[$cat][$valor])) {
							$registro[$campo] = $valor . '-' . $catalogos[$cat][$valor];
						}
					}
					unset($registro);
				}
			}
			unset($bloque);
		}

	private function cargarDatosCatalogo(): array
	{
		$arr = [];
		$cat = $this->config->r_combo ?? [];
		$catalogosUnicos = [];

		foreach ($cat as $elem) {
			if (!is_array($elem) || empty($elem['cat'])) {
				continue;
			}
			$nombreCatalogo = trim($elem['cat']);
			if ($nombreCatalogo === '') {
				continue;
			}
			// Evita repetir EMPRESA, ROL, BAI, etc.
			if (!isset($catalogosUnicos[$nombreCatalogo])) {
				$catalogosUnicos[$nombreCatalogo] = [$nombreCatalogo => ''];
			}
		}

		$arr = array_values($catalogosUnicos);

		if (!empty($arr)) {
			emp_catalogo($arr);
		}

		return $arr;
	}

	private function cargarParametrosCampos(): array
	{
		$arrprm = [];
		$campos = $this->config->r_filtros['cmp'] ?? [];

		if (!is_array($campos)) {
			return $arrprm;
		}

		foreach ($campos as $campo) {
			$_prm = explode('-', $campo['esp'] ?? '');
			$arrprm[$campo['campo']] = $this->datoD($_prm[0] ?? '');
		}

		return $arrprm;
	}	

	private function cargarConsulta($r_tipo = ''): array
	{
		if ($r_tipo == '' ){$r_tipo = $this->config->_det ?? '';}
		$arrb = [];
		$datos = [];

		$cat = [$this->config->r_campos] ?? [];
		if ($r_tipo == 'B' ){$cat = $this->config->r_camposbot ?? [];}
		if ($r_tipo == 'D' ){$cat = $this->config->r_camposdet ?? [];}

		if (!is_array($cat) || count($cat) === 0) {
			return $arrb;
		}

		// Obtener ID de cabecera usando el índice principal
		$_index =  $this->config->_index ?? '';
		$cam_ind_maestro = explode("|", $this->config->r_index ?? '');
		$idCabecera = $this->construirIdDesdeIndex($_index, $cam_ind_maestro);

		foreach ($cat as $r => $elem) {	

			if (!is_array($elem)) {
				continue;
			}

			$tabla = $elem['tabla'] ?? '';
			$join = $elem['join'] ?? [];
			$relacion = $elem['relacion'] ?? [];
			$whereExtra = $elem['where'] ?? [];

			// Si existe relación explícita, construir where desde cabecera
			if (!empty($relacion) && is_array($relacion)) {
				$whereDetalle = $this->construirWhereRelacion($idCabecera, $relacion);
			} else {
				// fallback al esquema antiguo por índices del detalle
				$sd = explode(",", $this->config->r_index ?? '');
				if ($r_tipo == 'B' ){$sd = explode(",", $this->config->r_indexbot ?? '');}
				if ($r_tipo == 'D' ){$sd = explode(",", $this->config->r_indexdet ?? '');}
				$cam_ind = explode("|", $sd[$r] ?? '');
				$whereDetalle = $this->construirIdDesdeIndex($_index, $cam_ind);
			}

			// Mezclar whereExtra si existe
			if (is_array($whereExtra) && !empty($whereExtra)) {
				$whereDetalle = array_merge($whereDetalle, $whereExtra);
			}

			$dat[$r] = $whereDetalle;

			$consul = 0;

			if (!empty($whereDetalle) && is_array($whereDetalle)) {
				$consul = 1;
				$datos = r_emp($whereDetalle, $tabla,$join);
			}

			if (!empty($tabla) && !$consul) {
				$datos = r_empo('', $tabla);
			}

			$arrb[] = [
            'tabla' => $tabla,
            'datos' => is_array($datos) ? $datos : []
        	];
		}

		$this->config->dat = $dat;
		return $arrb;
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
		$opcionBtn = session()->get('opcionBtn') ?? '';

		// Creamos el nuevo contenido
		$nuevoContenido = [
			'productoId' => $productoId,
			'productoName' => $productoName,
			'moduloId' => $moduloId,
			'moduloName' => $moduloName,
			'transaccionName' => $transaccionName.' - '.$opcionBtn,
			'transaccionIn' => $transaccionIn,
			'opcionBtn' => $opcionBtn
		];

		// Retornamos la respuesta en formato JSON
		return $this->response->setJSON($nuevoContenido);
	}

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// carga detalle lista boton detalle grid +-
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
		function detalle()
		{
			$indice = service('uri')->getSegment(3);			
			$this->_param($indice);	
			$this->config->r_accion = 'condet';				
			
			$totSegmento = service('uri')->getTotalSegments();
			
            $i = ($totSegmento >= 4) ? service('uri')->getSegment(4):'0';						
			$_index = ($totSegmento >= 5) ? service('uri')->getSegment(5):'0';			
			$_det = ($totSegmento >= 6) ? service('uri')->getSegment(6):'D'; 
			$_deti = ($totSegmento >= 7) ? service('uri')->getSegment(7):'0';
			$_ubic_det = ($totSegmento >= 8) ? service('uri')->getSegment(8):'0';	

			$_ubic   =  $indice."|".$i."|".$_index;		
			
			$this->config->_index = $_index;
			$this->config->_det = $_det;

			$consulta = $this->cargarConsulta();
			$dat = $this->config->dat ?? '';

			$data = [
				'id' => $dat,
				'emp' => $consulta,
				'ubic_det' => $_ubic,
				'config' => $this->config,
				'car'=> $this->obtenerCatalogos()
			]; 
			
			$data['emp']  = $this->agregarIndex(
				$data['emp'],
				$this->config->r_camposdet ?? []
			);

			$this->descripcionCatalogo($data['car'],$data['emp']);
			log_message('debug', 'detalle-data: ' . print_r($data, true));
			return view('empresa/emp_dlst', $data);
		}
		private function construirWhereRelacion(array $idCabecera, array $relacion): array
		{
			$where = [];

			foreach ($relacion as $campoCabecera => $campoDetalle) {
				if (array_key_exists($campoCabecera, $idCabecera)) {
					$where[$campoDetalle] = $idCabecera[$campoCabecera];
				}
			}

			return $where;
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

			$camposConfig = $this->getCamposConfig($_det, $_deti);										
				$tabla = $camposConfig['tabla'];
				$cam_ind = $camposConfig['cam_ind'];
				$campos = $camposConfig['campos'];
			
			$dat = $this->construirIdDesdeIndex($_indexc, $cam_ind);
    		$this->id = $dat;

			$arrprm = $this->construirValoresPorDefecto($campos ?? [], $dat ?? [], $_det);
								
				$arrdf[] = $arrprm;  								
				$data['def'] = $arrdf;
				$data['emp'] = null;			
				$data['car'] = $this->obtenerCatalogos();				
				$data['indexc'] = $_indexc;
				$data['det'] = $_det;
				$data['deti'] = $_deti;
				$data['ubic'] = $_ubic;
				$data['ubic_det'] = $_ubic_det;
				$data['config'] = $this->config;

				return view('empresa/emp_cam', $data);
		}

		private function construirValoresPorDefecto(array $campos, array $dat = [], string $_det = '0'): array
		{
			$iddato = '';
			$arrprm = [];

			foreach ($campos as $campo) {
				$nombreCampo = $campo['campo'] ?? null;
				$esId = isset($campo['id']) && (int)$campo['id'] === 1;

				if (!$nombreCampo) {
					continue;
				}

				if ($esId && array_key_exists($nombreCampo, $dat)) {
					$iddato .= '|' . $dat[$nombreCampo];
				}
			}

			foreach ($campos as $campo) {
				$nombreCampo = $campo['campo'] ?? null;
				$esp = $campo['esp'] ?? '';
				$esId = isset($campo['id']) && (int)$campo['id'] === 1;

				if (!$nombreCampo) {
					continue;
				}

				$_prm = explode('-', $esp);

				if (count($_prm) > 1) {
					$parametro = $_prm[1];

					if ($_det === 'D') {
						$parametro .= '|' . $nombreCampo . $iddato;
					}

					$arrprm[$nombreCampo] = $this->datoD($parametro);
				}

				if ($esId && array_key_exists($nombreCampo, $dat)) {
					$arrprm[$nombreCampo] = $dat[$nombreCampo];
				}
			}

			return $arrprm;
		}

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// btn graba registo envia request crea registro -- nuevo
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
		function recibirdatos() {

			// Obtener la instancia del servicio de validación
			$validation = Services::validation();
		
			$indice = service('uri')->getSegment(3);                
			$this->_param($indice);
		
			$_indexc = service('uri')->getSegment(5);
			$_det = service('uri')->getSegment(6);
			$_deti = service('uri')->getSegment(7);
		
			// Verificar si la solicitud es AJAX
			if (!$this->request->isAJAX()) {
				// redirect('404');
				echo "|0|no ajax"; exit;
			}
		
			$camposConfig = $this->getCamposConfig($_det, $_deti);
										
				$tabla = $camposConfig['tabla'];
				$cam_ind = $camposConfig['cam_ind'];
				$campos = $camposConfig['campos'];
				$___prm = $camposConfig['prm'];

			$campos = $campos ?? [];

			$dat = $this->construirIdDesdeIndex($_indexc, $cam_ind);
			$this->id = $dat;

			$rules = $this->construirReglasValidacion($campos);				
							
			// Obtener los datos del formulario enviado por AJAX
			$data = $this->request->getPost();  // Usar getPost en lugar de $_REQUEST
			unset($data['url']);  // Eliminar 'url' si está presente en los datos
		
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
		
				$data = $this->aplicarDatosEspecialesIngreso($campos, $data);
        		$data = $this->normalizarCamposMultiples($campos, $data);
		
				// Procesar la creación de los datos
				//$tabla = $___prm[4];
		
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
								$_xml = $this->Axml($data);
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

		private function construirIdDesdeIndex(string $_indexc, array $cam_ind): array
		{
			$cmp_val = explode('--', $_indexc);

			array_pop($cmp_val);
			array_pop($cam_ind);

			$this->ajustarIndices($cmp_val, $cam_ind);

			return array_combine($cam_ind, $cmp_val) ?: [];
		}

		private function aplicarDatosEspecialesIngreso(array $campos, array $data): array
		{
			foreach ($campos as $campo) {
				$nombreCampo = $campo['campo'] ?? null;
				$esp = $campo['esp'] ?? '';

				if (!$nombreCampo || $esp === '') {
					continue;
				}

				$_prm = explode('-', $esp);

				if (count($_prm) > 1 && trim($_prm[1]) !== '') {
					$parametro = $_prm[1];

					if (strpos($parametro, 'SECUENCIA') !== false) {
						$parametro .= '|' . $nombreCampo;
					}

					if (!array_key_exists($nombreCampo, $data)) {
						$data[$nombreCampo] = $this->datoD($parametro, 'E');
					}
				}
			}

			return $data;
		}

		private function construirReglasValidacion(array $campos): array
		{
			$rules = [];

			foreach ($campos as $campo) {
				$lst = $campo['lst'] ?? '';
				$lista = explode('|', $lst);

				if (($lista[1] ?? 0) != 1) {
					continue;
				}

				foreach ($campo as $elem) {
					if (!is_array($elem)) {
						continue;
					}

					if (($elem['tipo'] ?? null) === 'rls') {
						$field = $elem['attr']['field'] ?? null;
						$rule  = $elem['attr']['rules'] ?? null;

						if ($field && $rule) {
							$rules[$field] = $rule;
						}
					}
				}
			}

			return $rules;
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
						
				$dat = $this->construirIdDesdeIndex($_index, $cam_ind);
       		    $this->id = $dat;
											
				$data['emp'] = r_emp($this->id,$tabla);
				$data['def'] = null;								
				$data['car'] = $this->obtenerCatalogos();
				$data['indexc'] = $_indexc;
				$data['det'] = $_det;
				$data['deti'] = $_deti;
				$data['ubic'] = $_ubic;
				$data['ubic_det'] = $_ubic_det;
                $data['config'] = $this->config;				

				return view('empresa/emp_cam', $data);				
				
		}

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// btn graba registo envia request actualiza registro -- actualizar
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
		function Modificardatos(){
			
			$indice = service('uri')->getSegment(3);										
			$this->_param($indice);

			$_det = service('uri')->getSegment(6);
			$_deti = service('uri')->getSegment(7);
			
			$data = $this->request->getPost();
			unset($data['url']);
			$dat = $data;			
			
			$camposConfig = $this->getCamposConfig($_det, $_deti);
										
				$tabla = $camposConfig['tabla'];
				$cam_ind = $camposConfig['cam_ind'];
				$campos = $camposConfig['campos'];					
				$___prm = $camposConfig['prm'];
				$___prm[4] = $tabla;

				$campos = $campos ?? [];

				$data = $this->aplicarDatosEspeciales($campos, $data);
				$this->id = $this->extraerCamposId($campos, $data);
				$data = $this->normalizarCamposMultiples($campos, $data);
						
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
			echo json_encode($respuesta);
			
			//if ($respuesta->errCodigo == "0" ){
			//	echo "<div class = 'alert alert-success' >TRANSACCION EXITOSA</div>";
			    
			//}else{
			//	echo "<div class = 'alert alert-danger' > Error: ". $respuesta->errCodigo . " - " . $respuesta->errMenssa . "</div>";
			//}

			//$this->___index();
			
		}

		private function aplicarDatosEspeciales(array $campos, array $data): array
		{
			foreach ($campos as $campo) {
				$nombreCampo = $campo['campo'] ?? null;
				$esp = $campo['esp'] ?? '';

				if (!$nombreCampo || $esp === '') {
					continue;
				}

				$_prm = explode('-', $esp);

				if (count($_prm) >= 3) {
					$tieneEspecial = trim($_prm[2]) !== '';

					if ($tieneEspecial && !array_key_exists($nombreCampo, $data)) {
						$data[$nombreCampo] = $this->datoD($_prm[1], 'E');
					}
				}
			}

			return $data;
		}

		private function extraerCamposId(array $campos, array $data): array
		{
			$camposId = [];

			foreach ($campos as $campo) {
				$nombreCampo = $campo['campo'] ?? null;
				//$esId = isset($campo['id']) && (int)$campo['id'] !== 0;
				$esId = isset($campo['id']) && (int)$campo['id'] === 1;

				if ($esId && $nombreCampo) {
					$camposId[] = strtoupper($nombreCampo);
				}
			}

			if (empty($camposId)) {
				return [];
			}

			$resultado = [];

			foreach ($data as $key => $value) {
				if (in_array(strtoupper($key), $camposId, true)) {
					$resultado[$key] = $value;
				}
			}

			return $resultado;
		}

		private function normalizarCamposMultiples(array $campos, array $data): array
		{
			foreach ($campos as $campo) {
				$nombreCampo = $campo['campo'] ?? null;

				if (!$nombreCampo || !array_key_exists($nombreCampo, $data)) {
					continue;
				}

				foreach ($campo as $elem) {
					if (!is_array($elem)) {
						continue;
					}

					$tipo = $elem['tipo'] ?? null;
					$attr = $elem['attr']['attr'] ?? '';

					if (
						$tipo === 'cbo' &&
						strpos($attr, 'multiple="multiple"') !== false &&
						is_array($data[$nombreCampo])
					) {
						$data[$nombreCampo] = implode('|', $data[$nombreCampo]);
					}
				}
			}

			return $data;
		}

		// Función para obtener la configuración de campos según el valor de $_det
		private function getCamposConfig($_det, $_deti): array
		{
			$camposConfig = [];

			session()->set('opcionBtn', '');

			if ($_det == 'D') {
				$camposCon = $this->config->r_camposdet ?? [];
				$sd = explode(",", $this->config->r_indexdet ?? '');
				$cam_ind = explode("|", $sd[$_deti] ?? '');
				$camposConfig['campos'] = $camposCon[$_deti]['cmp'] ?? [];
				$camposConfig['prm'] = explode("|", $camposCon[$_deti]['prm'] ?? '');
				$camposConfig['tabla'] = $camposCon[$_deti]['tabla'] ?? '';
				session()->set('opcionBtn', $camposCon[$_deti]['title']);
			} elseif ($_det == 'B') {
				$camposCon = $this->config->r_camposbot ?? [];
				$sd = explode(",", $this->config->r_indexbot ?? '');
				$cam_ind = explode("|", $sd[$_deti] ?? '');
				$camposConfig['campos'] = $camposCon[$_deti]['cmp'] ?? [];
				$camposConfig['prm'] = explode("|", $camposCon[$_deti]['prm'] ?? '');
				$camposConfig['tabla'] = $camposCon[$_deti]['tabla'] ?? '';
				session()->set('opcionBtn', $camposCon[$_deti]['title']);
			} else {
				$camposCon = $this->config->r_campos ?? [];
				$cam_ind = explode("|", $this->config->r_index ?? '');
				$camposConfig['campos'] = $camposCon['cmp'] ?? [];
				$camposConfig['prm'] = explode("|", $camposCon['prm'] ?? '');
				$camposConfig['tabla'] = $camposCon['tabla'] ?? '';
			}

			$camposConfig['cam_ind'] = $cam_ind ?? [];

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
			
			$dat = $this->construirIdDesdeIndex($_index, $cam_ind);
       		$this->id = $dat;

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
					
					if ($ind == 'USUARIO') {
						$rsp = session('usuario') ?? 'JULIO';
					}
					
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