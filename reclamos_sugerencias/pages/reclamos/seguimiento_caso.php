<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>Seguimiento caso, <?=NOMBRE_USUARIO?></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
       <div class="table-responsive" id="dvResult">
          <table class="table table-striped jambo_table bulk_action" id="tblMain">
            <thead>
              <tr class="headings">
                <th class="column-title">#</th>
                <th class="column-title">Fecha</th>
                <th class="column-title">Código</th>
                <th class="column-title">Tipo registro</th>
                <th class="column-title">Nombre</th>
                <th class="column-title">Tipo cliente</th>
                <th class="column-title">Departamento</th>
                <th class="column-title">Municipio</th> 
                <th class="column-title">Documento</th>
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


  <!-- MODAL PARA EDITAR -->
  <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="modalEditarTitleLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarTitleLabel">Asignar para seguimiento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form  id="frmEditar">
        <div class="modal-body">
          <div class="form-group">
            <label for="nombre" class="col-form-label">Código #:</label>
            <input type="text" readonly required class="form-control" name="codigo">            
          </div>
          <div class="form-group">
            <label for="nombre" class="col-form-label">Detalle:</label>
            <textarea rows="5" id="txtDetalle" style="width: 100%;" readonly></textarea>          
          </div>
          <div class="form-group">
            <label for="tipo_res_id" class="col-form-label">Tipo resolución:</label>
            <select class="form-control" required name="tipo_res_id">
              <option value="">Seleccione</option>
            </select>
            <input type="hidden" class="form-control" name="id">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="btnActualizar" style="display:none;">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- FIN MODAL PARA EDITAR -->

<script src="<?=HOST?>js/pages/seguimiento_caso.js"></script>