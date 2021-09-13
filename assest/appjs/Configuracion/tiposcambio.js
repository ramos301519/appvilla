var save_method_tcmb; //for save method string
var table_tcmb;
$(function() {
    table_tcmb = $('#tabla_tcmb').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "Configuracion/Tiposcambio_control/ajax_list",
            "type": "POST"
        },
        "columnDefs": [{
            "targets": [-1],
            "orderable": false,
        }, ],
    });
});

function add_tcmb() {
    save_method_tcmb = 'add';
    get_all_moneda();
    $('#form_tcmb')[0].reset();
    let fa=fechaactual;
    $('#fecha_tcmb').val(fa);
    $('#modal_form_tcmb').modal('show');
    $('.modal-title').text('Agregar Tipo de cambio');
}

function edit_tcmb(id) {
    save_method_tcmb = 'update';
    $('#form_tcmb')[0].reset();

    $.ajax({
        url: "Configuracion/Tiposcambio_control/ajax_edit/" + id,
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
                $("#moneda_tcmb").val(dat.moneda_id);
                $("#fecha_tcmb").val(dat.fechatc);
                $("#venta_tcmb").val(dat.venta);
                $("#compra_tcmb").val(dat.compra);
                $('#modal_form_tcmb').modal('show');
                $('#modal_form_tcmb .modal-title').text('Editar tipo de cambio');
                get_all_moneda();
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

function reload_table_tcmb() {
    table_tcmb.ajax.reload(null, false);
}

function save_tcmb() { 
    var url;
    if (save_method_tcmb == 'add') {
        url = "Configuracion/Tiposcambio_control/ajax_add";
    } else {
        url = "Configuracion/Tiposcambio_control/ajax_update";
    }
  
    $.ajax({
        url: url,
        type: "POST",
        data: $('#form_tcmb').serialize(),
        dataType: "JSON",
        beforeSend: function() {
            loadshowmodal();
        },
        success: function(data) {
            loadhidenmodal();
            if (data.status === true) {
                $('#modal_form_tcmb').modal('hide');
                reload_table_tcmb();
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

function delete_tcmb(id) {
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
                url: "Configuracion/Tiposcambio_control/ajax_delete",
                type: "POST",
                data: { id: id },
                dataType: "JSON",
                beforeSend: function() {
                    loadshowmodal();
                },
                success: function(data) {
                    loadhidenmodal();
                    if (data.status === true) {
                        reload_table_tcmb();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Dato Eliminado :' + data.info,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#modal_form_tcmb').modal('hide');
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


function get_all_moneda() {
    $.ajax({
        type: 'POST',
        url: 'Configuracion/Tiposcambio_control/ajax_all_monedas',
        dataType: 'json',
        data: { data: '0' },
        success: function(json) {
            var str = '<option value="">--Seleccione--</option>';
            if (json.status === true) {
                cad = json.info;
                num = cad.length;
                for (e = 0; e < num; e++) {
                    dat = cad[e];
                    colpac = dat['id'];
                    colpad = dat['codigo'].toUpperCase()+' '+dat['nombre'];
                    str += '<option value="' + colpac + '">' + colpad + '</option>';
                }
            } else {
                str += '<option value="">No hay resultados</option>';
            }
            
            $('#moneda_tcmb').html(str);

        },
        error: function(jqXHR, xhr, textStatus, errorThrown) {
            var msgerror = textStatus + ' ' + errorThrown + ' ' + jqXHR + ' ' + xhr + ' ' + xhr.statusText + ' ' + xhr.responseText + ' ' + xhr.status;
            $('#moneda_tcmb').html(msgerror);
        }
    });
}