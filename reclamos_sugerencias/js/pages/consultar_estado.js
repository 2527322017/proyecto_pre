var URL_AJAX = proyecto_carpeta + 'procesar_datos/consulta_reclamo';

$(document).ready(function () {

    var validatorFrm = $("#frmConsultar").validate({
        rules: {
            codigo: "required"
        },
        errorPlacement : function( error, element ) { 
            error.appendTo('#error_codigo');
        }
    });

    $("#frmConsultar").submit(function(e) {
        e.preventDefault();
        c = $("#frmConsultar input[name='codigo']").val().trim();
        $("#frmConsultar input[name='codigo']").val(c);
        if(validatorFrm.form()){
            consultar();
        }
    });

});


function consultar() {
    $.ajax({
        type: "POST",
        url: URL_AJAX,
        dataType: "json",
        data:$("#frmConsultar").serialize(),
        beforeSend: function() {
            loader.open('',true);
        },
        success: function (response) {
            loader.close();
            
            if(response.status == 'success') {
                html_table = '';
                if(response.result.codigo) {
                    d = response.result;
                    estado_registro = 'Asignado';
                    switch (parseInt(d.estado)) {
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

                    html_table += `<tr><th width="15%">Código</th><td>${d.codigo}</td></tr>`;
                    html_table += `<tr><th>Nombre</th><td>${d.nombre} ${d.apellido}</td></tr>`;
                    html_table += `<tr><th>Fecha registro</th><td>${d.fecha_crea}</td></tr>`;
                    html_table += `<tr><th>Estado</th><td>${estado_registro}</td></tr>`;
                    if(d.tipo_resolucion != '') {
                        html_table += `<tr class="tr_resolucion"><th>Resolución</th><td>${d.tipo_resolucion}</td></tr>`;
                    }

                    $("#dvResultTbody").html(html_table);
                } else {
                    $("#dvResultTbody").html('<tr><td>No se encontraron registros</td></tr>');
                }
            } else {
                $("#dvResultTbody").html('<tr><td>No se encontraron registros</td></tr>');
            }
           
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
           console.log(textStatus);
           loader.close();
        }
    });
}