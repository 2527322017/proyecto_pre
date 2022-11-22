$(document).ready(function () {
    $("body").on('click',"#sidebar-menu a[href*='/page/']", function(e) {
        if($(".chatbot-iframe-container").length <= 0) { //si esta activo el chatbot recargar la pagina
            e.preventDefault();
            var href_page = $(this).attr('href');
            var name_page = $(this).attr('href').split('/').pop();
            var parentMenu = $(this).parent(); //padre
            window.history.pushState("", "", name_page);
        
            $("#main_page").load(href_page, function( response, status, xhr ) {
                if ( status == "error" ) {
                  console.log( xhr.status + " " + xhr.statusText );
                } 
              });
    
            setTimeout(function() {
                $("#sidebar-menu a[href*='/page/']").parent().removeClass('active');
                $("#sidebar-menu a[href*='/page/']").parent().removeClass('current-page');
                parentMenu.addClass('current-page');
                parentMenu.addClass('active');
                if(is_mobile()) {
                    $("#menu_toggle").trigger('click');
                }
                /*
                setTimeout(() => {
                    if($(this).parent().hasClass('active-sm')) { //si esta en modo responsive
                        $(".current-page").parent().parent().find('a:first').trigger('click');
                    } 
                }, 1000);
                */
                

            }, 500);
        }
    });


    $("body").on("keypress", ".soloLetras" , function(e) {
        if ($(this).attr('extras')) {
            var masC = $(this).attr('extras');
            return soloLetras(e, masC);
        } else {
            return soloLetras(e, '');
        }
    });

    $("body").on("keypress", ".soloNumeros" , function(e) {
        if ($(this).attr('extras')) {
            var masC = $(this).attr('extras');
            return soloNumeros(e, masC);
        } else {
            return soloNumeros(e, '');
        }
    });


});

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
    },
    openSwal: function(mensaje) {
        if (mensaje == null) {
            mensaje = '';
        }
        Swal.fire({
            title: '',
            html: mensaje,
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    },
    closeSwal: function() {
        swal.close();
    }
};

function is_mobile() {
    let navegador = navigator.userAgent;
    if (navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i) || navigator.userAgent.match(/Windows Phone/i) || window.innerWidth <= 780) {
        return true;
    } else {
        return false;
    }
}

//mensajes personalizados
jQuery.extend(jQuery.validator.messages, {
    required: "Campo requerido.",
    remote: "Please fix this field.",
    email: "Por favor ingrese un correo valido",
    url: "Please enter a valid URL.",
    date: "Please enter a valid date.",
    dateISO: "Please enter a valid date (ISO).",
    number: "Please enter a valid number.",
    digits: "Please enter only digits.",
    creditcard: "Please enter a valid credit card number.",
    equalTo: "Valor ingresado no coincide.",
    accept: "Please enter a value with a valid extension.",
    maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
    minlength: jQuery.validator.format("Por favor ingresar al menos {0} caracteres."),
    rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
    range: jQuery.validator.format("Please enter a value between {0} and {1}."),
    max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
    min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
});

function soloLetras(e, masCaracteres) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    if (tecla == '\'' || tecla == '%' || tecla == '"' ) { return false;} 
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz" + masCaracteres;
    especiales = [8,37,39,46,13,9];
    // especiales = [13];

    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial)
     {    return false; }
}

function soloNumeros(e, masCaracteres) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    if (tecla == '\'' || tecla == '%' || tecla == '"' ) { return false;} 
    letras = " 1234567890.-" + masCaracteres;
    especiales = [8,37,39,46,13,9];
    // especiales = [13];

    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial)
     {    return false; }
}

function alert_error() {
    swal.fire("Server Error", "Error de servidor, favor intentar más tarde", "error");
}