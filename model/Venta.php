<?php

class Venta extends Conexion {

    public function __construct() {
        parent::__construct();
    }

    public function registrar($idCliente, $estadoVenta, $precioVenta, $fechaVenta) {
        try {
            $statement = $this->conexion->prepare("INSERT INTO venta(ClienteVenta,EstadoVenta,PrecioVenta,FechaVenta) "
                    . "VALUES (:idCli, :estado,:precio,:fecha)");
            $statement->bindParam(":idCli", $idCliente, PDO::PARAM_INT);
            $statement->bindParam(":estado", $estadoVenta, PDO::PARAM_INT);
            $statement->bindParam(":precio", $precioVenta, PDO::PARAM_INT);
            $statement->bindParam(":fecha", $fechaVenta, PDO::PARAM_STR);
            $statement->execute();
            if ($statement) {
                $idVenta = $this->conexion->lastInsertId();
                return $idVenta;
            } else {
                return "No se pudo registrar la Venta.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function listarVentas($idCli = null) {
        $where = "ORDER BY venta.EstadoVenta DESC";
        if ($idCli != null) {
            $where = " WHERE ClienteVenta = " . $idCli . " AND EstadoVenta = 1 ";
        }
        $statement = $this->conexion->prepare("SELECT cliente.NombreCliente,cliente.CargoCliente,"
                . "venta.idVenta, venta.PrecioVenta, venta.EstadoVenta, venta.FechaVenta "
                . "FROM venta INNER JOIN cliente ON venta.ClienteVenta = cliente.idCliente $where");
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function listarVentasPay($idCli) {
        $where = " WHERE ClienteVenta = " . $idCli . " AND EstadoVenta = 2 GROUP BY venta.idVenta";
        $statement = $this->conexion->prepare("SELECT cliente.NombreCliente,venta.idVenta, venta.PrecioVenta, MAX(venta.FechaVenta) as fechaV "
                . "FROM venta INNER JOIN cliente ON venta.ClienteVenta = cliente.idCliente $where");
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function registrarDetalleVenta($CantidadV, $precioInsu, $idInsumo, $VentaId) {
        try {
            $statement = $this->conexion->prepare("INSERT INTO detalleventa(CantidadVenta,PrecioVenta,InsumoVendido,VentaId) "
                    . "VALUES (:cantidad,:precio,:insumo,:venta)");
            $statement->bindParam(":cantidad", $CantidadV, PDO::PARAM_INT);
            $statement->bindParam(":precio", $precioInsu, PDO::PARAM_INT);
            $statement->bindParam(":insumo", $idInsumo, PDO::PARAM_INT);
            $statement->bindParam(":venta", $VentaId, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo registrar el Detalle.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function listarDetalleVentas($idVenta) {
        try {
            $statement = $this->conexion->prepare("SELECT detalleventa.idDetalleVenta, insumo.NombreInsumo,insumo.idInsumo,"
                    . "detalleventa.CantidadVenta,detalleventa.PrecioVenta FROM detalleventa INNER JOIN insumo "
                    . "WHERE detalleventa.InsumoVendido = insumo.idInsumo AND detalleventa.VentaId =:id");
            $statement->bindParam(":id", $idVenta, PDO::PARAM_INT);
            $statement->execute();
            $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function quitarInsumos($idVenta) {
        try {
            $statement = $this->conexion->prepare("DELETE FROM detalleventa WHERE VentaId=:id_venta");
            $statement->bindParam(":id_venta", $idVenta, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo eliminar los detalles de la venta.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function BuscarVenta($idVenta) {
        $statement = $this->conexion->prepare("SELECT cliente.NombreCliente,cliente.CargoCliente,"
                . "venta.idVenta, venta.PrecioVenta, venta.EstadoVenta, venta.FechaVenta "
                . "FROM venta INNER JOIN cliente ON venta.ClienteVenta = cliente.idCliente "
                . "WHERE idVenta =:id");
        $statement->bindParam(":id", $idVenta, PDO::PARAM_INT);
        $statement->execute();
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function EditarVenta($precioVenta, $fechaVenta, $idVenta) {
        try {
            $statement = $this->conexion->prepare("UPDATE venta SET PrecioVenta =:precio, FechaVenta=:fecha WHERE idVenta=:id");
            $statement->bindParam(":precio", $precioVenta, PDO::PARAM_INT);
            $statement->bindParam(":fecha", $fechaVenta, PDO::PARAM_STR);
            $statement->bindParam(":id", $idVenta, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo editar la Venta.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function DescontarCantidad_Estado($idVenta, $estadoVenta, $cantidadVenta, $precioVenta) {
        try {
            $statement = $this->conexion->prepare("UPDATE venta SET EstadoVenta=:estado,"
                    . "PrecioVenta=:precio,CantidadVenta=:cantidad WHERE idVenta=:id");
            $statement->bindParam(":estado", $estadoVenta, PDO::PARAM_INT);
            $statement->bindParam(":precio", $precioVenta, PDO::PARAM_INT);
            $statement->bindParam(":cantidad", $cantidadVenta, PDO::PARAM_INT);
            $statement->bindParam(":id", $idVenta, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo editar la Venta.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function actualizarVenta($idVenta, $estadoVenta) {
        try {
            $statement = $this->conexion->prepare("UPDATE venta SET EstadoVenta=:estado WHERE idVenta=:id");
            $statement->bindParam(":estado", $estadoVenta, PDO::PARAM_INT);
            $statement->bindParam(":id", $idVenta, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo editar la Venta.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function cargarGraficasCantVentas() {
        $statement = $this->conexion->prepare("SELECT ELT(MAX(MONTH(venta.FechaVenta)), 'Enero', 'Febrero', 'Marzo', 'Abril',"
                . " 'Mayo', 'Junio', 'Julio','Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre') AS mesVenta, "
                . "COUNT(venta.idVenta) AS idVen, MAX(DATE_FORMAT(venta.FechaVenta, '%d-%m-%Y')) AS ultimaFecha FROM venta "
                . "WHERE venta.EstadoVenta = 2 GROUP BY MONTH(venta.FechaVenta)");
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function cargarGraficasInsumosVent() {
        $statement = $this->conexion->prepare("SELECT MAX(DATE_FORMAT(venta.FechaVenta, '%d-%m-%Y')) as fechaRegistro, "
                . "insumo.NombreInsumo,SUM(detalleventa.CantidadVenta) as CantidadVendida,detalleventa.PrecioVenta as ValorVenta,"
                . "SUM(detalleventa.CantidadVenta) * detalleventa.PrecioVenta AS totalV FROM detalleventa "
                . "INNER JOIN insumo ON detalleventa.InsumoVendido = insumo.idInsumo INNER JOIN venta ON detalleventa.VentaId = venta.idVenta "
                . "GROUP BY insumo.idInsumo ORDER BY fechaVenta AND venta.EstadoVenta = 2");
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

}
