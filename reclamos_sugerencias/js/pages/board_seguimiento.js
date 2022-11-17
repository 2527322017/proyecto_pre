var URL_AJAX = proyecto_carpeta + 'procesar_datos/seguimiento_reclamo';
var URL_AJAX_ORDEN = proyecto_carpeta + 'procesar_datos/seguimiento_reclamo__orden_update';
var URL_AJAX_UPDATE = proyecto_carpeta + 'procesar_datos/seguimiento_reclamo__status_update';
var URL_AJAX_DETALLE = proyecto_carpeta + 'procesar_datos/seguimiento_reclamo__get_detalle';
var URL_AJAX_RELATION = proyecto_carpeta + 'procesar_datos/seguimiento_reclamo__relations';
var URL_AJAX_ADMIN = proyecto_carpeta + 'procesar_datos/seguimiento_reclamo__consultar_admin';

$(document).ready(function () {
    consultar(); //llamar al cargar la pagina
    set_relations(); //llenar los selectores relacionados

    //recargar cada 5 min
   /* setInterval(() => {
        if(window.location.pathname.indexOf('board') != -1) {
            consultar();
        }
    }, 300000);
    */

    var validatorAdd = $("#frmAgregar").validate();

    $("#frmAgregar").submit(function(e) {
        e.preventDefault();
        if(validatorAdd.form()){
            agregar_seguimiento_caso();
        }
    });


    $("#dvCorreo").hide();
    $("#frmAgregar select[name='tipo_res_id']").change(function (e) { 
       if($(this).val() > 0 && $("#frmAgregar input[name='codigo']").attr('correo') != '') {
        $("#dvCorreo").show('slow');
       } else {
        $("#frmAgregar select[name='notificar_correo']").val('0');
        $("#dvCorreo").hide('slow');
       }        

       if($(this).val() > 0) {
        $("#dvMsg").show('slow');
       } else {
        $("#dvMsg").hide('slow');
       }

    });


    $("select[name='usuario_id']").change(function (e) {    
        consultar_admin();
     });


});




function consultar() {
    if($("select[name='usuario_id']").length > 0 && $("select[name='usuario_id']").val() > 0) {
        consultar_admin();
    } else {
        consultar_tecnico();
    }
}


function consultar_tecnico() {
    $.ajax({
        type: "GET",
        url: URL_AJAX,
        dataType: "json",
        beforeSend: function() {
            loader.open('',true);
        },
        success: function (response) {
            loader.close();
            if(response.status == 'success') {
                var ItemsKanba = [];
                response.result.forEach(function(registro, indice) {
                    estado_registro = 'Registrado';
                    switch (parseInt(registro.estado)) {
                        case 2:
                            estado_registro = 'Asignado';
                            break;
                        case 3:
                            estado_registro = 'Análisis';
                            break;
                        case 4:
                            estado_registro = 'Verificación';
                            break;
                        case 5:
                            estado_registro = 'Finalizado';
                            break;
                    
                        default:
                            estado_registro = 'Registrado';
                            break;
                    }
                    html_resol = (registro.tipo_resolucion != '')?  `<div class="dvResolucion" data-key="${registro.id_key}"> Resoluci&oacute;n: ${registro.tipo_resolucion}</div>`:'';
                    title_html = `${registro.tipo_registro} 
                                <div class="dvInfo"> ${registro.nombre} ${registro.apellido} 
                                <br /> ${registro.fecha_crea}
                                </div> <div class="dvCodigo" data-key="${registro.id_key}" data-cod="${registro.codigo}" data-correo="${registro.correo}" > Cód. ${registro.codigo}</div>
                                ${html_resol}
                                `;

                    footer_html = `
                    <div class="divBtnAcciones">
                    <button type="button" title="ver detalle" onclick="ver_detalle(${registro.id_key});" class="btn btn-outline-info">Detalle</button>
                    <button type="button" title="Detalle seguimiento" onclick="agregar_seguimiento(${registro.id_key});" class="btn btn-outline-info">Seguimiento</button>
                    </div>
                    `;
                    ItemsKanba.push({
                        id: registro.id_key,
                        title: title_html,
                        block: estado_registro,
                       // link: '#',
                       // link_text: 'Ver detalle',
                        footer: footer_html
                    });
                });
                makeTablero(ItemsKanba);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
           console.log(textStatus);
           loader.close();
        }
    });
}

function makeTablero(itemsTablero) {
    $('#kanban').html(''); //vaciar
    $('#kanban').kanban({
        titles: ['Asignado' , 'Análisis' , 'Verificación' , 'Finalizado'],
        colours: ['#00aaff','#ff921d','#ffe54b','#00ff40'],
        items: itemsTablero,
        onChange:function(e,ui) {
            
            var orden_registros1 = [];
            setTimeout(() => {
                $(e.target).find('.cd_kanban_board_block_item').each(function(index, elemento){
                    orden_registros1.push($(elemento).attr('data-id'));
                });
                ordenar_seguimiento(orden_registros1);
            }, 2000);
            
        },
        onReceive:function(e,ui) {  

            var estado_tablero2 = e.target.getAttribute("data-block");
            var orden_registros2 = [];
            setTimeout(() => {
                $(e.target).find('.cd_kanban_board_block_item').each(function(index, elemento){
                    orden_registros2.push($(elemento).attr('data-id'));
                });
                ordenar_seguimiento(orden_registros2);
            }, 1000);

            

            var id_update = $(ui.item).attr('data-id');
            update_seguimiento(id_update, estado_tablero2);
        },
    });
}

function ordenar_seguimiento(registros) {
    if(registros.length > 0 ) {
        $.ajax({
            type: "POST",
            url: URL_AJAX_ORDEN,
            dataType: "json",
            data: {registros:registros},
            beforeSend: function() {
               // loader.open('',true);
            },
            success: function (response) {
                
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
               console.log(textStatus);
               //loader.close();
            }
        });
    }

}

function update_seguimiento(id_caso, estado, updateBoard) {
   var updateBoard = (typeof updateBoard !== 'undefined') ?  1: 0;

    $.ajax({
        type: "POST",
        url: URL_AJAX_UPDATE,
        dataType: "json",
        data: {estado:estado, id:id_caso},
        beforeSend: function() {
            loader.open('',true);
        },
        success: function (response) {
            loader.close();
            if(updateBoard == 1) {
                consultar();
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
            setTimeout(() => { loader.close(); }, 1500); //cerrar luego de renderizar el contenido
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
                    $("select[name='"+relation+"']").html(html_option);
                    $("select[name='"+relation+"']").removeAttr('disabled');
                    
                }); 


            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
           console.log(textStatus);
           loader.close();
        }
    });
}

