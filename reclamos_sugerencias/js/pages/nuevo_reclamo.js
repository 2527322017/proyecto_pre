var URL_AJAX = proyecto_carpeta + 'procesar_datos/reclamo';
var URL_AJAX_RELATION = proyecto_carpeta + 'procesar_datos/reclamo__relations';
var URL_AJAX_USER = proyecto_carpeta + 'procesar_datos/login__verificar_correo';
var URL_AJAX_REGISTER = proyecto_carpeta + 'procesar_datos/reclamo__last_register';

var DATOS_MUNICIPIO = [];
var ID_MUN_SELECTED = 0;
$(document).ready(function () {
    $("input[name='telefono']").mask('0000-0000', {placeholder: "____-____"});
    //$("input[name='numero_documento']").mask('00000000-0', {placeholder: "________-_"}); //default dui
    set_relations(); //llenar los selectores relacionados
    var validatorAdd = $("#frmAgregar").validate();
    if(is_login == 0) {
        $('#frmAgregar').captcha(); //aplicar captcha
        $("#dvHelpCaptcha").show();
    }
    

    $("#frmAgregar").submit(function(e) {
        e.preventDefault();
        if(validatorAdd.form()){
            agregar();
        }
    });

    $("#frmAgregar select[name='departamento_id']").change(function (e) { 
        var html_option = '<option value="">Seleccione</option>';
        var id_depto = $(this).val();
        if(DATOS_MUNICIPIO.length > 0 && id_depto > 0) {
            municipiosxdepto = DATOS_MUNICIPIO.filter(muni => muni.departamento_id == id_depto);

            municipiosxdepto.forEach(function(data, indice2) { 
                html_option += '<option value="'+data.id_key+'">'+data.value+'</option>';
            });  
        }
        $("#frmAgregar select[name='municipio_id']").html(html_option);    
    });


    $("#frmAgregar select[name='tipo_doc_id']").change(function (e) { 
        id = $(this).val();  
        $("input[name='numero_documento']").val(''); 
        if(id > 0) {
            texto = $("#frmAgregar select[name='tipo_doc_id'] option[value='"+id+"']").text();
            console.log(texto);
            if(texto.indexOf('dui') != -1 || texto.indexOf('DUI') != -1) {
                $("input[name='numero_documento']").unmask();
                $("input[name='numero_documento']").mask('00000000-0', {placeholder: "________-_"}); 
            }
            else if(texto.indexOf('nit') != -1 || texto.indexOf('NIT') != -1) {
                $("input[name='numero_documento']").unmask();
                $("input[name='numero_documento']").mask('0000-000000-000-0', {placeholder: "____-______-___-_"}); 
            } else {
                $("input[name='numero_documento']").unmask();
            }
        }
        
    });

    configurar_requeridos(0);
    $("#frmAgregar select[name='tipo_reg_id']").change(function (e) { 
        var txtButton = 'Enviar ';
        var txtTitle = 'Registro ';
        var tipo = $(this).val();
        var aplica_requeridos = 0;
        if(tipo > 0) {
            texto = $("#frmAgregar select[name='tipo_reg_id'] option[value='"+tipo+"']").text();
            txtButton += texto;
            txtTitle = texto;
            aplica_requeridos = $("#frmAgregar select[name='tipo_reg_id'] option[value='"+tipo+"']").attr('data_extra');
        }
        
        $("#btnEnviar").text(txtButton);
        $("#btnEnviar").val(txtButton);
        $("#lblTitleDetalle").text(txtTitle);
        configurar_requeridos(aplica_requeridos);
     });

     $("#frmAgregar input[name='correo']").blur(function (e) { 
        if($(this).val().trim()!= '') { //preguntar si tiene usuario
            validar_correo();
        }  
    });

});


