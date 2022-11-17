var URL_AJAX = proyecto_carpeta + 'procesar_datos/reportes__reclamos_resoluciones';
var URL_AJAX_LOCAL = proyecto_carpeta + 'generar_reporte/';

$(document).ready(function () {

    //consultar(); //llamar al cargar la pagina
    mostrar_datos('');
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
                                <td>${registro.tipo_cliente}</td>
                                <td>${estado_registro}</td>
                                <td>${registro.tipo_resolucion}</td>
                                <td>${registro.usuarios}</td>
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



