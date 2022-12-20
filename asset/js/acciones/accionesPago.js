let tablePagos;
$(document).ready(function () {
    if (cargo == "Administrador de Empresas" || cargo == "Contador Auditor") {
        cargarPagos();
    }
});

function buscarPago(idPago) {
    $("#tableDetalleP tbody").empty();
    $.post("../../controladores/PagoController.php?funcion=search",
            {idPago: idPago},
            function (response) {
                let pago = JSON.parse(response);
                //console.log(pago);
                $("#nombrePago").text(pago["NombreCliente"]);
                $("#fechaPago").text(pago["fechaPago"]);
                $("#horaPago").text(pago["horapago"]);
                $("#cantPago").text(pago["cantidadV"]);
                $("#totalP").text("$" + pago["subTotal"]);
                $("#medioPago").text(pago["nombreTipoPago"]);
                $("#telefonoP").text(pago["TelefonoCliente"]);
                $("#estadoP").text(pago["PagoEstado"]);
                for (let i = 0; i < pago["detalleV"].length; i++) {
                    $("#tableDetalleP tbody").append(`<tr>
                                            <td>${pago["detalleV"][i].NombreInsumo}</td>
                                            <td>${pago["detalleV"][i].CantidadVenta}</td>
                                            <td>$${pago["detalleV"][i].PrecioVenta}</td>
                                        </tr>`);
                }
            }
    );
    $("#modalPagoVer").modal('show');
}



function quitarPago(idPago) {
    swal({
        title: "Inhabilitar Pago",
        text: "¿Realmente desea Inhabilitar este Pago?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            $.ajax({
                type: "POST",
                url: urlIndex + "/controladores/PagoController.php?funcion=delete",
                data: {idPago: idPago},
                success: function (data) {
                    if (data) {
                        swal({
                            title: "Exito !",
                            text: "Pago Inhabilitado Exitosamente !!",
                            icon: "success"
                        }).then(function () {
                            tablePagos.ajax.reload()
                        });
                    }
                }
            });
        }
    });
}

function activarPago(idPago) {
    swal({
        title: "Activar Pago",
        text: "¿Realmente desea volver a Habilitar este Pago?",
        icon: "info",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            $.ajax({
                type: "POST",
                url: urlIndex + "/controladores/PagoController.php?funcion=activate",
                data: {idPago: idPago},
                success: function (data) {
                    if (data) {
                        swal({
                            title: "Exito !",
                            text: "Pago Activado Exitosamente !!",
                            icon: "success"
                        }).then(function () {
                            tablePagos.ajax.reload()
                        });
                    }
                }
            });
        }
    });
}

function cargarPagos() {
    tablePagos = $('#tablePagosA').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": "../../controladores/PagoController.php?funcion=listPagos",
            "dataSrc": ""
        },
        "columns": [
            {"data": "NombreCliente"},
            {"data": "fechaPago"},
            {"data": "horapago"},
            {"data": "montoP"},
            {"data": "PagoEstado"},
            {"data": "options"}
        ],
        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "asc"]]
    });
}
