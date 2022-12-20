<?php
require_once '../../config.php';
require_once '../../model/Conexion.php';
require_once '../../model/Vinculacion.php';
require_once '../../model/Personal.php';
session_start();
if (!isset($_SESSION["email-personal"])) {
    header("Location: " . URL);
}
if (!($_SESSION["cargo-usuario"] == "Jefa" || $_SESSION["cargo-usuario"] == "Administrador de Empresas" || $_SESSION["cargo-usuario"] == "Contador Auditor" || $_SESSION["cargo-usuario"] == "Analista-financiero")) {
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
                        <h1 class="display-7">Solicitud de Peticiones de Nuevos clientes</h1>
                        <p class="lead">Estas son todas las peticiones hechas por nuevos usuarios que quieran ser clientes.</p>
                        <hr>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <table class="table" id="TableVinculos">
                        <caption>Lista de Peticiones.</caption>
                        <thead >
                            <tr width="20%">
                                <th width="20%">Correo</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="Vinculos">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php include '../Clientes/AccionesCliente.php' ?>
        <?php include '../Template/footer.php'; ?>
        <script src="<?= ASSET ?>/js/acciones/accionesVincular.js" type="text/javascript"></script>
    </body>
</html>

