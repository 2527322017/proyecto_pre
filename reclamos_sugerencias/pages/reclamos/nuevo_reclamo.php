<script async>(function(w, d) { var h = d.head || d.getElementsByTagName("head")[0]; var s = d.createElement("script"); s.setAttribute("type", "text/javascript"); s.setAttribute("src", "https://app.bluecaribu.com/conversion/integration/dc9c7f280cf3e917fa4be626eb97ea93"); h.appendChild(s); })(window, document);</script>
    
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Registro de reclamos y sugerencias</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <form id="frmAgregar" autocomplete="off" data-parsley-validate class="form-horizontal form-label-left">

                <div  class="col-md-12 col-sm-12">
                    <div class="x_title">
                        <h2>Tipo de registro</h2>
                        <div class="clearfix"></div>
                    </div>
                </div>

            <div  class="col-md-12 col-sm-12">
                <div class="col-md-6">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name"><i
                                class="fa fa-asterisk" style='color: red'></i> Tipo</label>
                        <div class="col-md-9 col-sm-9 ">
                            <select name="tipo_reg_id" class="form-control" required>
                                <option value="">Cargando...</option>
                            </select>
                        </div>
                    </div>
                </div>  
            </div>



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
                            <input type="text" name="nombre" minlength = "3" maxlength = "100"  required="required" class="form-control autoComplete soloLetras" apply-read = "1">
                        </div>
                    </div>
                </div>
            

                <div class="col-md-6">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" ><i
                                class="fa fa-asterisk" style='color: red'></i> Apellidos</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" minlength = "3" maxlength = "100"  name="apellido" required="required" class="form-control autoComplete soloLetras" apply-read = "1">
                        </div>
                    </div>
                </div>
            </div>

            <div  class="col-md-12 col-sm-12 codicionante_opcional">
                <div class="col-md-6">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" ><i
                                class="fa fa-asterisk" style='color: red;'></i> Correo</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="email" name="correo" required="required" class="form-control autoComplete" apply-read = "1">
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" ><i
                                class="fa fa-asterisk" style='color: red'></i> Tel&eacute;fono</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" name="telefono" required="required" class="form-control autoComplete" apply-read = "1">
                        </div>
                    </div>
                </div>
            </div>


            <div  class="col-md-12 col-sm-12 codicionante_requerido">
                <div class="col-md-6">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name"><i
                                class="fa fa-asterisk" style='color: red'></i> Tipo de documento</label>
                        <div class="col-md-9 col-sm-9 ">
                            <select name="tipo_doc_id" class="form-control autoComplete" apply-read = "1" required>
                                <option value="">Cargando...</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" ><i
                                class="fa fa-asterisk" style='color: red'></i> N° de documento</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" name="numero_documento" required="required" class="form-control autoComplete" apply-read = "1">
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
                            <select  name="genero_id" class="form-control autoComplete" apply-read = "1" required>
                                <option value="">Cargando...</option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 codicionante_requerido">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name"><i
                                class="fa fa-asterisk" style='color: red'></i> Departamento residencia</label>
                        <div class="col-md-9 col-sm-9 ">
                            <select  name="departamento_id" class="form-control autoComplete" apply-read = "0" required>
                                <option value="">Cargando...</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>   
            
            
            <div  class="col-md-12 col-sm-12 codicionante_requerido">
                <div class="col-md-6">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name"><i
                                class="fa fa-asterisk" style='color: red'></i> Municipio residencia</label>
                        <div class="col-md-9 col-sm-9 ">
                            <select name="municipio_id" class="form-control autoComplete" apply-read = "0" required>
                                <option value="">Cargando...</option>
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
                            <textarea required="required" class="form-control autoComplete" apply-read = "0" name="direccion_residencia"
                                data-parsley-trigger="keyup"
                                data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.."
                                data-parsley-validation-threshold="10"></textarea>
                        </div>
                    </div>
                </div>

            </div>

                <div  class="col-md-12 col-sm-12">
                    <div class="x_title">
                        <h2>Detalle de <label id="lblTitleDetalle" style="text-transform:capitalize;">Registro</label> </h2>
                        <div class="clearfix"></div>
                    </div>
                </div>
 

                <div class="col-md-6">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name"><i
                                class="fa fa-asterisk" style='color: red'></i> Tipo de cliente</label>
                        <div class="col-md-9 col-sm-9 ">
                            <select name="tipo_cli_id" class="form-control" required>
                                <option value="">Cargando...</option>
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
                            <textarea class="form-control" minlength = "10" maxlength = "5000"  name="descripcion" required style="height: 10em;"></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="item form-group">
                        <label class="col-sm-2 control-label label-align" >
                            Adjuntar archivos</label>
                        <div class="col-sm-10">
                        <input class="form-control" type="file" id="adjuntar_archivos"  
                         name="adjuntar_archivos[]" accept="image/*,audio/*,video/*,.pdf"  multiple> 
                        <!-- <input type="text" id="adjuntar_archivos" name="adjuntar_archivos" value=""> -->
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="ln_solid"></div>
                    <div class="item form-group">
                        <div class="col-md-6 col-sm-6 offset-md-3">
                        <div style="margin-bottom: 10px; display:none;" id="dvHelpCaptcha">Completa la siguiente operación para continuar</div>
                            <input type="submit" class="btn btn-success" id="btnEnviar" value="Enviar">
                        </div>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>
