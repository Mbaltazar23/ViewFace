<div class="modal fade" id="modalCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <center><h4 class="modal-title" id="myModalLabel">Ver datos de la Vinculacion</h4></center>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form id="form-cliente-vinculo" method="Post">
                        <input type="hidden" id="idVincular" name="idVincular" value=""/>
                        <input type="hidden" id="idper" name="idPer" value="<?= $_SESSION['id'] ?>"/>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:7px;">Nombre:</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nombre" id="nombre" readonly/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:7px;">Correo:</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="correo" id="correo" readonly/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:7px;">Telefono:</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="telefono" id="telefono" readonly=""/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:7px;">Clave:</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="clave" id="clave" readonly=""/>
                            </div>
                        </div>
                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">Negocio:</legend>
                                <div class="col-sm-7">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="opcionNegocio" value="1" onclick="cargarNegocio(this.value)">
                                        <label class="form-check-label" for="opcionNegocio">
                                            Si tiene
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="opcionNegocio" value="2" onclick="cargarNegocio(this.value)">
                                        <label class="form-check-label" for="opcionNegocio">
                                            No tiene
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="row form-group" id="comboNegocio">
                            <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:4px;">Tipo de Negocio:</label>
                            </div>
                            <div class="col-sm-10 selectNegocios">
                                <select id="negocioTipo" name="empresa" class="form-control">

                                </select>
                            </div>
                        </div>
                        <div class="row form-group" id="DescribCargo">
                            <div class='col-sm-2'>
                                <label class='control-label' style='position:relative;top:7px;'>Cargo:</label>
                            </div>
                            <div class='col-sm-10'>
                                <textarea class="form-control" id="descripcionCargo"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar"><i class="fas fa-power-off"></i>&nbsp;Cancelar</button>
                            <button type="submit" class="btn btn-success"><i class="fas fa-link"></i>&nbsp;Vincular al Cliente</button>
                        </div>
                    </form>
                </div> 
            </div>
        </div>
    </div>
</div>