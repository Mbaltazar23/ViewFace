<div class="modal fade" id="modalVentaInsumo"tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <center><h4 class="modal-title titleVenta" id="myModalLabel"></h4></center>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="row">
                        <input type="hidden" id="opcionVenta"/>
                        <input type="hidden" name="id-venta" id="id-venta"/>
                        <div class="form-group col-md-4 selectInsumosCat">
                            <label for="insumo">Tipo-Insumo</label>
                            <select id="catInsumo" name="catInsumo" class="form-control" onchange="buscarInsumos(this.value, 'selectInsumos')">

                            </select>
                        </div>
                        <div class="form-group col-md-4 selectInsumos">
                            <label for="insumo">Insumo</label>
                            <select id="insumo" name="insumo" class="form-control">

                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" id="cantidadInsu" name="cantidadInsu" class="form-control" minlength="1"/>
                        </div>
                        <div class="form-group col-md-4" >
                            <button id="btnAgregarInsumo" class="btn btn-block btn-info" title="Agregar">Agregar</button>
                        </div>
                    </div>
                    <table id="tabla-insumos" class="table">
                        <thead>
                            <tr>
                                <th>NOMBRE</th>
                                <th>CANTIDAD</th>
                                <th>PRECIO($)</th>
                                <th>SUBTOTAL($)</th>
                                <th>OPERACIONES</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <div id="resumenVenta" hidden>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>