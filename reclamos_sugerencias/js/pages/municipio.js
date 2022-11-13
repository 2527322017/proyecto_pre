var URL_AJAX = proyecto_carpeta + 'procesar_datos/municipio';
var URL_AJAX_RELATION = proyecto_carpeta + 'procesar_datos/municipio__relations';

$(document).ready(function () {
    consultar(); //llamar al cargar la pagina
    set_relations(); //llenar los selectores relacionados

    var validatorAdd = $("#frmAgregar").validate( {
        messages: { required: 'Campo requerido' }
        });

    var validatorEdit = $("#frmEditar").validate( {
            messages: { required: 'Campo requerido' }
        });

    $("#frmAgregar").submit(function(e) {
        e.preventDefault();
        if(validatorAdd.form()){
            agregar();
        }
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
                    estado_registro = (registro.estado == 1)? 'Activo':'Inactivo';
                    html_tbody += `<tr class="even pointer" data-id="${registro.id_key}">
                                <td data="indice">${indice + 1}</td>
                                <td data="nombre">${registro.nombre}</td>
                                <td >${registro.departamento}</td>
                                <td data="estado" data-value="${registro.estado}" >${estado_registro}</td>
                                <td data="accion" class="acciones">`;
                    
                    //establecer las relaciones del registro
                    html_tbody += `<input type="hidden" class="relations" data-field="departamento_id"  value="${(registro.departamento_id > 0 ? registro.departamento_id:'')}">`;

                    html_tbody += `<button type="button" class="btn btn-info btnEditar" data-id="${registro.id_key}" >Editar</button>
                                <button type="button" class="btn btn-danger btnEliminar" data-id="${registro.id_key}" >Eliminar</button>
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
                consultar();
                Swal.fire({
                   // position: 'top-end',
                    icon: 'success',
                    title: '!Éxito!',
                    text: 'Registro ingresado con éxito',
                    showConfirmButton: false,
                    timer: 2000
                  }).then((result) => {
                    //consultar();
                  });

                  $("#frmAgregar").trigger("reset");
                  // validatorAdd.resetForm();
                   $("#agregarModal").modal('hide');


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
                    text: 'Registro actualizado con éxito',
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

function eliminar(id_registro) {
    $.ajax({
        type: "DELETE",
        url: URL_AJAX,
        dataType: "json",
        data: {id:id_registro},
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
                    text: 'Registro eliminado con éxito',
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
    $("#frmEditar input[name='nombre']").val(registro.find("td[data='nombre']").text());
    estado = registro.find("td[data='estado']").attr('data-value');
    $("#frmEditar select[name='estado'] option[value='"+estado+"']").attr('selected', true);
    $("#frmEditar select[name='estado']").val(estado);  

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
    
    $(".btnEliminar").click(function (e) { 
        e.preventDefault();
        var id = $(this).attr('data-id');
        var text_delete =  $("#tblDatos tr[data-id='"+id+"']").find("td[data='nombre']:first").text();
        Swal.fire({
            title: 'Confirmación',
            html: `¿Eliminar registro <b>${text_delete}</b> ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                eliminar(id);
            } 
        })
    
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
                    $("#frmEditar select[name='"+relation+"']").html(html_option);
                    
                }); 

                /*response.result.forEach(function(relation, indice) {
                    console.log(relation);
                    console.log(indice);
                    var html_option = '<option value="">Seleccione</option>';
                    if(relation.length > 0) {
                        relation.forEach(function(data, indice2) { 
                            html_option += '<option value="'+data.id_key+'">'+data.value+'</option>';
                        });
                    }

                    //llenar los selectores
                    $("#frmAgregar select[name='"+indice+"']").html(html_option);
                    $("#frmEditar select[name='"+indice+"']").html(html_option);
                    
                }); */

            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
           console.log(textStatus);
           loader.close();
        }
    });
}