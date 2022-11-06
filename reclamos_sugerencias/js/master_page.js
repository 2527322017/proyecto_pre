$(document).ready(function () {
    $("body").on('click',"#sidebar-menu a[href*='reclamos_sugerencias/page/']", function(e) {
        e.preventDefault();
        var href_page = $(this).attr('href');
        var name_page = $(this).attr('href').split('/').pop();
        var parentMenu = $(this).parent(); //padre
        window.history.pushState("", "", name_page);
        //loader.open();
        $("#main_page").load(href_page, function( response, status, xhr ) {
            //loader.close();
            if ( status == "error" ) {
              console.log( xhr.status + " " + xhr.statusText );
            } 
          });

     setTimeout(function() {
        $("#sidebar-menu a[href*='reclamos_sugerencias/page/']").parent().removeClass('active');
        $("#sidebar-menu a[href*='reclamos_sugerencias/page/']").parent().removeClass('current-page');
        parentMenu.addClass('current-page');
        parentMenu.addClass('active');
     }, 500);
      
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
    }
};

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