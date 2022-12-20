<?php

require_once ('../config.php');
require_once ('../model/Conexion.php');
require_once ('../model/Vinculacion.php');
$vinculacion = new Vinculacion();

$funcion = "";


if (isset($_GET["funcion"])) {

    $funcion = $_GET["funcion"];

    if ($funcion == "create") {
        $nombre = (isset($_POST["nombre"])) ? $_POST["nombre"] : "";
        $telefono = (isset($_POST["telefono"])) ? $_POST["telefono"] : "";
        $correo = (isset($_POST["correo"])) ? $_POST["correo"] : "";
        $clave = (isset($_POST["clave"])) ? $_POST["clave"] : "";
        $fecha = date("Y-m-d H:i:s");
        $estado = 1;
        $listaVinculo = $vinculacion->mostrarCorreos($correo);
        $result = "";
        if (empty($listaVinculo)) {
            $result = $vinculacion->registrar($nombre, $telefono, $correo, $clave, $fecha, $estado);
        } else {
            $result = "El correo ya esta registrado";
        }

        if ($result == true) {
            echo $result;
        } else {
            echo $result;
        }
    } else if ($funcion == "search") {
        $datosVinculo = $vinculacion->listarPorId($_POST["idVincular"]);
        echo json_encode($datosVinculo);
    } else if ($funcion == "delete") {
        $idVinculo = (isset($_POST["idVincular"])) ? $_POST["idVincular"] : "";
        $estadoVinculo = 0;
        $vinculoActual = $vinculacion->editarEstado($idVinculo, $estadoVinculo);
        if ($vinculoActual == true) {
            echo $vinculoActual;
        }
    } else if ($funcion == "listVinculos") {
        $ListaVinculos = $vinculacion->lista();
        for ($i = 0; $i < count($ListaVinculos); $i++) {
            if ($ListaVinculos[$i]['EstadoVinculo'] == 1) {
                $ListaVinculos[$i]['EstadoVinculo'] = "INACTIVO";
            } else if ($ListaVinculos[$i]['EstadoVinculo'] == 0) {
                $ListaVinculos[$i]['EstadoVinculo'] = "ACTIVO";
            }
            $btnAceptV = "<button class='btn btn-secondary text-light' data-toggle='modal' data-target='#modalCliente' onclick='buscarVinculo(" . $ListaVinculos[$i]["idVinculacion"] . ");'><i class='far fa-eye'></i></button>&nbsp;";
            $btnDelete = "<button class='btn btn-danger text-light' data-toggle='modal' onclick='eliminarVinculo(" . $ListaVinculos[$i]["idVinculacion"] . ")'><i class='fas fa-trash'></i></button>";
            $ListaVinculos[$i]['options'] = $btnAceptV . ' ' . $btnDelete;
        }
        echo json_encode($ListaVinculos);
    }
} else {
    echo "<script>$(location).attr('href', '" . URL . "');</script>";
}