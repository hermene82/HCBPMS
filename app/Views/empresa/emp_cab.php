<?php session_start(); ?>

<!doctype html>
<html>
<head>

<style>

.modal{
 //padding: 0 !important;
 //overflow: hidden;
}
.modal-dialog {
  max-width: 80% !important;
  //height: 95%;
  //padding: 0;
  //margin: 0;
  margin-right: 0;
  margin-left: 0;
}

.modal-content {
  //border-radius: 0 !important;
  //height: 95%;
}

.modalm {
  //border-radius: 0 !important;
  //height: 95%;
}
#drag {
            background-color: rgb(89, 0, 255);
            height: 60px;
            width: 150px;
        }
</style>


	
<link type="text/css" rel="stylesheet" href="../guia/application/views/empresa/style/style.css" >
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
 
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<!-- Latest compiled and minified CSS -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css"> -->
<link rel="stylesheet" href="../hdocs/style/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-en_US.min.js"></script>
<link rel = "stylesheet" href = "https://cdn.rawgit.com/tonystar/bootstrap-float-label/v4.0.1/dist/bootstrap-float-label.min.css"/>
<link href="https://unpkg.com/bootstrap-table@1.14.2/dist/bootstrap-table.min.css" rel="stylesheet"/>
<script src="https://unpkg.com/bootstrap-table@1.14.2/dist/bootstrap-table.min.js"></script>


<script type="text/javascript">
$(function () {
//$(".fecha").datepicker({ showon: "button", });
//$("#FHASTA").datepicker({ showon: "button", });
$(".selectpicker").selectpicker();
$('.btn dropdown-toggle btn-light bs-placeholder').addClass('w-100');
$('.dropdown-toggle').addClass('w-100');
});
</script>

    <script type="text/javascript">
        $(document).ready(function () {
            //window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3 });
            //window.test = $('.testsel').SumoSelect({okCancelInMulti:true });
			
					$('#formarch').on('submit', function(event){
					  event.preventDefault();
					  $.ajax({
					   url:"<?php echo base_url(); ?>empresa/import",
					   method:"POST",
					   data:new FormData(this),
					   contentType:false,
					   cache:false,
					   processData:false,
					   success:function(data){
						//$('#file').val('');
						//load_data();
						alert(data);
					   }
					  })
					 });

			
        });

        function add_person(btn_g,btn_c)
        {

            if (btn_g == 'S'){document.getElementById("btnSave").style.display = '';}else{document.getElementById('btnSave').style.display = 'none';}
            if (btn_c == 'S'){document.getElementById("btnclose").style.display = '';}else{document.getElementById('btnclose').style.display = 'none';}
            //save_method = 'add';
            //$('#form')[0].reset(); // reset form on modals
            //$('.form-group').removeClass('has-error'); // clear error class
            //$('.help-block').empty(); // clear error string
			$('#modal_form').modal('show'); // show bootstrap modal
			
            //$('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
        }
    </script>

    <title>empresa</title>

    <script type = "text/javascript">
	 $(document).ready(() => {
     $(function () {
        $("#drag").draggable();
		$("#modal_form").draggable();
       });      
     });
	
        $(document).ready(function(){          
            var request;
			     
			    
//$(".fecha").datepicker({ showon: "button", });
//$("#FHASTA").datepicker({ showon: "button", });
$(".selectpicker").selectpicker();
$('.btn dropdown-toggle btn-light bs-placeholder').addClass('w-100');
            //alert ('tabla');
            $('#myTable').DataTable({
                //"bJQueryUI" :  true ,
                "sPaginationType" :  "full_numbers" ,
                "aaSorting" :  [[ 0 ,  "desc" ]] ,
    "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            
            var nb_cols = api.columns().nodes().length;
	    var j = 3;
            var title = '';
	    while(j < nb_cols){
            
            title = api.column( j ).header();

            //if (j == 11){
            if ($(title).html() == 'COSTO' || $(title).html() == 'TOTAL') {      

            // Total over all pages
            total = api
                .column( j )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( j, { page: 'current'} )
                .data()
                .reduce( function (a, b) {			
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( j ).footer() ).html(
                '$'+pageTotal.round(2) +' E'+ total.round(2) +' '
            );
            } // if
            j++;
            } // while

        }

            });

        });

       /* Storing user's device details in a variable*/
        let details = navigator.userAgent;
  
        /* Creating a regular expression 
        containing some mobile devices keywords 
        to search it in details string*/
        let regexp = /android|iphone|kindle|ipad/i;
  
        /* Using test() method to search regexp in details
        it returns boolean value*/
        let isMobileDevice = regexp.test(details);
  
