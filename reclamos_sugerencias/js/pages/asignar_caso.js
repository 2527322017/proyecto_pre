var URL_AJAX = proyecto_carpeta + 'procesar_datos/asignar_reclamo';
var URL_AJAX_RELATION = proyecto_carpeta + 'procesar_datos/asignar_reclamo__relations';
var URL_AJAX_DETALLE = proyecto_carpeta + 'procesar_datos/seguimiento_reclamo__get_detalle';

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

                                html_tbody += `<button type="button" class="btn btn-info" onclick="ver_detalle(${registro.id_key});"  data-id="${registro.id_key}" >Detalle</button>
                                <button type="button" class="btn btn-info btnEditar" data-id="${registro.id_key}" >Asignar</button>
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



function ver_detalle(id_caso) {
    $.ajax({
        type: "POST",
        url: URL_AJAX_DETALLE,
        dataType: "json",
        data: {id:id_caso},
        beforeSend: function() {
            loader.open('',true);
        },
        success: function (response) {
            loader.close();
            registro_caso = response.result.registro;
            archivos_caso = response.result.archivos;
            seguimiento_caso = response.result.seguimiento;

            $(".lblTitle").text(registro_caso.tipo_registro);
            $(".lblTitle").text(registro_caso.tipo_registro);

            $("#modalInfo .td_info_nombre").html(registro_caso.nombre + ' ' + registro_caso.apellido);
            $("#modalInfo .td_info_documento").html(registro_caso.tipo_documento + ' ' + registro_caso.numero_documento);
            $("#modalInfo .td_info_correo").html(registro_caso.correo);
            $("#modalInfo .td_info_telefono").html(registro_caso.telefono);
            $("#modalInfo .td_info_genero").html(registro_caso.genero);
            direccion = (registro_caso.direccion_residencia == '')? '':registro_caso.direccion_residencia + ', ' + registro_caso.municipio + ', ' + registro_caso.departamento; 
            $("#modalInfo .td_info_direccion").html(direccion);
            $("#modalInfo .td_info_tipo_cliente").html(registro_caso.tipo_cliente);
            $("#modalInfo .td_info_area_salud").html(registro_caso.area_salud);
            $("#modalInfo .td_info_descripcion_caso").html(registro_caso.descripcion);

            if(archivos_caso.length > 0) {
                const array_type_img = ['png', 'jpeg', 'jpg', 'gif', 'bmp', 'tif'];
                var html_archivos = '<tr><td><div class="row">';
                archivos_caso.forEach(function(registro, indice) {
                    etiqueta_archivo = '';
                    if(array_type_img.includes(registro.extension)) {
                        etiqueta_archivo = `
                        <div class="col-md-4" style="text-align: center;">
                        <a
                        data-fancybox="gallery"
                        href="${proyecto_host}${registro.ruta}"
                        data-caption="${registro.nombre}"
                      >
                        <img src="${proyecto_host}${registro.ruta}"  height="100px"/>
                      </a>
                      </div>
                        `;
                    } else {
                        etiqueta_archivo = `
                        <div class="col-md-4" style="text-align: center;">
                        <a target="_blank" title="${registro.nombre}"
                        href="${proyecto_host}${registro.ruta}"
                        >
                        <img src="${proyecto_host}images/fileicon.png"  height="60px" title="${registro.nombre}"/>
                      </a>
                      </div>
                        `; 
                    }
                    /*
                    html_archivos += `<div class="col-md-4" style="text-align: center;">
                    ${etiqueta_archivo}
                    </div>`;
                    */
                    html_archivos += etiqueta_archivo;
                 });
                 html_archivos += `</div></td></tr>`;
                 $("#tbodyArchivos").html(html_archivos);
            } else {
                $("#tbodyArchivos").html('<tr><td>Sin registros</td></tr>');
            }

            if(seguimiento_caso.length > 0) {
                var html_seguimiento = '';
                seguimiento_caso.forEach(function(registro, indice) {
                    html_seguimiento += `<tr>
                    <td>${registro.fecha_registro}</td>
                    <td>${registro.comentario}</td>
                    <td>${registro.tipo_resolucion}</td>
                    <td>${registro.nombre_usuario}</td>
                </tr>`;
                 });
                 $("#tbodySeguimiento").html(html_seguimiento);
            } else {
                $("#tbodySeguimiento").html('<tr><td colspan="4">Sin registros</td></tr>');
            }


            $("#modalInfo").modal();
            loadFancybox();
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
           console.log(textStatus);
           loader.close();
        }
    });
   
}