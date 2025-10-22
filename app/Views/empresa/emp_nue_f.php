<script type = "text/javascript">
    alert ('hola');
    function rev(){
        var indice = '<?= $this->config->item('r_dato');?>'+'';
        var ind    = '<?= $this->config->item('r_index');?>'+'';
        var _index = ind.split('|');
        alert (_index);
        var empcodigo = $('#'+_index[0]).val();
        if(empcodigo == "" || empcodigo.length < 3){
            $('#'+_index[0]).css('border', '2px red solid');
        }else{
            $.ajax({
                type: "post",
                url: '<?= base_url();?>' + 'empresa/actualizar_id/'+ indice ,
                cache: false,
                data:$('#form').serialize(),
                success: function(response){
                    try{
                        if (response !='') {
                            $('#form').html(response);
                        }else{return false;}
                        //aspnetForm.submit();
                    }catch(e) {
                        alert('Exception while request..');
                    }
                },
                error: function(response){
                    alert('Error while request..');
                }
            });
        }
    }

</script>
<?= form_open('','class = "forma" id = "form" border="0"')?>
<?php $dato   =  $this->config->item('r_dato');
$this->acciono  = 'nue';
//echo $this->acciono;
$this->config->set_item('r_accion', $this->acciono);
//echo $this->config->item('r_accion');
?>
<h4> Filtro de Busqueda >> <?= $dato; ?></h4>

