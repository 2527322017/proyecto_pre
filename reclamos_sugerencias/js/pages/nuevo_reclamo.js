var URL_AJAX = proyecto_carpeta + 'procesar_datos/reclamo';
var URL_AJAX_RELATION = proyecto_carpeta + 'procesar_datos/reclamo__relations';
var DATOS_MUNICIPIO = [];
$(document).ready(function () {
    $("input[name='telefono']").mask('0000-0000', {placeholder: "____-____"});
    //$("input[name='numero_documento']").mask('00000000-0', {placeholder: "________-_"}); //default dui
    set_relations(); //llenar los selectores relacionados

    var validatorAdd = $("#frmAgregar").validate();

    $('#frmAgregar').captcha(); //aplicar captcha

    $("#frmAgregar").submit(function(e) {
        e.preventDefault();
        if(validatorAdd.form()){
            agregar();
        }
    });


    /*
    var validatorEdit = $("#frmEditar").validate();
    $("#frmEditar").submit(function(e) {
        e.preventDefault();
        if(validatorEdit.form()){
            editar();
        }
    });
    */

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

});


function configurar_requeridos(aplica_req) {
    if(parseInt(aplica_req) == 1) {
        $('.codicionante_requerido').show('slow');
        $(".codicionante_requerido").find('select').attr('required',true);
        $(".codicionante_requerido").find('input').attr('required',true);


        $(".codicionante_opcional").find('.fa-asterisk').show();
        $(".codicionante_opcional").find('input').attr('required',true);
    } else {
        $('.codicionante_requerido').hide('slow');
        $(".codicionante_requerido").find('select').removeAttr('required');
        $(".codicionante_requerido").find('input').removeAttr('required');

        $(".codicionante_opcional").find('.fa-asterisk').hide();
        $(".codicionante_opcional").find('input').removeAttr('required');
    }
}

function agregar() {
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

            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
           console.log(textStatus);
           loader.close();
        }
    });
}