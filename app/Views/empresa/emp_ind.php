

<div >

<ul class="tab">
    <li><a href="javaScript:;" onclick="carga('<?= base_url() ?>empresa/catalogo','filtro');" class="tablinks" >Catalogo </a></li>
    <li><a href="javaScript:;" onclick="carga('<?= base_url() ?>empresa/cliente','filtro');" class="tablinks" >Cliente </a></li>
		<li><a href="javaScript:;" onclick="carga('<?= base_url() ?>empresa/empresas','filtro');" class="tablinks" >Guias </a></li>        
    <li><a href="javaScript:;" onclick="carga('<?= base_url() ?>empresa/sucursal','filtro');" class="tablinks" >Factura </a></li>
		<li><a href="javaScript:;" onclick="carga('<?= base_url() ?>empresa/proveedor','filtro');" class="tablinks" >Proveedor </a></li>
		<li><a href="javaScript:;" onclick="carga('<?= base_url() ?>empresa/ocp','filtro');" class="tablinks" >OCP </a></li>
		<li><a href="javaScript:;" onclick="carga('<?= base_url() ?>empresa/contabilidad','filtro');" class="tablinks" >Contabilidad </a></li>
		<li><a href="javaScript:;" onclick="carga('<?= base_url() ?>empresa/banco','filtro');" class="tablinks" >Banco </a></li>
    <li><a href="javaScript:;" onclick="carga('<?= base_url() ?>empresa/rol','filtro');" class="tablinks" >Rol </a></li>
</ul>   


<div class="accordion md-accordion accordion-blocks" id="accordionEx78" role="tablist" aria-multiselectable="true">
  <!-- Accordion card -->
  <div class="card">
    <!-- Card header -->
    <div class="card-header" role="tab" id="headingUnfiled">
      
      <!--Options-->
      <div class="dropdown float-left">
        <button class="btn btn-info btn-sm m-0 mr-3 p-2 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-pencil-alt"></i></button>
        <div class="dropdown-menu dropdown-info">
          <a class="dropdown-item" href="#">Add new condition</a>
          <a class="dropdown-item" href="#">Rename folder</a>
          <a class="dropdown-item" href="#">Delete folder</a>
        </div>
      </div>

      <!-- Heading -->
      <a data-toggle="collapse" data-parent="#accordionEx78" href="#collapseUnfiled" aria-expanded="true" aria-controls="collapseUnfiled">
        <h5 class="mt-1 mb-0">
          <span>Unfiled items</span>
          <i class="fas fa-angle-down rotate-icon"></i>
        </h5>
      </a>

    </div>

    <!-- Card body -->
    <div id="collapseUnfiled" class="collapse" role="tabpanel" aria-labelledby="headingUnfiled" data-parent="#accordionEx78">
      <div class="card-body">
        <div id="filtro" class="tabcontent"></div>
        <div id="lista"  class="tabcontent"></div>
        <div class="contenido"></div>
      </div>
    </div>
	
    <!-- drag -->
	  <div id="drag" style="display:none" >
      <p>content</p>
    </div>
	
    <!-- Bootstrap modal -->
    <div id="modal_form" class="modal fade" role="document" tabindex="-1" role="dialog" >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Informacion de <?= 000 ?> del sistema</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <div id="contenidom" class ="modalm"> </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
            <button type="button" id="btnclose" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

  </div>
</div>


