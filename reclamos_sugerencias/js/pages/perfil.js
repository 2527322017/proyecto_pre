var URL_AJAX = proyecto_carpeta + 'procesar_datos/perfil';
var URL_AJAX_USER = proyecto_carpeta + 'procesar_datos/perfil__update_user';
var URL_AJAX_PASS = proyecto_carpeta + 'procesar_datos/perfil__update_password';
$(document).ready(function () {
    consultar(); //llamar al cargar la pagina
    var validatorClave= $("#frmEditarClave").validate( {
        rules: {
            clave: {
                minlength: 5,
            },
            clave_confirm: {
                minlength: 5,
                equalTo: "#clave"
            }
        }
        });

    var validatorEdit = $("#frmEditar").validate();

    $("#frmEditarClave").submit(function(e) {
        e.preventDefault();
        if(validatorClave.form()){
            //Swal.fire('En desarrollo.. :(, intentar luego');
            editar_clave();
        }
    });
    
    $("#frmEditar").submit(function(e) {
        e.preventDefault();
        if(validatorEdit.form()) {
            editar();
        }
    });


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
            if(response.status == 'success') {
               $("#nombre").val(response.result.nombre);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
           console.log(textStatus);
           loader.close();
        }
    });
}


function editar_clave() {
    $.ajax({
        type: "POST",
        url: URL_AJAX_PASS,
        dataType: "json",
        data: $("#frmEditarClave").serialize(),
        beforeSend: function() {
            loader.open();
        },
        success: function (response) {
            loader.close();
            if(response.status == 'success') {
                Swal.fire({
                   // position: 'top-end',
                    icon: 'success',
                    title: '!Éxito!',
                    text: 'Registro ingresado con éxito',
                    showConfirmButton: false,
                    timer: 2000
                  }).then((result) => {
                    location.href = $("#lnkLogout").attr('href');
                  });

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


function editar() {
    $.ajax({
        type: "PUT",
        url: URL_AJAX_USER,
        dataType: "json",
        data: $("#frmEditar").serialize(),
        beforeSend: function() {
            loader.open();
        },
        success: function (response) {
            loader.close();
            if(response.status == 'success') {
                Swal.fire({
                   // position: 'top-end',
                    icon: 'success',
                    title: '!Éxito!',
                    text: 'Registro actualizado con éxito',
                    showConfirmButton: false,
                    timer: 2000
                  }).then((result) => {
                    //consultar();
                  });

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
