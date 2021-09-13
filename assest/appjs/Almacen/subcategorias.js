var save_method; //for save method string
var table;
$(function() {
    table = $('#tablasbctg').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "Almacen/Subcategoria_control/ajax_list",
            "type": "POST"
        },
        "columnDefs": [{
            "targets": [-1],
            "orderable": false,
        }, ],
    });
    get_show_tables();
});

function get_show_tables() {
    get_listacategorias();
}

function get_listacategorias() {
    $.ajax({
        type: 'POST',
        url: 'Almacen/Categoria_control/categ_ajax_all',
        dataType: 'json',
        beforeSend: function() {
            loadshowmodal();
        },
        success: function(data) {
            loadhidenmodal();
            if (data.status === true) {
                var dat = data.info;
                var lista = dat.lista;
                var str = "";
                if (lista != 0) {
                    cad = lista.split('&&&');
                    num = cad.length;
                    for (e = 0; e < num; e++) {
                        dat = cad[e].split('#$#');
                        id = dat[0];
                        nombre = dat[1];
                        str += '<option value="' + id + '">' + nombre + '</option>';
                    }
                } else {
                    str += '<option value="">No hay resultados</option>';
                }
                $('#selctg').html(str);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error en Optencio de datos Categoria',
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

function add_sbctg() {
    save_method = 'add';
    $('#form')[0].reset();
    $('#modal_form').modal('show');
    $('.modal-title').text('Agregar Sub categoria');
}

function edit_sbctg(id) {
    save_method = 'update';
    $('#form')[0].reset();

    $.ajax({
        url: "Almacen/Subcategoria_control/ajax_edit/" + id,
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
                $('[name="selctg"]').val(dat.categoria_id);
                $('[name="nomsbctg"]').val(dat.nombre);
                $('[name="descsbctg"]').val(dat.descripcion);
                $('#modal_form').modal('show');
                $('#modal_form .modal-title').text('Editar Sub categoria');
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
    table.ajax.reload(null, false);
}

function save() {
    var url;
    if (save_method == 'add') {
        url = "Almacen/Subcategoria_control/ajax_add";
    } else {
        url = "Almacen/Subcategoria_control/ajax_update";
    }

    $.ajax({
        url: url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        beforeSend: function() {
            loadshowmodal();
        },
        success: function(data) {
            loadhidenmodal();
            if (data.status === true) {
                $('#modal_form').modal('hide');
                reload_table();
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

function delete_sbctg(id) {
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
                url: "Almacen/Subcategoria_control/ajax_delete",
                type: "POST",
                data: { id: id },
                dataType: "JSON",
                beforeSend: function() {
                    loadshowmodal();
                },
                success: function(data) {
                    loadhidenmodal();
                    if (data.status === true) {
                        reload_table();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Dato Eliminado :' + data.status,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#modal_formmp').modal('hide');
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