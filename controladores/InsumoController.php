<?php

require_once ('../config.php');
require_once ('../model/Conexion.php');
require_once ('../model/Insumos.php');

$insumo = new Insumos();
$funcion = "";
if (isset($_GET["funcion"])) {
    $funcion = $_GET["funcion"];
    if ($funcion == "create") {
        $nombreInsumo = (isset($_POST["nombre"])) ? $_POST["nombre"] : "";
        $cantidadInsumo = (isset($_POST["cantidad"])) ? $_POST["cantidad"] : "";
        $codigoCategoria = (isset($_POST["idCategoria"])) ? $_POST["idCategoria"] : "";
        $descripcionInsumo = (isset($_POST["descripcion"])) ? $_POST["descripcion"] : "";
        $estadoInsumo = 0;
        $precioUnic = (isset($_POST["precio"])) ? $_POST["precio"] : "";
        $precioT = (isset($_POST["precioT"])) ? $_POST["precioT"] : "";
        $resultado = "";
        $nombresInsumo = $insumo->mostrarNombresInsumos($nombreInsumo);
        if (empty($nombresInsumo)) {
            $resultado = $insumo->registrar($codigoCategoria, $nombreInsumo, $cantidadInsumo, $descripcionInsumo, $estadoInsumo, $precioUnic, $precioT);
        } else {
            $resultado = "El nombre del insumo ya esta Registrado..";
        }

        if ($resultado == true) {
            echo $resultado;
        } else {
            echo $resultado;
        }
    } else if ($funcion == "update") {
        $idInsumo = (isset($_POST["idInsumo"])) ? $_POST["idInsumo"] : "";
        $nombreInsumo = (isset($_POST["nombre"])) ? $_POST["nombre"] : "";
        $codigoCategoria = (isset($_POST["idCategoria"])) ? $_POST["idCategoria"] : "";
        $descripcionInsumo = (isset($_POST["descripcion"])) ? $_POST["descripcion"] : "";
        $precioUnic = (isset($_POST["precio"])) ? $_POST["precio"] : "";
        $precioT = (isset($_POST["precioT"])) ? $_POST["precioT"] : "";
        $resultado = $insumo->editarInsumo($codigoCategoria, $nombreInsumo, $descripcionInsumo, $precioUnic, $precioT, $idInsumo);
        if ($resultado == true) {
            echo $resultado;
        }
    } else if ($funcion == "search") {
        $idInsumo = (isset($_POST["idInsumo"])) ? $_POST["idInsumo"] : "";
        $resultadoInsumo = $insumo->buscarInsumo($idInsumo);
        echo json_encode($resultadoInsumo);
    } else if ($funcion == "updateCant") {
        $idInsu = (isset($_POST["idInsumo"])) ? $_POST["idInsumo"] : "";
        $precioT = (isset($_POST["precioT"])) ? $_POST["precioT"] : "";
        $cantidad = (isset($_POST["cantidad"])) ? $_POST["cantidad"] : "";

        $resultado = $insumo->actualizarCantidad($idInsu, $cantidad, $precioT);
        if ($resultado == true) {
            echo $resultado;
        }
    } else if ($funcion == "delete") {
        $idInsu = (isset($_POST["idInsumo"])) ? $_POST["idInsumo"] : "";
        $estadoInsumo = 0;
        $resultado = $insumo->ActualizarEstado($idInsu, $estadoInsumo);
        if ($resultado == true) {
            echo $resultado;
        }
    } else if ($funcion == "activate") {
        $idInsu = (isset($_POST["idInsumo"])) ? $_POST["idInsumo"] : "";
        $estadoInsumo = 1;
        $resultado = $insumo->ActualizarEstado($idInsu, $estadoInsumo);
        if ($resultado == true) {
            echo $resultado;
        }
        //
    } else if ($funcion == "list") {
        $listadoInsumo = $insumo->lista();
        for ($i = 0; $i < count($listadoInsumo); $i++) {
            $btnDelete = '';
            $btnEditCant = '';
            $btnEdit = '';
            if ($listadoInsumo[$i]['EstadoInsumo'] == 1) {
                $listadoInsumo[$i]['EstadoInsumo'] = "<span class='badge badge-success'>ACTIVO</span>";
                $btnDelete = "<button class='btn btn-danger btn-circle' data-toggle='modal' onclick='buscarInsumoEliminar(" . $listadoInsumo[$i]["idInsumo"] . ")'><i class='fas fa-power-off'></i></button>";
                $btnEditCant = "<button class='btn btn-secondary btn-circle' data-toggle='modal' data-target='#modalInsumoCantidad' onclick='buscarInsumoCant(" . $listadoInsumo[$i]["idInsumo"] . ");'><i class='fas fa-plus-circle'></i></button>";
                $btnEdit = "<button class='btn btn-success btn-circle' onclick='buscarInsumoEdit(" . $listadoInsumo[$i]["idInsumo"] . ");'><i class='fas fa-edit'></i></button>";
            } else if ($listadoInsumo[$i]['EstadoInsumo'] == 0) {
                $listadoInsumo[$i]['EstadoInsumo'] = "<span class='badge badge-danger'>INACTIVO</span>";
                $btnDelete = "<button class='btn btn-primary btn-circle' data-toggle='modal' onclick='InsumoActivar(" . $listadoInsumo[$i]["idInsumo"] . ")'><i class='fas fa-toggle-on'></i></button>";
                $btnEditCant = "<button class='btn btn-secondary btn-circle' data-toggle='modal' data-target='#modalInsumoCantidad' onclick='buscarInsumoCant(" . $listadoInsumo[$i]["idInsumo"] . ");' disabled=''><i class='fas fa-plus-circle'></i></button>";
                $btnEdit = "<button class='btn btn-secondary btn-circle' onclick='buscarInsumoEdit(" . $listadoInsumo[$i]["idInsumo"] . ");' disabled=''><i class='fas fa-edit'></i></button>";
            }
            $listadoInsumo[$i]['options'] = $btnEdit . ' ' . $btnEditCant . ' ' . $btnDelete;
        }
        echo json_encode($listadoInsumo);
        //
    } else if ($funcion == "InsumosGrafica") {
        $GraficaInsumo = $insumo->cargarGraficoInsumosVendidos();
        echo json_encode($GraficaInsumo);
    }
} else {
    echo "<script>$(location).attr('href', '" . URL . "');</script>";
}
    