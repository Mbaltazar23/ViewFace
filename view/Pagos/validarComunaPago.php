<div class="modal fade" id="modalComunaPago" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <center><h4 class="modal-title" id="myModalLabel">Seleccione su Direccion</h4></center>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="ComunaPago" method="Post">
                        <input type="hidden" name="idVentaC" id="idVentaC"/>
                        <div class="form-group SelectComunaVenta">
                            <label for="comuna">Nombre de la Comuna</label>
                            <select id="comunaP" class="form-control" onchange="seleccionarDireccion(this.value)"></select>
                        </div>
                        <div class="form-group SelectDirecciones" id="Direcciones">
                            <label for="Direccion">Direccion</label>
                            <select id="DireccionP" class="form-control"></select>
                        </div>
                         <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-power-off"></i>&nbsp;Cancelar</button>
                            <button type="submit" class="btn btn-success"><i class="fas fa-link"></i>&nbsp;Aceptar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
