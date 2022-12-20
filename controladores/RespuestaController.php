<?php

require_once ('../config.php');
require_once ('../model/Conexion.php');
require_once ('../model/Respuesta.php');
require_once ('../model/Solicitud.php');

$respuesta = new Respuesta();
$solicitud = new Solicitud();
$funcion = "";
if (isset($_GET["funcion"])) {
    $funcion = $_GET["funcion"];
    if ($funcion == "create") {
        //el 1 representa que estara activa la respuesta
        $idCliente = (isset($_POST["idCliente"])) ? $_POST["idCliente"] : "";
        $idSolicitud = (isset($_POST["idSolicitud"])) ? $_POST["idSolicitud"] : "";
        $respuestaSoli = (isset($_POST["respuesta"])) ? $_POST["respuesta"] : "";
        $RecepcionM = (isset($_POST["RecepcionM"])) ? $_POST["RecepcionM"] : "";
        $idRespuesta = (isset($_POST["idRespuesta"])) ? $_POST["idRespuesta"] : "";
        $fecha = date("Y-m-d H:i:s");
        $estadoSolicitud = "";
        $resultRes = $respuesta->registrar($RecepcionM, $respuestaSoli, $fecha, $idCliente, $idSolicitud, 1);

        if ($resultRes == true) {
            //la respuesta se registra de igual manera
            $estadoSolicitud = 2;
            $cambioestado = $solicitud->ActualizarSolicitud($idSolicitud, $estadoSolicitud);
        }

        if ($resultRes == true) {
            echo $resultRes;
        }
    } else if ($funcion == "search") {
        $idSolicitud = (isset($_POST["idSolicitud"])) ? $_POST["idSolicitud"] : "";
        $respuestaSoli = $respuesta->verificarRespuesta_Solicitud($idSolicitud);
        echo json_encode($respuestaSoli);
    } else if ($funcion == "searchRes") {
        $idRespuesta = (isset($_POST["idRespuesta"])) ? $_POST["idRespuesta"] : "";
        $respuestaCli = $respuesta->buscarRespuesta($idRespuesta);
        echo json_encode($respuestaCli);
    } else if ($funcion == "update") {
        $idRespuesta = (isset($_POST["idRespuesta"])) ? $_POST["idRespuesta"] : "";
        $respuestaSoli = (isset($_POST["respuesta"])) ? $_POST["respuesta"] : "";
        $fecha = date("Y-m-d H:i:s");

        $respuestaActualizada = $respuesta->editar($respuestaSoli, $fecha, $idRespuesta);

        if ($respuestaActualizada == true) {
            echo $respuestaActualizada;
        }
    } else if ($funcion == "response") {
        $idCliente = (isset($_POST["idCliente"])) ? $_POST["idCliente"] : "";
        $idSolicitud = (isset($_POST["idSolicitud"])) ? $_POST["idSolicitud"] : "";
        $idRespuesta = (isset($_POST["idRespuesta"])) ? $_POST["idRespuesta"] : "";
        $respuestaSoli = (isset($_POST["respuesta"])) ? $_POST["respuesta"] : "";
        $RecepcionM = (isset($_POST["RecepcionM"])) ? $_POST["RecepcionM"] : "";
        $fecha = date("Y-m-d H:i:s");
        $estadoSolicitud = "";
        $cambioestado = "";
        $resultSoli = $solicitud->BuscarSolicitud($idSolicitud);
        $resultRes = $respuesta->editar($RecepcionM, $respuestaSoli, $fecha, $idRespuesta);

        if ($resultSoli["SolicitudEstado"] == 3 && $resultRes == true) {
            $estadoSolicitud = 2;
            $cambioestado = $solicitud->ActualizarSolicitud($idSolicitud, $estadoSolicitud);
            echo $cambioestado;
        } else {
            $estadoSolicitud = 3;
            $cambioestado = $solicitud->ActualizarSolicitud($idSolicitud, $estadoSolicitud);
            echo $cambioestado;
        }
    }
} else {
    echo "<script>$(location).attr('href', '" . URL . "');</script>";
}
