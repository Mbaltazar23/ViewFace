let tableRecibos;
$(document).ready(function () {
    if (cargo == "Administrador de Empresas" || cargo == "Contador Auditor") {
        cargarRecibosAdmin();
    } else if (cargo == "Cliente") {
        cargarRecibosCliente();
    }
});

function buscarReciboCli(idRecibo) {
    $.post("../../controladores/ReciboController.php?funcion=search",
            {idRecibo: idRecibo},
            function (response) {
                var recibo = JSON.parse(response);
                //console.log(recibo);
                $("#nombreCliRe").text(recibo["NombreCliente"]);
                $("#telefonoCliR").text(recibo["ReciboTelefono"]);
                $("#FechaR").text(recibo["fechaRecibo"]);
                $("#HoraR").text(recibo["horarecibo"]);
                $("#SubTotalR").text("$" + recibo["SubTotalRecibo"]);
                $("#TotalR").text("$" + recibo["TotalRecibo"]);
                $("#DireccionR").text(recibo["DireccionRecibo"]);
                $("#CuidadR").text(recibo["ComunaNombre"]);
                $("#CostoEnvio").text("$" + recibo["ValorEnvio"]);
                $("#idRe").val(recibo["idRecibo"]);
            }
    );
}

function imprimirRecibo() {
    let nombreCli = $("#nombreCliRe").text();
    let id = $('#idRe').val();
    var pdf = new jsPDF();
    pdf.text(20, 40, "Recibo del Cliente : " + nombreCli);
    var elementHTML = $('#ReciboCliente').html();

    pdf.fromHTML(elementHTML, 20, 50, {
        'width': 300
    });

// Save the PDF
    pdf.save('Recibo.pdf');
//Se quita este recibo para que quede impreso
    $.ajax({
        type: 'POST',
        url: "../../controladores/ReciboController.php?funcion=imprimir",
        data: {idRecibo: id},
        success: function (data) {
            if (data) {
                swal({
                    title: "Exito !",
                    text: "Boleta Impresa Exitosamente !!",
                    icon: "success"
                }).then(function () {
                    //window.location = urlIndex + "/view/Recibos";
                    $("#modalReciboVer").modal('hide');
                    tableRecibos.ajax.reload();
                });
            }
        }
    });
}

function procesarRecibo(idRecibo) {
    swal({
        title: "Digitalizar Recibo",
        text: "¿Realmente desea Digitalizar este Recibo?",
        icon: "info",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            $.ajax({
                type: 'POST',
                url: "../../controladores/ReciboController.php?funcion=imprimir",
                data: {idRecibo: idRecibo},
                success: function (data) {
                    if (data) {
                        swal({
                            title: "Exito !",
                            text: "Boleta Digitalizada Exitosamente !!",
                            icon: "success"
                        }).then(function () {
                            //window.location = urlIndex + "/view/Recibos";
                            $("#modalReciboVer").modal('hide');
                            tableRecibos.ajax.reload();
                        });
                    }
                }
            });
        }
    });

}


function quitarRecibo(idRecibo) {
    swal({
        title: "Inhabilitar Recibo",
        text: "¿Realmente desea Inhabilitar este Recibo?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            $.ajax({
                type: "POST",
                url: urlIndex + "/controladores/ReciboController.php?funcion=delete",
                data: {idRecibo: idRecibo},
                success: function (data) {
                    if (data) {
                        swal({
                            title: "Exito !",
                            text: "Recibo Inhabilitado Exitosamente !!",
                            icon: "success"
                        }).then(function () {
                            tableRecibos.ajax.reload();
                            //window.location = urlIndex + "/view/Solicitud";
                        });
                    }
                }
            });
        }
    });
}
function activarRecibo(idRecibo) {
    swal({
        title: "Activar Recibo",
        text: "¿Realmente desea Activar este Recibo?",
        icon: "info",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            $.ajax({
                type: "POST",
                url: urlIndex + "/controladores/ReciboController.php?funcion=activate",
                data: {idRecibo: idRecibo},
                success: function (data) {
                    if (data) {
                        swal({
                            title: "Exito !",
                            text: "Recibo Activado Exitosamente !!",
                            icon: "success"
                        }).then(function () {
                            tableRecibos.ajax.reload();
                            //window.location = urlIndex + "/view/Solicitud";
                        });
                    }
                }
            });
        }
    });
}

function cargarRecibosAdmin() {
    tableRecibos = $('#TableRecibosAdmin').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": "../../controladores/ReciboController.php?funcion=listRecibosAd",
            "dataSrc": ""
        },
        "columns": [
            {"data": "NombreCliente"},
            {"data": "ReciboTelefono"},
            {"data": "Valor"},
            {"data": "DireccionRecibo"},
            {"data": "EstadoRecibo"},
            {"data": "options"}
        ],
        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "asc"]]
    });
}

function cargarRecibosCliente() {
    tableRecibos = $('#TableRecibosCli').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": "../../controladores/ReciboController.php?funcion=listRecibosCli",
            "type": "POST",
            "data": {idCliente: cliente},
            "dataSrc": ""
        },
        "columns": [
            {"data": "fechaRecibo"},
            {"data": "Valor"},
            {"data": "ReciboTelefono"},
            {"data": "DireccionRecibo"},
            {"data": "ComunaNombre"},
            {"data": "EstadoRecibo"},
            {"data": "options"}
        ],
        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "asc"]]
    });

}
