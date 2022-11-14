var URL_AJAX = proyecto_carpeta + 'procesar_datos/seguimiento_reclamo';
var URL_AJAX_DETALLE = proyecto_carpeta + 'procesar_datos/seguimiento_reclamo__get_detalle';

$(document).ready(function () {
    consultar(); //llamar al cargar la pagina

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
                    estado_registro = 'En proceso';
                    switch (parseInt(registro.estado)) {
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
                            estado_registro = 'En proceso';
                            break;
                    }
                    asignacion  = '';
                    if(type_user == 1) {
                        asignacion  = `<td data="usuarios">${registro.usuarios}</td>`;
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
                                <td data="tipo_resolucion">${registro.tipo_resolucion}</td>
                                ${asignacion}
                                <td data="accion" class="acciones">`;
                                html_tbody += `<button type="button" class="btn btn-info" data-id="${registro.id_key}" onclick="ver_detalle(${registro.id_key});" >Detalle</button>
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



function mostrar_datos(html) {
    if ( $.fn.DataTable.isDataTable('#tblMain') ) {
        $('#tblMain').DataTable().destroy();
    }
    $('#tblMain tbody').empty();
    $("#tblDatos").html(html);
    $('#tblMain').DataTable();
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
                const array_type_img = ['png', 'jpeg', 'jpg', 'gif', 'bmp', 'tif', 'PNG', 'JPEG', 'JPG', 'GIF', 'BMP', 'TIF'];
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

function loadFancybox() {
    Fancybox.bind('[data-fancybox="gallery"]', {
        caption: function (fancybox, carousel, slide) {
          return (
            `${slide.index + 1} / ${carousel.slides.length} <br />` + slide.caption
          );
        },
      });
}