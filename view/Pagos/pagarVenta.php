<div class="modal fade" id="modalPagoVenta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <center><h4 class="modal-title">Pagar Venta</h4></center>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="formPagosAdd" method="Post">
                        <input type="hidden" id="VentaPag">
                        <input type="hidden" id="ComunaP">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="sub-total">Sub-total($)</label>
                                <input type="text" id="PrecioPag" class="form-control" readonly=""/>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="costo-total">Costo-Envio($)</label>
                                <input type="text" id="costoEnvio" class="form-control" readonly=""/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="total">Costo-Total($)</label>
                                <input type="text" id="totalV" class="form-control" readonly=""/>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="direccion">Direccion-Envio</label>
                                <input type="text" id="DireccionPago" class="form-control" readonly=""/>
                            </div>
                        </div>
                        <div class="form-group SelectTipoPago">
                            <label for="TipoPagos">Tipo-Pago</label>
                            <select id="tipoPago" name="tipoPago" class="form-control">

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Descripcion">Descripcion</label>
                            <textarea class="form-control" id="descripcionPago"></textarea>
                        </div>
                        <!--                        <div id="paypal-btn-container"></div>-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Ordenar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
