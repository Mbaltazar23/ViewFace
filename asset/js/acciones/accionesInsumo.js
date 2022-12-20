let tableCategorias;
let tableInsumos;
$(document).ready(function () {
    cargarInsumos();
    /*funciones principales del Submodulo "Categoria"*/

    $.ajax({
        type: "POST",
        url: "../../controladores/CategoriaController.php?funcion=listCategorias",
        success: function (data) {
            $('.selectCategoria select').html(data).fadeIn();
        }
    });

    $(".ModalCat").click(function () {
        cargarCategorias();
    });

    $("#addCat").click(function () {
        $("#titleAdd").text("Agregar Nueva Categoria");
        $("#opcion").val("createCat");
        $("#modalCatEdit-Add").modal('show');
        $("#nombreCat").val("");
        $("#descripcionCat").val("");
        $(".btnCategoria").text("Registrar");
    });

    $(".formCat").submit(function (e) {
        e.preventDefault();
        let nombreCat = $("#nombreCat").val();
        let descripcionCat = $("#descripcionCat").val();
        let idCategoria = $("#idcat").val();
        let opcion = $("#opcion").val();
        let error = false;
        let mensaje = [];
        //console.log(opcion);
        if (descripcionCat == "") {
            mensaje.push("Este campo no puede estar vacio");
            error = true;
        }

        if (nombreCat == "") {
            mensaje.push("El nombre no debe estar vacio ..");
            error = true;
        } else if (nombreCat.length < 3) {
            mensaje.push("El nombre debe tener una cantidad mayor a 3 caracteres..");
            error = true;
        }

        if (error == true) {
            for (let i = 0; i < mensaje.length; i++) {
                swal("Ops...", mensaje[i], "error");
            }
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "../../controladores/CategoriaController.php?funcion=" + opcion,
                data: {nombreCat: nombreCat, descripcionC: descripcionCat, idCategoria: idCategoria},
                success: function (data) {
                    if (data == 1) {
                        if (opcion == "create") {
                            swal({
                                title: "Exito !",
                                text: "Categoria Agregada Exitosamente !!",
                                icon: "success"
                            }).then(function () {
                                //window.location = urlIndex + '/view/Insumos';
                                $("#modalCatEdit-Add").modal('hide');
                                tableCategorias.ajax.reload();
                            });
                        } else if (opcion == "update") {
                            swal({
                                title: "Exito !",
                                text: "Categoria Actualizada Exitosamente !!",
                                icon: "success"
                            }).then(function () {
                                //window.location = urlIndex + '/view/Insumos';
                                $("#modalCatEdit-Add").modal('hide');
                                tableCategorias.ajax.reload();
                                tableInsumos.ajax.reload();
                            });
                        }
                    } else {
                        swal('Oops...', data, 'error');
                        $("#nombreCat").val("");
                    }
                }
            });
        }
    });

    /*funciones principales del modulo "Insumos"*/

    $("#buttonAddInsumo").click(function () {
        vaciarCampos();
        $(".titleFormIns").text("Agregar Nuevo Insumo");
        $("#opcionIns").val("create");
        $(".btnInsumo").text("Agregar");
        $("#modalInsumoForm").modal('show');
    });

    $(".form-insumo").submit(function (e) {
        e.preventDefault();
        let nombre = $('#nombre').val();
        let cantidad = $('#cantidad').val();
        let idInsu = $("#idInsu").val();
        let opcion = $("#opcionIns").val();
        let categoria = $('select#cat option:selected').val();
        let descripcion = $('#descripcion').val();
        let precio = $('#precio').val();
        let validarNum = /^([0-9])*$/;
        let precioT = "";
        let mensaje = "";
        let error = false;
        if (cantidad < 1) {
            mensaje = "Debe ingresar una cantidad.";
            error = true;
        } else if (nombre == "") {
            mensaje = "Debe ingresar un nombre";
            error = true;
        } else if (descripcion == "") {
            mensaje = "Debe ingresar una descripcion";
            error = true;
        } else if (categoria < 1) {
            mensaje = "Debe ingresar una categoria para el insumo";
            error = true;
        } else if (precio < 1) {
            mensaje = "Debe ingresar un precio";
            error = true;
        } else if (!validarNum.test(precio)) {
            mensaje = "El precio ingresado no es valido";
            error = true;
        } else if (!validarNum.test(cantidad)) {
            mensaje = "El precio ingresado no es valido";
            error = true;
        } else {
            precioT = cantidad * precio;
        }

        if (error == true) {
            swal('Oops...', mensaje, 'error');
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "../../controladores/InsumoController.php?funcion=" + opcion,
                data: {idInsumo: idInsu, nombre: nombre, cantidad: cantidad, idCategoria: categoria, descripcion: descripcion, precio: precio, precioT: precioT},
                success: function (data) {
                    if (data == 1) {
                        if (opcion == "create") {
                            swal({
                                title: "Exito !",
                                text: "Insumo Agregado Exitosamente !!",
                                icon: "success"
                            }).then(function () {
                                //window.location = urlIndex + '/view/Insumos';
                                $("#modalInsumoForm").modal('hide');
                                tableInsumos.ajax.reload();
                            });
                        } else if (opcion == "update") {
                            swal({
                                title: "Exito !",
                                text: "Insumo Actualizado Exitosamente !!",
                                icon: "success"
                            }).then(function () {
                                //window.location = urlIndex + '/view/Insumos';
                                $("#modalInsumoForm").modal('hide');
                                tableInsumos.ajax.reload();
                            });
                        }
                    } else {
                        swal('Error...', data, 'error');
                        $('#nombre').val("");
                    }
                }
            });
        }
    });

    $("#form-insumo-cantidadIn").submit(function (e) {
        e.preventDefault();
        let idInsu = $('#idInsumo').val();
        let cantidad = $('#cantidadIn').val();
        let precio = $('#precioIn').val();
        let precioT = "";
        let error = false;
        let validarNum = /^([0-9])*$/;
        let mensaje = "";
        if (idInsu < 1) {
            mensaje = "El insumo no esta identificado";
            error = true;
        } else if (cantidad < 1) {
            mensaje = "La cantidad no puede ser menor a 1";
            error = true;
        } else if (!validarNum.test(precio)) {
            mensaje = "El precio ingresado no es valida !!";
            error = true;
        } else if (!validarNum.test(cantidad)) {
            mensaje = "La cantidad ingresada no es valida !!";
            error = true;
        } else {
            precioT = cantidad * precio;
        }

        if (error == true) {
            swal('Oops...', mensaje, 'error');
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "../../controladores/InsumoController.php?funcion=updateCant",
                data: {cantidad: cantidad, idInsumo: idInsu, precioT: precioT},
                success: function (data) {
                    if (data) {
                        swal({
                            title: "Exito !",
                            text: "Cantidad Actualizada Exitosamente !!",
                            icon: "success"
                        }).then(function () {
                            //window.location = urlIndex + '/view/Insumos';
                            tableInsumos.ajax.reload();
                            $("#modalInsumoCantidad").modal('hide');
                        });
                    }
                }
            });
        }

    });

    $("#btnExportar").click(function () {
        $.post("../../controladores/InsumoController.php?funcion=list",
                function (response) {
                    var fecha = new Date();
                    var insumo = JSON.parse(response);
                    //console.log(insumo);
                    //let estado = "";
                    var pdf = new jsPDF();
                    pdf.text(20, 20, "Reportes de los Insumo");
                    var data = [];
                    var columns = ["Nombre", "Cantidad", "Precio", "Total-Precio", "Descripcion", "Categoria", "Estado"];
                    for (let i = 0; i < insumo.length; i++) {
                        data[i] = [insumo[i].NombreInsumo, insumo[i].CantidadInsumo, "$" + insumo[i].PrecioUnitarioInsumo,
                            "$" + insumo[i].PrecioTotalInsumo, insumo[i].DescripcionInsumo, insumo[i].Categoria, insumo[i].EstadoInsumo];
                    }
                    pdf.autoTable(columns, data,
                            {margin: {top: 40}}
                    );
                    pdf.text(20, 190, "Fecha de Creacion : " + fecha.getDate() + "/" + (fecha.getMonth() + 1) + "/" + fecha.getFullYear());
                    pdf.save('ReporteInsumo.pdf');
                    swal('Exito', "Reporte Imprimido Exitosamente..", 'success');
                }
        );
    });
});

