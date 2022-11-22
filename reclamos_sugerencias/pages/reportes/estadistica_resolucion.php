<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<style>
  @import "https://code.highcharts.com/css/highcharts.css";

.highcharts-pie-series .highcharts-point {
    stroke: #ede;
    stroke-width: 2px;
}

.highcharts-pie-series .highcharts-data-label-connector {
    stroke: silver;
    stroke-dasharray: 2, 2;
    stroke-width: 2px;
}

.highcharts-figure,
.highcharts-data-table table {
    min-width: 320px;
    max-width: 600px;
    margin: 1em auto;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}

.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
    padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}

.highcharts-data-table tr:hover {
    background: #f1f7ff;
}
</style>

<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>Estadisticas de reclamos y sugerencias por resoluci&oacute;n</h2>
        <select name="year_data" id="year_data"  class="form-control" style="width: 20%; float: right;">
        <?php
          $y = date("Y");
          for ($i=$y; $i >= ($y - 6); $i--) { 
            $selected = ($i == $y)? 'selected':'';
            echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
          }
        ?>
      </select>
        <div class="clearfix"></div>
      </div>

      
      <div class="x_content" id="contenedorPrincipal" style="display:none;">

          <div class="row">
            
            <div class="col-md-6 col-sm-6">
                <div class="x_panel tile">
                  <div class="x_content">
                    <figure class="highcharts-figure">
                    <div id="containerChart"></div>
                    <p class="highcharts-description">
                    El presente gráfico se puede observar los casos resueltos por tipo de resolución.
                    </p>
                    </figure>
                  </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6">
                <div class="x_panel tile">
                  <div class="x_content">
                    <figure class="highcharts-figure">
                    <div id="containerChart2"></div>
                    <p class="highcharts-description">
                      El presente gráfico se puede observar los casos resueltos por tipo de registro.
                    </p>
                    </figure>
                  </div>
                </div>
            </div>


          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="x_panel tile">
                <div class="x_content">
                  <div id="containerChart3" style="width: 100% !important;"></div>
                  <p class="highcharts-description">
                 Estadísticas de resoluciones de reclamos y sugerencias por mes. Con los botones inferiores puedes cambiar la vista del gráfico.
                  </p>

                  <button id="containerChart3_plain" class="btn btn-outline-secondary">Vertical</button>
                  <button id="containerChart3_inverted" class="btn btn-outline-secondary" >Horizontal</button>
                  <button id="containerChart3_polar" class="btn btn-outline-secondary" >Polar</button>
                  
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>

  </div>
<script src="<?=HOST?>js/reportes/estadistica_resolucion.js"></script>

