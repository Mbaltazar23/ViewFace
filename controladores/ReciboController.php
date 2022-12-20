<?php

require_once ('../config.php');
require_once ('../model/Conexion.php');
require_once ('../model/Recibo.php');
require_once ('../model/Venta.php');
require_once ('../model/Pago.php');
$recibo = new Recibo();
$pago = new Pago();
$venta = new Venta();
$funcion = "";
if (isset($_GET["funcion"])) {
    $funcion = $_GET["funcion"];
    if ($funcion == "search") {
        $idRecibo = (isset($_POST["idRecibo"])) ? $_POST["idRecibo"] : "";
        $reciboEncontrado = $recibo->buscarRecibo($idRecibo);
        echo json_encode($reciboEncontrado);
    } else if ($funcion == "listRecibosAd") {
        $Recibos = $recibo->listarRecibos();
        for ($i = 0; $i < count($Recibos); $i++) {
            $btnView = "";
            $btnDelete = "";
            if ($Recibos[$i]['EstadoRecibo'] == 1) {
                $Recibos[$i]['EstadoRecibo'] = "<span class='badge badge-info'>PROCESADA</span>";
                $btnView = "<button class='btn btn-secondary' data-toggle='modal' data-target='#modalReciboVer' onclick='buscarReciboCli(" . $Recibos[$i]['idRecibo'] . ")'><i class='far fa-eye'></i></button>";
                $btnDelete = "<button class='btn btn-danger text-light' onclick='quitarRecibo(" . $Recibos[$i]['idRecibo'] . ")'><i class='fas fa-trash-alt'></i></button>";
            } else if ($Recibos[$i]['EstadoRecibo'] == 2) {
                $Recibos[$i]['EstadoRecibo'] = "<span class='badge badge-dark'>IMPRESA</span>";
                $btnView = "<button class='btn btn-primary' onclick='procesarRecibo(" . $Recibos[$i]['idRecibo'] . ")'><i class='fab fa-digital-ocean'></i></button>";
                $btnDelete = "<button class='btn btn-danger text-light' onclick='quitarRecibo(" . $Recibos[$i]['idRecibo'] . ")'><i class='fas fa-ban'></i></button>";
            } else if ($Recibos[$i]['EstadoRecibo'] == 0) {
                $Recibos[$i]['EstadoRecibo'] = "<span class='badge badge-danger'>RECHAZADA</span>";
                $btnView = "<button class='btn btn-secondary' onclick='procesarRecibo(" . $Recibos[$i]['idRecibo'] . ")' disabled=''><i class='far fa-eye'></i></button>";
                $btnDelete = "<button class='btn btn-primary text-light' onclick='activarRecibo(" . $Recibos[$i]['idRecibo'] . ")'><i class='fas fa-toggle-on'></i></button>";
            }
            $Recibos[$i]['Valor'] = "$" . $Recibos[$i]['TotalRecibo'];
            $Recibos[$i]['options'] = $btnView . ' ' . $btnDelete;
        }
        echo json_encode($Recibos);
    } else if ($funcion == "listRecibosCli") {
        $idCliente = (isset($_POST["idCliente"])) ? $_POST["idCliente"] : "";
        $RecibosCliente = $recibo->listarRecibos($idCliente);
        for ($i = 0; $i < count($RecibosCliente); $i++) {
            $btnView = "";
            if ($RecibosCliente[$i]['EstadoRecibo'] == 1) {
                $RecibosCliente[$i]['EstadoRecibo'] = "<span class='badge badge-info'>PROCESADA</span>";
                $btnView = "<button class='btn btn-secondary' data-toggle='modal' data-target='#modalReciboVer' onclick='buscarReciboCli(" . $RecibosCliente[$i]['idRecibo'] . ")'><i class='far fa-eye'></i></button>";
            } else if ($RecibosCliente[$i]['EstadoRecibo'] == 2) {
                $RecibosCliente[$i]['EstadoRecibo'] = "<span class='badge badge-dark'>IMPRESA</span>";
                $btnView = "<button class='btn btn-primary' onclick='procesarRecibo(" . $RecibosCliente[$i]['idRecibo'] . ")'><i class='fab fa-digital-ocean'></i></button>";
            }
            $RecibosCliente[$i]['Valor'] = "$" . $RecibosCliente[$i]['TotalRecibo'];
            $RecibosCliente[$i]['options'] = $btnView;
        }
        echo json_encode($RecibosCliente);
    } else if ($funcion == "listCuidades") {
        $listComunas = $recibo->listarCiudades();
        echo '<option value="0"> Seleccione una Comuna </option>';
        for ($i = 0; $i < count($listComunas); $i++) {
            echo '<option value="' . $listComunas[$i]['idComuna'] . '">' . $listComunas[$i]['ComunaNombre'] . '</option>';
        }
    } else if ($funcion == "imprimir") {
        $idRecibo = (isset($_POST["idRecibo"])) ? $_POST["idRecibo"] : "";
        $EstadoRecibo = 0;
        $respuesta = "";
        $resultRecibo = $recibo->buscarRecibo($idRecibo);
        if ($resultRecibo["EstadoRecibo"] == 2) {
            $EstadoRecibo = 1;
            $respuesta = $recibo->actualizarRecibo($idRecibo, $EstadoRecibo);
        } else {
            $EstadoRecibo = 2;
            $respuesta = $recibo->actualizarRecibo($idRecibo, $EstadoRecibo);
        }
        if ($respuesta) {
            echo $respuesta;
        }
    } else if ($funcion == "delete") {
        $idRecibo = (isset($_POST["idRecibo"])) ? $_POST["idRecibo"] : "";
        $EstadoRecibo = 0;
        $reciboCli = $recibo->buscarRecibo($idRecibo);
        $resultRecibo = $recibo->actualizarRecibo($idRecibo, $EstadoRecibo);
        if ($resultRecibo == true) {
            $estado = 0;
            $idPago = $reciboCli["ReciboPago"];
            $idVenta = $reciboCli["idVenta"];
            $resultPago = $pago->actualizarPagoRecibo($idPago, $estado);
            $resultVenta = $venta->actualizarVenta($idVenta, $estado);
            if ($resultPago == true && $resultVenta == true) {
                echo $resultPago;
            }
        }
    } else if ($funcion == "activate") {
        $idRecibo = (isset($_POST["idRecibo"])) ? $_POST["idRecibo"] : "";
        $EstadoRecibo = 1;
        $reciboCli = $recibo->buscarRecibo($idRecibo);
        $resultRecibo = $recibo->actualizarRecibo($idRecibo, $EstadoRecibo);
        if ($resultRecibo == true) {
            $estado = 1;
            $idPago = $reciboCli["ReciboPago"];
            $idVenta = $reciboCli["idVenta"];
            $resultPago = $pago->actualizarPagoRecibo($idPago, $estado);
            $resultVenta = $venta->actualizarVenta($idVenta, 2);
            if ($resultPago == true && $resultVenta == true) {
                echo $resultPago . $resultVenta;
            }
        }
    } else if ($funcion == "comisionD") {
        $idDireccion = (isset($_POST["idDireccion"])) ? $_POST["idDireccion"] : "";
        $DatoComision = $recibo->buscarCostoEnvio($idDireccion);
        $Comision = $DatoComision["ValorEnvio"];
        echo json_encode($Comision);
    } else if ($funcion == "listTipoPagos") {
        $listTiposPago = $recibo->listarTiposPago();
        echo '<option value="0">Seleccione un medio de Pago</option>';
        for ($i = 0; $i < count($listTiposPago); $i++) {
            echo '<option value="' . $listTiposPago[$i]['idTipoPago'] . '">' . $listTiposPago[$i]['nombreTipoPago'] . '</option>';
        }
    } else if ($funcion == "searchDireccion") {
        $idCuidad = (isset($_POST["idCuidad"])) ? $_POST["idCuidad"] : "";
        $listDirecciones = $recibo->buscarDireccion_Cuidad($idCuidad);
        echo '<option value="0">Seleccione su Direccion</option>';
        for ($i = 0; $i < count($listDirecciones); $i++) {
            echo '<option value="' . $listDirecciones[$i]['idDireccion'] . '">' . $listDirecciones[$i]['DireccionNombre'] . '</option>';
        }
    } else if ($funcion == "graficaRecibos") {
        $GraficaRecibos = $recibo->cargarGraficaCantRecibosClientes();
        echo json_encode($GraficaRecibos);
    }
} else {
    echo "<script>$(location).attr('href', '" . URL . "');</script>";
}
?>


