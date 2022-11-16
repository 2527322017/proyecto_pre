<div class="page-title">
    <div class="title_left" style="width: 100%;">
        <h3>Perfil de usuario</h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_content" style="text-align: center;">
            <div class="row">
						<div class="col-md-12 col-sm-12 ">
							<div class="x_panel">
								<div class="x_title">
									<h2>Editar información <small><?=NOMBRE_USUARIO?></small></h2>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<form id="frmEditar" method="POST" class="form-horizontal form-label-left" >
                                    <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="usuario">Fecha de registro <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="fregistro" readonly value="<?=$_SESSION['usuario']['fecha_crea']?>" required="required" class="form-control ">
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="usuario">Usuario <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="usuario" readonly value="<?=$_SESSION['usuario']['usuario']?>" required="required" class="form-control ">
											</div>
										</div>
                                        <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="correo">Correo <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="correo" readonly value="<?=$_SESSION['usuario']['correo']?>" required="required" class="form-control ">
											</div>
										</div>
                                        
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="nombre">Nombre<span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="nombre" value="" name="nombre" required="required" class="form-control">
											</div>
										</div>
										<div class="ln_solid"></div>
										<div class="item form-group">
											<div class="col-md-6 col-sm-6 offset-md-3">
												<button type="submit" class="btn btn-success">Guardar cambios</button>
											</div>
										</div>
									</form>
								</div>
                            </div>

                            
                <div class="accordion" id="accordion1" role="tablist" aria-multiselectable="true">
                    <div class="panel">
                        <a class="panel-heading collapsed" role="tab" id="lnkDatos1" data-toggle="collapse" data-parent="#accordion1" href="#datosIdentificacion" aria-expanded="false" aria-controls="collapseOne">
                          <h5 class="panel-title">Cambiar contraseña</h5>
                        </a>
                        <div id="datosIdentificacion" class="panel-collapse collapse" role="tabpanel" aria-labelledby="lnkDatos1">

                        <div class="x_content">
									<form id="frmEditarClave"  method="POST" class="form-horizontal form-label-left" >
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="clave_actual">Clave actual <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="password" id="clave_actual"  name="clave_actual" required="required" class="form-control ">
											</div>
										</div>
                                        <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="clave">Nueva clave <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="password" id="clave" name="clave" required="required" class="form-control ">
											</div>
										</div>
                                        <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="clave_confirm">Confirmar clave <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="password" id="clave_confirm" name="clave_confirm" required="required" class="form-control ">
											</div>
										</div>
										<div class="ln_solid"></div>
										<div class="item form-group">
											<div class="col-md-6 col-sm-6 offset-md-3">
												<button type="submit" class="btn btn-success">Cambiar contrase&ntilde;a</button>
											</div>
										</div>
									</form>
								</div>

                        </div>
                    </div>
                </div>

						</div>
					</div>
            </div>
        </div>
    </div>
</div>
<style>
label.error {
    float: left;
}
</style>

<script src="<?=HOST?>js/pages/perfil.js"></script>