function vaciarCampos() {
    $(".form-insumo")[0].reset();
    $("#cat").val("0");
    $(".formCantInsumo").show();
    $.ajax({
        type: 'POST',
        url: "../../controladores/CategoriaController.php?funcion=listCategorias",
        success: function (data) {
            $('.selectCategoria select').html(data).fadeIn();
        }
    });
}

/*Funciones referente al modulo "Insumo"*/

function cargarInsumos() {
    tableInsumos = $('#tableInsumo').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": "../../controladores/InsumoController.php?funcion=list",
            "dataSrc": ""
        },
        "columns": [
            {"data": "NombreInsumo"},
            {"data": "PrecioUnitarioInsumo"},
            {"data": "CantidadInsumo"},
            {"data": "PrecioTotalInsumo"},
            {"data": "Categoria"},
            {"data": "EstadoInsumo"},
            {"data": "options"}
        ],

        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "asc"]]
    });
}

function buscarInsumoEdit(idInsumo) {
    $(".titleFormIns").text("Actualizar Insumo");
    $("#opcionIns").val("update");
    $(".formCantInsumo").hide();
    $.post("../../controladores/InsumoController.php?funcion=search",
            {idInsumo: idInsumo},
            function (response) {
                var insumo = JSON.parse(response);
                $("#idInsu").val(insumo["idInsumo"]);
                $('#nombre').val(insumo["NombreInsumo"]);
                $("#precio").val(insumo["PrecioUnitarioInsumo"]);
                $("#cantidad").val(insumo["CantidadInsumo"]);
                $("#cat").val(insumo["CategoriaInsumo"]);
                $("#descripcion").val(insumo["DescripcionInsumo"]);
            }
    );
    $(".btnInsumo").text("Actualizar");
    $("#modalInsumoForm").modal('show');
}

