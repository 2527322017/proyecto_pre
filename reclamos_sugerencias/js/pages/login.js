var URL_AJAX = '/reclamos_sugerencias/procesar_datos/login';
$(document).ready(function () {
    var validatorLogin = $("#frmLogin").validate( {
        rules: {
           // usuario: "required",
            clave: "required",
            usuario: {
                required: true,
                /*minlength: 2,
                remote: "users.php" */
            }
        },
        messages: {
            clave: "Clave requerida",
            usuario: {
                required: "Usuario requerido",
               /* minlength: jQuery.format("Ingresar {0} caracteres"),
                remote: jQuery.format("{0} listo usuario valido")*/
            }
        }
        });
    
    $("#frmLogin").submit(function(e) {
        e.preventDefault();
        if(validatorLogin.form()){
            login();
        }
    });


});





function login() {
    $.ajax({
        type: "POST",
        url: URL_AJAX,
        dataType: "json",
        data: $("#frmLogin").serialize(),
        beforeSend: function() {
            loader.open();
        },
        success: function (response) {
            loader.close();
            if(response.status == 'success') {
                loader.open('Bienvenido/a ' + response.result.nombre);
                location.href = 'page/';
               /* Swal.fire({
                   // position: 'top-end',
                    icon: 'success',
                    title: '!Éxito!',
                    text: 'Registro ingresado con éxito',
                    showConfirmButton: false,
                    timer: 2000
                  }).then((result) => {
                    //consultar();
                  }); */

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


var loader = {
    open: function(mensaje, superposcion) {
        if (mensaje == null) {
            mensaje = '';
        }
        z_index = '999999999';
        if (superposcion) {
            z_index = '999';
        } 
        $("#dvWaitPage").remove(); //si existe eliminarlo
        html_load = '<div id="dvWaitPage" style="position: fixed; font-size: 25px; top: 0px; z-index: '+z_index+' ; width: 100%; height: 100%; text-align: center; background: #e0e0e070;">';
        html_load += '<style>';
        html_load += '  .loaderDiv { border: 16px solid #f7f4f4; border-radius: 50%; border-top: 16px solid #4a4a4a; width: 100px; height: 100px; -webkit-animation: spin 2s linear infinite; animation: spin 2s linear infinite; left: 48%; position: relative; margin-left: -25px;}';
        html_load += '/* Safari */';
        html_load += '@-webkit-keyframes spin { 0% { -webkit-transform: rotate(0deg); } 100% { -webkit-transform: rotate(360deg); } }';
        html_load += '@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }';
        html_load += '@-webkit-keyframes spinning { 0% {-webkit-transform: rotate(0deg);} 50% {-webkit-transform: rotate(180deg);} 100% {-webkit-transform: rotate(360deg);}';
        html_load += '}';
        html_load += '</style>';
        html_load += '<span style="top: calc(50% - 50px); position: relative;">';
        html_load += '<div class="loaderDiv"></div>';
        html_load += '<div style="color: #4a4646;">' + mensaje + '</div>';
        html_load += '</span>';
        html_load += '</div>';
        $("body").append(html_load);
    },
    close: function() {
        if (document.getElementById("dvWaitPage")) {
            var element = document.getElementById('dvWaitPage');
            element.parentNode.removeChild(element);
        }
    }
};