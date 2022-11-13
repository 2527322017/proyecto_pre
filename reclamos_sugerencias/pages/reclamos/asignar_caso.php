<div class="col-md-12 col-sm-12  ">
    <div class="x_panel">
      <div class="x_title">
        <h2>Asingar caso</h2>
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
          <div class="form-group" style="display:none;">
            <label for="nombre" class="col-form-label">Detalle:</label>
            <textarea rows="5" id="txtDetalle" style="width: 100%;" readonly></textarea>          
          </div>
          <div class="form-group">
            <label for="usuario_id" class="col-form-label">Técnico / Encargado:</label>
            <select class="form-control" required name="usuario_id">
              <option value="">Seleccione</option>
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
<!-- FIN MODAL PARA EDITAR -->

<div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="modalEditarTitleLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h3>Datos <b class="lblTitle"></b></h3>
          </div>
          <div class="modal-body" style="max-height:500px; overflow:auto;">
            <div class="row">
            <table class="table table-bordered">
            <thead>
                <tr>
                <th colspan="2" style="text-transform: uppercase;">Datos de Identificación</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <th width="25%">Nombre</th>
                <td class="td_info_nombre"></td>
                </tr>
                <tr>
                <th>Documento</th>
                <td class="td_info_documento"></td>
                </tr>
                <tr>
                <th>Correo</th>
                <td class="td_info_correo"></td>
                </tr>
                <tr>
                <th>Teléfono</th>
                <td class="td_info_telefono"></td>
                </tr>
                <tr>
                <th>G&eacute;nero</th>
                <td class="td_info_genero"></td>
                </tr>
                <tr>
                <th>Dirección Residencia</th>
                <td class="td_info_direccion"></td>
                </tr>
            </tbody>
            </table>
            </div>

            <div class="row">
            <table class="table table-bordered">
            <thead>
                <tr>
                <th colspan="2"  style="text-transform: uppercase;">Datos de <span class="lblTitle"></span></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <th width="25%">Tipo cliente</th>
                <td class="td_info_tipo_cliente"></td>
                </tr>
                <tr>
                <th>Área de salud</th>
                <td class="td_info_area_salud"></td>
                </tr>
                <tr>
                <th>Descripción</th>
                <td class="td_info_descripcion_caso"></td>
                </tr>
            </tbody>
            </table>
            </div>

            <div class="row">
            <table width="100%" class="table table-bordered">
            <thead>
                <tr>
                <th style="text-transform: uppercase;">Archivos</th>
                </tr>
            </thead>
            <tbody  id="tbodyArchivos">
            </tbody>
            </table>
            </div>

            <div class="row">
            <table class="table table-bordered">
            <thead>
                <tr>
                <th colspan="4"  style="text-transform: uppercase;">Seguimiento de caso</th>
                </tr>
                <tr>
                    <th>Fecha</th>
                    <th>Comentario</th>
                    <th>Resolución</th>
                    <th>Técnico / Encargado</th>
                </tr>
            </thead>
            <tbody id="tbodySeguimiento">

            </tbody>
            </table>
            </div>


          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <style>
    td.acciones button{
      width: 100%;
    }
  </style>

<script src="<?=HOST?>js/pages/asignar_caso.js"></script>