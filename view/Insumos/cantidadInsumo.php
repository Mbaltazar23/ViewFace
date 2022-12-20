<div class="modal fade" id="modalInsumoCantidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <center><h4 class="modal-title" id="myModalLabel">Ver cantidad de Insumos</h4></center>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="form-insumo-cantidadIn" method="Post">
                        <input type="hidden" id="idInsumo"/>
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombreIn" readonly="">
                        </div>
                        <div class="form-group">
                            <label for="nombre">Precio</label>
                            <input type="text" class="form-control" id="precioIn" readonly>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Cantidad</label>
                            <input type="number" class="form-control" id="cantidadIn">
                        </div>
                        <div class="form-group col-sm-12" id="error">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