</div>
<style>

#captchaInput {
    width: 50px;
    margin-right: 5px;
    font-size: 14px;
}

#captchaText {
    margin-right: 5px;
    font-size: 20px;
}

#captchaInput-error {
    position: absolute;
    top: 100%;
    left: 10px;
}
</style>

<!-- MODAL PARA ENVIAR -->
<script src="<?=HOST?>js/pages/nuevo_reclamo.js"></script>
<link href="<?=HOST?>js/uploader/jquery.uploader.css" rel="stylesheet">
<script src="<?=HOST?>js/uploader/jquery.uploader.min.js"></script>

<link href="<?=HOST?>js/uploader2/imageuploadify.min.css" rel="stylesheet">
<script src="<?=HOST?>js/uploader2/imageuploadify.min.js"></script>

<script type="application/javascript">
    $(document).ready(function() {
           /* $('#adjuntar_archivos').imageuploadify();
            setTimeout(() => {
                $(".imageuploadify-message").text('Arrastrar y soltar tus archivos aqui');
                $(".imageuploadify-images-list button:first").text('o selecciona el archivo a cargar');
            }, 200);
            */
        })
  /*
  let ajaxConfig = {
        ajaxRequester: function (config, uploadFile, pCall, sCall, eCall) {
            let progress = 0
            let interval = setInterval(() => {
                progress += 10;
                pCall(progress)
                if (progress >= 100) {
                    clearInterval(interval)
                    const windowURL = window.URL || window.webkitURL;
                    sCall({
                        data: windowURL.createObjectURL(uploadFile.file)
                    })
                    console.log(uploadFile.file);
                     eCall("hola")
                }
            }, 300)
        }
    }
    $("#adjuntar_archivos").uploader({multiple: true, ajaxConfig: ajaxConfig,autoUpload: true})
    //https://simpleupload.michaelcbrook.com/#examples
    //https://formstone.it/components/upload/
    //https://formstone.it/components/upload/demo/
    //https://www.cssscript.com/demo/drag-and-file-uploader-vanilla-javascript/
    //https://www.cssscript.com/demo/file-uploader-preview-file-upload-preview-js/
    //https://www.dropzone.dev/
    //https://slashuploader.com/#demos
    //https://www.jqueryscript.net/demo/Fancy-File-Uploader-jQuery/
    //https://www.remove.bg/es/upload quitar fondo
*/
</script>