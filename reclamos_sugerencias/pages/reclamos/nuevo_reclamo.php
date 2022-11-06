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
                <div  class="col-md-12 col-sm-12">
                    <div class="x_title">
                        <h2>Datos de Identificación</h2>
                        <div class="clearfix"></div>
                    </div>
                </div>

            <div  class="col-md-12 col-sm-12">
                <div class="col-md-6">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" ><i
                                class="fa fa-asterisk" style='color: red'></i> Nombres</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" name="nombre" required="required" class="form-control">
                        </div>
                    </div>
                </div>
            

                <div class="col-md-6">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" ><i
                                class="fa fa-asterisk" style='color: red'></i> Apellidos</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" name="apellido" required="required" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div  class="col-md-12 col-sm-12">
                <div class="col-md-6">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name"><i
                                class="fa fa-asterisk" style='color: red'></i> Tipo de documento</label>
                        <div class="col-md-9 col-sm-9 ">
                            <select name="tipo_doc_id" class="form-control" required>
                                <option value="">Cargando...</option>
                                <option value="press">Press</option>
                                <option value="net">Internet</option>
                                <option value="mouth">Word of mouth</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" ><i
                                class="fa fa-asterisk" style='color: red'></i> N° de documento</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" name="numero_documento" required="required" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            
            <div  class="col-md-12 col-sm-12">
                <div class="col-md-6">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" ><i
                                class="fa fa-asterisk" style='color: red;'></i> Correo</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="email" name="correo" required="required" class="form-control">
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" ><i
                                class="fa fa-asterisk" style='color: red'></i> Tel&eacute;fono</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" name="telefono" required="required" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

                
            <div  class="col-md-12 col-sm-12">
                <div class="col-md-6">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name"><i
                                class="fa fa-asterisk" style='color: red'></i> G&eacute;nero</label>
                        <div class="col-md-9 col-sm-9 ">
                            <select  name="genero_id" class="form-control" required>
                                <option value="">Cargando...</option>
                                <option value="press">Press</option>
                                <option value="net">Internet</option>
                                <option value="mouth">Word of mouth</option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name"><i
                                class="fa fa-asterisk" style='color: red'></i> Departamento residencia</label>
                        <div class="col-md-9 col-sm-9 ">
                            <select  name="departamento_id" class="form-control" required>
                                <option value="">Cargando...</option>
                                <option value="press">Press</option>
                                <option value="net">Internet</option>
                                <option value="mouth">Word of mouth</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>   
            
            
            <div  class="col-md-12 col-sm-12">
                <div class="col-md-6">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name"><i
                                class="fa fa-asterisk" style='color: red'></i> Municipio residencia</label>
                        <div class="col-md-9 col-sm-9 ">
                            <select name="municipio_id" class="form-control" required>
                                <option value="">Cargando...</option>
                                <option value="press">Press</option>
                                <option value="net">Internet</option>
                                <option value="mouth">Word of mouth</option>
                            </select>
                        </div>
                    </div>
                </div>

                
                <div class="col-md-6">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" ><i
                                class="fa fa-asterisk" style='color: red'></i> Direcci&oacute;n de
                            residencia</label>
                        <div class="col-md-9 col-sm-9 ">
                            <textarea required="required" class="form-control" name="direccion_residencia"
                                data-parsley-trigger="keyup"
                                data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.."
                                data-parsley-validation-threshold="10"></textarea>
                        </div>
                    </div>
                </div>

            </div>



                <div  class="col-md-12 col-sm-12">
                    <div class="x_title">
                        <h2>Datos de Reclamo / Sugerencia</h2>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name"><i
                                class="fa fa-asterisk" style='color: red'></i> Tipo de registro</label>
                        <div class="col-md-9 col-sm-9 ">
                            <select name="tipo_reg_id" class="form-control" required>
                                <option value="">Cargando...</option>
                                <option value="press">Press</option>
                                <option value="net">Internet</option>
                                <option value="mouth">Word of mouth</option>
                            </select>
                        </div>
                    </div>
                </div>   

                <div class="col-md-6">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name"><i
                                class="fa fa-asterisk" style='color: red'></i> Tipo de cliente</label>
                        <div class="col-md-9 col-sm-9 ">
                            <select name="tipo_cli_id" class="form-control" required>
                                <option value="">Cargando...</option>
                                <option value="press">Press</option>
                                <option value="net">Internet</option>
                                <option value="mouth">Word of mouth</option>
                            </select>
                        </div>
                    </div>
                </div>



                <div class="col-md-6">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name"><i
                                class="fa fa-asterisk" style='color: red'></i> &Aacute;rea de salud</label>
                        <div class="col-md-9 col-sm-9 ">
                            <select name="area_sal_id" class="form-control" required>
                                <option value="">Cargando...</option>
                                <option value="press">Press</option>
                                <option value="net">Internet</option>
                                <option value="mouth">Word of mouth</option>
                            </select>
                        </div>
                    </div>
                </div>





                <div class="col-md-12">
                    <div class="item form-group">
                        <label class="col-sm-2 control-label label-align" ><i
                                class="fa fa-asterisk" style='color: red'></i> Ingrese los detalles:<br />
                            ¿Qué reclama?<br />
                            ¿Qué sugiere?<br />
                            ¿Dónde ocurrió?<br />
                            ¿Cuándo ocurrió?
                        </label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="descripcion" required style="height: 10em;"
                                data-parsley-trigger="keyup"></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="item form-group">
                        <label class="col-sm-2 control-label label-align" >
                            Adjuntar archivos</label>
                        <div class="col-sm-10">
                        <input class="form-control" type="file" id="formFileMultiple" multiple>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="ln_solid"></div>
                    <div class="item form-group">
                        <div class="col-md-6 col-sm-6 offset-md-3">
                            <button type="submit" class="btn btn-success" id="btnEnviar">Enviar  </button>
                        </div>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA ENVIAR -->
<script src="<?=HOST?>js/pages/nuevo_reclamo.js"></script>