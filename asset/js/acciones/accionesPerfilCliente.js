$(document).ready(function () {
    if (cliente) {
        CargarPerfilCliente(cliente);
    }
});

function CargarPerfilCliente(idCliente) {
    $.post("../../controladores/ClienteController.php?funcion=perfilCli",
            {idCliente: idCliente},
            function (response) {
                var perfil = JSON.parse(response);
                //console.log(perfil);
                $("#nomCli").text(perfil["NombreCliente"]);
                $("#TelefonoCli").text(perfil["TelefonoCliente"]);
                $("#CorreoCli").text(perfil["correoVinculo"]);
                $("#NegocioCli").text(perfil["NegocioCliente"]);
                $("#FechaRe").text(perfil["fechaRegistro"]);
                $("#HoraRe").text(perfil["horaRegistro"]);
                $("#userNa").text(perfil["UserNombre"]);
                $("#CorreoPer").text(perfil["CorreoPersonal"]);
                $("#CargoPer").text(perfil["CargoPersonal"]);
            }
    );
}