function configurar_requeridos(aplica_req) {
    if(parseInt(aplica_req) == 1) {
        $('.codicionante_requerido').show('fast'); //.show('fast'); fadeIn
        $(".codicionante_requerido").find('select').attr('required',true);
        $(".codicionante_requerido").find('input').attr('required',true);


        $(".codicionante_opcional").find('.fa-asterisk').show();
        $(".codicionante_opcional").find('input').attr('required',true);
    } else {
        $('.codicionante_requerido').fadeOut(); //.hide('fast'); //fadeOut
        $(".codicionante_requerido").find('select').removeAttr('required');
        $(".codicionante_requerido").find('input').removeAttr('required');

        $(".codicionante_opcional").find('.fa-asterisk').hide();
        $(".codicionante_opcional").find('input').removeAttr('required');
    }
}

function agregar() {
    $(".autoComplete").removeAttr('disabled'); //for select tags
    var formData = new FormData($("#frmAgregar")[0]);
    $.ajax({
        type: "POST",
        url: URL_AJAX,
        dataType: "json",
        data: formData,
        cache: false,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        beforeSend: function() {
            loader.open();
        },
        success: function (response) {
            loader.close();
            if(response.status == 'success') {
                //consultar();
                Swal.fire({
                   // position: 'top-end',
                    icon: 'success',
                    title: '!Éxito!',
                    html: 'Registro ingresado con éxito <br />' + '<b>CÓDIGO # '+ response.result.codigo +'</b><br /> (Para seguimiento)',
                    showConfirmButton: true,
                    confirmButtonText: 'Aceptar'
                   // timer: 10000
                  }).then((result) => {
                    location.href = location.href;
                  });

                  $("#frmAgregar").trigger("reset");
                  $("#btnEnviar").text("Enviar");
                  $("#btnEnviar").val("Enviar");
                  $("#lblTitleDetalle").text("Registro");


            } else {
                Swal.fire({
                    title: '!Error!',
                    text: response.result.msg,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                  }); 
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
           console.log(textStatus);
           loader.close();
        }
    });
}


//Llenar los selectores relacionados
function set_relations() {
    $.ajax({
        type: "GET",
        url: URL_AJAX_RELATION,
        dataType: "json",
        beforeSend: function() {
          loader.open('',true);
        },
        success: function (response) {
            loader.close();
            var html_tbody = '';
            if(response.status == 'success') {
                //console.log(response.result);
                var keys = Object.keys(response.result);
                var values = Object.values(response.result);
                //console.log(keys);
                //console.log(values);

                keys.forEach(function(relation, indice) {
                   // console.log(relation);
                  //  console.log(indice);
                    var html_option = '<option value="">Seleccione</option>';
                    if(values[indice].length > 0) {
                        values[indice].forEach(function(data, indice2) { 
                            extra_field = (data.data_extra != '')? 'data_extra="'+data.data_extra+'" ':'';
                            html_option += '<option value="'+data.id_key+'" '+extra_field+' >'+data.value+'</option>';
                        });
                    }

                    //llenar los selectores
                    $("#frmAgregar select[name='"+relation+"']").html(html_option);

                    //condicionar selectore especiales.
                    if(relation == 'municipio_id') {
                        DATOS_MUNICIPIO = values[indice];
                        $("#frmAgregar select[name='"+relation+"']").html('<option value="">Seleccione</option>');
                    }
                    
                }); 

                verificar_sesion();
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
           console.log(textStatus);
           loader.close();
        }
    });
}

function validar_correo() {
    var correo_registro = $("#frmAgregar input[name='correo']").val().trim();
    var readOnly = $("#frmAgregar input[name='correo']").attr('readonly');
    if(correo_registro != '' && !readOnly && correo_registro.indexOf('@') != -1 ) {
        $.ajax({
            type: "POST",
            url: URL_AJAX_USER,
            dataType: "json",
            data: {correo:correo_registro},
            beforeSend: function() {
              loader.openSwal('Validando correo...');
            },
            success: function (response) {
                loader.closeSwal();
                if(response.status == 'success') {
                       Swal.fire({
                         icon: 'warning',
                         title: '!Usuario detectado!',
                         html: 'El correo ingresado posee usuario <br /> <small>(Favor iniciar sesión para continuar)</small>',
                         showDenyButton: true,
                         showCancelButton: false,
                         confirmButtonText: 'Aceptar',
                        // cancelButtonText: 'Reintentar',
                         denyButtonText: `Iniciar sessión`,
                       }).then((result) => {
                         /* Read more about isConfirmed, isDenied below */
                         if (result.isConfirmed) {
                             //loader.open();
                            // location.href = location.href;
                            $("#frmAgregar input[name='correo']").val('');
                         } else if (result.isDenied) {
                            loader.open();
                            location.href = $("#lnkLogout").attr('href');
                         }
                       });
                       
                } 
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
               console.log(textStatus);
               loader.closeSwal();
            }
        });
    }
}

function verificar_sesion() {
    if(is_login == 1 && type_user == 3) { //preguntar si el cliente final tiene la sessión activa.
        $.ajax({
            type: "POST",
            url: URL_AJAX_REGISTER,
            dataType: "json",
           // data: {type_user:type_user},
            beforeSend: function() {
              loader.open();
            },
            success: function (response) {
                loader.close();
                if(response.status == 'success') {
                    d = response.result;
                    var keys = Object.keys(response.result);
                    var values = Object.values(response.result);
                    //console.log(keys);
                    //console.log(values);
                    keys.forEach(function(campo, indice) {

                        valor_campo = values[indice];
                         if(valor_campo != ''  && valor_campo  != 'null' && valor_campo != null) {
                             if($("select[name='"+campo+"']").length > 0) {
                                if($("select[name='"+campo+"']").hasClass("autoComplete")) {
                                    soloLectura = parseInt($("select[name='"+campo+"']").attr('apply-read'));
                                    $("select[name='"+campo+"'] option[value='"+valor_campo+"']").attr('selected',true);
                                    $("select[name='"+campo+"']").val(valor_campo);
                                    if(soloLectura == 1) {
                                        $("select[name='"+campo+"']").attr('disabled',true);  
                                    }

                                    if(campo == 'municipio_id') {
                                        ID_MUN_SELECTED = valor_campo;
                                    }
                                    
                                }
                             } 
                            if($("input[name='"+campo+"']").length > 0) {
                                if($("input[name='"+campo+"']").hasClass("autoComplete")) { 
                                    soloLectura = parseInt($("input[name='"+campo+"']").attr('apply-read'));
                                    $("input[name='"+campo+"']").val(valor_campo);
                                    if(soloLectura == 1) {
                                        $("input[name='"+campo+"']").attr('readonly',true);  
                                    }
                                }
                            }
                            if($("textarea[name='"+campo+"']").length > 0) {
                                if($("textarea[name='"+campo+"']").hasClass("autoComplete")) { 
                                    soloLectura = parseInt($("textarea[name='"+campo+"']").attr('apply-read'));
                                    $("textarea[name='"+campo+"']").val(valor_campo);
                                    if(soloLectura == 1) {
                                        $("textarea[name='"+campo+"']").attr('readonly',true);  
                                    }
                                }
                            }
                         }
                         
                     }); 

                     if(parseInt(ID_MUN_SELECTED) > 0) {
                        $("select[name='departamento_id']").trigger('change');
                        setTimeout(() => {
                            $("select[name='municipio_id'] option[value='"+ID_MUN_SELECTED+"']").attr('selected',true);
                            $("select[name='municipio_id']").val(ID_MUN_SELECTED);
                        }, 1000);
                        
                     }
                     /*
                    $(".autoComplete").each(function(indice, elemento) {
                        soloLectura = parseInt($(elemento).attr('apply-read'));
                        nombre = $(elemento).attr('name');
                        if($(elemento).is('select')) {
                            if(d.{nombre} != '' && d.{nombre} != 'null' && d.{nombre} != null) {

                            }
                            $(elemento).find();
                        } else {

                        }
                    });
                    */
                } 
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
               console.log(textStatus);
               loader.close();
            }
        });
    }
}