let tableVentas;
$(document).ready(function () {
    if (cargo == "Analista-financiero") {
        cargarVentasAnalista();
    } else if (cargo == "Cliente") {
        cargarVentasCli(cliente);
        $.ajax({
            type: "POST",
            url: "../../controladores/ReciboController.php?funcion=listCuidades",
            success: function (data) {
                $('.SelectComunaVenta select').html(data).fadeIn();
            }
        });

        $.ajax({
            type: "POST",
            url: "../../controladores/CategoriaController.php?funcion=listCategoriasVisibles",
            success: function (data) {
                $('.selectInsumosCat select').html(data).fadeIn();
            }
        });
    }

    //Funciones de agregar/editar Venta
    $("#buttonAddVentaInsumo").click(function () {
        $("#opcionVenta").val("create");
        $(".titleVenta").text("Agregar Insumos");
        vaciarCampos("#tabla-insumos > tbody", "#tabla-resumen > tbody", "cantidadInsu", "insumo", "catInsumo");
    });

    $("#btnAgregarInsumo").click(function () {
        let id_insumo = $("#insumo option:selected").val();
        let cantidad = $("#cantidadInsu").val();
        let opcion = $("#opcionVenta").val();
        let btn = "";
        let mensaje = "";
        let error = false;
        if (id_insumo < 1) {
            mensaje = "Debe seleccionar un Insumo al menos..";
            error = true;
        } else if (cantidad == "" || cantidad < 1) {
            mensaje = "Debe ingresar una Cantidad correcta.";
            error = true;
        } else if (opcion == "create") {
            btn = "Registrar Venta";
        } else if (opcion == "edit") {
            btn = "Actualizar Venta";
        }
        if (error == true) {
            swal('Oops...', mensaje, 'error');
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "../../controladores/InsumoController.php?funcion=search",
                data: {idInsumo: id_insumo},
                success: function (data) {
                    let datos = JSON.parse(data);
                    //console.log(datos["nombre"]);
                    let nombre = datos["NombreInsumo"];
                    let precio = datos["PrecioUnitarioInsumo"];
                    var banderaCoincidencia = false;
                    $("#tabla-insumos tbody tr").each(function (row, element) {
                        var id = $(element).find("td")[0].innerHTML;
                        if (id_insumo == id) {
                            var cantidadActual = $(element).find("td")[2].innerHTML;
                            var cantidadTotal = parseInt(cantidadActual) + parseInt(cantidad);
                            var precioActualizado = cantidadTotal * precio;
                            $("#tdCantidad_" + id_insumo).text(cantidadTotal);
                            $("#tdPrecio_" + id_insumo).text(precioActualizado);
                            banderaCoincidencia = true;
                        }
                    });
                    if (!banderaCoincidencia) {
                        $('#tabla-insumos tbody').append(`<tr>
                                            <td hidden>${id_insumo}</td>
                                            <td>${nombre}</td>
                                            <td class='text-center' id='tdCantidad_${id_insumo}'>${cantidad}</td>
                                            <td class='text-center'>${precio}</td>
                                            <td class='text-center' id='tdPrecio_${id_insumo}'>${precio * cantidad}</td>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" id="btnDeleteIns" class="btn btn-danger btn-sm" onclick="eliminarInsumo(this);"><i class='fas fa-trash'></i></button></td>
                                        </tr>`);
                    }
                    $("#catInsumo").val("0");
                    $("#insumo").val("0");
                    $("#cantidadInsu").val("");
                    swal('Exito...', "Insumo Agregado Exitosamente...", 'success');
                    mostrarResumen("tabla-insumos", "resumenVenta", "#tabla-insumos tbody tr", "tabla-resumen", "btnVenta", "cantidadInsu", btn);
                }
            });
        }
    });

    $("#resumenVenta").on("click", ".btnVenta", function () {
        let opcion = $("#opcionVenta").val();
        let idVenta = $("#id-venta").val();
        var valorTotal = 0;
        var arregloInsumos = [];
        $("#tabla-insumos tbody tr").each(function (row, element) {
            var idInsumo = $(element).find("td")[0].innerHTML;
            var cantidadV = parseInt($(element).find("td")[2].innerHTML);
            var precioV = parseInt($(element).find("td")[3].innerHTML);
            var subtotalV = parseInt($(element).find("td")[4].innerHTML);
            valorTotal += subtotalV;
            arregloInsumos.push({"idInsumo": idInsumo, "cantidad": cantidadV, "precio": precioV});
        });
        $.ajax({
            type: "POST",
            url: "../../controladores/VentaController.php?funcion=" + opcion,
            data: {precioTotalV: valorTotal, arregloInsumos: arregloInsumos, idCliente: cliente, idVenta: idVenta},
            success: function (data) {
                if (data) {
                    if (opcion == "create") {
                        swal({
                            title: "Exito !",
                            text: "Venta Almacenada Exitosamente !!",
                            icon: "success"
                        }).then(function () {
                            //window.location = urlIndex + "/view/Ventas";
                            $("#modalVentaInsumo").modal('hide');
                            tableVentas.ajax.reload();
                        });
                    } else if (opcion == "edit") {
                        swal({
                            title: "Exito !",
                            text: "Venta Actualizada Exitosamente !!",
                            icon: "success"
                        }).then(function () {
                            //window.location = urlIndex + "/view/Ventas";
                            $("#modalVentaInsumo").modal('hide');
                            tableVentas.ajax.reload();
                        });
                    }

                }
            }
        });
    });

    //aceptarPagoVenta
    $("#ComunaPago").submit(function (e) {
        e.preventDefault();
        let OptiondireccionP = $("select#DireccionP option:selected").val();
        let direccionC = $('select#comunaP option:selected').val();
        let idVenta = $("#idVentaC").val();
        let direccionComuna = "";
        let mensaje = "";
        let error = false;
        if (direccionC < 1) {
            mensaje = "Debe ingresar una comuna !!";
            error = true;
        } else if (OptiondireccionP < 1) {
            mensaje = "Debe seleccionar una direccion !!";
            error = true;
        } else {
            direccionComuna = $('#DireccionP option:selected').text();
        }

        if (error == true) {
            swal('Oops...', mensaje, 'error');
            return false;
        } else {
            $.ajax({
                type: 'POST',
                url: "../../controladores/VentaController.php?funcion=searchTotalPrice",
                data: {idVenta: idVenta},
                success: function (response) {
                    let valorTotal = JSON.parse(response);
                    let Comision = mostrarComisionDireccion(OptiondireccionP);
                    //console.log("precio:" + valorTotal, "Comision de : " + Comision, "Direccion:" + direccionComuna);
                    $("#modalComunaPago").modal('hide');
                    $("#VentaPag").val(idVenta);
                    $("#PrecioPag").val(valorTotal);
                    $("#costoEnvio").val(Comision);
                    $("#totalV").val(parseInt(valorTotal) + parseInt(Comision));
                    $("#DireccionPago").val(direccionComuna);
                    $("#ComunaP").val(direccionC);
                    $("#modalPagoVenta").modal('show');
                    mostrarMediosPago();
                }
            });
        }
    });

    //pagarVenta
    $("#formPagosAdd").submit(function (e) {
        e.preventDefault();
        let idVenta = $("#VentaPag").val();
        let costoTotal = $("#totalV").val();
        let subtotal = $("#PrecioPag").val();
        let direccion = $("#DireccionPago").val();
        let tipoPago = $("#tipoPago").val();
        let descripcion = $("#descripcionPago").val();
        let comuna = $("#ComunaP").val();
        let mensaje = "";
        let error = false;
        if (tipoPago < 1) {
            mensaje = "Debe escoger un medio de pago";
            error = true;
        } else if (descripcion == "") {
            mensaje = "Debe ingresar un comentario o detalle";
            error = true;
        }

        if (error == true) {
            swal('Oops...', mensaje, 'error');
            return false;
        } else {
            $.ajax({
                type: 'POST',
                url: "../../controladores/PagoController.php?funcion=create",
                data: {idVenta: idVenta, costoTotal: costoTotal, subTotal: subtotal, Direccion: direccion, tipoPago: tipoPago, descripcion: descripcion, idComuna: comuna, idCliente: cliente},
                success: function (response) {
                    if (response) {
                        swal({
                            title: "Exito !",
                            text: "Pago Registrado Exitosamente !!",
                            icon: "success"
                        }).then(function () {
                            //window.location = urlIndex + "/view/Ventas";
                            $("#modalPagoVenta").modal('hide');
                            tableVentas.ajax.reload();
                        });
                    }
                }
            });
        }
    });
});

