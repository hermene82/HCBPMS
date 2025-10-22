<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class empresa_model extends CI_Model
{
    public $tabla;

   function __construct(){
    parent::__construct();
   }

   function WSconsume($proceso){
    $peticionA = array('peticion' =>  array( array( 'idPeticion' => '0',
                                                    'agencia' => '',
                                                    'canal' => '',
                                                    'fechaHora' => '',
                                                    'hostName' => '',
                                                    'idMensaje' => '',
                                                    'idUsuario' => '',
                                                    'ip' => '',
                                                    'localidad' => '',
                                                    'macAddress' => '',
                                                    'token' => '',
                                                    'cliente' => '',
                                                    'proceso' => $proceso
                                                ))
                                                );
    $peticionJ = json_encode($peticionA);
    echo print_r($peticionJ,true);  

                    $url = 'http://192.168.100.8/hcws/apis/api/v1/SolicitudDatos';				
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
					curl_setopt($ch, CURLOPT_POSTFIELDS,$peticionJ);
					//obtenemos la respuesta
					$respuesta = curl_exec($ch);
					
					if($errno = curl_errno($ch)) {
						$error_message = curl_strerror($errno);
						echo "cURL error ({$errno}):\n {$error_message}";
					}					
					
					// Se cierra el recurso CURL y se liberan los recursos del sistema
                    curl_close($ch);
      
    //$respuestaj = json_decode($respuesta,true);   
	//echo print_r($respuesta,true); 				
    //return $respuestaj[0]['response'][0]['respuesta'];
    return $respuesta;
   } 


    function crear_emp($data,$tabla){
        $proceso = array( array('idProceso' => '0',
                                'proceso' => 'ING',
                                'type' => 'TB',
                                'struct' => $tabla,
                                'condicion' => '',
                                'data' => $data,
                                'id' => '',
                                'param' => '',
                                'usuario'=>'JULIO',
                                'transaccion'=>'00000',
                                'referencia'=>'crear_emp'
         ));

        $respuesta = json_decode($this->WSconsume($proceso));
        return $respuesta[0]->response;
   }

    function emp(){   
        $_tab = explode('|',$this->config->item('r_tabla')) ;
        $this->tabla = $_tab[2];

        $proceso = array( array('idProceso' => '0',
                                'proceso' => 'CON',
                                'type' => 'TB',
                                'struct' => $this->tabla,
                                'condicion' => '',
                                'data' => '',
                                'id' => '',
                                'param' => '',
                                'usuario'=>'JULIO',
                                'transaccion'=>'00000',
                                'referencia'=>'emp'
                        ));

        $respuesta = json_decode($this->WSconsume($proceso));
        //return $respuesta[0]->response;
        return  json_decode(json_encode($respuesta[0]->response->respuesta),true);
    }

    function errBase(){
            //if ($this->db->_error_message() !== null) {
            //$error = $this->db->_error_message();
            //if (isset($error['message'])) {
            //    return $error['message'];
            //}
			//}else{ return '';}
    }


    function cat($dic,$id){
        //$cursor = $this->db->get_cursor();
        //$params = array(array('name'=>':i_cdic_nombre', 'value'=>$dic , 'type'=>SQLT_CHR, 'length'=>-1),
        //                array('name'=>':r_curso', 'value'=>&$cursor, 'type'=>OCI_B_CURSOR, 'length'=>-1)
        //                );
        //$this->db->stored_procedure('PQ_PRO_PROCESOS','SP_CON_DIC',$params);
        //oci_fetch_all($cursor, $row, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        //oci_free_statement($cursor);
        //return $row;


        switch ($dic) {
            case 'CLIENTE':
                $select = 'a.codigo as DDIC_LISTA,a.comercial as DDIC_NOMBRE';  
                $proceso = array( array('idProceso' => '0',
                'proceso' => 'CON',
                'type' => 'TB',
                'struct' =>'admin.cliente AS a',
                'condicion' => array('select'=> $select,
                                    'where'=>'',
                                    'wherein'=>'',
                                    'join'=> '',
                                    'like'=> array('a.tpcli'=> 'C')
                                    ),
                'data' => '',
                'id' => '',
                'param' => '',
                'usuario'=>'JULIO',
                'transaccion'=>'00000',
                'referencia'=>'cat'
                ));
                break;
            case 'EMPRESA':
                $select = 'a.codigo as DDIC_LISTA,a.comercial as DDIC_NOMBRE';  
                $proceso = array( array('idProceso' => '0',
                'proceso' => 'CON',
                'type' => 'TB',
                'struct' =>'admin.cliente AS a',
                'condicion' => array('select'=> $select,
                                    'where'=>  '',
                                    'wherein'=>'',
                                    'join'=> '',
                                    'like'=> array('a.tpcli'=> 'E')
                                    ),
                'data' => '',
                'id' => '',
                'param' => '',
                'usuario'=>'JULIO',
                'transaccion'=>'00000',
                'referencia'=>'cat'
                ));
                break;
            case 'ITEM':
                $select = 's.codigo as DDIC_LISTA, s.nombre as DDIC_NOMBRE, s.empresa as NOMBRE1,s.ces_iva as NOMBRE2';  
                $proceso = array( array('idProceso' => '0',
                'proceso' => 'CON',
                'type' => 'TB',
                'struct' =>'factura.itemsrv AS s',
                'condicion' => array('select'=> $select,
                                    'where'=>  '',
                                    'wherein'=>'',
                                    'join'=> ''
                                    ),
                'data' => '',
                'id' => '',
                'param' => '',
                'usuario'=>'JULIO',
                'transaccion'=>'00000',
                'referencia'=>'cat'
                ));
                break;
            default:
                $select = 'b.codigo as DDIC_LISTA,b.nombre as DDIC_NOMBRE';  
                $proceso = array( array('idProceso' => '0',
                'proceso' => 'CON',
                'type' => 'TB',
                'struct' =>'admin.clista AS a',
                'condicion' => array('select'=> $select,
                                    'where'=>  array('a.nombre'=> $dic),
                                    'wherein'=>'',
                                    'join'=>array(array( 'join' => 'admin.dlista as b',
                                                    'on' => "a.lista = b.lista and b.estado = 'A'",
                                                    'type' => 'inner'
                                    ))),
                'data' => '',
                'id' => '',
                'param' => '',
                'usuario'=>'JULIO',
                'transaccion'=>'00000',
                'referencia'=>'cat'
                ));
        }






        $respuesta = json_decode($this->WSconsume($proceso));
        //$consulta =  json_decode(json_encode($response->respuesta),true);
        //return $respuesta[0]->response;
        return  json_decode(json_encode($respuesta[0]->response->respuesta),true);

    }

    function catalogo($dic,$id){
        //$cursor = $this->db->get_cursor();
        //$params = array(array('name'=>':i_cdic_nombre', 'value'=>$dic , 'type'=>SQLT_CHR, 'length'=>-1),
        //                array('name'=>':r_curso', 'value'=>&$cursor, 'type'=>OCI_B_CURSOR, 'length'=>-1)
        //                );
        //$this->db->stored_procedure('PQ_PRO_PROCESOS','SP_CON_CATALOGO',$params);
        //oci_fetch_all($cursor, $row, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        //oci_free_statement($cursor);
        //return $row;
        
        //The available JOIN types are:
        //    inner
        //    left
        //    right
        //    outer
        //    left outer
        //    right outer
        $select = 'b.*';  
        $proceso = array( array('idProceso' => '0',
        'proceso' => 'CON',
        'type' => 'TB',
        'struct' =>'admin.clista AS a',
        'condicion' => array('select'=> $select,
                             'where'=>  array('a.nombre'=> $dic),
                             'wherein'=>'',
                             'join'=>array(array( 'join' => 'admin.dlista as b',
                                            'on' => "a.lista = b.lista and b.estado = 'A'",
                                            'type' => 'inner'
                              ))),
        'data' => '',
        'id' => '',
        'param' => '',
        'usuario'=>'JULIO',
        'transaccion'=>'00000',
        'referencia'=>'catalogo'
        ));

        $respuesta = json_decode($this->WSconsume($proceso));
        //return $respuesta[0]->response;
        return  json_decode(json_encode($respuesta[0]->response->respuesta),true);
    }

    function r_emp($id,$tabla){
        //$this->db->where($id);
        //$query = $this->db->get($tabla);
        //return $query;
        $proceso = array( array('idProceso' => '0',
                                'proceso' => 'CON',
                                'type' => 'TB',
                                'struct' => $tabla,
                                'condicion' => array('select'=>'',
                                                     'where'=> $id,
                                                     'wherein'=>'',
                                                     'join'=>''),
                                'data' => '',
                                'id' => '',
                                'param' => '',
                                'usuario'=>'JULIO',
                                'transaccion'=>'00000',
                                'referencia'=>'r_emp'
                        ));

        $respuesta = json_decode($this->WSconsume($proceso));
        //return $respuesta[0]->response;
        //echo print_r($respuesta[0]->response,true);
        return  json_decode(json_encode($respuesta[0]->response->respuesta),true);
    }

    function r_emps($id,$tabla,$select){
        //$this->db->where($id);
        //$query = $this->db->get($tabla);
        //return $query;
        $proceso = array( array('idProceso' => '0',
                                'proceso' => 'CON',
                                'type' => 'TB',
                                'struct' => $tabla,
                                'condicion' => array('select'=>$select,
                                                     'where'=> $id,
                                                     'wherein'=>'',
                                                     'join'=>''),
                                'data' => '',
                                'id' => '',
                                'param' => '',
                                'usuario'=>'JULIO',
                                'transaccion'=>'00000',
                                'referencia'=>'r_emps'
                        ));

        $respuesta = json_decode($this->WSconsume($proceso));
        //return $respuesta[0]->response;
        return  json_decode(json_encode($respuesta[0]->response->respuesta),true);
    }
	
	function r_empo($id,$tabla){
        //if ($tabla == 'RPT_GUIA'){
		//	$this->db->order_by("SECUENCIA", "asc");
		//	}		
		//$query = $this->db->get($tabla);
        //return $query;
        $proceso = array( array('idProceso' => '0',
                                'proceso' => 'CON',
                                'type' => 'TB',
                                'struct' => $tabla,
                                'condicion' => '',
                                'data' => '',
                                'id' => '',
                                'param' => '',
                                'usuario'=>'JULIO',
                                'transaccion'=>'00000',
                                'referencia'=>'r_empo'
                        ));

        $respuesta = json_decode($this->WSconsume($proceso));
        //return $respuesta[0]->response;
        return  json_decode(json_encode($respuesta[0]->response->respuesta),true);
    }
	

    function reg ($select = null , $where = null ){

       // if (is_array($select )){
       //     $this->bd->select($select);
       // }
       // if (is_array($where)){
       //     $this->bd->select($where);
       // }
       //     return $this->db->get($this->tabla)-> result();
    }

    public function actualizar_emp($id,$data,$tabla){
        //$this->db->where( $id);
        //$respuesta = $this->db->update($tabla, $data);
        //return $respuesta;
        $proceso = array( array('idProceso' => '0',
                                'proceso' => 'ACT',
                                'type' => 'TB',
                                'struct' => $tabla,
                                'condicion' => array('select'=>'',
                                                     'where'=> $id,
                                                     'wherein'=>'',
                                                     'join'=>''),
                                'data' => $data,
                                'id' => '',
                                'param' => '',
                                'usuario'=>'JULIO',
                                'transaccion'=>'00000',
                                'referencia'=>'actualizar_emp'
                        ));

        $respuesta = json_decode($this->WSconsume($proceso));
        return $respuesta[0]->response;
    }

    public function eliminar_emp($id,$tabla){
        //$this->db->where($id);
        //$this->db->delete($tabla);
        $proceso = array( array('idProceso' => '0',
                                'proceso' => 'ELI',
                                'type' => 'TB',
                                'struct' => $tabla,
                                'condicion' => array('select'=>'',
                                                     'where'=> $id,
                                                     'wherein'=>'',
                                                     'join'=>''),
                                'data' => '',
                                'id' => '',
                                'param' => '',
                                'usuario'=>'JULIO',
                                'transaccion'=>'00000',
                                'referencia'=>'eliminar_emp'
                        ));

        $respuesta = json_decode($this->WSconsume($proceso));
        return $respuesta[0]->response;
    }

    function emp_sp($data,$tabla){

        //$t = explode("_",$this->config->item('r_tabla'));
        //$cursor = $this->db->get_cursor();
        //$params = array(array('name'=>':r_curso', 'value'=>&$cursor, 'type'=>OCI_B_CURSOR, 'length'=>-1)
        //          );
        //$this->db->stored_procedure('PQ_PRO_PROCESOS','pr_con_'.$t[0],$params);
        //oci_fetch_all($cursor, $row, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        //oci_free_statement($cursor);
        //return $row;

        $proceso = array( array('idProceso' => '0',
                'proceso' => 'PRO',
                'type' => 'SP',
                'struct' => $tabla,
                'condicion' => '',
                'data' => '',
                'id' => '',
                'param' => $data,
                'usuario'=>'JULIO',
                'transaccion'=>'00000',
                'referencia'=>'emp_sp'
        ));

        $respuesta = json_decode($this->WSconsume($proceso));
        return $respuesta[0]->response;

    }

    function emp_sprcursor($paq,$prc,$params,$cursor){

        //$this->db->stored_procedure($paq,$prc,$params);
        //oci_fetch_all($cursor, $row, null, null, OCI_FETCHSTATEMENT_BY_ROW);  
        //return $row;

    }
	
	function emp_sprcursor_sec($params){
        //return $this->db->stored_procedure_sec($params);
        //echo $params;
        $cmp_prm = explode("|",$params);
        $proceso = array( array('idProceso' => '0',
                'proceso' => 'CON',
                'type' => 'TB',
                'struct' => $cmp_prm[0],
                'condicion' => array('select'=>'IFNULL(MAX('.$cmp_prm[1] .'),0)+1 as SECUENCIA',
                                     'where'=> '',
                                     'wherein'=>'',
                                     'join'=>''),
                'data' => '',
                'id' => '',
                'param' => '',
                'usuario'=>'JULIO',
                'transaccion'=>'00000',
                'referencia'=>'emp_sprcursor_sec'
        ));

        $respuesta = json_decode($this->WSconsume($proceso));
        //return $respuesta[0]->response;
        return  json_decode(json_encode($respuesta[0]->response->respuesta),true);
    }

    function emp_sprc($paq,$prc,$params){

        //$this->db->stored_procedure($paq,$prc,$params);

        


    }


    function PR_PRO_PENDIENTE($params){
        
        
        


    }
   

    function emp_catalogo(&$data){

        $r = 0;
        if (is_array($data)) {
       
        foreach ($data as $items => $items_value) {            
            foreach ($items_value as $item => $item_value) {      
            $pro[] =  array('idProceso' => $r ,
                'proceso' => 'PRO',
                'type' => 'SP',
                'struct' => 'admin.consulta_catalogo',
                'condicion' => '',
                'data' => '',
                'id' => '',
                'param' => array('CATALOGO' => $item),
                'usuario'=>'JULIO',
                'transaccion'=>'00000',
                'referencia'=>'emp_catalogo'
            );
            } 
            $r++;
            }
        }

        $proceso = ($pro);
        $respuesta = json_decode($this->WSconsume($proceso));


        $r = 0;
        if (is_array($data)) {      
        foreach ($data as $items => $items_value) {            
            foreach ($items_value as $item => $item_value) {  
                $data[$r][$item] = json_decode(json_encode($respuesta[$r]->response->respuesta),true);
            } 
            $r++;
            }
        }       

    }    


}