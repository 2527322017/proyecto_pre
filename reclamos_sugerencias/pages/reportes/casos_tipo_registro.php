<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>Registros de reclamos y sugerencias</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
      <form id="frmConsultar" autocomplete="off" class="form-horizontal form-label-left">
          <div  class="col-md-12 col-sm-12">

                <div class="col-md-4">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" ><i
                                class="fa fa-asterisk" style='color: red'></i> Desde</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="date" name="desde" id="desde" required="required" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" ><i
                                class="fa fa-asterisk" style='color: red'></i> Hasta</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="date" name="hasta" id="hasta" required="required" class="form-control">
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" >Tipo</label>
                        <div class="col-md-9 col-sm-9 ">
                            <select name="tipo_reg_id" class="form-control" >
                                <option value="">Cargando...</option>
                            </select>
                        </div>
                    </div>
                </div>
          </div>

          <div  class="col-md-12 col-sm-12">

              <div class="col-md-4">
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" >Área</label>
                    <div class="col-md-9 col-sm-9 ">
                        <select name="area_sal_id" class="form-control" >
                            <option value="">Cargando...</option>
                        </select>
                    </div>
                  </div>
              </div>

              <div class="col-md-4">
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" >Tipo cliente</label>
                    <div class="col-md-9 col-sm-9 ">
                        <select name="tipo_cli_id" class="form-control" >
                            <option value="">Cargando...</option>
                        </select>
                    </div>
                  </div>
              </div>

              <div class="col-md-4">
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" >G&eacute;nero</label>
                    <div class="col-md-9 col-sm-9 ">
                        <select name="genero_id" class="form-control" >
                            <option value="">Cargando...</option>
                        </select>
                    </div>
                  </div>
              </div>

          </div>

          <div  class="col-md-12 col-sm-12">

            <div class="col-md-4">
                <div class="item form-group">
                  <label class="col-form-label col-md-3 col-sm-3 label-align" >Departamento</label>
                  <div class="col-md-9 col-sm-9 ">
                      <select name="departamento_id" class="form-control" >
                          <option value="">Cargando...</option>
                      </select>
                  </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="item form-group">
                  <label class="col-form-label col-md-3 col-sm-3 label-align" >Municipio</label>
                  <div class="col-md-9 col-sm-9 ">
                      <select name="municipio_id" class="form-control" >
                          <option value="">Cargando...</option>
                      </select>
                  </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="item form-group">
                  <label class="col-form-label col-md-3 col-sm-3 label-align" ></label>
                    <div class="col-md-9 col-sm-9 ">
                      <button type="submit" class="btn btn-info" style="width: 100%;">Consultar</button>
                    </div>
                </div>
            </div>

          </div>

      </form>
      <br />
      <div class="clearfix"></div>
       <div class="table-responsive" id="dvResult">
        <div style="float:right; display:none;" id="dvBtnExport">
       <button type="button" class="btn btn-outline-info" id="bntPdf" ><i class="fa fa-file-pdf-o"></i> Generar PDF</button>
       <button type="button" class="btn btn-outline-info" id="bntExcel" ><i class="fa fa-file-excel-o"></i> Exportar Excel</button>
       </div>
          <table class="table table-striped jambo_table bulk_action" id="tblMain" >
            <thead>
              <tr class="headings">
                <th class="column-title">Fecha</th>
                <th class="column-title">Código</th>
                <th class="column-title">Tipo registro</th>
                <th class="column-title">Nombre</th>
                <th class="column-title">Género</th>
                <th class="column-title">Correo</th>
                <th class="column-title">Departamento</th>
                <th class="column-title">Municipio</th>
                <th class="column-title">Tipo cliente</th>
                <th class="column-title">Área</th>
                <th class="column-title">Estado</th>
              </tr>
            </thead>
            <tbody id="tblDatos" >
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div style="display:none;">
  <div id='tblReporte'>
    <table cellspacing = "0" cellspadding="3" id="tblReporteData" border="1">
      <thead>
        <tr>
          <th class="title_th"  width="5%">Fecha</th>
          <th class="title_th"  width="10%">Código</th>
          <th class="title_th"  width="10%">Tipo registro</th>
          <th class="title_th"  width="10%">Nombre</th>
          <th class="title_th"  width="10%">Género</th>
          <th class="title_th"  width="10%">Correo</th>
          <th class="title_th"  width="10%">Departamento</th>
          <th class="title_th"  width="10%">Municipio</th>
          <th class="title_th"  width="10%">Tipo cliente</th>
          <th class="title_th"  width="10%">Área</th>
          <th class="title_th"  width="5%">Estado</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
</div>
    <form id="frmReporteExport" target="_blank" method="POST">
      <textarea name="table_reporte"  id="table_reporte"></textarea>
      <input type="hidden" name="tipo_reporte"  id="tipo_reporte" value="1">
      <input type="hidden" name="desde_"  id="desde_" value="1">
      <input type="hidden" name="hasta_"  id="hasta_" value="1">
    </form>
  </div>



  <style>
    #tblMain {
      font-size: 12px;
    }
  </style>
<script src="<?=HOST?>js/reportes/casos_tipo_registro.js"></script>
