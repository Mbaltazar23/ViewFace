<div class="modal fade" id="modalRespuestaForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background: #DFE1DB">
            <div class="modal-header">
                <center><h4 class="modal-title titleSoliRes"></h4></center>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form class="formRespuesta" method="POST">
                        <input type="hidden" id="opcionRes"/>
                        <input type="hidden" id="idCliRes"/>
                        <input type="hidden" id="idSoliRes"/>
                        <input type="hidden" id="idRes"/>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombreCliRes" disabled="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="cargoCliRes">Cargo</label>
                                <input type="text" class="form-control" id="cargoCliRes" disabled="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Mensaje">Mensaje</label>
                            <textarea class="form-control" id="mensajeRes" disabled=""></textarea>
                        </div>
                        <div class="form-group">
                            <label for="respuesta">Respuesta</label>
                            <textarea class="form-control" id="respuestaSoli"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-default btnRespuesta"></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
