<?php

class Pago extends Conexion {

    public function __construct() {
        parent::__construct();
    }

    public function registrar($PagoFecha, $PagoDescripcion, $PagoMonto, $estadoPago, $idVenta, $tipoPago) {
        try {
            $statement = $this->conexion->prepare("INSERT INTO pago(PagoFecha,PagoDescripcion,PagoMonto,PagoEstado,VentaPagada,TipoPago) "
                    . "VALUES (:pago,:descripcion,:monto,:estado,:venta,:tipo)");
            $statement->bindParam(":pago", $PagoFecha, PDO::PARAM_STR);
            $statement->bindParam(":descripcion", $PagoDescripcion, PDO::PARAM_STR);
            $statement->bindParam(":monto", $PagoMonto, PDO::PARAM_INT);
            $statement->bindParam(":estado", $estadoPago, PDO::PARAM_INT);
            $statement->bindParam(":venta", $idVenta, PDO::PARAM_INT);
            $statement->bindParam(":tipo", $tipoPago, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                $idPago = $this->conexion->lastInsertId();
                return $idPago;
            } else {
                return "No se pudo registrar el Pago.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function listarPagos($idCli = null) {
        $where = "";
        if ($idCli != null) {
            $where = " AND cliente.idCliente = " . $idCli;
        }
        $statement = $this->conexion->prepare("SELECT pago.idPago, DATE_FORMAT(pago.PagoFecha, '%d-%m-%Y') as fechaPago,"
                . "DATE_FORMAT(pago.PagoFecha, '%H:%i:%s') as horapago ,pago.PagoDescripcion, pago.PagoMonto,pago.PagoEstado, "
                . "cliente.NombreCliente, cliente.TelefonoCliente FROM pago INNER JOIN venta ON pago.VentaPagada = venta.idVenta "
                . "INNER JOIN cliente ON venta.ClienteVenta = cliente.idCliente  $where");
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function buscarPago($idPago) {
        try {
            $statement = $this->conexion->prepare("SELECT pago.idPago,pago.PagoMonto,cliente.NombreCliente,cliente.TelefonoCliente,"
                    . "DATE_FORMAT(pago.PagoFecha, '%d-%m-%Y') as fechaPago,DATE_FORMAT(pago.PagoFecha, '%H:%i:%s') as horapago,pago.VentaPagada,"
                    . "pago.PagoEstado,tipopago.nombreTipoPago, recibo.idRecibo, recibo.SubTotalRecibo FROM pago INNER JOIN venta "
                    . "ON pago.VentaPagada = venta.idVenta INNER JOIN cliente ON venta.ClienteVenta = cliente.idCliente "
                    . "INNER JOIN tipopago ON pago.TipoPago = tipopago.idTipoPago INNER JOIN recibo ON pago.idPago = recibo.ReciboPago "
                    . "WHERE pago.idPago=:id");
            $statement->bindParam(":id", $idPago, PDO::PARAM_INT);
            $statement->execute();
            $resultado = $statement->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function actualizarPagoVenta($idVenta, $estadoPago) {
        try {
            $statement = $this->conexion->prepare("UPDATE pago SET PagoEstado=:estado WHERE VentaPagada=:id");
            $statement->bindParam(":estado", $estadoPago, PDO::PARAM_INT);
            $statement->bindParam(":id", $idVenta, PDO::PARAM_INT);
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

    public function actualizarPagoRecibo($idPago, $estadoPago) {
        try {
            $statement = $this->conexion->prepare("UPDATE pago SET PagoEstado=:estado WHERE idPago=:id");
            $statement->bindParam(":estado", $estadoPago, PDO::PARAM_INT);
            $statement->bindParam(":id", $idPago, PDO::PARAM_INT);
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

    public function buscarPagoVenta($idVenta) {
        try {
            $statement = $this->conexion->prepare("SELECT pago.idPago,cliente.NombreCliente,cliente.TelefonoCliente,"
                    . "DATE_FORMAT(pago.PagoFecha, '%d-%m-%Y') as fechaPago,DATE_FORMAT(pago.PagoFecha, '%H:%i:%s') as horapago,"
                    . "pago.PagoDescripcion, pago.PagoMonto, pago.PagoEstado FROM pago INNER JOIN venta ON pago.VentaPagada = venta.idVenta "
                    . "INNER JOIN cliente ON venta.ClienteVenta = cliente.idCliente WHERE venta.idVenta =:id");
            $statement->bindParam(":id", $idVenta, PDO::PARAM_INT);
            $statement->execute();
            $resultado = $statement->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function cargarPagosGrafica() {
        $statement = $this->conexion->prepare("SELECT ELT(MAX(MONTH(pago.PagoFecha)), 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',"
                . " 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre') AS mesPago, MAX(DATE_FORMAT(pago.PagoFecha, '%d-%m-%Y')) as ultimaFecha,"
                . " SUM(pago.PagoMonto) as totalP FROM pago WHERE pago.PagoEstado = 1 GROUP BY MONTH(pago.PagoFecha)");
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

}
