$('#SesionModal').click(function () {
    swal({
        title: "Cerrar Sesion",
        text: "¿Realmente salir de su sesion?",
        icon: "info",
        buttons: true,
        dangerMode: false
    }).then((isClosed) => {
        if (isClosed) {
            $.ajax({
                type: "POST",
                url: urlIndex + "/controladores/PersonalController.php?funcion=logout",
                success: function (data) {
                    if (data) {
                        swal({
                            title: "Exito !",
                            text: "Sesion Finalizada !!",
                            icon: "success"
                        }).then(function () {
                            window.location = urlIndex;
                        });
                    }
                }
            });
        }
    });
});

$(document).ready(function () {
    $("#formClienteSesion").submit(function (e) {
        e.preventDefault();
        let correo = $("#correoCli").val();
        let clave = $("#claveCli").val();
        var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
        let mensaje = "";
        let error = false;
        if (correo == "") {
            mensaje = "El correo no puede estar vacio";
            error = true;
        } else if (!regex.test(correo)) {
            mensaje = "El correo ingresado no es valido";
            error = true;
        } else if (clave == "") {
            mensaje = "La clave no puede estar vacia";
            error = true;
        }

        if (error == true) {
            swal('Oops...', mensaje, 'error');
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: urlIndex + "/controladores/ClienteController.php?funcion=login",
                data: {correoCli: correo, claveCli: clave},
                success: function (data) {
                    var cliente = JSON.parse(data);
                    if (cliente) {
                        //console.log(personal);
                        swal({
                            title: "Exito !",
                            text: "Bienvenido(a) señor(a)" + cliente.NombreCliente,
                            icon: "success"
                        }).then(function () {
                            window.location = urlIndex;
                        });
                    } else {
                        swal('Oops...', "Su cuenta no Existe o esta Inhabilitada..", 'error');
                        return false;
                        $("#claveCli").val("");
                    }

                }
            });
        }
    });

    $("#form-loginPer").submit(function (e) {
        e.preventDefault();
        let correo = $('#correo').val();
        let clave = $('#clave').val();
        var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
        let mensaje = "";
        let error = false;
        if (correo == "") {
            mensaje = "Debe ingresar el Correo.";
            error = true;
        } else if (correo.length > 40) {
            mensaje = "El correo es demasiado largo. Max. 40 caractéres.";
            error = true;
        } else if (!regex.test(correo.trim())) {
            mensaje = "Ingrese un Correo válido.";
            error = true;
        } else if (clave == "") {
            mensaje = "Debe ingresar la Clave.";
            error = true;
        }

        if (error == true) {
            swal('Oops...', mensaje, 'error');
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "../../controladores/PersonalController.php?funcion=login",
                data: {correoPer: correo, clavePer: clave},
                success: function (data) {
                    var personal = JSON.parse(data);
                    //console.log(personal);
                    if (personal) {
                        swal({
                            title: "Exito !",
                            text: "Bienvenido(a) " + personal.CargoPersonal,
                            icon: "success"
                        }).then(function () {
                            window.location = urlIndex;
                        });
                    } else {
                        swal('Oops...', "Usted no forma parte del Personal", 'error');
                        return false;
                        $("#form-loginPer")[0].reset();
                    }
                }
            });
        }
    });
    $("#BotonSesionPersonal").on("click", function () {
        $("#form-loginPer")[0].reset();
    });

    $("#BotonSesionCliente").on("click", function () {
        $("#formClienteSesion")[0].reset();
    });
});

