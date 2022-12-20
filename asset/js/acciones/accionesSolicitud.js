let tableSolicitud;
let tableRespuestas;
$(document).ready(function () {
    if (cargo == "Jefa") {
        cargarSolicitudesAceptadasJefa();
    } else if (cargo == "Cliente") {
        cargarSolicitudesCliente(cliente);
    }

    $.ajax({
        type: "POST",
        url: "../../controladores/SolicitudController.php?funcion=listMercancia",
        success: function (data) {
            $('.selectMercancia select').html(data).fadeIn();
        }
    });
    //funcion del formulario de la solicitud para responderla

    $(".form-solicitudCli").submit(function (e) {
        e.preventDefault();
        let idCli = $('#idCli').val();
        let idSoli = $("#solicitudId").val();
        let cargoCli = $('#CargoCli').val();
        let opcion = $("#opcionSoli").val();
        let mercancia = $("select#mercancia option:selected").val();
        let descrip = $("#descripcionSolic").val();
        let error = false;
        let mensaje = "";

        if (mercancia < 1) {
            mensaje = "Seleccione un tipo de Mercancia";
            error = true;
        } else if (descrip == "") {
            mensaje = "La descripcion no puede estar vacia";
            error = true;
        }

        if (error == true) {
            swal('Oops...', mensaje, 'error');
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "../../controladores/SolicitudController.php?funcion=" + opcion,
                data: {idCliente: idCli, cargoCliente: cargoCli, mercancia: mercancia, descripcion: descrip, idSolicitud: idSoli},
                success: function (data) {
                    if (data) {
                        if (opcion == "create") {
                            swal({
                                title: "Exito !",
                                text: "Solicitud Envidada Exitosamente !!",
                                icon: "success"
                            }).then(function () {
                                //window.location = urlIndex + "/view/Solicitud/";
                                $("#modalSolicitudForm").modal('hide');
                                tableSolicitud.ajax.reload();
                            });
                        } else if (opcion == "update") {
                            swal({
                                title: "Exito !",
                                text: "Solicitud Actualizada Exitosamente !!",
                                icon: "success"
                            }).then(function () {
                                //window.location = urlIndex + "/view/Solicitud/";
                                $("#modalSolicitudForm").modal('hide');
                                tableSolicitud.ajax.reload();
                            });
                        }

                    }
                }
            });
        }
    });

    $(".formRespuesta").submit(function (e) {
        e.preventDefault();
        let opcion = $("#opcionRes").val();
        let idCli = $("#idCliRes").val();
        let idSoli = $("#idSoliRes").val();
        let mensajeR = $("#mensajeRes").val();
        let res = $("#respuestaSoli").val();
        let idRes = $("#idRes").val();
        let error = false;
        let mensaje = "";

        if (res == "") {
            mensaje = "La respuesta esta vacia...";
            error = true;
        }

        if (error == true) {
            swal("Error...", mensaje, "error");
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "../../controladores/RespuestaController.php?funcion=" + opcion,
                data: {idCliente: idCli, idSolicitud: idSoli, respuesta: res, idRespuesta: idRes, RecepcionM: mensajeR},
                success: function (data) {
                    if (data) {
                        if (opcion == "create") {
                            swal({
                                title: "Exito !",
                                text: "Respuesta Envidada Exitosamente !!",
                                icon: "success"
                            }).then(function () {
                                //window.location = urlIndex + "/view/Solicitud/";
                                $("#modalRespuestaForm").modal('hide');
                                tableSolicitud.ajax.reload();
                            });
                        } else if (opcion == "update") {
                            swal({
                                title: "Exito !",
                                text: "Respuesta Actualizada Exitosamente !!",
                                icon: "success"
                            }).then(function () {
                                //window.location = urlIndex + "/view/Solicitud/";
                                $("#modalRespuestaForm").modal('hide');
                                tableSolicitud.ajax.reload();
                            });
                        } else if (opcion == "response") {
                            swal({
                                title: "Exito !",
                                text: "Respuesta Respondida Exitosamente !!",
                                icon: "success"
                            }).then(function () {
                                //window.location = urlIndex + "/view/Solicitud/";
                                $("#modalRespuestaForm").modal('hide');
                                tableSolicitud.ajax.reload();
                            });
                        }
                    }
                }
            });
        }

    });

    $("#btnRes").click(function () {
        let id_soli = $("#idSolicitudR").val();
        devolverRespuesta(id_soli);
    });

});

//funciones referentes a activar o aceptar las solicitudes

function ActivarSolicitud(idSolicitud) {
    swal({
        title: "Reenviar Solicitud",
        text: "¿Realmente desea Reenviar a este Solicitud?",
        icon: "info",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            $.ajax({
                type: "POST",
                url: urlIndex + "/controladores/SolicitudController.php?funcion=activate",
                data: {idSolicitud: idSolicitud},
                success: function (data) {
                    if (data) {
                        swal({
                            title: "Exito !",
                            text: "Solicitud Enviada Exitosamente !!",
                            icon: "success"
                        }).then(function () {
                            tableSolicitud.ajax.reload();
                            //window.location = urlIndex + "/view/Solicitud";
                        });
                    }
                }
            });
        }
    });
}

