<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>Reclamos/sugerencias <?=(TYPE_USER == 2)? 'asignados':'registradas'?> <?=(TYPE_USER == 1)? '(ultimos 6 meses)':''?></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
       <div class="table-responsive" id="dvResult">
          <table class="table table-striped jambo_table bulk_action" id="tblMain" >
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
                <th class="column-title">Resolución</th>
                <?=(TYPE_USER == 1)? '<th class="column-title">Asignación</th>':''?>
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


  <div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="modalEditarTitleLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h3>Detalle de <b class="lblTitle"></b></h3>
          </div>
          <div class="modal-body" style="max-height:500px; overflow:auto;">
            <div class="accordion" id="accordion1" role="tablist" aria-multiselectable="true">
                      <div class="panel">
                        <a class="panel-heading collapsed" role="tab" id="lnkDatos1" data-toggle="collapse" data-parent="#accordion1" href="#datosIdentificacion" aria-expanded="false" aria-controls="collapseOne">
                          <h5 class="panel-title">Datos de identificación</h5>
                        </a>
                        <div id="datosIdentificacion" class="panel-collapse collapse" role="tabpanel" aria-labelledby="lnkDatos1" style="">
                          <div class="panel-body">
                          <table class="table table-hover">
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
                        </div>
                      </div>
                      <div class="panel">
                        <a class="panel-heading collapsed" role="tab" id="lnkDatos2" data-toggle="collapse" data-parent="#accordion1" href="#datosDetalle" aria-expanded="false" aria-controls="collapseTwo">
                          <h5 class="panel-title">Detalle de <span class="lblTitle"></span></h5>
                        </a>
                        <div id="datosDetalle" class="panel-collapse collapse" role="tabpanel" aria-labelledby="lnkDatos2" style="">
                          <div class="panel-body">
                          <table class="table table-hover">
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
                        </div>
                      </div>
                      <div class="panel">
                        <a class="panel-heading collapsed" role="tab" id="lnkDatos3" data-toggle="collapse" data-parent="#accordion1" href="#datosArchivo" aria-expanded="false" aria-controls="collapseThree">
                          <h5 class="panel-title">Archivos</h5>
                        </a>
                        <div id="datosArchivo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="lnkDatos3" style="">
                          <div class="panel-body">
                          <table width="100%" class="table table-bordered">
                            <tbody  id="tbodyArchivos">
                            </tbody>
                          </table> 
                         </div>
                        </div>
                      </div>
                      <div class="panel">
                        <a class="panel-heading collapsed" role="tab" id="lnkDatos4" data-toggle="collapse" data-parent="#accordion1" href="#datosSeguimiento" aria-expanded="false" aria-controls="collapseThree">
                          <h5 class="panel-title">Seguimiento de caso</h5>
                        </a>
                        <div id="datosSeguimiento" class="panel-collapse collapse" role="tabpanel" aria-labelledby="lnkDatos4" style="">
                          <div class="panel-body">
                          <table class="table table-hover">
                            <thead>
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
                      </div>
              </div>

          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <style>
    #tblMain {
      font-size: 12px;
    }

    a[data-fancybox] img {
    cursor: zoom-in;
    }

    .fancybox__caption {
    text-align: center;
    }
  </style>

<script src="<?=HOST?>js/pages/seguimiento_caso.js"></script>