function esMobil(){
	    if (isMobileDevice) {
            alert ('es Mobil');
        } else {
            alert ('es Desktop');
        }
};

function roundToTwo(num) {    
    return +(Math.round(num + "e+2")  + "e-2");
};

function cambioss(param,ind) {
    var camp = param.split('@');
    //console.log("camp:" + camp);
	for (var i = 0; i< camp.length; i++){
		
		var cm = camp[i].split('|');
		//console.log("cm:" + cm);
		var dt = cm[1].split(',');
		//console.log("dt:" + dt);
		
		var p = cm[0]+'|';
		//console.log("p1:" + p);
		//console.log("campo1:" + cm[0]);
		
		var campo = '#'+cm[0];
		
		for (var j = 0; j< dt.length; j++){
			var cmp = dt[j].split('-');
			
			//console.log("cmp0:" + cmp[0]);
			//console.log("cmp1:" + cmp[1]);
			
			var dto = document.getElementById(cmp[0]);
			var value = dto.options[dto.selectedIndex].value;

			//console.log("dto:" + value);
			
			p = p + cmp[1] + '-' + value + ";" ;
						
			//console.log("p2:" + p);
		}
		//console.log("p:" + i);
		//console.log("p:" + p);
    	//console.log("campo:" + campo);
		opcionfill(campo,p,ind);		
	}
     
};

function opcionfill(campo,p,ind){
		$.post("<?php echo base_url(); ?>empresa/fill/"+ind, {
			id : p
		}, function(data) {
			console.log("data:" + data);
			console.log("c:" + campo);
			$(campo).html(data);
			$(".selectpicker").selectpicker('refresh');
		});
	
}

