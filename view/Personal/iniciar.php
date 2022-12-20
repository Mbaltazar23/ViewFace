<?php
require_once '../../config.php';
session_start();
if (isset($_SESSION["email-personal"])) {
    header("Location: " . URL);
}
?>
<!DOCTYPE html>
<html>
    <?php include '../Template/header.php'; ?>
    <body>
        <?php include '../Template/menu.php'; ?>
        <div class="container my-5">
            <div class="row">
                <div class="col-12 py-3">
                    <h2>Iniciar Sesion como</h2>
                    <br>
                    <p>
                        <button class="btn btn-primary btn-lg block" id="BotonSesionPersonal" data-toggle="modal" data-target="#ModalSesionPer"><i class="fas fa-user-edit"></i>&nbsp;Personal</button>
                    </p>
                    <p>
                        <button class="btn btn-primary btn-lg block" id="BotonSesionCliente"data-toggle="modal" data-target="#ModalSesionCli"><i class="fas fa-user-friends"></i>&nbsp;Cliente</button>
                    </p>
                </div>
            </div>
        </div>
        <?php include '../Template/footer.php' ?> 
        <?php include '../Personal/sesionPersonal.php'; ?>
        <?php include '../Clientes/sesionCliente.php'; ?>
    </body>
</html>

