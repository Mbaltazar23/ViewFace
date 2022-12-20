<?php
$icono = "";
if (isset($_SESSION["cargo-usuario"]) && $_SESSION["cargo-usuario"] == "Cliente") {
    $icono = "<i class='fas fa-user'></i>";
} else if (isset($_SESSION["cargo-usuario"]) && isset($_SESSION["cargo-usuario"]) == "Jefa" || isset($_SESSION["cargo-usuario"]) == "Administrador de Empresas" || isset($_SESSION["cargo-usuario"]) == "Contador Auditor" || isset($_SESSION["cargo-usuario"]) == "Analista-financiero") {
    $icono = "<i class='fas fa-user-edit'></i>'";
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?= URL ?>">View Face</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php if (isset($_SESSION["email-personal"]) && $_SESSION["cargo-usuario"] == "Jefa") { ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>/view/Insumos/"><i class="fab fa-product-hunt"></i>&nbsp;Insumos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>/view/Vinculaciones/"><i class="fas fa-envelope-open-text"></i>&nbsp;Peticiones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>/view/Clientes/"><i class="fas fa-users"></i>&nbsp;Clientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>/view/Solicitud/"><i class="fas fa-envelope-square"></i>&nbsp;Solicitudes</a>
                </li>
            <?php } else if (isset($_SESSION["email-personal"]) && ($_SESSION["cargo-usuario"] == "Administrador de Empresas" || $_SESSION["cargo-usuario"] == "Contador Auditor")) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>/view/Recibos/"><i class="fas fa-file-invoice-dollar"></i>&nbsp;Recibos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>/view/Pagos/"><i class="fas fa-dollar-sign"></i>&nbsp;Pagos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>/view/Vinculaciones/"><i class="fas fa-envelope-open-text"></i>&nbsp;Peticiones</a>
                </li>
            <?php } else if (isset($_SESSION["email-personal"]) && $_SESSION["cargo-usuario"] == "Analista-financiero") { ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>/view/Ventas/"><i class="fas fa-cart-arrow-down"></i>&nbsp;Ventas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>/view/Vinculaciones/"><i class="fas fa-envelope-open-text"></i>&nbsp;Peticiones</a>
                </li>
            <?php } else if (isset($_SESSION["email-personal"]) && $_SESSION["cargo-usuario"] == "Cliente") { ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>/view/Solicitud/"><i class="fas fa-envelope-square"></i>&nbsp;Mis Solicitudes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>/view/Ventas/"><i class="fas fa-cart-arrow-down"></i>&nbsp;Mis Ventas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>/view/Recibos/"><i class="fas fa-file-invoice-dollar"></i>&nbsp;Mis Recibos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>/view/Clientes/"><i class="fas fa-user-circle"></i>&nbsp;Mis Datos</a>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>/tutorial.php"><i class="fas fa-chalkboard-teacher"></i>&nbsp;Tutorial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>/view/Vinculaciones/registrarOrden.php"><i class="fas fa-envelope-square"></i>&nbsp;Solicitar Orden</a>
                </li>
            <?php } ?>
        </ul>
        <ul class="navbar-nav ml-auto">
            <?php if (!isset($_SESSION["email-personal"]) || $_SESSION["cargo-usuario"] == "") { ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>/view/Personal/iniciar.php"><i class="fas fa-sign-in-alt"></i>&nbsp;Iniciar</a>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <span class="nav-link"><?php echo $icono; ?>&nbsp;&nbsp;<?php echo "Hola " . $_SESSION["email-personal"]; ?></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" id="SesionModal"><i class="fas fa-sign-out-alt"></i>&nbsp;Salir</a>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>

