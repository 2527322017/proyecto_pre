<div class="col-md-12 col-sm-12  ">
    <div class="x_panel">
      <div class="x_title">
        <h2>Tipo de resoluci&oacute;n</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarModal">Agregar</button>
       <div class="table-responsive" id="dvResult">
          <table class="table table-striped jambo_table bulk_action" id="tblMain">
            <thead>
              <tr class="headings">
                <th class="column-title">#</th>
                <th class="column-title">Nombre</th>
                <th class="column-title">Estado</th>
                <th class="column-title acciones" >Acción</th>
              </tr>
            </thead>
            <tbody id="tblDatos" >
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL PARA AGREGAR -->
  <div class="modal fade" id="agregarModal" tabindex="-1" role="dialog" aria-labelledby="modalTitleLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAgregarTitleLabel">Nuevo registro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="frmAgregar">
      <div class="modal-body">
          <div class="form-group">
            <label for="nombre" class="col-form-label">Nombre:</label>
            <input type="text" required class="form-control" name="nombre">
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- FIN MODAL PARA AGREGAR -->

  <!-- MODAL PARA EDITAR -->
  <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="modalEditarTitleLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarTitleLabel">Editar registro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form  id="frmEditar">
        <div class="modal-body">
          <div class="form-group">
            <label for="nombre" class="col-form-label">Nombre:</label>
            <input type="text" required class="form-control" name="nombre">            
          </div>
          <div class="form-group">
            <label for="estado" class="col-form-label">Estado:</label>
            <select class="form-control" required name="estado">
              <option value="1">Activo</option>
              <option value="0">Inactivo</option>
            </select>
            <input type="hidden" class="form-control" name="id">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="btnActualizar">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<style>
  .acciones {
    text-align: right !important;
  }
</style>
<!-- FIN MODAL PARA EDITAR -->

<script src="<?=HOST?>js/pages/tipo_resolucion.js"></script>