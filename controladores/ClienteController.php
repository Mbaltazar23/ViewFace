<?php

require_once ('../config.php');
require_once ('../model/Conexion.php');
require_once ('../model/Cliente.php');
require_once ('../model/Vinculacion.php');
require_once ('../model/Personal.php');

$cliente = new Cliente();
$vinculacion = new Vinculacion();
$personal = new Personal();
$funcion = "";

if (isset($_GET["funcion"])) {
    $funcion = $_GET["funcion"];
    if ($funcion == "create") {
        $idCargo = (isset($_POST["idNegocio"])) ? $_POST["idNegocio"] : "";
        $idVinculo = (isset($_POST["idVinculo"])) ? $_POST["idVinculo"] : "";
        $nombreCliente = (isset($_POST["nombre"])) ? $_POST["nombre"] : "";
        $claveCliente = (isset($_POST["clave"])) ? $_POST["clave"] : "";
        $idPer = (isset($_POST["idPersonal"])) ? $_POST["idPersonal"] : "";
        $telefonoCliente = (isset($_POST["telefono"])) ? $_POST["telefono"] : "";
        $DescCargo = (isset($_POST["DescCargo"])) ? $_POST["DescCargo"] : "";
        $estadoCli = 1;
        $resultado = $cliente->registrar($idVinculo, $nombreCliente, $claveCliente, $telefonoCliente, $estadoCli, $DescCargo);
        $resulId = $personal->buscarPersonal($idPer);
        $estadoVinculo = 0;
        $fecha = date("Y-m-d H:i:s");
        if ($resultado > 0) {
            $idCliente = $resultado;
            $resultPer = $personal->guardarRegistro($idCliente, $resulId, $fecha);
            if (!empty($idCargo)) {
                $resultCargo = $personal->registrarCargo($idCliente, $idCargo);
            } else {
                $resultCargo = $personal->registrarCargo($idCliente, ROL_SIN_NEGOCIO);
            }
        }
        $editarVin = $vinculacion->editarEstado($idVinculo, $estadoVinculo);
        if ($resultPer == true && $editarVin == true && $resultado > 0 && $resultCargo) {
            echo $resultado;
        } else {
            echo "<div class='alert alert-danger' role='alert'>Registro Fallido</div>";
            echo "<script>alert('Registro Fallido');</script>";
        }
    } else if ($funcion == "login") {
        $correoCli = (isset($_POST["correoCli"])) ? $_POST["correoCli"] : "";
        $claveCli = (isset($_POST["claveCli"])) ? $_POST["claveCli"] : "";
        $resultado = "";
        $resultado = $cliente->loginCliente($correoCli, $claveCli);
        if (!empty($resultado)) {
            echo json_encode($resultado);
        } else {
            $resultado = "";
            echo json_encode($resultado);
        }
    } else if ($funcion == "search") {
        $idCliente = (isset($_POST["idCliente"])) ? $_POST["idCliente"] : "";
        $result = $cliente->buscarClientePorId($idCliente);
        if (empty($result["CargoCliente"])) {
            $result["CargoCliente"] = "No tiene un cargo especifico";
        }
        echo json_encode($result);
    } else if ($funcion == "delete") {
        $idCliente = (isset($_POST["idCliente"])) ? $_POST["idCliente"] : "";
        $estadoCliente = 0;
        $eliminacion = $cliente->cambiarEstadoCliente($idCliente, $estadoCliente);
        if ($eliminacion == true) {
            echo $eliminacion;
        }
    } else if ($funcion == "listar") {
        $clientes = $cliente->listar();
        for ($i = 0; $i < count($clientes); $i++) {
            $btnView = '';
            $btnDelete = '';
            if ($clientes[$i]['ClienteEstado'] == 1) {
                $clientes[$i]['ClienteEstado'] = "<span class='badge badge-success'>ACTIVO</span>";
                $btnView = "<button class='btn btn-secondary text-light' data-toggle='modal' data-target='#modalClienteVer' onclick='VerCliente(" . $clientes[$i]["idCliente"] . ")'><i class='far fa-eye'></i></button>";
                $btnDelete = "<button class='btn btn-danger text-light' onclick='buscarClienteD(" . $clientes[$i]["idCliente"] . ")'><i class='fas fa-power-off'></i></button>";
            } else if ($clientes[$i]['ClienteEstado'] == 0) {
                $clientes[$i]['ClienteEstado'] = "<span class='badge badge-danger'>INACTIVO</span>";
                $btnView = "<button class='btn btn-secondary text-light' data-toggle='modal' data-target='#modalClienteVer' onclick='VerCliente(" . $clientes[$i]["idCliente"] . ")' disabled=''><i class='far fa-eye'></i></button>";
                $btnDelete = "<button class='btn btn-primary text-light' onclick='activarCliente(" . $clientes[$i]["idCliente"] . ")'><i class='fas fa-toggle-on'></button>";
            }
            $clientes[$i]['options'] = $btnView . ' ' . $btnDelete;
        }
        echo json_encode($clientes);
    } else if ($funcion == "listNegocios") {
        $empresas = $cliente->listarNegocios();
        echo '<option value="0">Seleccione el tipo de Negocio</option>';
        for ($i = 0; $i < count($empresas); $i++) {
            echo '<option value="' . $empresas[$i]['idNegocio'] . '">' . $empresas[$i]['NegocioNombre'] . '</option>';
        }
    } else if ($funcion == "listarCli") {
        $Clientes = $cliente->listar();
        echo '<option value="0"> Seleccione un Cliente </option>';
        for ($i = 0; $i < count($Clientes); $i++) {
            echo '<option value="' . $Clientes[$i]['idCliente'] . '">' . $Clientes[$i]['NombreCliente'] . '</option>';
        }
    } else if ($funcion == "perfilCli") {
        $idCliente = (isset($_POST["idCliente"])) ? $_POST["idCliente"] : "";
        $Perfil = $cliente->verPerfilCliente($idCliente);
        if ($Perfil) {
            echo json_encode($Perfil);
        } else {
            return false;
        }
    } else if ($funcion == "activate") {
        $idCliente = (isset($_POST["idCliente"])) ? $_POST["idCliente"] : "";
        $estadoCliente = 1;
        $activacion = $cliente->cambiarEstadoCliente($idCliente, $estadoCliente);
        if ($activacion == true) {
            echo $activacion;
        }
    } else if ($funcion == "ClientesGrafica") {
        $GraficaClientes = $cliente->mostrarRegistrosCliente();
        echo json_encode($GraficaClientes);
    }
} else {
    echo "<script>$(location).attr('href', '" . URL . "');</script>";
}
    

