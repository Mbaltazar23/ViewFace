<div class="modal fade" id="modalInsumoForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <center><h4 class="modal-title titleFormIns" id="myModalLabel"></h4></center>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form class="form-insumo" method="Post">
                        <input type="hidden" id="opcionIns"/>
                        <input type="hidden" id="idInsu"/>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nombre">Precio</label>
                                <input type="text" class="form-control" id="precio">
                            </div>
                        </div>
                        <div class="form-group formCantInsumo">
                            <label for="nombre">Cantidad</label>
                            <input type="text" class="form-control" id="cantidad">
                        </div>
                        <div class="form-group selectCategoria">
                            <label for="categoria">Categoria</label>
                            <select id="cat" class="form-control">

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Descripcion">Descripcion</label>
                            <textarea class="form-control" id="descripcion"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary btnInsumo"></button>
                        </div>
                    </form>
                </div> 
            </div>
        </div>
    </div>
</div>