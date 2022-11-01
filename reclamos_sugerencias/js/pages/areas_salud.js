$(document).ready(function () {
  consultar(); //llamar al cargar la pagina
});

function consultar() {
    $.ajax({
        type: "GET",
        url: '/reclamos_sugerencias/procesar_datos/areas_salud',
        data: {service:'areas_salud'},
        dataType: "json",
        beforeSend: function() {
            loader.open();
        },
        success: function (response) {
            loader.close();
            var html_table = '';
            if(response.status == 'success') {
                response.result.forEach(function(registro, indice) {
                    estado_registro = (registro.estado == 1)? 'Activo':'Inactivo';
                    html_table += `<tr class="even pointer">
                                <td>${indice + 1}</td>
                                <td>${registro.nombre}</td>
                                <td>${estado_registro}</td>
                                <td>
                                <a href="#">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modaEditar" >Editar</button>
                                </a>
                                </td>
                             </tr>`;
                });

                $("#tblDatos").html(html_table);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
           console.log(textStatus);
           loader.close();
        }
    });
}