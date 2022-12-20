<div class="modal fade" id="modalRepuestaView" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <center><h4 class="modal-title" id="myModalLabel">Ver Respuesta</h4></center>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <input type="hidden" id="idSolicitudR"/>
                    <p><strong>Mensaje:</strong>&nbsp; &nbsp;<label id="mensajeR"></label></p>
                    <p><strong>Fecha:</strong>&nbsp; &nbsp;<label id="fechaR"></label></p>
                    <p><strong>Hora:</strong> &nbsp;&nbsp;<label id="horaR"></label></p>
                    <p><strong>Respuesta:</strong> &nbsp; &nbsp;<label id="respuestaR"></label></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar"><i class="fas fa-window-close"></i>&nbsp;&nbsp;Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btnRes"><i class="far fa-envelope"></i>&nbsp;&nbsp;Responder</button>
                </div>
            </div>
        </div>
    </div>
</div>