<?php

class Categoria extends Conexion {

    public function __construct() {
        parent::__construct();
    }

    public function listar() {
        //$statement = $this->conexion->prepare("SELECT * FROM categoria");
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function listarCategoriasActivas() {
        //$statement = $this->conexion->prepare("SELECT * FROM categoria WHERE EstadoCategoria = 1");
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function listarCategoriasActivas_Cliente() {
//        $statement = $this->conexion->prepare("SELECT DISTINCT insumo.CategoriaInsumo,categoria.NombreCategoria, "
//                . "categoria.idCategoria FROM insumo INNER JOIN categoria ON insumo.CategoriaInsumo = categoria.idCategoria "
//                . "WHERE insumo.EstadoInsumo = 1 AND insumo.CategoriaInsumo != 0");
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function registrarCategoria($nombre, $descripcion, $estado) {
        try {
//            $statement = $this->conexion->prepare("INSERT INTO categoria(NombreCategoria,DescripcionCategoria,EstadoCategoria) "
//                    . "VALUES (:nombre,:descripcion,:estado)");
            $statement->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $statement->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
            $statement->bindParam(":estado", $estado, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo registrar la Categoria.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function editarCategoria($nombre, $descripcion, $idCat) {
        try {
//            $statement = $this->conexion->prepare("UPDATE categoria SET NombreCategoria =:nombre, DescripcionCategoria=:descripcion WHERE idCategoria=:id");
            $statement->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $statement->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
            $statement->bindParam(":id", $idCat, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo editar la Categoria.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function actualizarEstadoCat($estado, $idCat) {
        try {
//            $statement = $this->conexion->prepare("UPDATE categoria SET EstadoCategoria=:estado WHERE idCategoria=:id");
            $statement->bindParam(":estado", $estado, PDO::PARAM_INT);
            $statement->bindParam(":id", $idCat, PDO::PARAM_INT);
            $statement->execute();
            if ($statement) {
                return true;
            } else {
                return "No se pudo quitar la Categoria.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function mostrarNombresCat($nombre) {
        try {
            //$statement = $this->conexion->prepare("SELECT * FROM categoria WHERE NombreCategoria =:nombre");
            $statement->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $statement->execute();
            $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function buscarCat($idCat) {
        try {
            //$statement = $this->conexion->prepare("SELECT * FROM categoria WHERE idCategoria =:id");
            $statement->bindParam(":id", $idCat, PDO::PARAM_INT);
            $statement->execute();
            $resultado = $statement->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function verificarCategoriaInsumo($idCat) {
        try {
            //$statement = $this->conexion->prepare("SELECT * FROM insumo WHERE CategoriaInsumo =:id AND EstadoInsumo =1");
            $statement->bindParam(":id", $idCat, PDO::PARAM_INT);
            $statement->execute();
            $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

}
