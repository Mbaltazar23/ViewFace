$(document).ready(function () {
    if (cargo == "Cliente") {
        cargarVentasCli(idCli);
    }
});

function cargarVentasCli(idCliente) {
    $.ajax({
        type: 'POST',
        url: urlIndex + "/controladores/VentaController.php?funcion=graficaVentaCli",
        data: {idCliente: idCliente}
    }).done(function (response) {
        if (response.length > 0) {
            let ventas = JSON.parse(response);
            //console.log(ventas);
            var titulo = [];
            var cantidad = [];
            var colores = [];
            var fechas = [];
            for (let i = 0; i < ventas.length; i++) {
                titulo.push(ventas[i]["descripcionIns"]);
                cantidad.push(ventas[i]["cantidadTotalV"]);
                fechas.push("Cantidad vendida el :" + ventas[i]["fechaV"]);
                colores.push(colorRGB());
            }
            GenerarGrafico(titulo, cantidad, fechas, colores, 'bar', "Cantidad de Productos adquiridos por usted", "VentasCliG");
        }
    });
}

/*funciones encargadas de general la grafica*/

function GenerarGrafico(titulo, cantidad, fecha, colores, tipo, encabezado, idGrafica) {
    var grafica = {
        x: titulo,
        y: cantidad,
        type: tipo,
        text: fecha,
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