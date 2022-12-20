<?php if (isset($_SESSION["cargo-usuario"]) && !isset($_SESSION["idCli"])) { ?>
    <script src="<?= ASSET ?>/js/librerias/plotly-latest.min.js" type="text/javascript"></script>
    <script src="<?= ASSET ?>/js/graficas/<?= $_SESSION['graficas'] ?>" type="text/javascript"></script>
    <script src="<?= ASSET ?>/js/acciones/accionesBanner.js"></script>
    <script>
        const cargoBan = "<?= $_SESSION["cargo-usuario"]; ?>";
    </script>
<?php } else if (isset($_SESSION["cargo-usuario"]) && isset($_SESSION["idCli"])) { ?>
    <script src="<?= ASSET ?>/js/librerias/plotly-latest.min.js" type="text/javascript"></script>
    <script src="<?= ASSET ?>/js/graficas/<?= $_SESSION['graficas'] ?>" type="text/javascript"></script>
    <script src="<?= ASSET ?>/js/acciones/accionesBanner.js"></script>
    <script>
        const idCli = "<?= $_SESSION["idCli"] ?>";
        const cargoBan = "<?= $_SESSION["cargo-usuario"]; ?>";
    </script>
<?php } else { ?>
    <script src="<?= ASSET ?>/js/acciones/accionesBannerInicial.js" type="text/javascript"></script>
<?php } ?>

