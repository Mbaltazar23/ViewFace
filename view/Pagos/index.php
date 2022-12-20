<?php
require_once '../../config.php';
require_once '../../model/Conexion.php';

session_start();
if (!isset($_SESSION["email-personal"])) {
    header("Location: " . URL);
} else if (!($_SESSION["cargo-usuario"] == "Administrador de Empresas" || $_SESSION["cargo-usuario"] == "Contador Auditor")) {
    header("Location: " . URL);
}
?>
<!DOCTYPE html>
<html lang="es">
    <?php include '../Template/header.php'; ?>
    <body>
        <?php include '../Template/menu.php'; ?>
        <div class="container my-3">
            <div class="row">
                <div class="col-12">
                    <div class="jumbotron">
                        <h1 class="display-7">Pagos</h1>
                        <p class="lead">Administración de los Pagos hechos por los Clientes.</p>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <table class="table table-striped" id="tablePagosA">
                        <thead>
                            <tr>
                                <th>Nombre-Cliente</th>  
                                <th>Fecha-Creada</th>
                                <th>Hora-Creada</th>
                                <th>Monto-Total($)</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php include './verPago.php'; ?> 
        <?php include '../../view/Template/footer.php'; ?>
        <script src="<?= ASSET ?>/js/acciones/accionesPago.js" type="text/javascript"></script>
        <script>
            const cargo = "<?= $_SESSION["cargo-usuario"] ?>";
        </script>
    </body>
</html>


