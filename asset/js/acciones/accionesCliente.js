let tableClientes;
$(document).ready(function () {
    cargarClientes();
});

function VerCliente(idCliente) {
    $.post("../../controladores/ClienteController.php?funcion=search",
            {idCliente: idCliente},
            function (response) {
                var cliente = JSON.parse(response);
                $("#nombreCli").text(cliente["NombreCliente"]);
                $("#correoCli").text(cliente["CorreoVinculado"]);
                $("#cargoCli").text(cliente["NegocioCliente"]);
                $("#telefonoCli").text(cliente["TelefonoCliente"]);
                $("#cargoDesc").text(cliente["CargoCliente"]);
            }
    );
}

function buscarClienteD(idCliente) {
    swal({
        title: "Inhabilitar Cuenta del Cliente",
        text: "¿Realmente desea Inhabilitar a esta Cuenta?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            $.ajax({
                type: "POST",
                url: urlIndex + "/controladores/ClienteController.php?funcion=delete",
                data: {idCliente: idCliente},
                success: function (data) {
                    if (data) {
                        swal({
                            title: "Exito !!",
                            text: "Cuenta Inhabilitada Exitosamente !!",
                            icon: "success"
                        }).then(function () {
                            tableClientes.ajax.reload();
                        });
                    }
                }
            });
        }
    });
}

function activarCliente(idCliente) {
    swal({
        title: "Habilitar Cuenta del Cliente",
        text: "¿Realmente desea Habilitar a esta Cuenta?",
        icon: "info",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            $.ajax({
                type: "POST",
                url: urlIndex + "/controladores/ClienteController.php?funcion=activate",
                data: {idCliente: idCliente},
                success: function (data) {
                    if (data) {
                        swal({
                            title: "Exito !!",
                            text: "Cuenta Activada Exitosamente !!",
                            icon: "success"
                        }).then(function () {
                            tableClientes.ajax.reload();
                        });
                    }
                }
            });
        }
    });
}

function cargarClientes() {
    tableClientes = $('#TableClientes').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": "../../controladores/ClienteController.php?funcion=listar",
            "dataSrc": ""
        },
        "columns": [
            {"data": "NombreCliente"},
            {"data": "TelefonoCliente"},
            {"data": "NegocioCliente"},
            {"data": "ClienteEstado"},
            {"data": "options"}
        ],

        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "asc"]]
    });
}


