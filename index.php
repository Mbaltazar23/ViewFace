<?php
require_once './config.php';
require_once './model/Conexion.php';
session_start();
?>
<!DOCTYPE html>
<html>
    <?php include './view/Template/header.php'; ?>
    <body>
        <?php include './view/Template/menu.php'; ?>

        <div class="jumbotron text-center rounded-0">
            <h1 class="display-3 pb-4" id="titleBanner"></h1>      
            <p id="parrafoBanner"></p> 
        </div>
        <div class="container">
            <?php include './view/Graficos/cargarGraficos.php'; ?>
        </div>
        <?php include './view/Template/footer.php'; ?>
        <?php include './view/Template/footer-graficas.php'; ?>
    </body>
</html>
