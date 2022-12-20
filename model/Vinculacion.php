<?php

class Vinculacion extends Conexion {

    public function __construct() {
        parent::__construct();
    }

    public function registrar($nombre, $telefono, $correo, $clave, $fechaVinculo, $estado) {
        try {
            $statement = $this->conexion->prepare("INSERT INTO vinculacion (nombreVinculo,telefonoVinculo,CorreoVinculo,ClaveVinculo,fechaVinculo,EstadoVinculo)"
                    . "VALUES (:nombre,:telefono,:correo, :clave,:fecha,:estado)");
            $statement->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $statement->bindParam(":telefono", $telefono, PDO::PARAM_STR);
            $statement->bindParam(":correo", $correo, PDO::PARAM_STR);
            $statement->bindParam(":clave", $clave, PDO::PARAM_STR);
            $statement->bindParam(":fecha", $fechaVinculo, PDO::PARAM_STR);
            $statement->bindParam(":estado", $estado, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo registrar la orden.";
            }
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function lista() {
        $statement = $this->conexion->prepare("SELECT vinculacion.idVinculacion, "
                . "vinculacion.correoVinculo,DATE_FORMAT(vinculacion.fechaVinculo, '%d-%m-%Y') as fechaVinculo,"
                . " DATE_FORMAT(vinculacion.fechaVinculo, '%H:%i:%s') as horaVinculo, vinculacion.EstadoVinculo "
                . "FROM vinculacion WHERE EstadoVinculo = 1");
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function mostrarCorreos($correo) {
        try {
            $statement = $this->conexion->prepare("SELECT * FROM vinculacion WHERE correoVinculo =:correo");
            $statement->bindParam(":correo", $correo, PDO::PARAM_STR);
            $statement->execute();
            $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function listarPorId($idVinculo) {
        try {
            $statement = $this->conexion->prepare("SELECT * FROM vinculacion WHERE idVinculacion=:id");
            $statement->bindParam(":id", $idVinculo, PDO::PARAM_INT);
            $statement->execute();
            $resultado = $statement->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function editarEstado($idVinculo, $estadoVinculo) {
        try {
            $statement = $this->conexion->prepare("UPDATE vinculacion SET EstadoVinculo=:estado WHERE idVinculacion=:id");
            $statement->bindParam(":estado", $estadoVinculo, PDO::PARAM_INT);
            $statement->bindParam(":id", $idVinculo, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo actualizar la vinculacion.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

}
