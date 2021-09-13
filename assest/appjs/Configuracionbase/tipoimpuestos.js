var save_method; //for save method string
var table;
$(function() {
    table = $('#tabla_tpoimp').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "Appvilla/Appvilla_tipoimpuestos_control/ajax_list",
            "type": "POST",
        },
        "columnDefs": [{
            "targets": [-1],
            "orderable": false,
        }, ],
    });
});

function add_tpoimp() {
    save_method = 'add';
    $('#form_tpoimp')[0].reset();
    $('#modal_form_tpoimp').modal('show');
    $('.modal-title').text('Agregar Tipo de Impuestos');
}

function edit_tpoimp(id) {
    save_method = 'update';
    $('#form_tpoimp')[0].reset();

    $.ajax({
        url: "Appvilla/Appvilla_tipoimpuestos_control/ajax_edit/" + id,
        type: "GET",
        dataType: "JSON",
        beforeSend: function() {
            loadshowmodal();
        },
        success: function(data) {
            loadhidenmodal();
            if (data.status === true) {
                var dat = data.info;
                $('[name="idtim"]').val(dat.id);
                $('[name="codetim"]').val(dat.codigo);
                $('[name="siglatim"]').val(dat.sigla);
                $('[name="nomtim"]').val(dat.nombre);
                $('#modal_form_tpoimp').modal('show');
                $('#modal_form_tpoimp .modal-title').text('Editar Tipo de Impuestos');
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

function save_tpoimp() {
    var url;
    if (save_method == 'add') {
        url = "Appvilla/Appvilla_tipoimpuestos_control/ajax_add";
    } else {
        url = "Appvilla/Appvilla_tipoimpuestos_control/ajax_update";
    }

    $.ajax({
        url: url,
        type: "POST",
        data: $('#form_tpoimp').serialize(),
        dataType: "JSON",
        beforeSend: function() {
            loadshowmodal();
        },
        success: function(data) {
            loadhidenmodal();
            if (data.status === true) {
                $('#modal_form_tpoimp').modal('hide');
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

function delete_tpoimp(id) {
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
                url: "Appvilla/Appvilla_tipoimpuestos_control/ajax_delete",
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
                        $('#modal_form_tpoimp').modal('hide');
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