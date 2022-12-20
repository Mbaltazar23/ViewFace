<div class="modal fade" id="modalReciboVer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <center><h4 class="modal-title" id="myModalLabel">Ver Recibo del Cliente</h4></center>
            </div>
            <div class="modal-body">
                <div id="ReciboCliente">
                    <div class="card-body">
                        <input type="hidden" id="idRe"/>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <p><strong>Nombre:</strong>&nbsp;&nbsp;<label id="nombreCliRe"></label></p>
                                <p><strong>Telefono:</strong> &nbsp;&nbsp;<label id="telefonoCliR"></label></p>
                                <p><strong>SubTotal:</strong> &nbsp;<label id="SubTotalR"></label></p>
                                <p><strong>Total-Pago:</strong> &nbsp; &nbsp;<label id="TotalR"></label></p>
                                <p><strong>Cuidad:</strong> &nbsp; &nbsp;<label id="CuidadR"></label></p>
                            </div>
                            <div class="form-group col-md-6">
                                <p><strong>Fecha:</strong>&nbsp;&nbsp;<label id="FechaR"></label></p> 
                                <p><strong>Hora:</strong>&nbsp;&nbsp;<label id="HoraR"></label></p> 
                                <p><strong>Costo-Envio:</strong> &nbsp;<label id="CostoEnvio"></label></p>  
                                <p><strong>Direccion:</strong> &nbsp;<label id="DireccionR"></label></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar"><i class="fa fa-close"></i>&nbsp;Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="imprimirRecibo();"><i class="fas fa-print"></i>&nbsp;Imprimir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>