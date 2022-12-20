<?php

require_once ('../config.php');
require_once ('../model/Conexion.php');
require_once ('../model/Insumos.php');
require_once ('../model/Categoria.php');

$insumo = new Insumos();
$categoria = new Categoria();
$funcion = "";

if (isset($_GET["funcion"])) {
    $funcion = $_GET["funcion"];
    if ($funcion == "create") {
        $nombreCat = (isset($_POST["nombreCat"])) ? $_POST["nombreCat"] : "";
        $descripcionC = (isset($_POST["descripcionC"])) ? $_POST["descripcionC"] : "";
        $estadoCategoria = 1;
        $listaCats = $categoria->mostrarNombresCat($nombreCat);
        $result = "";
        if (empty($listaCats)) {
            $result = $categoria->registrarCategoria($nombreCat, $descripcionC, $estadoCategoria);
        } else {
            $result = "La categoria ya esta registrada";
        }

        if ($result == true) {
            echo $result;
        } else {
            echo $result;
        }
        
    } else if ($funcion == "update") {
        $nombreCat = (isset($_POST["nombreCat"])) ? $_POST["nombreCat"] : "";
        $descripcionC = (isset($_POST["descripcionC"])) ? $_POST["descripcionC"] : "";
        $idCat = (isset($_POST["idCategoria"])) ? $_POST["idCategoria"] : "";
        $result = $categoria->editarCategoria($nombreCat, $descripcionC, $idCat);

        if ($result == true) {
            echo $result;
        }
    } else if ($funcion == "search") {
        $idCategoria = (isset($_POST["idCategoria"])) ? $_POST["idCategoria"] : "";
        $categoriaSearch = $categoria->buscarCat($idCategoria);
        echo json_encode($categoriaSearch);
        
    } else if ($funcion == "delete") {
        $idCategoria = (isset($_POST["idCategoria"])) ? $_POST["idCategoria"] : "";
        $estadoCategoria = 0;
        $estadoCat = $categoria->verificarCategoriaInsumo($idCategoria);
        $result = "";

        if (empty($estadoCat)) {
            $result = $categoria->actualizarEstadoCat($estadoCategoria, $idCategoria);
        } else {
            $result = "La categoria ya esta en uso...";
        }
        if ($result == true) {
            echo $result;
        } else {
            echo $result;
        }
        
    } else if ($funcion == "activate") {
        $idCategoria = (isset($_POST["idCategoria"])) ? $_POST["idCategoria"] : "";
        $estadoCategoria = 1;
        $result = $categoria->actualizarEstadoCat($estadoCategoria, $idCategoria);
        if ($result == true) {
            echo $result;
        }
    } else if ($funcion == "searchInsumoCat") {
        $idCategoria = (isset($_POST["idCategoria"])) ? $_POST["idCategoria"] : "";
        $InsumosCat = $insumo->mostrarInsumos_Categoria($idCategoria);
        echo '<option value="0">Escoga un Insumo</option>';
        for ($i = 0; $i < count($InsumosCat); $i++) {
            echo '<option value="' . $InsumosCat[$i]['idInsumo'] . '">' . $InsumosCat[$i]['NombreInsumo'] . '</option>';
        }
    } else if ($funcion == "listCategorias") {
        $Categorias = $categoria->listarCategoriasActivas();
        echo '<option value="0">Seleccione una categoria</option>';
        for ($i = 0; $i < count($Categorias); $i++) {
            echo '<option value="' . $Categorias[$i]['idCategoria'] . '">' . $Categorias[$i]['NombreCategoria'] . '</option>';
        }
    } else if ($funcion == "listCategoriasVisibles") {
        $Categorias = $categoria->listarCategoriasActivas_Cliente();
        echo '<option value="0">Seleccione una categoria</option>';
        for ($i = 0; $i < count($Categorias); $i++) {
            echo '<option value="' . $Categorias[$i]['idCategoria'] . '">' . $Categorias[$i]['NombreCategoria'] . '</option>';
        }
    } else if ($funcion == "listCat") {
        $Categorias = $categoria->listar();
        for ($i = 0; $i < count($Categorias); $i++) {
            $btnEdit = '';
            $btnDelete = '';
            if ($Categorias[$i]['EstadoCategoria'] == 1) {
                $Categorias[$i]['EstadoCategoria'] = "<span class='badge badge-success'>ACTIVO</span>";
                $btnEdit = "<button class='btn btn-success btn-circle' onclick='buscarCategoria(" . $Categorias[$i]["idCategoria"] . ");'><i class='fas fa-edit'></i></button></button>";
                $btnDelete = "<button class='btn btn-danger btn-circle' data-toggle='modal' onclick='EliminarCategoria(" . $Categorias[$i]["idCategoria"] . ")'><i class='fas fa-power-off'></i></button>";
            } else if ($Categorias[$i]['EstadoCategoria'] == 0) {
                $Categorias[$i]['EstadoCategoria'] = "<span class='badge badge-danger'>INACTIVO</span>";
                $btnEdit = "<button class='btn btn-secondary btn-circle' onclick='buscarCategoria(" . $Categorias[$i]["idCategoria"] . ");' disabled=''><i class='fas fa-edit'></i></button></button>";
                $btnDelete = "<button class='btn btn-primary btn-circle' data-toggle='modal' onclick='ActivarCategoria(" . $Categorias[$i]["idCategoria"] . ")'><i class='fas fa-toggle-on'></i></button>";
            }
            $Categorias[$i]['options'] = '<div class="text-center">' . $btnEdit . ' ' . $btnDelete . '</div>';
        }
        echo json_encode($Categorias);
    }
} else {
    echo "<script>$(location).attr('href', '" . URL . "');</script>";
}