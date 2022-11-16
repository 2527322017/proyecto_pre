<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>Resolución de reclamos y sugerencias</h2>
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
                    <button type="submit" class="btn btn-info" >Consultar</button>
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
                <th class="column-title">Tipo cliente</th>
                <th class="column-title">Estado</th>
                <th class="column-title">Resolución</th>
                <th class="column-title">Asignación</th>
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
          <th class="title_th" width="10%">Fecha</th>
          <th class="title_th" width="10%">Código</th>
          <th class="title_th" width="10%">Tipo registro</th>
          <th class="title_th" width="25%">Nombre</th>
          <th class="title_th" width="10%">Tipo cliente</th>
          <th class="title_th" width="10%">Estado</th>
          <th class="title_th" width="10%">Resolución</th>
          <th class="title_th" width="15%">Asignación</th>
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
<script src="<?=HOST?>js/reportes/reclamos_resoluciones.js"></script>