function mostrarResumen(tableInsumos, resumen, tableInsumosCont, tableResumen, btn, selectInsumos, valorBtn) {
    var filas = document.getElementById(tableInsumos).rows.length;
    if (filas > 1) {
        document.getElementById(resumen).removeAttribute("hidden");
        actualizarResumen(tableInsumosCont, tableResumen, btn, resumen, valorBtn);
    } else {
        document.getElementById(resumen).setAttribute("hidden", "");
        actualizarResumen(tableInsumosCont, tableResumen, btn, resumen, valorBtn);
    }
    cargarCantiVacia(selectInsumos);
}

function cargarCantiVacia(selectInsumo) {
    $('option', '#' + selectInsumo).remove();
    var selectInsumo = document.getElementById(selectInsumo);
    selectInsumo.innerHTML = "<option value='0'>Escoga un Insumo</option>";
}

function vaciarCampos(tableInsumos, tableResumen, selectCant, InsumoSelect, CatSelect) {
    $(tableInsumos).empty();
    $(tableResumen).empty();
    cargarCantiVacia(InsumoSelect);
    $("#" + selectCant).val("0");
    $(InsumoSelect).val("0");
    $("#" + CatSelect).val("0");
}

function actualizarResumen(table, tableResumen, btn, resumen, valorBtn) {
    var valorTotal = 0;
    $(table).each(function (row, element) {
        var subtotalT = $(element).find("td")[4].innerHTML;
        var subtotal = parseInt(subtotalT);
        valorTotal += subtotal;
    });
    var html = ` <br><table id="${tableResumen}" style="width: center;">
                     <tbody>
                        <tr>
                            <th style="text-align: left; width:200px;">Valor Total: </th>
                            <td style="text-align: right; width: 100px;">$${valorTotal}</td>
                            <td style="text-align:right; width:700px"><button class="btn btn-primary rounded-pill ${btn}" >${valorBtn}</button></td>
                        </tr>
                     </tbody>
                    </table>`;
    document.getElementById(resumen).innerHTML = html;
}

