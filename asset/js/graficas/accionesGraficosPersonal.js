$(document).ready(function () {
    if (cargo == "Jefa") {
        cargarGraficoInsumosJefa();
        cargarGraficaClientesRegistro();
    } else if (cargo == "Analista-financiero") {
        cargarGraficaCantVentas();
        cargarGraficaInsumosV();
    } else if (cargo == "Administrador de Empresas" || cargo == "Contador Auditor") {
        cargarGananciasPagosAdminCont();
        cargarCantRecibosAdminCont();
    }
});

/*graficas para el personal "Directora"*/

function cargarGraficoInsumosJefa() {
    $.ajax({
        type: 'POST',
        url: urlIndex + "/controladores/InsumoController.php?funcion=InsumosGrafica"
    }).done(function (response) {
        if (response.length > 0) {
            var insumos = JSON.parse(response);
            var titulo = [];
            var cantidad = [];
            var colores = [];
            var fechas = [];
            for (var i = 0; i < insumos.length; i++) {
                titulo.push(insumos[i]["NombreInsumo"]);
                cantidad.push(insumos[i]["CantidadVendida"]);
                fechas.push("Ultino registro vendido el :" + insumos[i]["fechaVenta"]);
                colores.push(colorRGB());
            }
            GenerarGrafico(titulo, cantidad, fechas, colores, 'bar', "Cantidad de insumos mas vendidos en el Mes/año", "insumoG");
        }
    });
}

function cargarGraficaClientesRegistro() {
    $.ajax({
        type: 'POST',
        url: urlIndex + "/controladores/ClienteController.php?funcion=ClientesGrafica"
    }).done(function (response) {
        if (response.length > 0) {
            var registros = JSON.parse(response);
            //console.log(registros);
            var mes = [];
            var cantidad = [];
            var fecha = [];
            var colores = [];

            for (var i = 0; i < registros.length; i++) {
                mes.push(registros[i]["mesRegistro"]);
                cantidad.push(registros[i]["registroClientes"]);
                fecha.push("Año :" + registros[i]["Anioregistro"] + ", Ultimo Registro :" + registros[i]["fechaRegistro"] + ",Hora :" + registros[i]["HoraVista"]);
                colores.push(colorRGB());
            }
            GenerarGrafico(mes, cantidad, fecha, colores, 'bar', "Cantidad de Clientes registrados en el Mes/Año", "clientesG");
        }
    });
}

/*graficas para el personal "Analista-financiero"*/

function cargarGraficaCantVentas() {
    $.ajax({
        type: 'POST',
        url: urlIndex + "/controladores/VentaController.php?funcion=cantGraficaV"
    }).done(function (response) {
        if (response.length > 0) {
            let ventas = JSON.parse(response);
            var mes = [];
            var cantidad = [];
            var fecha = [];
            var colores = [];

            for (var i = 0; i < ventas.length; i++) {
                mes.push(ventas[i]["mesVenta"]);
                cantidad.push(ventas[i]["idVen"]);
                fecha.push("Ultima Fecha de la Venta: " + ventas[i]["ultimaFecha"]);
                colores.push(colorRGB());
            }
            GenerarGrafico(mes, cantidad, fecha, colores, 'bar', "Cantidad de Ventas registradas en el Mes/Año", "CantVentasG");
        }
    });
}

function cargarGraficaInsumosV() {
    $.ajax({
        type: 'POST',
        url: urlIndex + "/controladores/VentaController.php?funcion=insumosVGrafi"
    }).done(function (response) {
        if (response.length > 0) {
            let ventas = JSON.parse(response);
            var insumo = [];
            var cantidad = [];
            var colores = [];
            var precio_fecha = [];
            for (var i = 0; i < ventas.length; i++) {
                insumo.push(ventas[i]["NombreInsumo"]);
                cantidad.push(ventas[i]["CantidadVendida"]);
                precio_fecha.push("Valor unitario : $" + ventas[i]["ValorVenta"] + ", Ganancias : $" + ventas[i]["totalV"] + ", Ultima fecha registrada: " + ventas[i]["fechaRegistro"]);
                colores.push(colorRGB());
            }
            GenerarGrafico(insumo, cantidad, precio_fecha, colores, 'bar', "Cantidad de Insumos vendidos y las Ganacias Acumuladas en el Mes/Año", "InsumosVentasG");
        }
    });
}

/*graficas para el personal "Adminstrador de Empresas" y "Contador Auditor"*/

function cargarGananciasPagosAdminCont() {
    $.ajax({
        type: 'POST',
        url: urlIndex + "/controladores/PagoController.php?funcion=graficaPagos"
    }).done(function (response) {
        if (response.length > 0) {
            let pago = JSON.parse(response);
            var mes = [];
            var montoAcumulado = [];
            var colores = [];
            var detalle = [];
            for (var i = 0; i < pago.length; i++) {
                mes.push(pago[i]["mesPago"]);
                montoAcumulado.push(pago[i]["totalP"]);
                detalle.push("Ultimo pago registrado: " + pago[i]["ultimaFecha"] + ", Ganacias en total: $" + pago[i]["totalP"]);
                colores.push(colorRGB());
            }
            GenerarGrafico(mes, montoAcumulado, detalle, colores, 'bar', "Ganacias Acumuladas en el Mes/Año", "pagosA-C");
        }
    });
}

function cargarCantRecibosAdminCont() {
    $.ajax({
        type: 'POST',
        url: urlIndex + "/controladores/ReciboController.php?funcion=graficaRecibos"
    }).done(function (response) {
        if (response.length > 0) {
            let recibos = JSON.parse(response);
            var clientes = [];
            var cantRecibos = [];
            var detallesRecibo = [];
            var colores = [];
            for (var i = 0; i < recibos.length; i++) {
                clientes.push(recibos[i]["NombreCliente"]);
                cantRecibos.push(recibos[i]["CantRecibos"]);
                detallesRecibo.push("Ultimo recibo Registrado: " + recibos[i]["fechaRecibo"] + ", Fono del Cliente: " + recibos[i]["TelefonoCliente"]);
                colores.push(colorRGB());
            }
            GenerarGrafico(clientes, cantRecibos, detallesRecibo, colores, 'bar', "Cantidad de Recibos generados por los Clientes registrados en el Mes/Año", "recibosA-C");
        }
    });
}

/*funciones encargadas de general la grafica*/

function GenerarGrafico(titulo, cantidad, texto, colores, tipo, encabezado, idGrafica) {
    var grafica = {
        x: titulo,
        y: cantidad,
        type: tipo,
        text: texto,
        marker: {
            color: colores
        }
    };

    var data = [grafica];

    var layout = {
        title: encabezado,
        font: {
            family: 'Raleway, sans-serif'
        },
        showlegend: false,
        xaxis: {
            tickangle: -45
        },
        yaxis: {
            zeroline: false,
            gridwidth: 4
        },
        bargap: 0.05
    };

    Plotly.newPlot(idGrafica, data, layout);
}

function generarNumero(numero) {
    return (Math.random() * numero).toFixed(0);
}

function colorRGB() {
    var coolor = "(" + generarNumero(243) + "," + generarNumero(235) + "," + generarNumero(254) + ")";
    return "rgb" + coolor;
}