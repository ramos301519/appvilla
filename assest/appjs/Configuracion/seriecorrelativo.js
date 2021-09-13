var save_method_srco; //for save method string
var table_srco;
$(function() {
    table_srco = $('#tabla_srco').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "Configuracion/Seriecorrelativos_control/ajax_list",
            "type": "POST"
        },
        "columnDefs": [{
            "targets": [-1],
            "orderable": false,
        }, ],
    });
    

});

function add_srco() {
    save_method_srco = 'add';
    get_all_tipocomprobante();
    $('#form_srco')[0].reset();
    $('#modal_form_srco').modal('show');
    $('.modal-title').text('Agregar Serie y correlativo');
}

function edit_srco(id) {
    save_method_srco = 'update';
    $('#form_srco')[0].reset();

    $.ajax({
        url: "Configuracion/Seriecorrelativos_control/ajax_edit/" + id,
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
                $("#typevoucher_srco").val(dat.tipocomprobante_id);
                $("#typevoucher_srco option").attr("selected", "selected");
                $("#ser_srco").val(dat.serie);
                $("#digit_srco").val(dat.number_digit);
                $("#start_srco").val(dat.ser_inicia);
                $("#last_srco").val(dat.ser_actual);
                $("#next_srco").val(dat.next_number);
                $('#modal_form_srco').modal('show');
                $('#modal_form_srco .modal-title').text('Editar Serie y correlativo');
                get_all_tipocomprobante();
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

function reload_table_srco() {
    table_srco.ajax.reload(null, false);
}

function save_srco() { 
    var url;
    if (save_method_srco == 'add') {
        url = "Configuracion/Seriecorrelativos_control/ajax_add";
    } else {
        url = "Configuracion/Seriecorrelativos_control/ajax_update";
    }
  
    $.ajax({
        url: url,
        type: "POST",
        data: $('#form_srco').serialize(),
        dataType: "JSON",
        beforeSend: function() {
            loadshowmodal();
        },
        success: function(data) {
            loadhidenmodal();
            if (data.status === true) {
                $('#modal_form_srco').modal('hide');
                reload_table_srco();
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

function delete_srco(id) {
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
                url: "Configuracion/Seriecorrelativos_control/ajax_delete",
                type: "POST",
                data: { id: id },
                dataType: "JSON",
                beforeSend: function() {
                    loadshowmodal();
                },
                success: function(data) {
                    loadhidenmodal();
                    if (data.status === true) {
                        reload_table_srco();
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


function get_all_tipocomprobante() {
    $.ajax({
        type: 'POST',
        url: 'Configuracion/Seriecorrelativos_control/ajax_all_tipocomprobante',
        dataType: 'json',
        data: { data: '0' },
        success: function(json) {
            var str = '<option value="">--Seleccione--</option>';
            if (json.status === true) {
                cad = json.info;
                num = cad.length;
                for (e = 0; e < num; e++) {
                    dat = cad[e];
                    colpac = dat['codigo'];
                    colpad = dat['nombre'];
                    str += '<option value="' + colpac + '">' + colpad + '</option>';
                }
            } else {
                str += '<option value="">No hay resultados</option>';
            }
            
            $('#typevoucher_srco').html(str);

        },
        error: function(jqXHR, xhr, textStatus, errorThrown) {
            var msgerror = textStatus + ' ' + errorThrown + ' ' + jqXHR + ' ' + xhr + ' ' + xhr.statusText + ' ' + xhr.responseText + ' ' + xhr.status;
            $('#typevoucher_srco').html(msgerror);
        }
    });
}

function get_exist_srco() {
   let tipcomp_id= $("#typevoucher_srco").val();
   let ser=$("#ser_srco").val();
    var dato={tcomp_id:tipcomp_id,serie:ser};
    $.ajax({
        url: "Configuracion/Seriecorrelativos_control/get_serco_exist",
        type: "POST",
        dataType: "JSON",
        data:{dat:dato},
        beforeSend: function() {
            loadshowmodal();
        },
        success: function(data) {
            loadhidenmodal();
            if (data.status === true) {

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
                    title: 'Ya existe la serie'
                });
               
                $('#btnSave_tcmb').attr('disabled','disabled');
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
                    icon: 'success',
                    title: data.info
                });
                $('#btnSave_tcmb').removeAttr('disabled');

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