function eliminarInsumo(dato) {
    var fila = dato.parentNode.parentNode.rowIndex;
    let opcion = $("#opcionVenta").val();
    let btn = "";
    if (opcion == "create") {
        btn = "Registrar Venta";
    } else if (opcion == "edit") {
        btn = "Actualizar Venta";
    }
    swal({
        title: "Eliminar Insumo",
        text: "¿Realmente desea Eliminar a este Insumo?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            swal("Insumo Eliminado...", "El insumo fue retirado Exitosamente !!", "success");
            document.getElementById("tabla-insumos").deleteRow(fila);
        }
        mostrarResumen("tabla-insumos", "resumenVenta", "#tabla-insumos tbody tr", "tabla-resumen", "btnVenta", "cantidadInsu", btn);
    });
}

function buscarInsumos(idCategoria, idSelect) {
    $.post("../../controladores/CategoriaController.php?funcion=searchInsumoCat",
            {idCategoria: idCategoria},
            function (response) {
                $('.' + idSelect + ' select').html(response).fadeIn();
            }
    );
}

function buscarVenta(idVenta) {
    $("#opcionVenta").val("edit");
    $(".titleVenta").text("Actualizar Venta de Insumos");
    vaciarCampos("#tabla-insumos > tbody", "#tabla-resumen > tbody", "cantidadInsu", "insumo", "catInsumo");
    $.ajax({
        type: 'POST',
        url: "../../controladores/VentaController.php?funcion=search",
        data: {idVenta: idVenta},
        success: function (response) {
            $("#id-venta").val(idVenta);
            let venta = JSON.parse(response);
            for (let i = 0; i < venta["detalleV"].length; i++) {
                $("#tabla-insumos tbody").append(`<tr>
                                            <td hidden>${venta["detalleV"][i].idInsumo}</td>
                                            <td>${venta["detalleV"][i].NombreInsumo}</td>
                                            <td class='text-center' id='tdCantidad_${venta["detalleV"][i].idInsumo}'>${venta["detalleV"][i].CantidadVenta}</td>
                                            <td class='text-center'>${venta["detalleV"][i].PrecioVenta}</td>
                                            <td class='text-center' id='tdPrecio_${venta["detalleV"][i].idInsumo}'>${venta["detalleV"][i].PrecioVenta * venta["detalleV"][i].CantidadVenta}</td>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm" onclick="eliminarInsumo(this);"><i class='fas fa-trash'></i></button></td>
                                        </tr>`);
            }
            mostrarResumen("tabla-insumos", "resumenVenta", "#tabla-insumos tbody tr", "tabla-resumen", "btnVenta", "cantidadInsu", "Actualizar Venta");
        }
    });
    $("#modalVentaInsumo").modal('show');
}

