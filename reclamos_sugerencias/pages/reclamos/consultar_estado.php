<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>Consulta de Estado</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">

      <div class="title_right">
        <form id="frmConsultar">
          <div class="col-md-5 col-sm-5   form-group row pull-right">
              <div class="input-group">
                <input type="text" class="form-control" name="codigo" required placeholder="Ingrese código de caso">
                <span class="input-group-btn">
                  <button class="btn btn-primary" type="submit">Consultar</button>
                </span>
              </div>
              <div id="error_codigo"></div>
            </div>
        </form>
        <div id="dvResult" class="table-responsive">
        <table class="table">
          <tbody id="dvResultTbody">
          </tbody>
        </table>
        </div>
        </div> 
      
      </div>
    </div> 
  </div>
  <style>
  .tr_resolucion {
    background: #e2f7e4;
    color: #060693;
    font-weight: bold;
  }
  </style>

<script src="<?=HOST?>js/pages/consultar_estado.js"></script>