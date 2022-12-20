<?php

class Respuesta extends Conexion {

    public function __construct() {
        parent::__construct();
    }

    public function registrar($Recepcion, $Mensaje, $fechaRes, $resCliente, $solicitudRes, $estadoRes) {
        try {
            $statement = $this->conexion->prepare("INSERT INTO respuestasolicitud(RecepcionMensaje, MensajeRespuesta,FechaRespuesta,RespuestaCliente,RespuestaSolicitud,estadoRespuesta) "
                    . "VALUES (:recepcion,:mensaje,:fecha,:cliente,:solicitud,:estado)");
            $statement->bindParam(":recepcion", $Recepcion, PDO::PARAM_STR);
            $statement->bindParam(":mensaje", $Mensaje, PDO::PARAM_STR);
            $statement->bindParam(":fecha", $fechaRes, PDO::PARAM_STR);
            $statement->bindParam(":cliente", $resCliente, PDO::PARAM_INT);
            $statement->bindParam(":solicitud", $solicitudRes, PDO::PARAM_INT);
            $statement->bindParam(":estado", $estadoRes, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo registrar la Respuesta.";
            }
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function editar($receptcion, $Mensaje, $fechaRes, $idRespuesta) {
        try {
            $statement = $this->conexion->prepare("UPDATE respuestasolicitud SET RecepcionMensaje=:recepcion, MensajeRespuesta=:mensaje, "
                    . "FechaRespuesta=:fecha WHERE idRespuesta_solicitud =:id");
            $statement->bindParam(":recepcion", $receptcion, PDO::PARAM_STR);
            $statement->bindParam(":mensaje", $Mensaje, PDO::PARAM_STR);
            $statement->bindParam(":fecha", $fechaRes, PDO::PARAM_STR);
            $statement->bindParam(":id", $idRespuesta, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo editar la Respuesta.";
            }
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function verificarRespuesta_Solicitud($idSolicitud) {
        try {
            $statement = $this->conexion->prepare("SELECT respuestasolicitud.idRespuesta_solicitud,respuestasolicitud.RespuestaSolicitud,"
                    . "cliente.NombreCliente,cliente.idCliente,solicitud.CargoSolicitud,DATE_FORMAT(respuestasolicitud.FechaRespuesta, '%d-%m-%Y') as fechaRespuesta,"
                    . "DATE_FORMAT(respuestasolicitud.FechaRespuesta, '%H:%i:%s') as horaRespuesta,respuestasolicitud.RecepcionMensaje as RespuestaSoli,"
                    . "respuestasolicitud.MensajeRespuesta,solicitud.SolicitudEstado FROM respuestasolicitud "
                    . "INNER JOIN solicitud ON respuestasolicitud.RespuestaSolicitud = solicitud.idSolicitud "
                    . "INNER JOIN cliente ON respuestasolicitud.RespuestaCliente = cliente.idCliente "
                    . "WHERE solicitud.idSolicitud =:id");
            $statement->bindParam(":id", $idSolicitud, PDO::PARAM_INT);
            $statement->execute();
            $resultado = $statement->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function buscarRespuesta($idRespuesta) {
        try {
            $statement = $this->conexion->prepare("SELECT respuestasolicitud.idRespuesta_solicitud,respuestasolicitud.RespuestaSolicitud,"
                    . "cliente.NombreCliente,cliente.idCliente,solicitud.CargoSolicitud,DATE_FORMAT(respuestasolicitud.FechaRespuesta, '%d-%m-%Y') as fechaRespuesta,"
                    . "DATE_FORMAT(respuestasolicitud.FechaRespuesta, '%H:%i:%s') as horaRespuesta,respuestasolicitud.RecepcionMensaje as RespuestaSoli,"
                    . "respuestasolicitud.MensajeRespuesta,solicitud.SolicitudEstado,respuestasolicitud.estadoRespuesta FROM respuestasolicitud INNER JOIN solicitud "
                    . "ON respuestasolicitud.RespuestaSolicitud = solicitud.idSolicitud "
                    . "INNER JOIN cliente ON respuestasolicitud.RespuestaCliente = cliente.idCliente "
                    . "WHERE idRespuesta_solicitud =:id");
            $statement->bindParam(":id", $idRespuesta, PDO::PARAM_INT);
            $statement->execute();
            $resultado = $statement->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function eliminarRespuesta($idSolicitud) {
        try {
            $statement = $this->conexion->prepare("DELETE FROM respuestasolicitud WHERE RespuestaSolicitud=:id_soli");
            $statement->bindParam(":id_soli", $idSolicitud, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo eliminar la respuesta.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function actualizarEstadoRes($idRespuesta, $estado) {
        try {
            $statement = $this->conexion->prepare("UPDATE respuestasolicitud SET estadoRespuesta=:estado WHERE idRespuesta_solicitud=:id");
            $statement->bindParam(":estado", $estado, PDO::PARAM_INT);
            $statement->bindParam(":id", $idRespuesta, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo eliminar la respuesta.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

}
