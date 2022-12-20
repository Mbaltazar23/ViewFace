<?php
require_once '../../config.php';
require_once '../../model/Conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
    <?php include '../Template/header.php'; ?>
    <body>
        <?php include '../Template/menu.php'; ?>
        <div class="container py-lg-4 py-md-3 py-2">
            <div class="row">
                <div class="col-md-8 col-12 offset-md-2">
                    <div class="card bg-light shadow">
                        <div class="card-header bg-light text-center">
                            <h3>Agregar Nueva Peticion</h3>
                        </div>
                        <div class="card-body">
                            <form id="form-registrar-orden" method="POST">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" id="nombre" name="nombre" class="form-control" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="telefono">Telefono</label>
                                        <input type="text" id="telefono" name="telefono" class="form-control" value="+569" readonly maxlength="12"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="correo">Correo del Cliente</label>
                                    <input type="text" id="correo" name="correo" class="form-control" />
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="clave">Clave</label>
                                        <input type="password" id="clave" name="clave" class="form-control" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Repetirclave">Repetir Clave</label>
                                        <input type="password" id="Repetirclave" name="Repetirclave" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group my-4">
                                    <button type="submit" class="btn btn-primary rounded-pill message">Registrar Orden</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
        <div id="mensajeError"></div>
        <?php include '../Template/footer.php'; ?>
        <script src="<?= ASSET ?>/js/acciones/accionesOrdenes.js" type="text/javascript"></script>
    </body>
</html>