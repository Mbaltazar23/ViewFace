<div class="modal fade" id="modalVentaView" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <center><h4 class="modal-title" id="myModalLabel">Ver datos de la Venta</h4></center>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <p><strong>Nombre:</strong>&nbsp; &nbsp;<label id="nombreVen"></label></p>
                    <p><strong>Cargo:</strong>&nbsp; &nbsp;<label id="cargoVen"></label></p>
                    <p><strong>Total:</strong>&nbsp; &nbsp;<label id="totalVen"></label></p>
                    <p><strong>Status:</strong>&nbsp; &nbsp;<label id="estadoV"></label></p>
                    <table class="table" id="tableDetalleV">
                        <thead>
                            <tr>
                                <th>NOMBRE</th>
                                <th>CANTIDAD</th>
                                <th>PRECIO</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>