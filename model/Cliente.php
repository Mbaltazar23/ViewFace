<?php

class Cliente extends Conexion {

    public function __construct() {
        parent::__construct();
    }

    public function registrar($VinculoCliente, $nombreCliente, $claveCliente, $telefonoCliente, $estadoCli, $CargoCli) {
        try {
            $claveEncryp = md5($claveCliente);
            $statement = $this->conexion->prepare("INSERT INTO cliente(VinculoCliente,NombreCliente,ClaveCliente,TelefonoCliente,ClienteEstado,CargoCliente) "
                    . "VALUES (:idVin, :nombre,:clave,:telefono,:estado,:cargo)");
            $statement->bindParam(":idVin", $VinculoCliente, PDO::PARAM_INT);
            $statement->bindParam(":nombre", $nombreCliente, PDO::PARAM_STR);
            $statement->bindParam(":clave", $claveEncryp, PDO::PARAM_STR);
            $statement->bindParam(":telefono", $telefonoCliente, PDO::PARAM_STR);
            $statement->bindParam(":estado", $estadoCli, PDO::PARAM_INT);
            $statement->bindParam(":cargo", $CargoCli, PDO::PARAM_STR);
            $statement->execute();
            if ($statement) {
                $idCliente = $this->conexion->lastInsertId();
                return $idCliente;
            } else {
                return "No se pudo registrar el Cliente.";
            }
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function listarNegocios() {
        $statement = $this->conexion->prepare("SELECT * FROM negocio WHERE idNegocio != " . ROL_SIN_NEGOCIO);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function listar() {
        $statement = $this->conexion->prepare("SELECT cliente.idCliente, cliente.ClienteEstado,"
                . "cliente.NombreCliente,cliente.TelefonoCliente,cliente.ClaveCliente,vinculacion.CorreoVinculo AS CorreoVinculado"
                . ",negocio.NegocioNombre AS NegocioCliente FROM detallecargocliente INNER JOIN negocio ON "
                . "negocio.idNegocio = detallecargocliente.NegocioCargo INNER JOIN cliente ON detallecargocliente.ClienteCargo = cliente.idCliente "
                . "INNER JOIN vinculacion ON cliente.VinculoCliente = vinculacion.idVinculacion");
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function buscarClientePorId($idcliente) {
        try {
            $statement = $this->conexion->prepare("SELECT cliente.idCliente,cliente.NombreCliente,cliente.TelefonoCliente,"
                    . "cliente.CargoCliente,cliente.ClaveCliente,vinculacion.CorreoVinculo AS CorreoVinculado,negocio.NegocioNombre AS NegocioCliente "
                    . "FROM detallecargocliente INNER JOIN negocio ON negocio.idNegocio = detallecargocliente.NegocioCargo INNER JOIN cliente "
                    . "ON detallecargocliente.ClienteCargo = cliente.idCliente INNER JOIN vinculacion ON "
                    . "cliente.VinculoCliente = vinculacion.idVinculacion WHERE idCliente =:id");
            $statement->bindParam(":id", $idcliente, PDO::PARAM_INT);
            $statement->execute();
            $resultado = $statement->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function loginCliente($correo, $clave) {
        try {
            $claveEncript = md5($clave);
            $statement = $this->conexion->prepare("SELECT cliente.idCliente,cliente.NombreCliente,cliente.ClienteEstado,"
                    . "cliente.TelefonoCliente,cliente.ClaveCliente,vinculacion.correoVinculo,negocio.NegocioNombre AS NegocioCliente "
                    . "FROM detallecargocliente INNER JOIN negocio ON negocio.idNegocio = detallecargocliente.NegocioCargo "
                    . "INNER JOIN cliente ON detallecargocliente.ClienteCargo = cliente.idCliente INNER JOIN vinculacion "
                    . "ON cliente.VinculoCliente = vinculacion.idVinculacion "
                    . "WHERE vinculacion.correoVinculo =:correo AND cliente.ClaveCliente=:clave AND cliente.ClienteEstado = 1");
            $statement->bindParam(":correo", $correo, PDO::PARAM_STR);
            $statement->bindParam(":clave", $claveEncript, PDO::PARAM_STR);
            $statement->execute();
            $resultado = $statement->fetch(PDO::FETCH_ASSOC);
            if ($resultado) {
                //Si existe el usuario
                session_start();
                $_SESSION["email-personal"] = $resultado["correoVinculo"];
                $_SESSION["idCli"] = $resultado["idCliente"];
                $_SESSION["cargo-usuario"] = "Cliente";
                $_SESSION['graficas'] = "accionesGraficasCliente.js";
                return $resultado;
            } else {
                //No exite el usuario
                return false;
            }
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function verPerfilCliente($idCliente) {
        try {
            $statement = $this->conexion->prepare("SELECT cliente.idCliente, cliente.NombreCliente,"
                    . " cliente.TelefonoCliente,vinculacion.correoVinculo,negocio.NegocioNombre AS NegocioCliente,"
                    . "DATE_FORMAT(registro.FechaRegistro, '%d-%m-%Y') as fechaRegistro, DATE_FORMAT(registro.FechaRegistro, '%H:%i:%s') as horaRegistro,"
                    . "personal.CargoPersonal, personal.CorreoPersonal,usuario.UserNombre FROM detallecargocliente "
                    . "INNER JOIN negocio ON negocio.idNegocio = detallecargocliente.NegocioCargo INNER JOIN cliente "
                    . "ON detallecargocliente.ClienteCargo = cliente.idCliente INNER JOIN vinculacion "
                    . "ON cliente.VinculoCliente = vinculacion.idVinculacion INNER JOIN registro ON registro.ClienteRegistrado = cliente.idCliente "
                    . "INNER JOIN personal ON registro.Personal = personal.idPersonal INNER JOIN usuario ON personal.PerfilUsuario = usuario.idUsuario "
                    . "WHERE idCliente=:id");
            $statement->bindParam(":id", $idCliente, PDO::PARAM_INT);
            $statement->execute();
            $resultado = $statement->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function cambiarEstadoCliente($idCliente, $estadoCliente) {
        try {
            $statement = $this->conexion->prepare("UPDATE cliente SET ClienteEstado=:estado WHERE idCliente=:id");
            $statement->bindParam(":estado", $estadoCliente, PDO::PARAM_INT);
            $statement->bindParam(":id", $idCliente, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo quitar al cliente.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function mostrarRegistrosCliente() {
        $statement = $this->conexion->prepare("SELECT ELT(MONTH(registro.FechaRegistro), 'Enero', 'Febrero', 'Marzo', 'Abril',"
                . " 'Mayo','Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre') as mesRegistro,"
                . "MAX(DATE_FORMAT(registro.FechaRegistro, '%H:%i:%s')) as HoraVista, DATE_FORMAT(registro.FechaRegistro, '%Y') as Anioregistro, "
                . "MAX(DATE_FORMAT(registro.FechaRegistro, '%d-%m-%Y')) as fechaRegistro,COUNT(registro.idRegistro) as registroClientes "
                . "FROM registro GROUP BY mesRegistro ASC ORDER BY MONTH(registro.FechaRegistro) LIMIT 20");
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

}
