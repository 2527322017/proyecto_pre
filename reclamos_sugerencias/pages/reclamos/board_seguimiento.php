
<div class="container">
<h2>Tablero de trabajo, <?=NOMBRE_USUARIO?></h2>
<div id="kanban"></div>
</div>


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

    <!-- MODAL PARA AGREGAR -->
    <div class="modal fade" id="agregarModal" tabindex="-1" role="dialog" aria-labelledby="modalEditarTitleLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarTitleLabel">Agregar seguimiento / Resolución</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form  id="frmAgregar">
        <div class="modal-body">
          <div class="form-group">
            <label for="codigo" class="col-form-label">Código #*:</label>
            <input type="text" readonly correo="" required class="form-control" name="codigo">            
          </div>
          <div class="form-group">
            <label for="comentario" class="col-form-label">Comentario*:</label>
            <textarea rows="5" id="comentario"  name="comentario" required style="width: 100%;"></textarea>          
          </div>
          <div class="form-group" id="dvResolucion">
            <label for="tipo_res_id" class="col-form-label">Tipo resolución:</label>
            <select class="form-control" name="tipo_res_id">
              <option value="">Seleccione</option>
            </select>
          </div>

          <div class="form-group" id="dvCorreo">
            <label for="notificar_correo" class="col-form-label">Notificar por correo:</label>
            <select class="form-control" name="notificar_correo">
              <option value="0">No</option>
              <option value="1">Sí</option>
            </select>
            <input type="hidden" class="form-control" name="id">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="btnActualizar" >Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- FIN MODAL PARA AGREGAR -->


<style>
    .cd_kanban_board_block {
      height: auto !important;
    }
    .cd_kanban_board_block[data-block="Asignado"] .cd_kanban_board_block_item {
      border-left: 4px solid #00aaff !important;
    }
    .cd_kanban_board_block[data-block="Análisis"] .cd_kanban_board_block_item {
      border-left: 4px solid #ff921d !important;
    }
    .cd_kanban_board_block[data-block="Verificación"] .cd_kanban_board_block_item {
      border-left: 4px solid #ffe54b !important;
    }
    .cd_kanban_board_block[data-block="Finalizado"] .cd_kanban_board_block_item {
      border-left: 4px solid #00ff40 !important;
    } 

    .divBtnAcciones {
        margin-top: 12px;
        text-align: center;
    }

    .dvCodigo {
        font-size: 12px;
        margin-top: 10px;
    }
    .dvResolucion {
        font-size: 14px;
        margin-top: 10px;
        color:red;
    }
    .dvInfo {
    font-size: 13px;
    margin-top: 10px;
    }

    a[data-fancybox] img {
  cursor: zoom-in;
}

.fancybox__caption {
  text-align: center;
}

</style>

 <script src="<?=HOST?>js/pages/board_seguimiento.js"></script>