function quitarVenta(idVenta) {
    swal({
        title: "Eliminar Venta",
        text: "¿Realmente desea Eliminar a esta Venta?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            $.ajax({
                type: "POST",
                url: urlIndex + "/controladores/VentaController.php?funcion=delete",
                data: {idVenta: idVenta},
                success: function (data) {
                    if (data) {
                        swal({
                            title: "Exito !",
                            text: "Venta Eliminada Exitosamente !!",
                            icon: "success"
                        }).then(function () {
                            //window.location = urlIndex + "/view/Ventas";
                            tableVentas.ajax.reload();
                        });
                    }
                }
            });
        }
    });
}

function cargarVentasAnalista() {
    tableVentas = $('#TableVentasA').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": "../../controladores/VentaController.php?funcion=listVentasA",
            "dataSrc": ""
        },
        "columns": [
            {"data": "NombreCliente"},
            {"data": "valorV"},
            {"data": "fechaV"},
            {"data": "horaV"},
            {"data": "EstadoVenta"},
            {"data": "options"}
        ],

        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "asc"]]
    });
}

function cargarVentasCli(idCli) {
    tableVentas = $('#TableVentasC').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": "../../controladores/VentaController.php?funcion=listVentasC",
            "type": "POST",
            "data": {idCliente: idCli},
            "dataSrc": ""
        },
        "columns": [
            {"data": "descripcionIns"},
            {"data": "fechaV"},
            {"data": "horaV"},
            {"data": "ValorV"},
            {"data": "options"}
        ],

        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "asc"]]
    });
}

function seleccionarDireccion(idComuna) {
    $.ajax({
        type: 'POST',
        url: "../../controladores/ReciboController.php?funcion=searchDireccion",
        data: {idCuidad: idComuna},
        success: function (data) {
            $('.SelectDirecciones select').html(data).fadeIn();
            $("#Direcciones").show();
        }
    });
}

function ventaPagar(idVenta) {
    $("#comunaP").val("0");
    $("#Direcciones").hide();
    $("#idVentaC").val(idVenta);
}

function mostrarComisionDireccion(idDireccion) {
    var comision = null;
    $.ajax({
        type: 'POST',
        async: false,
        url: "../../controladores/ReciboController.php?funcion=comisionD",
        dataType: 'json',
        data: {idDireccion: idDireccion},
        success: function (data) {
            comision = data;
        }
    });
    return comision;
}

function mostrarMediosPago() {
    $.ajax({
        type: "POST",
        url: "../../controladores/ReciboController.php?funcion=listTipoPagos",
        success: function (data) {
            $('.SelectTipoPago select').html(data).fadeIn();
        }
    });
}

