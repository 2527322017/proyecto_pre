var URL_AJAX = '/reclamos_sugerencias/procesar_datos/asignar_reclamo';
var URL_AJAX_RELATION = '/reclamos_sugerencias/procesar_datos/asignar_reclamo__relations';

$(document).ready(function () {
    consultar(); //llamar al cargar la pagina
    set_relations(); //llenar los selectores relacionados

    var validatorEdit = $("#frmEditar").validate( {
            messages: { required: 'Campo requerido' }
        });


    
    $("#frmEditar").submit(function(e) {
        e.preventDefault();
        if(validatorEdit.form()){
            editar();
        }
    });


});




function consultar() {
    $.ajax({
        type: "GET",
        url: URL_AJAX,
        dataType: "json",
        beforeSend: function() {
            loader.open('',true);
        },
        success: function (response) {
            loader.close();
            var html_tbody = '';
            if(response.status == 'success') {
                response.result.forEach(function(registro, indice) {
                    estado_registro = 'Registrado';
                    switch (registro.estado) {
                        case 2:
                            estado_registro = 'Análisis';
                            break;
                        case 3:
                            estado_registro = 'Verificación';
                            break;
                        case 4:
                            estado_registro = 'Finalizado';
                            break;
                    
                        default:
                            estado_registro = 'Registrado';
                            break;
                    }
                    html_tbody += `<tr class="even pointer" data-id="${registro.id_key}">
                                <td data="indice">${indice + 1}</td>
                                <td data="fecha_crea">${registro.fecha_crea}</td>
                                <td data="codigo">${registro.codigo}</td>
                                <td data="tipo_cliente">${registro.tipo_registro}</td>
                                <td data="nombre">${registro.nombre} ${registro.apellido}</td>
                                <td data="tipo_cliente">${registro.tipo_cliente}</td>
                                <td >${registro.departamento}</td>
                                <td >${registro.municipio}</td>
                                <td data="numero_documento">${registro.numero_documento}</td>
                                <td data="estado" data-value="${registro.estado}" >${estado_registro}</td>
                                <td data="accion" class="acciones">`;
                                 //establecer las relaciones del registro
                                html_tbody += `<textarea style="display:none;" data-field="descripcion">${registro.descripcion}</textarea>`;

                                html_tbody += `<button type="button" class="btn btn-info btnEditar" data-id="${registro.id_key}" >Asignar</button>
                                </td>
                             </tr>`;
                });

                mostrar_datos(html_tbody);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
           console.log(textStatus);
           loader.close();
        }
    });
}


function editar() {
    $.ajax({
        type: "PUT",
        url: URL_AJAX,
        dataType: "json",
        data: $("#frmEditar").serialize(),
        beforeSend: function() {
            loader.open();
        },
        success: function (response) {
            loader.close();
            if(response.status == 'success') {
                consultar();
                Swal.fire({
                   // position: 'top-end',
                    icon: 'success',
                    title: '!Éxito!',
                    text: 'Registro asignado con éxito',
                    showConfirmButton: false,
                    timer: 2000
                  }).then((result) => {
                    //consultar();
                  });

                  $("#frmEditar").trigger("reset");
                  // validatorEdit.resetForm();
                   $("#editarModal").modal('hide');


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


function load_editar(id) {
    registro = $("#tblDatos tr[data-id='"+id+"']");
    $("#frmEditar input[name='id']").val(id);
    $("#frmEditar input[name='codigo']").val(registro.find("td[data='codigo']").text());
    $("#frmEditar #txtDetalle").val(registro.find("textarea[data-field='descripcion']").val()); 

    //selected value relations
    registro.find(".relations").each(function( index, element ) {
        // element == this
        if($(element).val() != '') {
            $("#frmEditar select[name='"+$(element).attr('data-field')+"'] option[value='"+$(element).val()+"']").attr('selected', true);
            $("#frmEditar select[name='"+$(element).attr('data-field')+"']").val($(element).val()); 
        } else {
            $("#frmEditar select[name='"+$(element).attr('data-field')+"'] option[value='']").attr('selected', true);
            $("#frmEditar select[name='"+$(element).attr('data-field')+"']").val('');  
        }
        
      });


    $("#editarModal").modal();
}

function mostrar_datos(html) {
    if ( $.fn.DataTable.isDataTable('#tblMain') ) {
        $('#tblMain').DataTable().destroy();
    }
    $('#tblMain tbody').empty();
    $("#tblDatos").html(html);
    load_functions_async();
    $('#tblMain').DataTable();
}

function load_functions_async() {
    $(".btnEditar").click(function (e) { 
        e.preventDefault();
        id = $(this).attr('data-id');
        load_editar(id);
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
                    $("#frmEditar select[name='"+relation+"']").html(html_option);
                    
                }); 


            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
           console.log(textStatus);
           loader.close();
        }
    });
}