<div class="modal fade" id="ModalSesionCli" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingresa con tu cuenta de Cliente</h5>
            </div>
            <div class="modal-body">
                <form id="formClienteSesion" method="POST">
                    <div class="form-group">
                        <input type="text" class="form-control" id="correoCli" placeholder="Ingrese su Correo"/>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="claveCli" placeholder="Ingrese su Clave de Cliente"/>
                    </div>
                    <div id="errorcli" class="form-group">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeCli">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Iniciar Sesion</button>
                    </div>  
                </form>
            </div>
        </div>
    </div>
</div>