function buscarInsumoCant(idInsumo) {
    $.post("../../controladores/InsumoController.php?funcion=search",
            {idInsumo: idInsumo},
            function (response) {
                var insumo = JSON.parse(response);
                //console.log(insumo);
                $('#idInsumo').val(insumo["idInsumo"]);
                $('#nombreIn').val(insumo["NombreInsumo"]);
                $('#cantidadIn').val(insumo["CantidadInsumo"]);
                $('#precioIn').val(insumo["PrecioUnitarioInsumo"]);
            }
    );
}

function buscarInsumoEliminar(idInsumo) {
    swal({
        title: "Inhabilitar Insumo",
        text: "¿Realmente desea Inhabilitar a este Insumo?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            $.ajax({
                type: "POST",
                url: urlIndex + "/controladores/InsumoController.php?funcion=delete",
                data: {idInsumo: idInsumo},
                success: function (data) {
                    if (data) {
                        swal({
                            title: "Exito !",
                            text: "Insumo Inhabilitado Exitosamente !!",
                            icon: "success"
                        }).then(function () {
                            //window.location = urlIndex + "/view/Insumos";
                            tableInsumos.ajax.reload();
                        });
                    }
                }
            });
        }
    });
}

function InsumoActivar(idInsumo) {
    swal({
        title: "Activar Insumo",
        text: "¿Realmente desea Activar a este Insumo?",
        icon: "info",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            $.ajax({
                type: "POST",
                url: urlIndex + "/controladores/InsumoController.php?funcion=activate",
                data: {idInsumo: idInsumo},
                success: function (data) {
                    if (data) {
                        swal({
                            title: "Exito !",
                            text: "Insumo Activado Exitosamente !!",
                            icon: "success"
                        }).then(function () {
                            //window.location = urlIndex + "/view/Insumos";
                            tableInsumos.ajax.reload();
                        });
                    }
                }
            });
        }
    });
}

/*Funciones referente al modulo "Categorias"*/

function cargarCategorias() {
    tableCategorias = $('#tableCategorias').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "lengthChange": false,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": "../../controladores/CategoriaController.php?funcion=listCat",
            "dataSrc": ""
        },
        "columns": [
            {"data": "NombreCategoria"},
            {"data": "DescripcionCategoria"},
            {"data": "EstadoCategoria"},
            {"data": "options"}
        ],

        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 3,
        "order": [[0, "asc"]]
    });

}

function buscarCategoria(idCat) {
    $("#titleAdd").text("Editar Categoria");
    $("#opcion").val("editCat");
    $.post("../../controladores/CategoriaController.php?funcion=search",
            {idCategoria: idCat},
            function (response) {
                let categoria = JSON.parse(response);
                $("#nombreCat").val(categoria["NombreCategoria"]);
                $("#descripcionCat").val(categoria["DescripcionCategoria"]);
                $("#idcat").val(categoria["idCategoria"]);
            }
    );
    $(".btnCategoria").text("Actualizar");
    $("#modalCatEdit-Add").modal('show');
}

function EliminarCategoria(idCat) {
    swal({
        title: "Inhabilitar Categoria",
        text: "¿Realmente desea Inhabilitar a esta Categoria..?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            $.ajax({
                type: "POST",
                url: urlIndex + "/controladores/CategoriaController.php?funcion=delete",
                data: {idCategoria: idCat},
                success: function (data) {
                    if (data == 1) {
                        swal({
                            title: "Exito !",
                            text: "Categoria Inhabilitada Exitosamente !!",
                            icon: "success"
                        }).then(function () {
                            //window.location = urlIndex + "/view/Insumos";
                            tableInsumos.ajax.reload();
                            tableCategorias.ajax.reload();
                        });
                    } else {
                        swal('Error...', data, 'error');
                    }
                }
            });
        }
    });
}

function ActivarCategoria(idCat) {
    swal({
        title: "Activar Categoria",
        text: "¿Realmente desea Activar a esta Categoria?",
        icon: "info",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            $.ajax({
                type: "POST",
                url: urlIndex + "/controladores/CategoriaController.php?funcion=activate",
                data: {idCategoria: idCat},
                success: function (data) {
                    if (data) {
                        swal({
                            title: "Exito !",
                            text: "Categoria Activada Exitosamente !!",
                            icon: "success"
                        }).then(function () {
                            //window.location = urlIndex + "/view/Insumos";
                            tableInsumos.ajax.reload();
                            tableCategorias.ajax.reload();
                        });
                    }
                }
            });
        }
    });
}



