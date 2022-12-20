<?php if (isset($_SESSION["email-personal"]) && $_SESSION["cargo-usuario"] == "Jefa") { ?>
    <div class="card-body">
        <div class="col-lg-12">
            <div id="insumoG"></div>
        </div>
        <br>
        <div class="col-lg-12">
            <div id="clientesG"></div>
        </div>
    </div>
<?php } else if (isset($_SESSION["email-personal"]) && ($_SESSION["cargo-usuario"] == "Administrador de Empresas" || $_SESSION["cargo-usuario"] == "Contador Auditor")) { ?>
    <div class="card-body">
        <div class="col-lg-12">
            <div id="recibosA-C"></div>
        </div>
        <br>
        <div class="col-lg-12">
            <div id="pagosA-C"></div>
        </div>
    </div>
<?php } else if (isset($_SESSION["email-personal"]) && $_SESSION["cargo-usuario"] == "Analista-financiero") { ?>
    <div class="card-body">
        <div class="col-lg-12">
            <div id="CantVentasG"></div>
        </div>
        <br>
        <div class="col-lg-12">
            <div id="InsumosVentasG"></div>
        </div>
    </div>
<?php } else if (isset($_SESSION["email-personal"]) && $_SESSION["cargo-usuario"] == "Cliente") { ?>
    <div class="card-body">
        <div class="col-lg-12">
            <div id="VentasCliG"></div>
        </div>
    </div>
<?php } ?>

<?php if (isset($_SESSION["email-personal"])) { ?>
    <script>
        const cargo = "<?= $_SESSION["cargo-usuario"]; ?>";
    </script>
<?php } ?>
