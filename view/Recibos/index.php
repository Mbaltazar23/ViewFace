<?php
require_once '../../config.php';
require_once '../../model/Conexion.php';
require_once '../../model/Recibo.php';
require_once '../../model/Cliente.php';
session_start();
if (!isset($_SESSION["email-personal"])) {
    header("Location: " . URL);
}
if (!($_SESSION["cargo-usuario"] == "Administrador de Empresas" || $_SESSION["cargo-usuario"] == "Cliente" || $_SESSION["cargo-usuario"] == "Contador Auditor")) {
    header("Location: " . URL);
}
$recibo = new Recibo();
?>
<!DOCTYPE html>
<html>
    <?php include '../Template/header.php'; ?>
    <body>
        <?php include '../Template/menu.php'; ?>
        <?php if (isset($_SESSION["email-personal"]) && ($_SESSION["cargo-usuario"] == "Administrador de Empresas" || $_SESSION["cargo-usuario"] == "Contador Auditor")) { ?>
            <div class="container my-3">
                <div class="row">
                    <div class="col-12">
                        <div class="jumbotron">
                            <h1 class="display-7">Recibos</h1>
                            <p class="lead">Administración de los Recibos hechos por los pagos del Cliente.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-striped" id="TableRecibosAdmin">
                            <caption>Lista de Recibos.</caption>
                            <thead>
                                <tr>
                                    <th>Nombre-cliente</th>  
                                    <th>Telefono</th>
                                    <th>Sub-Total</th>
                                    <th>Direccion</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="RecibosAdmin">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        <?php } else if (isset($_SESSION["email-personal"]) && $_SESSION["cargo-usuario"] == "Cliente") { ?>
            <div class="container my-3">
                <div class="row">
                    <div class="col-12">
                        <div class="jumbotron">
                            <h1 class="display-7">Recibos</h1>
                            <p class="lead">Recibos hechos por el Cliente.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-striped" id="TableRecibosCli">
                            <thead>
                                <tr>
                                    <th>Fecha-Emitida</th>  
                                    <th>Total-Recibo</th>
                                    <th>Telefono</th>
                                    <th>Direccion</th>
                                    <th>Ciudad</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div> 
            <script>
                const cliente = "<?= $_SESSION['idCli'] ?>";
            </script>
        <?php } ?>
        <?php include '../Template/footer.php' ?>
        <?php include '../Recibos/verRecibo.php'; ?> 
        <script src="<?= ASSET ?>/js/librerias/jspdf.min.js" type="text/javascript"></script>
        <script src="<?= ASSET ?>/js/librerias/jspdf.plugin.autotable.js" type="text/javascript"></script>
        <script src="<?= ASSET ?>/js/acciones/accionesRecibo.js" type="text/javascript"></script>
        <script>
                const cargo = "<?= $_SESSION["cargo-usuario"]; ?>";
        </script>
    </body>
</html>