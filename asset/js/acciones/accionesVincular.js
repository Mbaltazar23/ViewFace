let tableVinculos;
$(document).ready(function () {
    cargarVinculos();
    $.ajax({
        type: 'POST',
        url: "../../controladores/ClienteController.php?funcion=listNegocios",
        success: function (data) {
            $('.selectNegocios select').html(data).fadeIn();
        }
    });
    $("#form-cliente-vinculo").submit(function (e) {
        e.preventDefault();
        let CargoCli = 0;
        let nombre = $('#nombre').val();
        let idVinculo = $('#idVincular').val();
        let idCargo = $('select#negocioTipo option:selected').val();
        let tipoNegocio = $('input[name="opcionNegocio"]').val();
        let correo = $('#correo').val();
        let clave = $('#clave').val();
        let telefono = $('#telefono').val();
        let idPer = $('#idper').val();
        let descripCargo = $("#descripcionCargo").val();
        var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
        var regulTele = /^(\+?56)?(\s?)(0?9)(\s?)[9876543]\d{7}$/;
        let mensaje = "";
        let error = false;
        if (nombre == "") {
            mensaje = "Debe ingresar un nombre";
            error = true;
        } else if (!regex.test(correo.trim())) {
            mensaje = "Debe ingresar un correo valido";
            error = true;
        } else if (clave == "") {
            mensaje = "Debe estar una clave ingresada";
            error = true;
        } else if (telefono == "") {
            mensaje = "Debe dejar un numero Telefonocico";
            error = true;
        } else if (!regulTele.test(telefono.trim())) {
            mensaje = "El Telefono ingresado no es Valido";
            error = true;
        } else if (idPer < 1) {
            mensaje = "el cargo esta nulo";
            error = true;
        } else if (tipoNegocio == 1) {
            CargoCli = idCargo;
        }else{
            CargoCli = "";
        }
        if (error == true) {
            swal('Oops...', mensaje, 'error');
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "../../controladores/ClienteController.php?funcion=create",
                data: {idNegocio: CargoCli, idVinculo: idVinculo, nombre: nombre, clave: clave, telefono: telefono, idPersonal: idPer, DescCargo: descripCargo},
                success: function (data) {
                    if (data) {
                        swal({
                            title: "Exito !",
                            text: "Cliente Vinculado Exitosamente !!",
                            icon: "success"
                        }).then(function () {
                            window.location = urlIndex + '/view/Vinculaciones';
                        });
                    }
                }
            });
        }
    });

});

function buscarVinculo(idVincular) {
    $.post("../../controladores/VinculoController.php?funcion=search",
            {idVincular: idVincular},
            function (response) {
                var data = JSON.parse(response);
                $('#idVincular').val(data["idVinculacion"]);
                $('#correo').val(data["correoVinculo"]);
                $('#clave').val(data["claveVinculo"]);
                $("#telefono").val(data["telefonoVinculo"]);
                $("#nombre").val(data["nombreVinculo"]);
                validarCheckNegocio();
            }
    );
}

function validarCheckNegocio() {
    if ($('input:radio[name="opcionNegocio"]:checked').val() === '1') {
        $('input:radio[name="opcionNegocio"]').filter('[value="1"]').prop('checked', false);
        $('input:radio[name="opcionNegocio"]').filter('[value="2"]').prop('checked', true);
        $("#comboNegocio").hide();
        $("#DescribCargo").hide();
        $("#negocioTipo").val("0");
    } else if ($('input:radio[name="opcionNegocio"]:checked').val() === '2') {
        $("#comboNegocio").hide();
        $("#DescribCargo").hide();
    } else {
        $("#comboNegocio").hide();
        $("#DescribCargo").hide();
    }
}

function eliminarVinculo(idVin) {
    let idVinculo = idVin;
    swal({
        title: "Eliminar Vinculo",
        text: "¿Realmente desea Eliminar a este Vinculo?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            $.ajax({
                type: "POST",
                url: urlIndex + "/controladores/VinculoController.php?funcion=delete",
                data: {idVincular: idVinculo},
                success: function (data) {
                    if (data) {
                        swal({
                            title: "Exito !",
                            text: "Vinculacion Eliminada Exitosamente !!",
                            icon: "success"
                        }).then(function () {
                            window.location = urlIndex + "/view/Vinculaciones";
                        });
                    }
                }
            });
        }
    });
}

function cargarVinculos() {
    tableVinculos = $('#TableVinculos').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": "../../controladores/VinculoController.php?funcion=listVinculos",
            "dataSrc": ""
        },
        "columns": [
            {"data": "correoVinculo"},
            {"data": "fechaVinculo"},
            {"data": "horaVinculo"},
            {"data": "EstadoVinculo"},
            {"data": "options"}
        ],

        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "asc"]]
    });
}

function cargarNegocio(opcion) {
    if (opcion == 1) {
        $("#comboNegocio").show();
        $("#DescribCargo").show();
    } else if (opcion == 2) {
        $("#comboNegocio").hide();
        $("#DescribCargo").hide();
    }
}