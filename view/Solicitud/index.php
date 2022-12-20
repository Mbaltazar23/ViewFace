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
        <?php if (isset($_SESSION["email-personal"]) && $_SESSION["cargo-usuario"] == "Jefa") { ?>
            <div class="container my-3">
                <div class="row">
                    <div class="col-12">
                        <div class="jumbotron">
                            <h1 class="display-7">Solicitudes de los Clientes</h1>
                            <p class="lead">Estas son todas las solicitudes recibidas.</p>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <table class="table" id="TableSolicitudJefa">
                            <thead>
                                <tr> 
                                    <th>Nombre-Cliente</th>  
                                    <th>Cargo-Cliente</th> 
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
        <?php } else if (isset($_SESSION["email-personal"]) && $_SESSION["cargo-usuario"] == "Cliente") { ?>
            <div class="container my-3">
                <div class="row">
                    <div class="col-12">
                        <div class="jumbotron">
                            <h1 class="display-7">Solicitudes de peticiones de Mercancia</h1>
                            <p class="lead">Administración de las Solicitudes que realicen.</p>
                            <br>
                            <button class="btn btn-info" onclick="buscarClienteSoli(<?= $_SESSION["idCli"] ?>)"><i class="fas fa-plus-circle"></i>&nbsp;Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-striped" id="TableSolicitudCliente">
                            <thead>
                                <tr>
                                    <th>Cargo-Empresa</th>
                                    <th>Fecha Solicitada</th>
                                    <th>Hora</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="SolicitudCli">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
            <?php include '../Solicitud/FormSolicitud.php'; ?>
            <script>
                const cliente = "<?= $_SESSION["idCli"] ?>";
            </script>
        <?php } ?> 
        <?php include '../Respuesta/verRespuesta.php'; ?>
        <?php include '../Respuesta/FormsRespuestas-Cliente.php'; ?>
        <?php include '../Template/footer.php'; ?>
        <script src="<?= ASSET ?>/js/acciones/accionesSolicitud.js" type="text/javascript"></script>
        <script>
                const cargo = "<?= $_SESSION["cargo-usuario"] ?>";
        </script>
    </body>
</html>

