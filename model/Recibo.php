<?php

class Recibo extends Conexion {

    public function __construct() {
        parent::__construct();
    }

    public function registrar($ReciboTelefono, $SubTotalRecibo, $TotalRecibo, $DireccionRecibo, $ReciboFecha, $EstadoRecibo, $ReciboPago, $ReciboComuna) {
        try {
            $statement = $this->conexion->prepare("INSERT INTO recibo(ReciboTelefono,SubTotalRecibo,TotalRecibo,DireccionRecibo,ReciboFecha,EstadoRecibo,ReciboPago,ReciboComuna)"
                    . "VALUES (:telefono,:subtotal,:total,:direccion,:fecha,:estadoR,:pago,:comuna)");
            $statement->bindParam(":telefono", $ReciboTelefono, PDO::PARAM_STR);
            $statement->bindParam(":subtotal", $SubTotalRecibo, PDO::PARAM_INT);
            $statement->bindParam(":total", $TotalRecibo, PDO::PARAM_INT);
            $statement->bindParam(":direccion", $DireccionRecibo, PDO::PARAM_STR);
            $statement->bindParam(":fecha", $ReciboFecha, PDO::PARAM_STR);
            $statement->bindParam(":estadoR", $EstadoRecibo, PDO::PARAM_INT);
            $statement->bindParam(":pago", $ReciboPago, PDO::PARAM_INT);
            $statement->bindParam(":comuna", $ReciboComuna, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo registrar el Pago.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function listarCiudades() {
        $statement = $this->conexion->prepare("SELECT * FROM comuna");
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function listarTiposPago() {
        $statement = $this->conexion->prepare("SELECT * FROM tipopago");
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function buscarDireccion_Cuidad($idCuidad) {
        try {
            $statement = $this->conexion->prepare("SELECT * FROM direccion WHERE DireccionComuna=:id");
            $statement->bindParam(":id", $idCuidad, PDO::PARAM_INT);
            $statement->execute();
            $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function buscarCostoEnvio($idDireccion) {
        try {
            $statement = $this->conexion->prepare("SELECT * FROM direccion WHERE idDireccion=:id");
            $statement->bindParam(":id", $idDireccion, PDO::PARAM_INT);
            $statement->execute();
            $resultado = $statement->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function listarRecibos($idCli = null) {
        $where = "";
        if ($idCli != null) {
            $where = "WHERE recibo.EstadoRecibo != 0 AND cliente.idCliente = " . $idCli;
        }
        $statement = $this->conexion->prepare("SELECT DISTINCT recibo.idRecibo, cliente.NombreCliente,recibo.ReciboTelefono,"
                . "recibo.SubTotalRecibo,recibo.TotalRecibo,DATE_FORMAT(recibo.ReciboFecha, '%d-%m-%Y') as fechaRecibo, "
                . "DATE_FORMAT(recibo.ReciboFecha, '%H:%i:%s') as horarecibo,recibo.EstadoRecibo,recibo.DireccionRecibo,"
                . "comuna.ComunaNombre FROM recibo INNER JOIN pago ON recibo.ReciboPago = pago.idPago INNER JOIN venta "
                . "ON pago.VentaPagada = venta.idVenta INNER JOIN detalleventa ON detalleventa.VentaId = venta.idVenta "
                . "INNER JOIN cliente ON venta.ClienteVenta = cliente.idCliente INNER JOIN comuna ON recibo.ReciboComuna = comuna.idComuna "
                . "$where");
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function buscarRecibo($idRecibo) {
        try {
            $statement = $this->conexion->prepare("SELECT recibo.idRecibo,venta.idVenta,cliente.NombreCliente,recibo.ReciboTelefono,"
                    . "recibo.SubTotalRecibo,recibo.TotalRecibo,DATE_FORMAT(recibo.ReciboFecha, '%d-%m-%Y') as fechaRecibo, "
                    . "DATE_FORMAT(recibo.ReciboFecha, '%H:%i:%s') as horarecibo,recibo.EstadoRecibo,recibo.ReciboPago,recibo.DireccionRecibo,"
                    . "direccion.ValorEnvio,comuna.ComunaNombre FROM recibo INNER JOIN pago ON recibo.ReciboPago = pago.idPago "
                    . "INNER JOIN venta ON pago.VentaPagada = venta.idVenta INNER JOIN detalleventa ON detalleventa.VentaId = venta.idVenta "
                    . "INNER JOIN cliente ON venta.ClienteVenta = cliente.idCliente INNER JOIN comuna ON recibo.ReciboComuna = comuna.idComuna "
                    . "INNER JOIN direccion ON recibo.DireccionRecibo = direccion.DireccionNombre WHERE recibo.idRecibo =:id");
            $statement->bindParam(":id", $idRecibo, PDO::PARAM_INT);
            $statement->execute();
            $resultado = $statement->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function actualizarRecibo($idRecibo, $EstadoRecibo) {
        try {
            $statement = $this->conexion->prepare("UPDATE recibo set EstadoRecibo =:estado WHERE idRecibo=:id");
            $statement->bindParam(":estado", $EstadoRecibo, PDO::PARAM_INT);
            $statement->bindParam(":id", $idRecibo, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo editar el Recibo.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function buscarReciboPagado($idPago) {
        try {
            $statement = $this->conexion->prepare("SELECT recibo.idRecibo, recibo.EstadoRecibo,"
                    . "recibo.SubTotalRecibo,pago.PagoMonto FROM pago INNER JOIN recibo ON recibo.ReciboPago = pago.idPago "
                    . "WHERE recibo.ReciboPago =:id");
            $statement->bindParam(":id", $idPago, PDO::PARAM_INT);
            $statement->execute();
            $resultado = $statement->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function cargarGraficaCantRecibosClientes() {
        $statement = $this->conexion->prepare("SELECT DISTINCT COUNT(recibo.idRecibo) as CantRecibos, cliente.NombreCliente, "
                . "cliente.TelefonoCliente, MAX(DATE_FORMAT(recibo.ReciboFecha, '%d-%m-%Y')) as fechaRecibo,recibo.EstadoRecibo "
                . "FROM recibo INNER JOIN pago ON recibo.ReciboPago = pago.idPago INNER JOIN venta ON pago.VentaPagada = venta.idVenta "
                . "INNER JOIN cliente ON venta.ClienteVenta = cliente.idCliente WHERE (recibo.EstadoRecibo = 1 OR recibo.EstadoRecibo = 2) GROUP BY cliente.idCliente");
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

}
