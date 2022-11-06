var URL_AJAX = '/reclamos_sugerencias/procesar_datos/seguimiento_reclamo';
var URL_AJAX_RELATION = '/reclamos_sugerencias/procesar_datos/seguimiento_reclamo__relations';

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
                var ItemsKanba = [];
                response.result.forEach(function(registro, indice) {
                    estado_registro = 'Asignado';
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
                            estado_registro = 'Asignado';
                            break;
                    }

                    ItemsKanba.push({
                        id: registro.id_key,
                        title: registro.tipo_registro + ' (' + registro.nombre + ' ' + registro.apellido + ') ' + "<br />" + registro.fecha_crea,
                        text:'hola mundo',
                        block: estado_registro,
                        link: '#',
                        link_text: 'Ver detalle',
                        footer: '<div> Cód.:'+registro.codigo+'</div>'
                    });

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

                                html_tbody += `<button type="button" class="btn btn-info btnEditar" data-id="${registro.id_key}" >Seguimiento</button>
                                </td>
                             </tr>`;
                });
                makeTablero(ItemsKanba);
                //mostrar_datos(html_tbody);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
           console.log(textStatus);
           loader.close();
        }
    });
}


function makeTablero(itemsTablero) {
    $('#kanban').kanban({
        titles: ['Asignado' , 'Análisis' , 'Verificación' , 'Finalizado'],
        colours: ['#00aaff','#ff921d','#ffe54b','#00ff40'],
        items: itemsTablero
    });
}