function agregar_seguimiento(id) {
    cod = $(".dvCodigo[data-key='"+id+"']").attr('data-cod');
    correo = $(".dvCodigo[data-key='"+id+"']").attr('data-correo');
    $("#frmAgregar input[name='id']").val(id);
    $("#frmAgregar input[name='codigo']").val(cod);
    $("#frmAgregar input[name='codigo']").attr('correo',correo);
    $("#frmAgregar select[name='tipo_res_id'] option").removeAttr('selected');
    $("#frmAgregar select[name='tipo_res_id']").val('');
    $("#frmAgregar textarea[name='comentario']").val('');
    $("#frmAgregar select[name='tipo_res_id']").trigger('change');
    $("#agregarModal").modal();
}

function agregar_seguimiento_caso() {
    
    $.ajax({
        type: "POST",
        url: URL_AJAX,
        dataType: "json",
        data:  $("#frmAgregar").serialize(),
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
                    html: 'Seguimiento ingresado con éxito',
                    showConfirmButton: true,
                    confirmButtonText: 'Aceptar'
                   // timer: 10000
                  }).then((result) => {
                    if($("#frmAgregar select[name='tipo_res_id']").val() > 0) { //si se selecciono resolución enviar a finalizado
                        update_seguimiento($("#frmAgregar input[name='id']").val(), 'Finalizado', 1);
                    }                    
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

function consultar_admin() {
    $.ajax({
        type: "POST",
        url: URL_AJAX_ADMIN,
        dataType: "json",
        data:{id_user_tecnico:$("select[name='usuario_id']").val()},
        beforeSend: function() {
            loader.open('',true);
        },
        success: function (response) {
            loader.close();
            if(response.status == 'success') {
                var ItemsKanba = [];
                response.result.forEach(function(registro, indice) {
                    estado_registro = 'Registrado';
                    switch (parseInt(registro.estado)) {
                        case 2:
                            estado_registro = 'Asignado';
                            break;
                        case 3:
                            estado_registro = 'Análisis';
                            break;
                        case 4:
                            estado_registro = 'Verificación';
                            break;
                        case 5:
                            estado_registro = 'Finalizado';
                            break;
                    
                        default:
                            estado_registro = 'Registrado';
                            break;
                    }

                    html_resol = (registro.tipo_resolucion != '')?  `<div class="dvResolucion" data-key="${registro.id_key}"> Resoluci&oacute;n: ${registro.tipo_resolucion}</div>`:'';
                    title_html = `${registro.tipo_registro} 
                                <div class="dvInfo"> ${registro.nombre} ${registro.apellido} 
                                <br /> ${registro.fecha_crea}
                                </div> <div class="dvCodigo" data-key="${registro.id_key}" data-cod="${registro.codigo}" data-correo="${registro.correo}" > Cód. ${registro.codigo}</div>
                                ${html_resol}
                                `;

                    footer_html = `
                    <div class="divBtnAcciones">
                    <button type="button" title="ver detalle" onclick="ver_detalle(${registro.id_key});" class="btn btn-outline-info">Detalle</button>
                    <button type="button" title="Detalle seguimiento" onclick="agregar_seguimiento(${registro.id_key});" class="btn btn-outline-info">Seguimiento</button>
                    </div>
                    `;
                    ItemsKanba.push({
                        id: registro.id_key,
                        title: title_html,
                        block: estado_registro,
                       // link: '#',
                       // link_text: 'Ver detalle',
                        footer: footer_html
                    });
                });
                makeTablero(ItemsKanba);
            }
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

