<?php

require_once ('../config.php');
require_once ('../model/Conexion.php');
require_once ('../model/Venta.php');
require_once ('../model/Pago.php');
require_once ('../model/Recibo.php');
$venta = new Venta();
$pago = new Pago();
$recibo = new Recibo();
$funcion = "";

if (isset($_GET["funcion"])) {
    $funcion = $_GET["funcion"];
    if ($funcion == "create") {
        $idCliente = (isset($_POST["idCliente"])) ? $_POST["idCliente"] : "";
        $arregloInsumos = (isset($_POST["arregloInsumos"])) ? $_POST["arregloInsumos"] : "";
        $precioTotalV = (isset($_POST["precioTotalV"])) ? $_POST["precioTotalV"] : "";
        $estadoVenta = 1;
        $fechaVenta = date("Y-m-d H:i:s");
        $registroVenta = $venta->registrar($idCliente, $estadoVenta, $precioTotalV, $fechaVenta);
        //validamos que se registro la venta 
        if ($registroVenta > 0) {
            //guardamos el id de la venta
            $idVenta = $registroVenta;
            //reccorremos el arreglo con los insumos escogidos y guardados su detalle
            foreach ($arregloInsumos as $ins) {
                $idInsu = $ins["idInsumo"];
                $precioI = $ins["precio"];
                $cantidadI = $ins["cantidad"];
                $detalleVen = $venta->registrarDetalleVenta($cantidadI, $precioI, $idInsu, $idVenta);
            }
        }
        if ($detalleVen == true) {
            echo $detalleVen;
        }
    } else if ($funcion == "search") {
        $idVenta = (isset($_POST["idVenta"])) ? $_POST["idVenta"] : "";
        $DetalleVenta = $venta->BuscarVenta($idVenta);
        if (empty($DetalleVenta["CargoCliente"])) {
            $DetalleVenta["CargoCliente"] = "No tiene un cargo fijo";
        }
        if ($DetalleVenta["EstadoVenta"] == 1) {
            $DetalleVenta["EstadoVenta"] = "EN PROCESO";
        } else if ($DetalleVenta["EstadoVenta"] == 2) {
            $DetalleVenta["EstadoVenta"] = "PROCESADA";
        }
        $DetalleInsumos = $venta->listarDetalleVentas($idVenta);
        $DetalleVenta["detalleV"] = $DetalleInsumos;
        echo json_encode($DetalleVenta);
    } else if ($funcion == "edit") {
        $idVenta = (isset($_POST["idVenta"])) ? $_POST["idVenta"] : "";
        $arregloInsumos = (isset($_POST["arregloInsumos"])) ? $_POST["arregloInsumos"] : "";
        $precioTotalV = (isset($_POST["precioTotalV"])) ? $_POST["precioTotalV"] : "";
        $fechaVenta = date("Y-m-d H:i:s");

        $eliminarInsumo = $venta->quitarInsumos($idVenta);
        $resultadoVenta = $venta->EditarVenta($precioTotalV, $fechaVenta, $idVenta);
        if ($resultadoVenta == true) {
            foreach ($arregloInsumos as $ins) {
                $idInsu = $ins["idInsumo"];
                $precioI = $ins["precio"];
                $cantidadI = $ins["cantidad"];
                $detalleVen = $venta->registrarDetalleVenta($cantidadI, $precioI, $idInsu, $idVenta);
            }
        }
        if ($detalleVen == true) {
            echo $detalleVen;
            //echo "<script>$(location).attr('href', '" . URL . "/view/Insumos/insumoCliente.php');</script>";
        }
    } else if ($funcion == "delete") {
        $idVenta = (isset($_POST["idVenta"])) ? $_POST["idVenta"] : "";
        $estadoVenta = 0;
        $resultadoVenta = "";
        $DetalleVenta = $venta->BuscarVenta($idVenta);
        if ($DetalleVenta["EstadoVenta"] == 2) {
            $estadoPagoR = 0;
            $resultPago = $pago->buscarPagoVenta($idVenta);
            $idPago = $resultPago["idPago"];
            $resultRecibo = $recibo->buscarReciboPagado($idPago);
            $idRecibo = $resultRecibo["idRecibo"];
            $EstateP = $pago->actualizarPagoRecibo($idPago, $estadoPagoR);
            $EstateR = $recibo->actualizarRecibo($idRecibo, $estadoPagoR);
            $resultadoVenta = $venta->actualizarVenta($idVenta, $estadoVenta);
        } else if ($DetalleVenta["EstadoVenta"] == 1) {
            $resultadoVenta = $venta->actualizarVenta($idVenta, $estadoVenta);
        }
        if ($resultadoVenta == true) {
            echo $resultadoVenta;
        }
    } else if ($funcion == "activate") {
        $idVenta = (isset($_POST["idVenta"])) ? $_POST["idVenta"] : "";
        $estadoVenta = 0;
        $estateV = "";
        $estadoPagoR = 1;
        $EstateP = "";
        $EstateR = "";
        $resultPago = $pago->buscarPagoVenta($idVenta);
        $idPago = $resultPago["idPago"];
        $resultRecibo = $recibo->buscarReciboPagado($idPago);
        $idRecibo = $resultRecibo["idRecibo"];
        if (!empty($idPago) && !empty($idRecibo)) {
            $EstateP = $pago->actualizarPagoRecibo($idPago, $estadoPagoR);
            $EstateR = $recibo->actualizarRecibo($idRecibo, $estadoPagoR);
            $estadoVenta = 2;
            $estateV = $venta->actualizarVenta($idVenta, $estadoVenta);
        } else {
            $estadoVenta = 1;
            $estateV = $venta->actualizarVenta($idVenta, $estadoVenta);
        }

        if ($estateV == true) {
            echo $estateV;
        }
    } else if ($funcion == "listVentasA") {
        $listVentas = $venta->listarVentas();
        for ($i = 0; $i < count($listVentas); $i++) {
            $btnView = "";
            $btnEdit_Delete = "";
            if ($listVentas[$i]["EstadoVenta"] == 1) {
                $listVentas[$i]["EstadoVenta"] = "<span class='badge badge-success'>EN PROCESO</span>";
                $btnView = "<button class='btn btn-primary text-light' onclick='verVenta(" . $listVentas[$i]["idVenta"] . ")'><i class='far fa-eye'></i></button>";
                $btnEdit_Delete = "<button class='btn btn-danger text-light' onclick='quitarVenta(" . $listVentas[$i]["idVenta"] . ")'><i class='fas fa-ban'></i></button>";
            } else if ($listVentas[$i]["EstadoVenta"] == 2) {
                $listVentas[$i]["EstadoVenta"] = "<span class='badge badge-primary'>PROCESADA</span>";
                $btnView = "<button class='btn btn-dark' onclick='verVentaPay(" . $listVentas[$i]["idVenta"] . ")'><i class='far fa-money-bill-alt'></i></button>";
                $btnEdit_Delete = "<button class='btn btn-danger text-light' onclick='quitarVenta(" . $listVentas[$i]["idVenta"] . ")'><i class='fas fa-trash-alt'></i></button>";
            } else if ($listVentas[$i]["EstadoVenta"] == 0) {
                $listVentas[$i]["EstadoVenta"] = "<span class='badge badge-danger'>INACTIVA</span>";
                $btnView = "<button class='btn btn-secondary text-light' onclick='verVenta(" . $listVentas[$i]["idVenta"] . ")' disabled><i class='far fa-eye'></i></button>";
                $btnEdit_Delete = "<button class='btn btn-primary text-light' onclick='actualizarVenta(" . $listVentas[$i]["idVenta"] . ")'><i class='fas fa-toggle-on'></i></button>";
            }
            $listVentas[$i]["fechaV"] = date_format(new DateTime($listVentas[$i]['FechaVenta']), 'd-m-Y');
            $listVentas[$i]["horaV"] = date_format(new DateTime($listVentas[$i]['FechaVenta']), 'H:i:s');
            $listVentas[$i]["valorV"] = "$" . $listVentas[$i]["PrecioVenta"];
            $listVentas[$i]['options'] = $btnView . ' ' . $btnEdit_Delete;
        }
        echo json_encode($listVentas);
    } else if ($funcion == "listVentasC") {
        $idCliente = (isset($_POST["idCliente"])) ? $_POST["idCliente"] : "";
        $VentasCli = $venta->listarVentas($idCliente);
        $descripcion = "";
        //recorremos el listado/arreglo de datos de la venta del cliente
        for ($i = 0; $i < count($VentasCli); $i++) {
            //obtenemos el id de la venta segun el detalle guardado
            $list_ventas = $venta->listarDetalleVentas($VentasCli[$i]["idVenta"]);
            $descripcionInsumos = "";
            foreach ($list_ventas as $venti) {
                $descripcionInsumos .= $venti["NombreInsumo"] . ", ";
            }
            $descripcion = rtrim($descripcionInsumos, ", ");
            //se instancia la descripcion o detalle de la venta y se guarda en una posicion del array
            $VentasCli[$i]["descripcionIns"] = $descripcion;
            $VentasCli[$i]["fechaV"] = date_format(new DateTime($VentasCli[$i]['FechaVenta']), 'd-m-Y');
            $VentasCli[$i]["horaV"] = date_format(new DateTime($VentasCli[$i]['FechaVenta']), 'H:i:s');
            $VentasCli[$i]["ValorV"] = "$" . $VentasCli[$i]['PrecioVenta'];

            $BtnEdit = '<button class="btn btn-success text-light" onclick="buscarVenta(' . $VentasCli[$i]["idVenta"] . ')"><i class="fas fa-edit"></i></button>&nbsp;';
            $BtnPay = '<button class="btn btn-secondary text-light" data-toggle="modal" data-target="#modalComunaPago" onclick="ventaPagar(' . $VentasCli[$i]["idVenta"] . ')"><i class="fas fa-cart-plus"></i></button>';
            $BtnDelete = '<button class="btn btn-danger text-light" onclick="quitarVenta(' . $VentasCli[$i]["idVenta"] . ')"><i class="fas fa-trash"></i></button>';
            $VentasCli[$i]['options'] = $BtnEdit . '  ' . $BtnPay . '  ' . $BtnDelete;
        }
        echo json_encode($VentasCli);
    } else if ($funcion == "searchTotalPrice") {
        $idVenta = (isset($_POST["idVenta"])) ? $_POST["idVenta"] : "";
        $DatoPrecio = $venta->BuscarVenta($idVenta);
        $PrecioVenta = $DatoPrecio["PrecioVenta"];
        echo json_encode($PrecioVenta);
        //
    } else if ($funcion == "graficaVentaCli") {
        $idCliente = (isset($_POST["idCliente"])) ? $_POST["idCliente"] : "";
        $graficVentas = $venta->listarVentasPay($idCliente);
        for ($i = 0; $i < count($graficVentas); $i++) {
            $list_ventas = $venta->listarDetalleVentas($graficVentas[$i]["idVenta"]);
            $descripcionInsumos = "";
            $cantidadV = 0;
            $numCan = "";
            foreach ($list_ventas as $venti) {
                $descripcionInsumos .= $venti["NombreInsumo"] . ", ";
                $numCan = number_format($venti["CantidadVenta"]);
                $cantidadV += $numCan;
            }
            $descripcion = rtrim($descripcionInsumos, ", ");
            //se instancia la descripcion o detalle de la venta y se guarda en una posicion del array
            $graficVentas[$i]["descripcionIns"] = $descripcion;
            $graficVentas[$i]["cantidadTotalV"] = $cantidadV;
            $graficVentas[$i]["fechaV"] = date_format(new DateTime($graficVentas[$i]['fechaV']), 'd-m-Y');
        }
        echo json_encode($graficVentas);
    } else if ($funcion == "cantGraficaV") {
        $GraficaCantV = $venta->cargarGraficasCantVentas();
        echo json_encode($GraficaCantV);
    } else if ($funcion == "insumosVGrafi") {
        $GraficaInsumosV = $venta->cargarGraficasInsumosVent();
        echo json_encode($GraficaInsumosV);
    }
} else {
    echo "<script>$(location).attr('href', '" . URL . "');</script>";
}    