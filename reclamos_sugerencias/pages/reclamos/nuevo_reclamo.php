<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Registro y gestión de reclamos y/o sugerencias</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <form id="frmAgregar" autocomplete="off" data-parsley-validate class="form-horizontal form-label-left">

                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name"><i
                                class="fa fa-asterisk" style='color: red'></i> Departamento</label>
                        <div class="col-md-6 col-sm-6 ">
                            <select  name="departamento_id" class="form-control" required>
                                <option value="">Cargando...</option>
                                <option value="press">Press</option>
                                <option value="net">Internet</option>
                                <option value="mouth">Word of mouth</option>
                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name"><i
                                class="fa fa-asterisk" style='color: red'></i> Municipio</label>
                        <div class="col-md-6 col-sm-6 ">
                            <select name="municipio_id" class="form-control" required>
                                <option value="">Cargando...</option>
                                <option value="press">Press</option>
                                <option value="net">Internet</option>
                                <option value="mouth">Word of mouth</option>
                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name"><i
                                class="fa fa-asterisk" style='color: red'></i> Tipo de cliente</label>
                        <div class="col-md-6 col-sm-6 ">
                            <select name="tipo_cli_id" class="form-control" required>
                                <option value="">Cargando...</option>
                                <option value="press">Press</option>
                                <option value="net">Internet</option>
                                <option value="mouth">Word of mouth</option>
                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name"><i
                                class="fa fa-asterisk" style='color: red'></i> Tipo de registro</label>
                        <div class="col-md-6 col-sm-6 ">
                            <select name="tipo_reg_id" class="form-control" required>
                                <option value="">Cargando...</option>
                                <option value="press">Press</option>
                                <option value="net">Internet</option>
                                <option value="mouth">Word of mouth</option>
                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name"><i
                                class="fa fa-asterisk" style='color: red'></i> &Aacute;rea de salud</label>
                        <div class="col-md-6 col-sm-6 ">
                            <select name="area_sal_id" class="form-control" required>
                                <option value="">Cargando...</option>
                                <option value="press">Press</option>
                                <option value="net">Internet</option>
                                <option value="mouth">Word of mouth</option>
                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name"><i
                                class="fa fa-asterisk" style='color: red'></i> Tipo de documento</label>
                        <div class="col-md-6 col-sm-6 ">
                            <select name="tipo_doc_id" class="form-control" required>
                                <option value="">Cargando...</option>
                                <option value="press">Press</option>
                                <option value="net">Internet</option>
                                <option value="mouth">Word of mouth</option>
                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name"><i
                                class="fa fa-asterisk" style='color: red'></i> N° de documento</label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" name="numero_documento" required="required" class="form-control">
                        </div>
                    </div>


                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name"><i
                                class="fa fa-asterisk" style='color: red'></i> Nombres</label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" name="nombre" required="required" class="form-control">
                        </div>
                    </div>


                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name"><i
                                class="fa fa-asterisk" style='color: red'></i> Apellidos</label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" name="apellido" required="required" class="form-control">
                        </div>
                    </div>


                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name"><i
                                class="fa fa-asterisk" style='color: red'></i> Tel&eacute;fono</label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" name="telefono" required="required" class="form-control">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name"><i
                                class="fa fa-asterisk" style='color: red'></i> G&eacute;nero</label>
                        <div class="col-md-6 col-sm-6 ">
                            <select  name="genero_id" class="form-control" required>
                                <option value="">Cargando...</option>
                                <option value="press">Press</option>
                                <option value="net">Internet</option>
                                <option value="mouth">Word of mouth</option>
                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name"><i
                                class="fa fa-asterisk" style='color: red'></i> Direcci&oacute;n de
                            residencia</label>
                        <div class="col-md-6 col-sm-6 ">
                            <textarea required="required" class="form-control" name="direccion_residencia"
                                data-parsley-trigger="keyup"
                                data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.."
                                data-parsley-validation-threshold="10"></textarea>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name"><i
                                class="fa fa-asterisk" style='color: red'></i> Ingrese los detalles:<br />
                            ¿Qué reclama?<br />
                            ¿Qué sugiere?<br />
                            ¿Dónde ocurrió?<br />
                            ¿Cuándo ocurrió?
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <textarea class="form-control" name="descripcion" style="height: 10em;"
                                data-parsley-trigger="keyup"></textarea>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">
                            Adjuntar archivos</label>
                        <div class="col-md-6 col-sm-6 ">
                        <input class="form-control" type="file" id="formFileMultiple" multiple>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="item form-group">
                        <div class="col-md-6 col-sm-6 offset-md-3">
                            <button type="submit" class="btn btn-success">Enviar</button>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA ENVIAR -->
<script src="<?=HOST?>js/pages/nuevo_reclamo.js"></script>