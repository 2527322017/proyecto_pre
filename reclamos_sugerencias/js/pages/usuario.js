var URL_AJAX = '/reclamos_sugerencias/procesar_datos/usuario';
$(document).ready(function () {
    consultar(); //llamar al cargar la pagina

    var validatorAdd = $("#frmAgregar").validate( {
        rules: {
            clave: {
                minlength: 5,
            },
            clave_confirm: {
                minlength: 5,
                equalTo: "#clave"
            }
        }
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
                    tipo_usu = $("#frmAgregar select[name='tipo'] option[value='"+registro.tipo+"']").text();

                    html_tbody += `<tr class="even pointer" data-id="${registro.id_key}">
                                <td data="indice">${indice + 1}</td>
                                <td data="nombre">${registro.nombre}</td>
                                <td data="usuario">${registro.usuario}</td>
                                <td data="correo">${registro.correo}</td>
                                <td data="clave" data-value="${registro.clave}" >${registro.clave.substring(0, 20)}...</td>
                                <td data="tipo" data-value="${registro.tipo}" >${tipo_usu}</td>
                                <td data="estado" data-value="${registro.estado}" >${estado_registro}</td>
                                <td data="accion" class="acciones">
                                <button type="button" class="btn btn-info btnEditar" data-id="${registro.id_key}" >Editar</button>
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
    $("#frmEditar input[name='usuario']").val(registro.find("td[data='usuario']").text());
    $("#frmEditar input[name='correo']").val(registro.find("td[data='correo']").text());
    
    estado = registro.find("td[data='estado']").attr('data-value');
    $("#frmEditar select[name='estado'] option[value='"+estado+"']").attr('selected', true);
    $("#frmEditar select[name='estado']").val(estado);  

    tipo = registro.find("td[data='tipo']").attr('data-value');
    $("#frmEditar select[name='tipo'] option[value='"+tipo+"']").attr('selected', true);
    $("#frmEditar select[name='tipo']").val(tipo);  


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