var save_method; //for save method string
var table;
$(function() {
    table = $('#tablaTipoIden').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "Appvilla/Appvilla_maestrobase_control/ajax_listti",
            "type": "POST"
        },
        "columnDefs": [{
            "targets": [-1],
            "orderable": false,
        }, ],
    });
});

function add_tipoiden() {
    save_method = 'add';
    $('#formti')[0].reset();
    $('#modal_formti').modal('show');
    $('.modal-title').text('Agregar Tipo de Identificacion');
}

function edit_tipoiden(id) {
    save_method = 'update';
    $('#formti')[0].reset();

    $.ajax({
        url: "Appvilla/Appvilla_maestrobase_control/ajax_editti/" + id,
        type: "GET",
        dataType: "JSON",
        beforeSend: function() {
            loadshowmodal();
        },
        success: function(data) {
            loadhidenmodal();
            if (data.status === true) {
                var dat = data.info;
                $('[name="idti"]').val(dat.id);
                $('[name="codeti"]').val(dat.codigo);
                $('[name="siglati"]').val(dat.sigla);
                $('[name="nomti"]').val(dat.nombre);
                $('#modal_formti').modal('show');
                $('#modal_formti .modal-title').text('Editar Tipo de Identificacion');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error en Optencio de datos',
                    text: 'Datos por optener ... :',
                    html: data.info,
                });
            }
        },
        error: function(xhr, textStatus, errorThrown) {
            loadhidenmodal();
            var msgerr = "<p>" + xhr + " :: " + textStatus + " :: " + errorThrown + ' ' + xhr + ' ' + xhr.statusText + ' ' + xhr.responseText + ' Codigohtp:' + xhr.status + "</p>";
            Swal.fire({
                icon: 'error',
                title: 'Error en Optencio de datos',
                text: 'Datos por optener ... :' + textStatus,
                html: msgerr,
            });
        }
    });
}

function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax
}

function saveti() {
    var url;
    if (save_method == 'add') {
        url = "Appvilla/Appvilla_maestrobase_control/ajax_addti";
    } else {
        url = "Appvilla/Appvilla_maestrobase_control/ajax_updateti";
    }

    $.ajax({
        url: url,
        type: "POST",
        data: $('#formti').serialize(),
        dataType: "JSON",
        beforeSend: function() {
            loadshowmodal();
        },
        success: function(data) {
            loadhidenmodal();
            if (data.status === true) {
                $('#modal_formti').modal('hide');
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Mensaje :' + data.info,
                    showConfirmButton: false,
                    timer: 2000
                });
                reload_table();
            } else {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                Toast.fire({
                    icon: 'error',
                    title: data.info
                });

            }
        },
        error: function(xhr, textStatus, errorThrown) {
            loadhidenmodal();
            var msgerr = "<p>" + xhr + " :: " + textStatus + " :: " + errorThrown + ' ' + xhr + ' ' + xhr.statusText + ' ' + xhr.responseText + ' Codigohtp:' + xhr.status + "</p>";
            Swal.fire({
                icon: 'error',
                title: 'Error en procesar de datos',
                text: 'Los datos Ingresados ... :' + textStatus,
                html: msgerr,
            });
        }
    });
}

function delete_tipoiden(id) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Esta Seguro de Eliminar Este Dato?',
        text: "No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Eliminar!',
        cancelButtonText: 'No, cancelar!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "Appvilla/Appvilla_maestrobase_control/ajax_deleteti",
                type: "POST",
                data: { id: id },
                dataType: "JSON",
                beforeSend: function() {
                    loadshowmodal();
                },
                success: function(data) {
                    loadhidenmodal();
                    if (data.status === true) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Dato Eliminado :' + data.status,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#modal_formti').modal('hide');
                        reload_table();
                    } else {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });
                        Toast.fire({
                            icon: 'error',
                            title: data.info
                        });
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    loadhidenmodal();
                    var msgerr = "<p>" + xhr + " :: " + textStatus + " :: " + errorThrown + ' ' + xhr + ' ' + xhr.statusText + ' ' + xhr.responseText + ' Codigohtp:' + xhr.status + "</p>";
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en proceso de eliminacion de dato',
                        text: 'Dato a Eliminar ... :' + textStatus,
                        html: msgerr,
                    });
                }
            });

        } else if (
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'Cancelado',
                'No se procedio a eliminar el dato :)',
                'error'
            )
        }
    })

}