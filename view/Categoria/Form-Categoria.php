<div class="modal fade" id="modalCatEdit-Add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content fondoCat">
            <div class="modal-header">
                <center><h4 class="modal-title" id="titleAdd"></h4></center>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form class="formCat" method="Post">
                        <input type="hidden" id="opcion"/>
                        <input type="hidden" id="idcat"/>
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombreCat">
                        </div>
                        <div class="form-group">
                            <label for="Descripcion">Descripcion</label>
                            <textarea class="form-control" id="descripcionCat"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary btnCategoria"></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