Number.prototype.round = function(places) {
  return +(Math.round(this + "e+" + places)  + "e-" + places);
};
        function load_tabla_det(){
			$('#detTable').bootstrapTable({
					striped: true,
					pagination: true,
					search:true
				});			
		}     

        //window.onload = function(){marca()};

        function load_tabla (){
            //alert ('tabla_o');
			$(".selectpicker").selectpicker();
			$('.btn dropdown-toggle btn-light bs-placeholder').addClass('w-100');
			$('.dropdown-toggle').addClass('w-100');
            $('#myTable').DataTable({
                //"bJQueryUI" :  true ,
                "sPaginationType" :  "full_numbers" ,
                "aaSorting" :  [[ 0 ,  "desc" ]] ,
    "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            
            var nb_cols = api.columns().nodes().length;
	    var j = 3;
            var title = '';
	    while(j < nb_cols){

            title = api.column( j ).header();


            //if (j == 11){
            if ($(title).html() == 'COSTO' || $(title).html() == 'TOTAL') {      

            // Total over all pages
            total = api
                .column( j )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( j, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( j ).footer() ).html(
                '$'+pageTotal.round(2) +' E'+ total.round(2) +' '
            );
            } // if
            j++;
            } // while

        }
            });
        };

        function consultar(evt,acc,ind) {
            //alert('hooooola'+acc+ind);
            var raccc ='';
            if (acc == 'con'){
                raccc ='consfiltro' ;
            }else{
                raccc ='consfiltro' ;
            }

            //var fr = $('#form').serialize();
            //alert fr ;

            request = $.ajax({
             type: 'post',
             url: '<?= base_url();?>' + 'empresa/' + raccc + '/' + ind,
             cache: false,
             data: $('#formf').serialize(),
             beforeSend: function() {
				$(".contenido").css("display",""); 
                $(".contenido").html("<img src='../guia/images/espera.gif'>");
				//$(".contenido").style.width = '400px';
             },
             success: function(response){
             //console.log( response );
             //alert(response);
             //$(".contenido").html("&nbsp;");
			 $(".contenido").css("display","none");
			 //$(".contenido").style.width = '0px';
             document.getElementById('filtro').innerHTML= response;
             load_tabla ()
                // return false;
             //$("#mensaje").html(msj);
             //if (msj == 'Registro Grabado con exito'){
             //   jQuery.fn.reset = function(){
             //    $(this).each(function(){this.reset();});
             //}
             //    alert("no_grb");
             //    return false;
             //    $('#form').reset();
             //}

             //alert("no_grb");
             //return true;
             //alert(msj);
             //$('#form').html(response);
             }
             });
            request.done(function (response, textstatus, jqxhr) {
             console.log("r:" + response);
             var str = response;
                 //alert ("doneee"+str);
             //--var arr = str.split('|');
             //console.log(arr[1]);
             //--if (arr[1] == "0") {
             //console.log("b" + arr[1]);
             //eje = false;
             //console.log("b" + eje);
             //return false;
             //--    alert("Transaccion Exitosa");
             //--} else {
             //console.log("b" + arr[1]);
             //eje = true;
             //console.log("b" + eje);
             //return true;
             //--    alert("Error:".arr[2]);
             //--}
             });
            request.fail(function (response, textstatus, thrown) {
                var str = response;
                //alert ("failll"+str);
             //conosle.log("e:" + textstatus);
             //eje = true;
             });
            request.always(function () {
             console.log("termino");
                //var str = response;
                //    alert ("alwaqswww"+str);
                //$('#form').html(response);
             });
            //console.log("eje" + eje);
            //alert(eje);
            //return eje;


        //    grab(acc);
        //if (grb(acc)) {
        //    alert("no graba");
        // }else{
        //    evt.preventDefault();
        // }

        };



        function graba(evt,acc,ind,det='A',deti='0',item='',item_det='',indexc='') {
            console.log('hooooola'+acc+'-'+ind+'-'+det+'-'+deti+'-'+item+'-'+item_det+'-'+indexc);
            var raccc ='';
			var str ='';
            if (acc == 'mod'){
                raccc ='Modificardatos' ;
            }else{
                raccc ='recibirdatos' ;
            }

            var fr = $('#form').serialize();
            console.log (fr) ;
            console.log ('<?= base_url();?>' + 'empresa/' + raccc + '/' + ind + '/0/' + indexc +'/'+ det + '/' + deti);
            request = $.ajax({
             type: 'post',
             url: '<?= base_url();?>' + 'empresa/' + raccc + '/' + ind + '/0/' + indexc + '/'+ det + '/' + deti,
             cache: false,
             data: $('#form').serialize(),
             success: function(response){
             console.log("success:" + response );
			 document.getElementById("mensajefin").innerHTML = response;
             console.log(response);
             str = response;
                // return false;
             //$("#mensaje").html(msj);
             //if (msj == 'Registro Grabado con exito'){
             //   jQuery.fn.reset = function(){
             //    $(this).each(function(){this.reset();});
             //}
             //    alert("no_grb");
             //    return false;
             //    $('#form').reset();
             //}

             //alert("no_grb");
             //return true;
             //alert(msj);
             //$('#form').html(response);
             }
             });

             request.done(function (response, textstatus, jqxhr) {
                console.log("r:" + response);
                console.log("s:" + textstatus);
                console.log(jqxhr);
              
                var resp = $.parseJSON(response);
                var mensaje = '';

                if (resp.errCodigo == '0'){
                    if (acc == 'nue'){
                        document.getElementById("grb_btn").style.display = "none";    
                    }
                    mensaje = "<div class = 'alert alert-success' >TRANSACCION EXITOSA</div>";

                    if (det == 'D'){
                        var arritem = item_det.split('|');
                        var ii = (parseInt(arritem[1], 10)-1);
                                        
                        console.log("item:" + '<?= base_url() ?>empresa/detalle/' + ind + '/'+ arritem[1] +'/' + arritem[2]);
                        cargadet('<?= base_url() ?>empresa/detalle/' + ind + '/'+ arritem[1] +'/' + arritem[2] ,'contenido',ii);
                        cargadet('<?= base_url() ?>empresa/detalle/' + ind + '/'+ arritem[1] +'/' + arritem[2] ,'contenido',ii);
                    }else{ 
                        var arritemc = item.split('|'); 
                        carga('<?= base_url() ?>empresa/' +arritemc[0] ,'filtro'); 
                    }
                }else{
                    mensaje = "<div class = 'alert alert-danger' > Error: " + resp.errCodigo + " - " + resp.errMenssa + "</div>";  
                }                
                document.getElementById("mensajefin").innerHTML = mensaje;              
             });
            
             request.fail(function (response, textstatus, thrown) {
                console.log("r:" + response);
                console.log(response);
                console.log("s:" + textstatus);
                console.log(jqxhr);
                str = response;
                console.log ("failll"+str);
                console.log ("failll"+textstatus)  
                console.log(str);
                document.getElementById("mensajefin").innerHTML = response;
             });
            
             request.always(function (response) {
                console.log("r:" + response);
                console.log("termino");
                console.log(response);
                //$('#form').html(response);
             });
 
			 console.log("str" + str);
			 console.log("finalllll");
        
        };
        function grab(accion) {
            alet('aaaa'+accion);

        };

        function nuevo() {
                alert('nuevo')
                $('#form').reset();
            };
        function hola() {
            alert('hola');
        };
        
        function carga(url,id){
            //alert(url);
			//if (isMobileDevice) {
			//	url = url +'/M';
			//}else{
			//	url = url +'/D';
			//}
			
            var pagecnx = createXMLHttpRequest();

            pagecnx.onreadystatechange=function(){
                if (pagecnx.readyState == 4 &&
                    (pagecnx.status==200 || window.location.href.indexOf("http")==-1))
                    document.getElementById(id).innerHTML=pagecnx.responseText;
                    //alert(pagecnx.responseText);
					console.log(pagecnx.responseText);
            }
            pagecnx.open('POST',url,false);
			$(".contenido").css("display",""); 
            $(".contenido").html("<img src='../guia/images/espera.gif'>");
			//$(".contenido").style.width = '400px';
            pagecnx.onload = function(){load_tabla();$(".contenido").css("display","none");};
            pagecnx.send(null)

        };

        function cargaRpt(url,id){
            //alert(url);
			if (isMobileDevice) {
				url = url +'/M';
			}else{
				url = url +'/D';
			}
			
            var pagecnx = createXMLHttpRequest();

            pagecnx.onreadystatechange=function(){
                if (pagecnx.readyState == 4 &&
                    (pagecnx.status==200 || window.location.href.indexOf("http")==-1))
                    document.getElementById(id).innerHTML=pagecnx.responseText;
                    //alert(pagecnx.responseText);
            }
            pagecnx.open('POST',url,false);
			$(".contenido").css("display",""); 
            $(".contenido").html("<img src='../guia/images/espera.gif'>");
			//$(".contenido").style.width = '400px';
            pagecnx.onload = function(){load_tabla();$(".contenido").css("display","none");};
            pagecnx.send(null)

        };

        function cargadet(url,id,ind){

            //alert (window.fila);
            //alert('termina');
            //load_tabla_det();
            //alert(document.getElementById("myTable").rows[1].innerHTML); 
            $(".selectpicker").selectpicker();
			$('.btn dropdown-toggle btn-light bs-placeholder').addClass('w-100');
			$('.dropdown-toggle').addClass('w-100');
            var table = $('#myTable').DataTable(); 
            index = table.row( ':eq('+ind+')' ).index();                         

            if ( table.row( ':eq('+ind+')' ).child.isShown() ) {
               //alert('oculta');  
               // This row is already open - close it
               table.row( ':eq('+ind+')' ).child.hide();
               document.getElementById("myTable").rows[index+1].classList.remove("shown");
            }
            else {
               //alert('open');
               //console.log(url);
               // Open this row

            var pagecnx = createXMLHttpRequest();
            var resp;

            pagecnx.onreadystatechange=function(){
                if (pagecnx.readyState == 4 &&
                    (pagecnx.status==200 || window.location.href.indexOf("http")==-1))
                    //document.getElementById(id).innerHTML=pagecnx.responseText;
                      resp = pagecnx.responseText;
                    //alert(pagecnx.responseText);
					//console.log(pagecnx.responseText);
            }
            pagecnx.open('POST',url,false);
			//load_tabla_det();
			$(".contenido").css("display",""); 
            $(".contenido").html("<img src='../guia/images/espera.gif'>");
			//$(".contenido").style.width = '400px';
            pagecnx.onload = function(){load_tabla_det();$(".contenido").css("display","none");};
            pagecnx.send(null)
               //load_tabla_det();
               //alert(resp);
               
               table.row( ':eq('+ind+')' ).child([' '+ resp +' ',' ']).show();
               
                              
               //document.getElementById("myTable").rows[index+1].setAttribute('class', 'shown');
               document.getElementById("myTable").rows[index+1].classList.add("shown");
            }
           //alert('fin');   
load_tabla_det();
        };

        
        function cargan(url){
            var pagecnx = createXMLHttpRequest();

            pagecnx.onreadystatechange=function(){
                if (pagecnx.readyState == 4 &&
                    (pagecnx.status==200 || window.location.href.indexOf("http")==-1)){

                    //alert(pagecnx.responseText);
                    var dato = pagecnx.responseText;
                    var arr = dato.length;

                    if (arr == 0) {
                       alert("Transaccion Exitosa");
                    }else{
                       alert(dato);
                    }

            }}
            //alert('4');
            pagecnx.open('POST',url,false);
            //alert('5');

            pagecnx.send(null)

        };

        function enviaCorreoGuia(doc){
		  cargan('http://192.168.100.14/mensajeria/envioCorreoGuia.php?id=' + doc) ;
		  
		}
		
        function carga_model(url,id){
            //alert(url);
            var pagecnx = createXMLHttpRequest();

            pagecnx.onreadystatechange=function(){
                if (pagecnx.readyState == 4 &&
                    (pagecnx.status==200 || window.location.href.indexOf("http")==-1))
                    //document.getElementById(id).innerHTML=pagecnx.responseText;
                $('#modal-body').text(pagecnx.responseText);

                //alert(pagecnx.responseText);
            }
            pagecnx.open('POST',url,false);
            pagecnx.onload = function(){load_tabla()};
            pagecnx.send(null)

        };

        function createXMLHttpRequest(){
            var xmlHttp=null;

            if (window.ActiveXObject) xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
            else if (window.XMLHttpRequest)
                xmlHttp = new XMLHttpRequest();

            return xmlHttp;
        };

        function limpia(id){
            document.getElementById(id).innerHTML = "";
        };

        function carga_usu(id){
           var usu = document.getElementById(id);
            usu.value = 'Julio';
        };
        //function openCity(evt, cityName) {
        //    // Declare all variables
        //    var i, tabcontent, tablinks;

        //    // Get all elements with class="tabcontent" and hide them
        //    tabcontent = document.getElementsByClassName("tabcontent");
        //    for (i = 0; i < tabcontent.length; i++) {
        //        tabcontent[i].style.display = "none";
        //    }

        //    // Get all elements with class="tablinks" and remove the class "active"
        //    tablinks = document.getElementsByClassName("tablinks");
        //    for (i = 0; i < tablinks.length; i++) {
        //        tablinks[i].className = tablinks[i].className.replace(" active", "");
        //    }

        //    // Show the current tab, and add an "active" class to the link that opened the tab
        //    document.getElementById(cityName).style.display = "block";
        //    evt.currentTarget.className += " active";
        //}

        function numero(evt){
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;

            return true;
        };

        function bloquea(id){
            document.getElementById(id).disabled = true;
        };

        function eliminar(){
            if (! confirm('Esta seguro de eliminar este registro?')) {
                return false;
            }else
            { return true;
            }
        };
		

        function importar(evt,acc,ind,nfile) {
            alert('hooooola'+acc+ind+nfile);
            var raccc ='import';
            //if (acc == 'con'){
            //    raccc ='consfiltro' ;
            //}else{
            //    raccc ='consfiltro' ;
            //}
			
			var data = new FormData();
			jQuery.each($('input[type=file]')[0].files, function(i, file) {
				data.append('file-'+i, file);
			});
			
			alert('paso1');
			var other_data = $('formarch').serializeArray();
			$.each(other_data,function(key,input){
				data.append(input.name,input.value);
			});

            alert('paso2');
			request = $.ajax({
             type: 'post',
             url: '<?= base_url();?>' + 'empresa/' + raccc + '/' + ind,
             cache: false,
             data: data,
			 contentType: false,
             processData: false,
             beforeSend: function() {
				$(".contenido").css("display",""); 
                $(".contenido").html("<img src='../guia/images/espera.gif'>");
				//$(".contenido").style.width = '400px';
             },
             success: function(response){
             //console.log( response );
             alert(response);
             //$(".contenido").html("&nbsp;");
			 $(".contenido").css("display","none");
			 //$(".contenido").style.width = '0px';
             //document.getElementById('filtro').innerHTML= response;
             //load_tabla ()
                // return false;
             //$("#mensaje").html(msj);
             //if (msj == 'Registro Grabado con exito'){
             //   jQuery.fn.reset = function(){
             //    $(this).each(function(){this.reset();});
             //}
             //    alert("no_grb");
             //    return false;
             //    $('#form').reset();
             //}

             //alert("no_grb");
             //return true;
             //alert(msj);
             //$('#form').html(response);
             }
             });
            request.done(function (response, textstatus, jqxhr) {
             console.log("r:" + response);
             var str = response;
                 alert ("doneee"+str);
				 alert ("doneeesta"+textstatus);
				 alert ("doneeesta"+jqxhr);
             //--var arr = str.split('|');
             //console.log(arr[1]);
             //--if (arr[1] == "0") {
             //console.log("b" + arr[1]);
             //eje = false;
             //console.log("b" + eje);
             //return false;
             //--    alert("Transaccion Exitosa");
             //--} else {
             //console.log("b" + arr[1]);
             //eje = true;
             //console.log("b" + eje);
             //return true;
             //--    alert("Error:".arr[2]);
             //--}
             });
            request.fail(function (response, textstatus, thrown) {
                var str = response;
                alert ("failll"+str);
			 //conosle.log("e:" + response); 	
             conosle.log("e:" + textstatus);
             //eje = true;
             });
            request.always(function (response, textstatus, thrown) {
             console.log("termino");
                var str = response;
                    alert ("alwaqswww"+str);
                //$('#form').html(response);
             });
            //console.log("eje" + eje);
            //alert(eje);
            //return eje;


        //    grab(acc);
        //if (grb(acc)) {
        //    alert("no graba");
        // }else{
        //    evt.preventDefault();
        // }
          alert('pasofin');
        };


    </script>
    <meta charset="utf-8">
</head>
<body>
