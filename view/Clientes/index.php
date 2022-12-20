<?php
require_once '../../config.php';
require_once '../../model/Conexion.php';
session_start();
if (!isset($_SESSION["email-personal"])) {
    header("Location: " . URL);
}
?>
<!DOCTYPE html>
<html lang="es">
    <?php include '../Template/header.php'; ?>
    <body>
        <?php include '../Template/menu.php'; ?>
        <?php if (isset($_SESSION["email-personal"]) && $_SESSION["cargo-usuario"] == "Jefa") { ?>
            <div class="container my-3">
                <div class="row">
                    <div class="col-12">
                        <div class="jumbotron">
                            <h1 class="display-7">Clientes Registrados</h1>
                            <p class="lead">Estas son todos los cliente registrados.</p>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <table class="table" id="TableClientes">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Telefono</th>
                                    <th>Cargo-Cliente</th>
                                    <th>Estado-Cuenta</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <?php include '../Clientes/verCliente.php'; ?>
        <?php } else if (isset($_SESSION["email-personal"]) && $_SESSION["cargo-usuario"] == "Cliente") { ?>
            <div class="container py-lg-4 py-md-3 py-2">
                <div class="row">
                    <div class="col-md-8 col-12 offset-md-2">               
                        <div class="card bg-light shadow">
                            <div class="card-header bg-light text-center">
                                <h3>Datos del Cliente</h3>
                            </div>
                            <div class="card-body">
                                <p><strong>Nombre:</strong>&nbsp; &nbsp; <label id="nomCli"></label></p>
                                <p><strong>Telefono:</strong>&nbsp; &nbsp; <label id="TelefonoCli"></label></p>
                                <p><strong>Correo:</strong>&nbsp; &nbsp; <label id="CorreoCli"></label></p>
                                <p><strong>Negocio:</strong>&nbsp; &nbsp; <label id="NegocioCli"></label></p>
                                <p><strong>Fecha Registro:</strong>&nbsp;&nbsp; <label id="FechaRe"></label></p>
                                <p><strong>Hora Registro:</strong>&nbsp;&nbsp; <label id="HoraRe"></label></p>
                                <p><strong>Nombre Personal Encargado:</strong>&nbsp; &nbsp;<label id="userNa"></label></p>
                                <p><strong>Correo del Personal Encargado:</strong>&nbsp; &nbsp;<label id="CorreoPer"></label></p>
                                <p><strong>Cargo del Personal Encargado:</strong>&nbsp; &nbsp;<label id="CargoPer"></label></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                const cliente = "<?= $_SESSION["idCli"] ?>";
            </script>
        <?php } ?>
        <?php include '../Template/footer.php'; ?>
        <?php if ($_SESSION["cargo-usuario"] == "Jefa") { ?>
            <script src="<?= ASSET ?>/js/acciones/accionesCliente.js" type="text/javascript"></script>
        <?php } else if ($_SESSION["cargo-usuario"] == "Cliente") { ?>
            <script src="<?= ASSET ?>/js/acciones/accionesPerfilCliente.js" type="text/javascript"></script>
        <?php } ?>
    </body>
</html>


