$(document).ready(function () {
    if (cargoBan == "Jefa") {
        $("#titleBanner").text("Directora");
        $("#parrafoBanner").text("Este sera su modulo donde vera que sus funciones principales (Insumos,Peticiones y Clientes).");
    } else if (cargoBan == "Cliente") {
        $("#titleBanner").text("Cliente");
        $("#parrafoBanner").text("Este sera su modulo donde podra realizar sus Ventas de cada Insumo y el recibo de cada venta");
    } else if (cargoBan == "Administrador de Empresas") {
        $("#titleBanner").text("Administrador de Empresas");
        $("#parrafoBanner").text("Este sera su modulo donde vera que sus funciones principales(Recibos/Pagos generados y las Peticiones)");
    } else if (cargoBan == "Contador Auditor") {
        $("#titleBanner").text("Contador Auditor");
        $("#parrafoBanner").text("Este sera su modulo donde vera que sus funciones principales(Recibos/Pagos generados y las Peticiones)");
    }else if (cargoBan == "Analista-financiero") {
         $("#titleBanner").text("Analista-financiero");
        $("#parrafoBanner").text("Este sera su modulo donde vera que sus funciones principales(Ventas generadas y las Peticiones)");
    }
});