function aceptarSolicitud(idSolicitud) {
    $(".titleSoliRes").text("Responder Solicitud");
    $.post("../../controladores/SolicitudController.php?funcion=search",
            {idSolicitud: idSolicitud},
            function (data) {
                var solicitud = JSON.parse(data);
                //console.log(solicitud);
                $("#idSoliRes").val(solicitud["idSolicitud"]);
                $("#idCliRes").val(solicitud["idCliente"]);
                $("#nombreCliRes").val(solicitud["NombreCliente"]);
                $("#cargoCliRes").val(solicitud["CargoSolicitud"]);
                $("#mensajeRes").val(solicitud["SolicitudDescripcion"]);
                $("#opcionRes").val("create");
                $(".btnRespuesta").removeClass('btn-default').addClass('btn-success').text("Responder");
                $("#modalRespuestaForm").modal('show');
            }
    );
}

//busqueda/eliminacion de datos de N° solicitud de N° Cliente

function buscarClienteSoli(idCliente) {
    $.ajax({
        type: 'POST',
        url: "../../controladores/ClienteController.php?funcion=search",
        data: {idCliente: idCliente},
        success: function (data) {
            let clientes = JSON.parse(data);
            //console.log(clientes);
            let idCli = clientes["idCliente"];
            let nombre = clientes["NombreCliente"];
            let empresa = clientes["NegocioCliente"];
            mostrarDatosCli(idCli, nombre, empresa);
        }
    });
}

function mostrarDatosCli(id, nombre, empresa) {
    $(".form-solicitudCli")[0].reset();
    $('#idCli').val(id);
    $('#nombre').val(nombre);
    $('#CargoCli').val(empresa);
    $("#mercancia").val("0");
    $(".titleSoli").text("Agregar Nueva Solicitud");
    $("#opcionSoli").val("create");
    $(".btnSolicitud").removeClass('btn-default').addClass('btn-success').text("Registrar");
    $("#modalSolicitudForm").modal('show');
}

function buscarSolicitud(idSolicitud) {
    $(".titleSoli").text("Actualizar Solicitud");
    $("#opcionSoli").val("update");
    $.ajax({
        type: 'POST',
        url: "../../controladores/SolicitudController.php?funcion=search",
        data: {idSolicitud: idSolicitud},
        success: function (data) {
            let solicitud = JSON.parse(data);
            //console.log(solicitud);
            $("#solicitudId").val(solicitud["idSolicitud"]);
            $('#idCli').val(solicitud["idCliente"]);
            $('#nombre').val(solicitud["NombreCliente"]);
            $('#CargoCli').val(solicitud["CargoSolicitud"]);
            $("#mercancia").val(solicitud["TipoMercancia"]);
            $("#descripcionSolic").val(solicitud["SolicitudDescripcion"]);
            $("#modalSolicitudForm").modal('show');
            $(".btnSolicitud").removeClass('btn-success').addClass('btn-primary').text("Actualizar");
        }
    });
}

function QuitarSolicitud(idSolicitud) {
    swal({
        title: "Eliminar Solicitud",
        text: "¿Realmente desea Eliminar a este Solicitud?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            $.ajax({
                type: "POST",
                url: urlIndex + "/controladores/SolicitudController.php?funcion=delete",
                data: {idSolicitud: idSolicitud},
                success: function (data) {
                    if (data) {
                        swal({
                            title: "Exito !",
                            text: "Solicitud Cancelada Exitosamente !!",
                            icon: "success"
                        }).then(function () {
                            tableSolicitud.ajax.reload();
                            //window.location = urlIndex + "/view/Solicitud";
                        });
                    }
                }
            });
        }
    });
}

//funciones de la carga de N° solicitudes tanto para el personal con el perfil "Jefa" como para el "Cliente"

function cargarSolicitudesAceptadasJefa() {
    tableSolicitud = $('#TableSolicitudJefa').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": "../../controladores/SolicitudController.php?funcion=listSolicitudJefa",
            "dataSrc": ""
        },
        "columns": [
            {"data": "NombreCliente"},
            {"data": "CargoSolicitud"},
            {"data": "fechaSolicitud"},
            {"data": "horaSolicitud"},
            {"data": "SolicitudEstado"},
            {"data": "options"}
        ],

        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "asc"]]
    });
}

function cargarSolicitudesCliente(idCliente) {
    tableSolicitud = $('#TableSolicitudCliente').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": "../../controladores/SolicitudController.php?funcion=listSolicitudCli",
            "type": "POST",
            "data": {idCliente: idCliente},
            "dataSrc": ""
        },
        "columns": [
            {"data": "CargoSolicitud"},
            {"data": "fechaSolicitud"},
            {"data": "horaSolicitud"},
            {"data": "SolicitudEstado"},
            {"data": "options"}
        ],

        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "asc"]]
    });
}

