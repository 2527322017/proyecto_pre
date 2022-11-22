var URL_AJAX = proyecto_carpeta + 'procesar_datos/reportes__casos_tipo_registro';
var URL_AJAX_LOCAL = proyecto_carpeta + 'generar_reporte/reporte_tipo_registro';
var URL_AJAX_RELATION = proyecto_carpeta + 'procesar_datos/reportes__filtros_relations';
var DATOS_MUNICIPIO = [];
$(document).ready(function () {
    mostrar_datos('');//limpiar la tabla
    set_relations(); //llenar los selectores relacionados
    var validatorFrm = $("#frmConsultar").validate();
    $("#frmConsultar").submit(function(e) {
        e.preventDefault();
        if(validatorFrm.form()){
            consultar();
        }
    });

    $("#bntPdf").click(function (e) { 
        e.preventDefault();
        $("#tipo_reporte").val(1);
        $("#table_reporte").val($("#tblReporte").html());
        $("#frmReporteExport").attr('action',URL_AJAX_LOCAL);
        $("#frmReporteExport").submit();
    });

    $("#bntExcel").click(function (e) { 
        e.preventDefault();
        $("#tipo_reporte").val(2);
        $("#table_reporte").val($("#tblReporte").html());
        $("#frmReporteExport").attr('action',URL_AJAX_LOCAL);
        $("#frmReporteExport").submit();
    });

    $("#frmConsultar select[name='departamento_id']").change(function (e) { 
        var html_option = '<option value="">Seleccione</option>';
        var id_depto = $(this).val();
        if(DATOS_MUNICIPIO.length > 0 && id_depto > 0) {
            municipiosxdepto = DATOS_MUNICIPIO.filter(muni => muni.departamento_id == id_depto);

            municipiosxdepto.forEach(function(data, indice2) { 
                html_option += '<option value="'+data.id_key+'">'+data.value+'</option>';
            });  
        }
        $("#frmConsultar select[name='municipio_id']").html(html_option);    
    });

});


function consultar() {
    $.ajax({
        type: "POST",
        url: URL_AJAX,
        dataType: "json",
        data: $("#frmConsultar").serialize(),
        beforeSend: function() {
            loader.open('',true);
        },
        success: function (response) {
            loader.close();
            var html_tbody = '';
            if(response.status == 'success') {
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
                    
                    html_tbody += `<tr nobre="true">
                                <td>${registro.fecha_crea}</td>
                                <td>${registro.codigo}</td>
                                <td>${registro.tipo_registro}</td>
                                <td>${registro.nombre} ${registro.apellido}</td>
                                <td>${registro.genero}</td>
                                <td>${registro.correo}</td>
                                <td>${registro.departamento}</td>
                                <td>${registro.municipio}</td>
                                <td>${registro.tipo_cliente}</td>
                                <td>${registro.area_salud}</td>
                                <td>${estado_registro}</td>
                             </tr>`;
                });

                mostrar_datos(html_tbody);

                $("#desde_").val($("#desde").val());
                $("#hasta_").val($("#hasta").val());
                $("#dvBtnExport").show();
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
    
    if(html == '') {
        html = '<tr><td colspan="8" align="center">Sin registros</td><tr>';
    }
    $("#tblReporte table tbody").html(html);
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
                var keys = Object.keys(response.result);
                var values = Object.values(response.result);
                keys.forEach(function(relation, indice) {
                    var html_option = '<option value="">Seleccione</option>';
                    if(values[indice].length > 0) {
                        values[indice].forEach(function(data, indice2) { 
                            extra_field = (data.data_extra != '')? 'data_extra="'+data.data_extra+'" ':'';
                            html_option += '<option value="'+data.id_key+'" '+extra_field+' >'+data.value+'</option>';
                        });
                    }

                    //llenar los selectores
                    $("#frmConsultar select[name='"+relation+"']").html(html_option);

                    //condicionar selectore especiales.
                    if(relation == 'municipio_id') {
                        DATOS_MUNICIPIO = values[indice];
                        $("#frmConsultar select[name='"+relation+"']").html('<option value="">Seleccione</option>');
                    }
                    
                }); 
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
           console.log(textStatus);
           loader.close();
           alert_error();
        }
    });
}