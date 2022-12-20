<div class="modal fade" id="modalCategorias" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container">
                    <br>
                    <h3 class="display-7">Categorias</h3>
                    <p class="lead">Administración de los Categorias de los Insumos disponibles.</p>
                </div>
            </div>
            <div class="modal-body">
                <div class="card-body">  
                    <div class="row">
                        <div class="col-12 panelCat">
                            <button id="addCat" class="btn btn-primary">
                                <i class='fas fa-plus-circle'></i>&nbsp;Agregar
                            </button>
                        </div>
                        <div class="col-12">
                            <table class="table table-striped" id="tableCategorias" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>   
                                        <th>Descripcion</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<?php include '../Categoria/Form-Categoria.php' ?>;

