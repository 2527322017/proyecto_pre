var URL_AJAX = '/reclamos_sugerencias/procesar_datos/reclamo';
var URL_AJAX_RELATION = '/reclamos_sugerencias/procesar_datos/reclamo__relations';
var DATOS_MUNICIPIO = [];
$(document).ready(function () {
    $("input[name='telefono']").mask('0000-0000', {placeholder: "____-____"});
    $("input[name='numero_documento']").mask('00000000-0', {placeholder: "________-_"}); //default dui
    set_relations(); //llenar los selectores relacionados

    var validatorAdd = $("#frmAgregar").validate();

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

});

function agregar() {
    $.ajax({
        type: "POST",
        url: URL_AJAX,
        dataType: "json",
        data: $("#frmAgregar").serialize(),
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
                    html: 'Registro ingresado con éxito' + '<b>CASO # '+ response.result.codigo +'</b>',
                    showConfirmButton: true,
                    confirmButtonText: 'Aceptar'
                   // timer: 10000
                  }).then((result) => {

                  });

                  $("#frmAgregar").trigger("reset");


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
                console.log(response.result);
                var keys = Object.keys(response.result);
                var values = Object.values(response.result);
                console.log(keys);
                console.log(values);

                keys.forEach(function(relation, indice) {
                   // console.log(relation);
                  //  console.log(indice);
                    var html_option = '<option value="">Seleccione</option>';
                    if(values[indice].length > 0) {
                        values[indice].forEach(function(data, indice2) { 
                            html_option += '<option value="'+data.id_key+'">'+data.value+'</option>';
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