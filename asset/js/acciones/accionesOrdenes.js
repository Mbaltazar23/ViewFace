$(document).ready(function () {
    $("#telefono").on("click", function () {
        $("#telefono").removeAttr("readonly");
    });
    $("#form-registrar-orden").submit(function (e) {
        e.preventDefault();
        let nombre = $("#nombre").val();
        let telefono = $("#telefono").val();
        let correo = $("#correo").val();
        let clave = $("#clave").val();
        let clave_R = $("#Repetirclave").val();
        var regexCoreo = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
        var regexTelefono = /^(\+?56)?(\s?)(0?9)(\s?)[9876543]\d{7}$/;
        let mensajes = [];
        let error = false;
        if (nombre == "") {
            mensajes.push("Debe ingresar un nombre.");
            error = true;
        }
        if (telefono == "") {
            mensajes.push("Debe ingresar un Numero telefonico.");
            error = true;
        }
        if (correo == "") {
            mensajes.push("Debe ingresar el Correo.");
            error = true;
        }
        if (correo.length > 40) {
            mensajes.push("El correo es demasiado largo. Max. 40 caractéres.");
            error = true;
        }
        if (!regexCoreo.test(correo.trim())) {
            mensajes.push("Ingrese un Correo válido.");
            error = true;
        }
        if (!regexTelefono.test(telefono.trim())) {
            mensajes.push("Ingrese un Telefono válido.");
            error = true;
        }
        if (clave == "" && clave_R == "") {
            mensajes.push("Debe ingresar la Clave.");
            error = true;
        }
        if (clave.length < 10 && clave_R.length < 10) {
            mensajes.push("La Clave ingresada no es valida.");
            error = true;

        } else if (clave != clave_R) {
            mensajes.push("La Clave no fue validada !!");
            error = true;
        }

        //console.log(mensajes);

        if (error == true) {
            for (let i = 0; i < mensajes.length; i++) {
                swal('Oops...', mensajes[i], 'error');
                //console.log(mensajes[i]);
            }
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "../../controladores/VinculoController.php?funcion=create",
                data: {nombre: nombre, telefono: telefono, correo: correo, clave: clave},
                success: function (data) {
                    if (data == true) {
                        swal({
                            title: "Exito !",
                            text: "Vinculo Enviado Exitosamente",
                            icon: "success"
                        }).then(function () {
                            window.location = urlIndex;
                        });
                    } else {
                        swal('Oops...', data, 'error');
                        $("#correo").val("");
                        $("#clave").val("");
                        $("#telefono").val("+569");
                    }
                }
            });
        }
    });
});

