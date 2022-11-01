$(document).ready(function () {
    $("body").on('click',"#sidebar-menu a[href*='reclamos_sugerencias/page/']", function(e) {
        e.preventDefault();
        var href_page = $(this).attr('href');
        var name_page = $(this).attr('href').split('/').pop();
        window.history.pushState("", "", name_page);
        //loader.open();
        $( "#main_page").load(href_page, function( response, status, xhr ) {
            //loader.close();
            if ( status == "error" ) {
              console.log( xhr.status + " " + xhr.statusText );
            }
          });
    });
});

var loader = {
    open: function(mensaje) {
        if (mensaje == null) {
            mensaje = '';
        }
        $("#dvWaitPage").remove(); //si existe eliminarlo
        html_load = '<div id="dvWaitPage" style="position: fixed; font-size: 25px; top: 0px; z-index: 999999999; width: 100%; height: 100%; text-align: center; background: #e0e0e070;">';
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