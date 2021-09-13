var save_methodmda; //for save method string
var table_mda;
$(function() {
    table_mda = $('#tablamda').DataTable({
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "loadingRecords": "Cargando...",
        "ajax": {
            "url": "Appvilla/Appvilla_moneda_control/ajax_list",
            "type": "POST",
            "dataType": "JSON",
        },

        "columnDefs": [{
            "targets": [-1],
            "orderable": false,
        }, ],
    });

});

function add_mda() {
    save_methodmda = 'add';
    $('#formmda')[0].reset();
    $('#modal_formmda').modal('show');
    $('.modal-title').text('Agregar Monedas');
}

function edit_mda(id) {
    save_methodmda = 'update';
    $('#formmda')[0].reset();
    $.ajax({
        url: "Appvilla/Appvilla_moneda_control/ajax_edit/" + id,
        type: "GET",
        dataType: "JSON",
        beforeSend: function() {
            loadshowmodal();
        },
        success: function(data) {
            loadhidenmodal();
            if (data.status === true) {
                var dat = data.info;
                $('[name="id"]').val(dat.id);
                $('[name="nommda"]').val(dat.nombre);
                $('[name="sglamda"]').val(dat.sigla);
                $('[name="codimda"]').val(dat.codigo);
                $('#modal_formmda').modal('show');
                $('#modal_formmda .modal-title').text('Editar Moneda');
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

function reload_table_mda() {
    table_mda.ajax.reload(null, false);
}

function savemda() {
    var url;
    if (save_methodmda == 'add') {
        url = "Appvilla/Appvilla_moneda_control/ajax_add";
    } else {
        url = "Appvilla/Appvilla_moneda_control/ajax_update";
    }
    $.ajax({
        url: url,
        type: "POST",
        data: $('#formmda').serialize(),
        dataType: "JSON",
        beforeSend: function() {
            loadshowmodal();
        },
        success: function(data) {
            loadhidenmodal();
            if (data.status === true) {
                $('#modal_formmda').modal('hide');
                reload_table_mda();
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Mensaje :' + data.info,
                    showConfirmButton: false,
                    timer: 2000
                });

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

function delete_mda(id) {
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
                url: "Appvilla/Appvilla_moneda_control/ajax_delete",
                type: "POST",
                data: { id: id },
                dataType: "JSON",
                beforeSend: function() {
                    loadshowmodal();
                },
                success: function(data) {
                    loadhidenmodal();
                    if (data.status === true) {
                        reload_table_mda();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Dato Eliminado :' + data.status,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#modal_formmda').modal('hide');
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