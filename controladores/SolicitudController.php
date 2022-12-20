<?php

require_once ('../config.php');
require_once ('../model/Conexion.php');
require_once ('../model/Solicitud.php');
require_once ('../model/Respuesta.php');

$solicitud = new Solicitud();
$respuesta = new Respuesta();
$funcion = "";

if (isset($_GET["funcion"])) {
    $funcion = $_GET["funcion"];
    if ($funcion == "create") {
        $idCliente = (isset($_POST["idCliente"])) ? $_POST["idCliente"] : "";
        $cargoCliente = (isset($_POST["cargoCliente"])) ? $_POST["cargoCliente"] : "";
        $descripcion = (isset($_POST["descripcion"])) ? $_POST["descripcion"] : "";
        $mercancia = (isset($_POST["mercancia"])) ? $_POST["mercancia"] : "";
        $SolicitudFecha = date("Y-m-d H:i:s");
        $SolicitudEstado = 1;
        $result = $solicitud->registrar($SolicitudFecha, $descripcion, $cargoCliente, $idCliente, $SolicitudEstado, $mercancia);
        if ($result == true) {
            echo $result;
        }
    } else if ($funcion == "update") {
        $idSolicitud = (isset($_POST["idSolicitud"])) ? $_POST["idSolicitud"] : "";
        $idCliente = (isset($_POST["idCliente"])) ? $_POST["idCliente"] : "";
        $cargoCliente = (isset($_POST["cargoCliente"])) ? $_POST["cargoCliente"] : "";
        $descripcion = (isset($_POST["descripcion"])) ? $_POST["descripcion"] : "";
        $mercancia = (isset($_POST["mercancia"])) ? $_POST["mercancia"] : "";
        $SolicitudFecha = date("Y-m-d H:i:s");

        $result = $solicitud->editar($SolicitudFecha, $descripcion, $cargoCliente, $idCliente, $mercancia, $idSolicitud);
        if ($result == true) {
            echo $result;
        }
    } else if ($funcion == "search") {
        $idSolicitud = (isset($_POST["idSolicitud"])) ? $_POST["idSolicitud"] : "";
        $Tiposolicitud = $solicitud->BuscarSolicitud($idSolicitud);
        echo json_encode($Tiposolicitud);
    } else if ($funcion == "delete") {
        $idSolicitud = (isset($_POST["idSolicitud"])) ? $_POST["idSolicitud"] : "";
        $estadoSolicitud = 0;
        $verificar = $respuesta->verificarRespuesta_Solicitud($idSolicitud);
        $result = "";
        if ($verificar["SolicitudEstado"] == 2 || $verificar["SolicitudEstado"] == 3) {
            $estadoSolicitud = 0;
            $quitarRes = $respuesta->eliminarRespuesta($verificar["idRespuesta_solicitud"]);
            $result = $solicitud->ActualizarSolicitud($idSolicitud, $estadoSolicitud);
        } else {
            $estadoSolicitud = 0;
            $result = $solicitud->ActualizarSolicitud($idSolicitud, $estadoSolicitud);
        }
        if ($result == true) {
            echo $result;
        }
    } else if ($funcion == "listSolicitudJefa") {
        $solicitudes = $solicitud->listarSolicitudes();
        for ($i = 0; $i < count($solicitudes); $i++) {
            $btnDelete = '';
            $btnEdit = '';
            if ($solicitudes[$i]['SolicitudEstado'] == 1) {
                $solicitudes[$i]['SolicitudEstado'] = "<span class='badge badge-success'>PENDIENTE</span>";
                $btnEdit = "<button class='btn btn-primary text-light' onclick='aceptarSolicitud(" . $solicitudes[$i]['idSolicitud'] . ")'><i class='fas fa-comment-dots'></i></button>";
                $btnDelete = "<button class='btn btn-danger' onclick='QuitarSolicitud(" . $solicitudes[$i]['idSolicitud'] . ")'><i class='fas fa-trash'></i></button>";
            } else if ($solicitudes[$i]['SolicitudEstado'] == 2) {
                $solicitudes[$i]['SolicitudEstado'] = "<span class='badge badge-dark'>EN ESPERA</span>";
                $btnEdit = "<button class='btn btn-success btn-circle' onclick='verRespuesta(" . $solicitudes[$i]['idSolicitud'] . ");' disabled=''><i class='fas fa-edit'></i></button></button>";
                $btnDelete = "<button class='btn btn-danger' onclick='QuitarSolicitud(" . $solicitudes[$i]['idSolicitud'] . ")'><i class='fas fa-trash'></i></button>";
            } else if ($solicitudes[$i]['SolicitudEstado'] == 3) {
                $solicitudes[$i]['SolicitudEstado'] = "<span class='badge badge-info'>RESPONDIDA</span>";
                $btnEdit = "<button class='btn btn-dark btn-circle' onclick='verRespuesta(" . $solicitudes[$i]['idSolicitud'] . ");'><i class='fab fa-facebook-messenger'></i></button>";
                $btnDelete = "<button class='btn btn-danger' onclick='QuitarSolicitud(" . $solicitudes[$i]['idSolicitud'] . ")'><i class='fas fa-trash'></i></button>";
            }
            $solicitudes[$i]['options'] = $btnEdit . ' ' . $btnDelete;
        }
        echo json_encode($solicitudes);
    } else if ($funcion == "listSolicitudCli") {
        $idCliente = (isset($_POST["idCliente"])) ? $_POST["idCliente"] : "";
        $solicitudesCli = $solicitud->listarSolicitudes($idCliente);
        for ($i = 0; $i < count($solicitudesCli); $i++) {
            $btnDelete = '';
            $btnEdit = '';
            $btnView = '';
            if ($solicitudesCli[$i]['SolicitudEstado'] == 1) {
                $solicitudesCli[$i]['SolicitudEstado'] = "<span class='badge badge-success'>PENDIENTE</span>";
                $btnEdit = "<button class='btn btn-success btn-circle' onclick='buscarSolicitud(" . $solicitudesCli[$i]['idSolicitud'] . ");'><i class='fas fa-edit'></i></button></button>";
                $btnDelete = "<button class='btn btn-danger' onclick='QuitarSolicitud(" . $solicitudesCli[$i]['idSolicitud'] . ")'><i class='fas fa-window-close'></i></button>";
                $btnView = '';
            } else if ($solicitudesCli[$i]['SolicitudEstado'] == 0) {
                $solicitudesCli[$i]['SolicitudEstado'] = "<span class='badge badge-danger'>CANCELADA</span>";
                $btnEdit = "<button class='btn btn-success btn-circle' onclick='buscarSolicitud(" . $solicitudesCli[$i]['idSolicitud'] . ");' disabled=''><i class='fas fa-edit'></i></button>";
                $btnDelete = "<button class='btn btn-primary' onclick='ActivarSolicitud(" . $solicitudesCli[$i]['idSolicitud'] . ")'><i class='fas fa-toggle-on'></i></button>";
                $btnView = '';
            } else if ($solicitudesCli[$i]['SolicitudEstado'] == 2) {
                $solicitudesCli[$i]['SolicitudEstado'] = "<span class='badge badge-primary'>RECIBIDA</span>";
                $btnEdit = "";
                $btnView = "<button class='btn btn-primary' onclick='verRespuesta(" . $solicitudesCli[$i]['idSolicitud'] . ")'><i class='far fa-eye'></i></button>";
                $btnDelete = "<button class='btn btn-danger' onclick='QuitarSolicitud(" . $solicitudesCli[$i]['idSolicitud'] . ")'><i class='fas fa-window-close'></i></button>";
            } else if ($solicitudesCli[$i]['SolicitudEstado'] == 3) {
                $solicitudesCli[$i]['SolicitudEstado'] = "<span class='badge badge-info'>EN ESPERA</span>";
                $btnEdit = "<button class='btn btn-secondary btn-circle' onclick='verRespuesta(" . $solicitudesCli[$i]['idSolicitud'] . ");'disabled><i class='fab fa-facebook-messenger'></i></button>";
                $btnView = "";
                $btnDelete = "<button class='btn btn-danger' onclick='QuitarSolicitud(" . $solicitudesCli[$i]['idSolicitud'] . ")'><i class='fas fa-window-close'></i></button>";
            }
            $solicitudesCli[$i]['options'] = $btnEdit . ' ' . $btnView . ' ' . $btnDelete;
        }
        echo json_encode($solicitudesCli);
    } else if ($funcion == "listMercancia") {
        $Mercancias = $solicitud->mostrarTiposMercancia();
        echo '<option value="0">Seleccione un Tipo de Mercancia</option>';
        for ($i = 0; $i < count($Mercancias); $i++) {
            echo '<option value="' . $Mercancias[$i]['idMercancia'] . '">' . $Mercancias[$i]['NombreMercancia'] . '</option>';
        }
    } else if ($funcion == "activate") {
        $idSolicitud = (isset($_POST["idSolicitud"])) ? $_POST["idSolicitud"] : "";
        $estadoSolicitud = 1;
        $respu = $solicitud->ActualizarSolicitud($idSolicitud, $estadoSolicitud);
        if ($respu == true) {
            echo $respu;
        }
    }
} else {
    echo "<script>$(location).attr('href', '" . URL . "');</script>";
}

