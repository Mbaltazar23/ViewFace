<?php

class Insumos extends Conexion {

    public function __construct() {
        parent::__construct();
    }

    public function registrar($codigoCategoria, $nombreInsumo, $cantidadInsumo, $descripcionInsumo, $estadoInsumo, $precioUnitario, $precioT) {
        try {
            $statement = $this->conexion->prepare("INSERT INTO insumo(CategoriaInsumo,NombreInsumo,CantidadInsumo,DescripcionInsumo,EstadoInsumo,PrecioUnitarioInsumo,PrecioTotalInsumo)"
                    . "VALUES (:idCategoria,:nombre,:cantidad,:descrip,:estado,:precio,:precioT)");
            $statement->bindParam(":idCategoria", $codigoCategoria, PDO::PARAM_INT);
            $statement->bindParam(":nombre", $nombreInsumo, PDO::PARAM_STR);
            $statement->bindParam(":cantidad", $cantidadInsumo, PDO::PARAM_INT);
            $statement->bindParam(":descrip", $descripcionInsumo, PDO::PARAM_STR);
            $statement->bindParam(":estado", $estadoInsumo, PDO::PARAM_INT);
            $statement->bindParam(":precio", $precioUnitario, PDO::PARAM_INT);
            $statement->bindParam(":precioT", $precioT, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo registrar el Insumo.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function editarInsumo($codigoCategoria, $nombreInsumo, $descripcionInsumo, $precioUnitario, $precioT, $idInsumo) {
        try {
            $statement = $this->conexion->prepare("UPDATE insumo SET NombreInsumo=:nombre,DescripcionInsumo=:descripcion,"
                    . "PrecioUnitarioInsumo=:precio, PrecioTotalInsumo=:total, CategoriaInsumo=:cat WHERE idInsumo =:id");
            $statement->bindParam(":nombre", $nombreInsumo, PDO::PARAM_STR);
            $statement->bindParam(":descripcion", $descripcionInsumo, PDO::PARAM_STR);
            $statement->bindParam(":precio", $precioUnitario, PDO::PARAM_INT);
            $statement->bindParam(":total", $precioT, PDO::PARAM_INT);
            $statement->bindParam(":cat", $codigoCategoria, PDO::PARAM_INT);
            $statement->bindParam(":id", $idInsumo, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo editar el Insumo.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function lista() {
        $statement = $this->conexion->prepare("SELECT insumo.idInsumo, insumo.NombreInsumo, "
                . "insumo.CantidadInsumo, insumo.DescripcionInsumo,insumo.PrecioUnitarioInsumo,"
                . "insumo.PrecioTotalInsumo, insumo.EstadoInsumo, categoria.NombreCategoria AS Categoria "
                . "FROM insumo INNER JOIN categoria ON insumo.CategoriaInsumo = categoria.idCategoria");
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function mostrarNombresInsumos($nombre) {
        try {
            $statement = $this->conexion->prepare("SELECT * FROM insumo WHERE NombreInsumo =:nombre");
            $statement->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $statement->execute();
            $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function buscarInsumo($id) {
        try {
            $statement = $this->conexion->prepare("SELECT * FROM insumo WHERE idInsumo=:id");
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();
            $resultado = $statement->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function DescontarCantidad($id, $cantidadInsumo) {
        try {
            $statement = $this->conexion->prepare("UPDATE insumo SET CantidadInsumo=:cant WHERE idInsumo=:id");
            $statement->bindParam(":cant", $cantidadInsumo, PDO::PARAM_INT);
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

    public function actualizarCantidad($id, $cantidadInsumo, $precioTotal) {
        try {
            $statement = $this->conexion->prepare("UPDATE insumo SET CantidadInsumo=:cant, PrecioTotalInsumo=:precioT WHERE idInsumo=:id");
            $statement->bindParam(":cant", $cantidadInsumo, PDO::PARAM_INT);
            $statement->bindParam(":precioT", $precioTotal, PDO::PARAM_STR);
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

    public function ActualizarEstado($id, $estado) {
        try {
            $statement = $this->conexion->prepare("UPDATE insumo SET EstadoInsumo=:estado WHERE idInsumo=:id");
            $statement->bindParam(":estado", $estado, PDO::PARAM_INT);
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

    public function cargarGraficoInsumosVendidos() {
        $statement = $this->conexion->prepare("SELECT insumo.NombreInsumo,SUM(detalleventa.CantidadVenta) as CantidadVendida,"
                . "MAX(DATE_FORMAT(venta.FechaVenta,'%d-%m-%Y')) as fechaVenta FROM detalleventa INNER JOIN insumo ON "
                . "detalleventa.InsumoVendido = insumo.idInsumo INNER JOIN venta ON detalleventa.VentaId = venta.idVenta "
                . "GROUP BY insumo.idInsumo ORDER BY fechaVenta AND venta.EstadoVenta = 2");
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function mostrarInsumos_Categoria($idCategoria) {
        try {
            $statement = $this->conexion->prepare("SELECT * FROM insumo WHERE CategoriaInsumo=:categoria AND EstadoInsumo = 1");
            $statement->bindParam(":categoria", $idCategoria, PDO::PARAM_INT);
            $statement->execute();
            $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

}
