<?php
require_once '../../config.php';
require_once '../../model/Conexion.php';
session_start();
if (!isset($_SESSION["email-personal"])) {
    header("Location: " . URL);
}
?>
<!DOCTYPE html>
<html>
    <?php include '../Template/header.php'; ?>
    <body>
        <?php include '../Template/menu.php'; ?>
        <?php if (isset($_SESSION["email-personal"]) && $_SESSION["cargo-usuario"] == "Analista-financiero") { ?>
            <div class="container my-3">
                <div class="row">
                    <div class="col-12">
                        <div class="jumbotron">
                            <h1 class="display-7">Ventas</h1>
                            <p class="lead">Estas son todas las ventas hechas por el cliente.</p>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <table class="table" id="TableVentasA">
                            <thead>
                                <tr> 
                                    <th>Nombre-Cliente</th>  
                                    <th>Precio Venta</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <?php include './verVenta.php'; ?>
            <?php include './verVentaPay.php'; ?>
        <?php } else if (isset($_SESSION["email-personal"]) && $_SESSION["cargo-usuario"] == "Cliente") { ?>
            <div class="container my-3">
                <div class="row">
                    <div class="col-12">
                        <div class="jumbotron">
                            <h1 class="display-7">Mis Ventas</h1>
                            <p class="lead">Administración de las Ventas hechas por el Cliente.</p>
                            <buuton class="btn btn-info" data-toggle="modal" data-target="#modalVentaInsumo" id="buttonAddVentaInsumo"><i class="fas fa-plus-circle"></i>&nbsp;Agregar</buuton>&nbsp;
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12" id="seccionVentasC">
                        <table class="table" id="TableVentasC">
                            <thead>
                                <tr> 
                                    <th style="width: 20%;">Insumos-Vendidos</th> 
                                    <th style="width: 20%;">Fecha</th>
                                    <th style="width: 20%;">Hora</th>
                                    <th style="width: 20%;">Precio</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <script>
                const cliente = "<?= $_SESSION["idCli"]; ?>";
            </script>
            <?php include './FormVenta.php'; ?>   
            <?php include '../Pagos/validarComunaPago.php'; ?>
            <?php include '../Pagos/pagarVenta.php'; ?>
        <?php } ?>      
        <?php include '../Template/footer.php'; ?>
<!--        <script src="https://www.paypalobjects.com/api/checkout.js?locale=es-CL"></script>-->
        <script src="<?= ASSET ?>/js/acciones/accionesVenta.js" type="text/javascript"></script>
        <script>
                const cargo = "<?= $_SESSION["cargo-usuario"] ?>";
        </script>
    </body>
</html>
