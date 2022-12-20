<div class="modal fade" id="modalRespuestasCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container">
                    <br>
                    <h3 class="display-7">Respuestas</h3>
                    <p class="lead">Administración de las Respuestas de la Solicitud procesada.</p>
                </div>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-striped" id="tableRespuestas" style="width: 100%">
                                <?php if (isset($_SESSION["email-personal"]) && $_SESSION["cargo-usuario"] == "Jefa") { ?>
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>   
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                <?php } else if (isset($_SESSION["email-personal"]) && $_SESSION["cargo-usuario"] == "Cliente") { ?>
                                    <thead>
                                        <tr>
                                            <th>Cargo</th>   
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                <?php } ?>
                            </table>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../Respuesta/FormRespuesta.php';

