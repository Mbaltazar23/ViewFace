<?php

require_once ('../config.php');
require_once ('../model/Conexion.php');
require_once ('../model/Venta.php');
require_once ('../model/Pago.php');
require_once ('../model/Insumos.php');
require_once ('../model/Recibo.php');
require_once ('../model/Cliente.php');

$pago = new Pago();
$venta = new Venta();
$insumo = new Insumos();
$recibo = new Recibo();
$cliente = new Cliente();
$funcion = "";

if (isset($_GET["funcion"])) {
    $funcion = $_GET["funcion"];
    if ($funcion == "create") {
        $idVenta = (isset($_POST["idVenta"])) ? $_POST["idVenta"] : "";
        $idCliente = (isset($_POST["idCliente"])) ? $_POST["idCliente"] : "";
        $costoTotal = (isset($_POST["costoTotal"])) ? $_POST["costoTotal"] : "";
        $subTotal = (isset($_POST["subTotal"])) ? $_POST["subTotal"] : "";
        $Direccion = (isset($_POST["Direccion"])) ? $_POST["Direccion"] : "";
        $tipoPago = (isset($_POST["tipoPago"])) ? $_POST["tipoPago"] : "";
        $descripcion = (isset($_POST["descripcion"])) ? $_POST["descripcion"] : "";
        $idComuna = (isset($_POST["idComuna"])) ? $_POST["idComuna"] : "";
        $estadoPago = 1;
        $fecha = date("Y-m-d H:i:s");
        $estadoVenta = 2;

        $registroPago = $pago->registrar($fecha, $descripcion, $costoTotal, $estadoPago, $idVenta, $tipoPago);
        if ($registroPago > 0) {
            $idPago = $registroPago;
            $detalleTelefono = $cliente->buscarClientePorId($idCliente);
            $ReciboTelefono = $detalleTelefono["TelefonoCliente"];
            $EstadoRecibo = 1;
            $registroRecibo = $recibo->registrar($ReciboTelefono, $subTotal, $costoTotal, $Direccion, $fecha, $EstadoRecibo, $idPago, $idComuna);
            if ($registroRecibo == true) {
                $detalleVentas = $venta->listarDetalleVentas($idVenta);
                foreach ($detalleVentas as $item) {
                    $idInsu = $item["idInsumo"];
                    $precioI = $item["PrecioVenta"];
                    $cantidadI = $item["CantidadVenta"];
                    //una vez guardado el recibo buscamos dicho insumo y le descontamos la cantidad que se vendio y pago
                    $insumoA = $insumo->buscarInsumo($idInsu);
                    $cantidadDesc = $insumoA["CantidadInsumo"] - $cantidadI;
                    $insumoB = $insumo->DescontarCantidad($idInsu, $cantidadDesc);
                    $insumoC = $insumo->buscarInsumo($idInsu);
                    //una vez descontada la cantidad lo volvemos a buscar para identificar si no queda mas insumos para dejarlo con la cantidad consumida o en caso que ya no haya ni un insumo se desabilita dicho insumo
                    if ($insumoC["CantidadInsumo"] == 0) {
                        $estadoInsumo = 0;
                        $actualInsumo = $insumo->ActualizarEstado($idInsu, $estadoInsumo);
                    } else {
                        $precioDescT = $precioI * $cantidadDesc;
                        $actualInsumo = $insumo->actualizarCantidad($idInsu, $cantidadDesc, $precioDescT);
                    }
                }
            }
        }
        $actualizarVenta = $venta->actualizarVenta($idVenta, $estadoVenta);

        if ($actualizarVenta == true) {
            echo $actualizarVenta;
        }
    } else if ($funcion == "search") {
        $idPago = (isset($_POST["idPago"])) ? $_POST["idPago"] : "";
        $pagoCli = $pago->buscarPago($idPago);
        $idVenta = $pagoCli["VentaPagada"];
        $detalleVenta = $venta->listarDetalleVentas($idVenta);
        if (!empty($pagoCli)) {
            if ($pagoCli['PagoEstado'] == 1) {
                $pagoCli['PagoEstado'] = "PROCESADO";
            }
            $numCan = "";
            $cantidadV = 0;
            $total = 0;
            $valorT = 0;
            foreach ($detalleVenta as $venIns) {
                $numCan = number_format($venIns["CantidadVenta"]);
                $valorT = $venIns["CantidadVenta"] * $venIns["PrecioVenta"];
                $cantidadV += $numCan;
                $total += $valorT;
            }
            $pagoCli["detalleV"] = $detalleVenta;
            $pagoCli["cantidadV"] = $cantidadV;
            $pagoCli["subTotal"] = $total;
        }
        echo json_encode($pagoCli);
    } else if ($funcion == "delete") {
        $idPago = (isset($_POST["idPago"])) ? $_POST["idPago"] : "";
        $estado = 0;
        $resulPago = $pago->buscarPago($idPago);
        $quitarPago = $pago->actualizarPagoRecibo($idPago, $estado);
        $idVenta = $resulPago["VentaPagada"];
        $idRecibo = $resulPago["idRecibo"];
        $resulV = $venta->actualizarVenta($idVenta, $estado);
        $resulR = $recibo->actualizarRecibo($idRecibo, $estado);
        if ($quitarPago == true && $resulR && $resulV) {
            echo $quitarPago . $resulR . $resulV;
        }
    } else if ($funcion == "activate") {
        $idPago = (isset($_POST["idPago"])) ? $_POST["idPago"] : "";
        $estado = 1;
        $resulPago = $pago->buscarPago($idPago);
        $quitarPago = $pago->actualizarPagoRecibo($idPago, $estado);
        $idVenta = $resulPago["VentaPagada"];
        $idRecibo = $resulPago["idRecibo"];
        $resulV = $venta->actualizarVenta($idVenta, 2);
        $resulR = $recibo->actualizarRecibo($idRecibo, $estado);
        if ($quitarPago == true && $resulR && $resulV) {
            echo $quitarPago . $resulR . $resulV;
        }
    } else if ($funcion == "listPagos") {
        $listaPagos = $pago->listarPagos();
        for ($i = 0; $i < count($listaPagos); $i++) {
            $btnView = "";
            $btnDelete = "";
            if ($listaPagos[$i]['PagoEstado'] == 1) {
                $listaPagos[$i]['PagoEstado'] = "<span class='badge badge-success'>PROCESADO</span>";
                $btnView = "<button class='btn btn-secondary' onclick='buscarPago(" . $listaPagos[$i]["idPago"] . ");'><i class='far fa-eye'></i></button>";
                $btnDelete = "<button class='btn btn-danger text-light' onclick='quitarPago(" . $listaPagos[$i]['idPago'] . ")'><i class='fas fa-trash-alt'></i></button>";
            } else if ($listaPagos[$i]['PagoEstado'] == 0) {
                $listaPagos[$i]['PagoEstado'] = "<span class='badge badge-danger'>CANCELADO</span>";
                $btnView = "<button class='btn btn-secondary' onclick='buscarPago(" . $listaPagos[$i]["idPago"] . ");' disabled=''><i class='far fa-eye'></i></button>";
                $btnDelete = "<button class='btn btn-primary text-light' onclick='activarPago(" . $listaPagos[$i]['idPago'] . ")'><i class='fas fa-toggle-on'></i></button>";
            }
            $listaPagos[$i]['montoP'] = "$" . $listaPagos[$i]['PagoMonto'];
            $listaPagos[$i]['options'] = $btnView . ' ' . $btnDelete;
        }
        echo json_encode($listaPagos);
    } else if ($funcion == "graficaPagos") {
        $GraficaPago = $pago->cargarPagosGrafica();
        echo json_encode($GraficaPago);
    } else {
        echo "<script>$(location).attr('href', '" . URL . "');</script>";
    }
}
    