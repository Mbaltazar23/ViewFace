<div class="modal fade" id="modalSolicitudForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <center><h4 class="modal-title titleSoli"></h4></center>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form class="form-solicitudCli" method="POST">
                        <input type="hidden" id="idCli"/>
                        <input type="hidden" id="opcionSoli"/>
                        <input type="hidden" id="solicitudId"/>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="Nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" disabled=""/>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Empresa">Cargo</label>
                                <input type="text" class="form-control" id="CargoCli" disabled=""/>
                            </div>
                        </div>
                        <div class="form-group selectMercancia">
                            <label for="mercancia">Tipo de Mercancia</label>
                            <select id="mercancia" class="form-control">

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Cargo">Describa que necesita</label>
                            <textarea class="form-control" id="descripcionSolic"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-default btnSolicitud"></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