//funciones referentes a las respuestas de N° Solicitudes

function buscarRespuesta(idSolicitud) {
    $(".titleSoliRes").text("Actualizar Respuesta");
    $.ajax({
        type: 'POST',
        url: "../../controladores/RespuestaController.php?funcion=search",
        data: {idSolicitud: idSolicitud},
        success: function (data) {
            let respuesta = JSON.parse(data);
            console.log(respuesta);
            $("#cargoCliRes").val(respuesta["CargoSolicitud"]);
            $("#idRes").val(respuesta["idRespuesta_solicitud"]);
            $("#nombreCliRes").val(respuesta["NombreCliente"]);
            $("#mensajeRes").val(respuesta["RespuestaSoli"]);
            $("#respuestaSoli").val(respuesta["MensajeRespuesta"]);
            $("#idSoliRes").val(respuesta["RespuestaSolicitud"]);
            $("#idCliRes").val(respuesta["idCliente"]);
        }
    });
    $("#modalRespuestaForm").modal('show');
    $("#opcionRes").val("update");
    $(".btnCancel").removeAttr('id');
    $(".btnRespuesta").removeClass('btn-success').addClass('btn-primary').text("Actualizar");
}

function responderRes(idRespuesta) {
    $(".titleSoliRes").text("Enviar Respuesta");
    $.ajax({
        type: 'POST',
        url: "../../controladores/RespuestaController.php?funcion=searchRes",
        data: {idRespuesta: idRespuesta},
        success: function (data) {
            let respuesta = JSON.parse(data);
            //console.log(respuesta);
            $("#cargoCliRes").val(respuesta["CargoSolicitud"]);
            $("#idRes").val(respuesta["idRespuesta_solicitud"]);
            $("#nombreCliRes").val(respuesta["NombreCliente"]);
            $("#mensajeRes").val(respuesta["MensajeRespuesta"]);
            $("#respuestaSoli").val("");
            $("#idSoliRes").val(respuesta["RespuestaSolicitud"]);
            $("#idCliRes").val(respuesta["idCliente"]);
        }
    });
    $("#opcionRes").val("create");
    $(".btnRespuesta").removeClass('btn-success').addClass('btn-primary').text("Enviar");
    $("#modalRespuestaForm").modal('open');
}

function verRespuesta(idSolicitud) {
    $.ajax({
        type: 'POST',
        url: "../../controladores/RespuestaController.php?funcion=search",
        data: {idSolicitud: idSolicitud},
        success: function (data) {
            let respuesta = JSON.parse(data);
            $("#mensajeR").text(respuesta["RespuestaSoli"]);
            $("#fechaR").text(respuesta["fechaRespuesta"]);
            $("#horaR").text(respuesta["horaRespuesta"]);
            $("#respuestaR").text(respuesta["MensajeRespuesta"]);
            $("#idSolicitudR").val(respuesta["RespuestaSolicitud"]);
        }
    });
    $("#modalRepuestaView").modal('show');
}

function devolverRespuesta(idSolicitud) {
    $(".titleSoliRes").text("Enviar Respuesta");
    $.ajax({
        type: 'POST',
        url: "../../controladores/RespuestaController.php?funcion=search",
        data: {idSolicitud: idSolicitud},
        success: function (data) {
            let respuesta = JSON.parse(data);
            $("#cargoCliRes").val(respuesta["CargoSolicitud"]);
            $("#idRes").val(respuesta["idRespuesta_solicitud"]);
            $("#nombreCliRes").val(respuesta["NombreCliente"]);
            $("#mensajeRes").val(respuesta["MensajeRespuesta"]);
            $("#respuestaSoli").val("");
            $("#idSoliRes").val(respuesta["RespuestaSolicitud"]);
            $("#idCliRes").val(respuesta["idCliente"]);
        }
    });
    $("#modalRepuestaView").modal('hide');
    $("#modalRespuestaForm").modal('show');
    $("#opcionRes").val("response");
    $(".btnRespuesta").removeClass('btn-success').addClass('btn-primary').text("Enviar");
}

function cargarRespuestasCliente(idCliente) {
    tableRespuestas = $('#tableRespuestas').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "lengthChange": false,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": "../../controladores/RespuestaController.php?funcion=list",
            "type": "POST",
            "data": {idCliente: idCliente},
            "dataSrc": ""
        },
        "columns": [
            {"data": "NombreCliente"},
            {"data": "fechaRespuesta"},
            {"data": "horaRespuesta"},
            {"data": "estadoRespuesta"},
            {"data": "options"}
        ],

        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 3,
        "order": [[0, "desc"]]
    });
}


//acciones para validar una solicitud que este en estado 2 que significa respondia
/*si esta en estado == 3 significa que habran respuestas que se mostraran en forma de tabla donde pueda ver las respuestas y responderlas de uno a uno*/
//de la misma forma para el cliente si recibe respuestas y por ende las pueda visualizar en el mismo form con el table pasandole su id y visualizar su respuestas