<?php
require_once '../../config.php';
require_once '../../model/Conexion.php';
session_start();
if (!isset($_SESSION["email-personal"]) || $_SESSION["cargo-usuario"] != "Jefa") {
    header("Location: " . URL);
}
?>
<!DOCTYPE html>
<html>
    <?php include '../Template/header.php'; ?>
    <body>
        <?php include '../Template/menu.php'; ?>
        <div class="container my-3">
            <div class="row">
                <div class="col-12">
                    <div class="jumbotron">
                        <h1 class="display-7">Insumos</h1>
                        <p class="lead">Administración de las Insumos Disponibles.</p>
                        <hr>
                        <buuton class="btn btn-info" id="buttonAddInsumo"><i class="fas fa-plus-circle"></i>&nbsp;Agregar</buuton>&nbsp;
                        <button class="btn btn-primary" id="btnExportar"><i class="far fa-file-pdf"></i>&nbsp;Generar Reporte</button>&nbsp;
                        <button class="btn btn-primary ModalCat" data-toggle="modal" data-target="#modalCategorias"><i class="far fa-copyright"></i>&nbsp;Categorias</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <table class="table table-striped" id="tableInsumo">
                        <thead>
                            <tr>
                                <th>Nombre</th>   
                                <th>Precio($)</th>
                                <th>Cantidad</th>
                                <th>Total-Precio($)</th>
                                <th>Categoria</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <?php include '../Categoria/ModalCategorias.php'; ?>   
        <?php include '../Insumos/FormInsumo.php'; ?>
        <?php include '../Insumos/cantidadInsumo.php'; ?>
        <?php include '../../view/Template/footer.php'; ?>
        <script src="<?= ASSET ?>/js/librerias/jspdf.min.js" type="text/javascript"></script>
        <script src="<?= ASSET ?>/js/librerias/jspdf.plugin.autotable.js" type="text/javascript"></script>
        <script src="<?= ASSET ?>/js/acciones/accionesInsumo.js" type="text/javascript"></script> 
        <script>
            const cargo = "<?= $_SESSION["cargo-usuario"]; ?>";
        </script>
    </body>
</html>
