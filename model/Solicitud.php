<?php

class Solicitud extends Conexion {

    public function __construct() {
        parent::__construct();
    }

    public function registrar($SolicitudFecha, $descripcionSoli, $CargoSolicitud, $ClienteSolicitud, $SolicitudEstado, $TipoMercancia) {
        try {
            $statement = $this->conexion->prepare("INSERT INTO solicitud(SolicitudFecha,SolicitudDescripcion,CargoSolicitud,ClienteSolicitud,SolicitudEstado,TipoMercancia) "
                    . "VALUES (:fecha,:descripcion,:cargo,:cliente,:estado,:mercancia)");
            $statement->bindParam(":fecha", $SolicitudFecha, PDO::PARAM_STR);
            $statement->bindParam(":descripcion", $descripcionSoli, PDO::PARAM_STR);
            $statement->bindParam(":cargo", $CargoSolicitud, PDO::PARAM_STR);
            $statement->bindParam(":cliente", $ClienteSolicitud, PDO::PARAM_INT);
            $statement->bindParam(":estado", $SolicitudEstado, PDO::PARAM_INT);
            $statement->bindParam(":mercancia", $TipoMercancia, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo registrar la Solicitud.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function editar($SolicitudFecha, $descripcionSoli, $CargoSolicitud, $ClienteSolicitud, $TipoMercancia, $idSolicitud) {
        try {
            $statement = $this->conexion->prepare("UPDATE solicitud SET SolicitudFecha=:fecha, CargoSolicitud =:cargo,"
                    . "ClienteSolicitud =:cliente,SolicitudDescripcion=:descripcion,TipoMercancia=:mercancia WHERE idSolicitud =:id");
            $statement->bindParam(":fecha", $SolicitudFecha, PDO::PARAM_STR);
            $statement->bindParam(":cargo", $CargoSolicitud, PDO::PARAM_STR);
            $statement->bindParam(":cliente", $ClienteSolicitud, PDO::PARAM_INT);
            $statement->bindParam(":descripcion", $descripcionSoli, PDO::PARAM_STR);
            $statement->bindParam(":mercancia", $TipoMercancia, PDO::PARAM_INT);
            $statement->bindParam(":id", $idSolicitud, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo editar la Solicitud.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function listarSolicitudes($idCliente = null) {
        $where = "";
        if ($idCliente != null) {
            $where = "WHERE cliente.idCliente= " . $idCliente;
        } else {
            $where = "WHERE solicitud.SolicitudEstado != 0";
        }
        $statement = $this->conexion->prepare("SELECT solicitud.idSolicitud, DATE_FORMAT(solicitud.SolicitudFecha, '%d-%m-%Y') as fechaSolicitud, "
                . "DATE_FORMAT(solicitud.SolicitudFecha, '%H:%i:%s') as horaSolicitud,solicitud.ClienteSolicitud,solicitud.CargoSolicitud,solicitud.SolicitudEstado,"
                . "cliente.NombreCliente FROM solicitud INNER JOIN cliente ON solicitud.ClienteSolicitud = cliente.idCliente $where");
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function ActualizarSolicitud($id, $estadoSolicitud) {
        try {
            $statement = $this->conexion->prepare("UPDATE solicitud SET SolicitudEstado=:estado WHERE idSolicitud=:id");
            $statement->bindParam(":estado", $estadoSolicitud, PDO::PARAM_INT);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo editar el insumo.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function BuscarSolicitud($idSolicitud) {
        try {
            $statement = $this->conexion->prepare("SELECT solicitud.idSolicitud, DATE_FORMAT(solicitud.SolicitudFecha, '%d-%m-%Y') as fechaSolicitud,"
                    . "DATE_FORMAT(solicitud.SolicitudFecha, '%H:%i:%s') as horaSolicitud,solicitud.TipoMercancia,solicitud.CargoSolicitud,solicitud.SolicitudEstado,"
                    . "solicitud.SolicitudDescripcion,cliente.NombreCliente, cliente.idCliente FROM solicitud INNER JOIN cliente ON "
                    . "solicitud.ClienteSolicitud = cliente.idCliente WHERE idSolicitud=:id");
            $statement->bindParam(":id", $idSolicitud, PDO::PARAM_INT);
            $statement->execute();
            $resultado = $statement->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function mostrarTiposMercancia() {
        $statement = $this->conexion->prepare("SELECT * FROM mercancia");
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

}