function verVenta(idVenta) {
    $("#tableDetalleV tbody").empty();
    $.ajax({
        type: 'POST',
        url: "../../controladores/VentaController.php?funcion=search",
        data: {idVenta: idVenta},
        success: function (data) {
            let venta = JSON.parse(data);
            $("#nombreVen").text(venta["NombreCliente"]);
            $("#cargoVen").text(venta["CargoCliente"]);
            $("#totalVen").text("$" + venta["PrecioVenta"]);
            $("#estadoV").text(venta["EstadoVenta"]);
            for (let i = 0; i < venta["detalleV"].length; i++) {
                //console.log(JSON.stringify(venta["detalleV"], ["NombreInsumo"]));
                $("#tableDetalleV tbody").append(`<tr>
                                            <td>${venta["detalleV"][i].NombreInsumo}</td>
                                            <td>${venta["detalleV"][i].CantidadVenta}</td>
                                            <td>$${venta["detalleV"][i].PrecioVenta}</td>
                                        </tr>`);
            }
        }
    });
    $("#modalVentaView").modal('show');
}
function verVentaPay(idVenta) {
    $("#tableDetalleVentaP tbody").empty();
    $.ajax({
        type: 'POST',
        url: "../../controladores/VentaController.php?funcion=search",
        data: {idVenta: idVenta},
        success: function (data) {
            let venta = JSON.parse(data);
            //console.log(venta["detalleV"]["CantidadVenta"]);
            $("#totalVenP").text("$" + venta["PrecioVenta"]);
            $("#estadoVP").text(venta["EstadoVenta"]);
            for (let i = 0; i < venta["detalleV"].length; i++) {
                $("#tableDetalleVentaP tbody").append(`<tr>
                                            <td>${venta["detalleV"][i].NombreInsumo}</td>
                                            <td>${venta["detalleV"][i].CantidadVenta}</td>
                                            <td>$${venta["detalleV"][i].PrecioVenta}</td>
                                            <td>$${venta["detalleV"][i].PrecioVenta * venta["detalleV"][i].CantidadVenta}</td>
                                        </tr>`);
            }
        }
    });
    $("#modalVentaViewPay").modal('show');
}

function actualizarVenta(idVenta) {
    swal({
        title: "Activar Venta",
        text: "¿Realmente desea Activar a esta Venta?",
        icon: "info",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            $.ajax({
                type: "POST",
                url: urlIndex + "/controladores/VentaController.php?funcion=activate",
                data: {idVenta: idVenta},
                success: function (data) {
                    if (data) {
                        swal({
                            title: "Exito !",
                            text: "Venta Activada Exitosamente !!",
                            icon: "success"
                        }).then(function () {
                            //window.location = urlIndex + "/view/Ventas";
                            tableVentas.ajax.reload();
                        });
                    }
                }
            });
        }
    });
}
//paypal.Button.render({
//    env: 'sandbox', // change for production if app is live,
//
//    client: {
//        sandbox: 'AYcF2p8R-9gV_iUQ1AGdOz_6vOAc_jwwUSfCC4FQr6bWLT_7_d4mbDFrv1ulNnelVZcicrJwgwVwJIRF',
//        production: 'AaBHKJFEej4V6yaArjzSx9cuf-UYesQYKqynQVCdBlKuZKawDDzFyuQdidPOBSGEhWaNQnnvfzuFB9SM'
//    },
//
//    commit: true, // Show a 'Pay Now' button
//
//    style: {
//        color: 'gold',
//        size: 'small'
//    },
//
//    payment: function (data, actions) {
//        let total = $("#PrecioPag").val();
//        return actions.payment.create({
//            payment: {
//                transactions: [
//                    {
//                        //total purchase
//                        amount: {
//                            total: total,
//                            currency: 'USD'
//                        }
//                    }
//                ]
//            }
//        });
//    },
//
//    onAuthorize: function (data, actions) {
//        return actions.payment.execute().then(function (payment) {
//        });
//    }
//}, '#paypal-btn-container');


//funcion para listar la venta donde se detalle los insumos, su cantidad, el valor unico y cuanto salio al total sin poner el subtotal

//otra funcion donde se muestre el nombre del cliente, el valor de la venta aun pendiente y los insumos que escogio en una tabla