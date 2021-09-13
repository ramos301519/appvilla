var save_method_imp; //for save method string
var table_imp;
$(function() {
    table_imp = $('#tabla_imp').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "Configuracion/Impuestos_control/ajax_list",
            "type": "POST"
        },
        "columnDefs": [{
            "targets": [-1],
            "orderable": false,
        }, ],
    });

   
    

});

function add_imp() {
    save_method_imp = 'add';
    $('#form_imp')[0].reset();
    let fa=fechaactual;
    $('#impfeact').val(fa);
    $('#modal_form_imp').modal('show');
    $('.modal-title').text('Agregar Impuestos ');
       
    get_tipoimpuesto();
}

function edit_imp(id) {
    save_method_imp = 'update';
    $('#form_imp')[0].reset();
    $.ajax({
        url: "Configuracion/Impuestos_control/ajax_edit/" + id,
        type: "GET",
        dataType: "JSON",
        beforeSend: function() {
            loadshowmodal();
        },
        success: function(data) {
            loadhidenmodal();
            if (data.status === true) {
                var dat = data.info;
                get_tipoimpuesto(); 
                     
                $("#idimp").val(dat.id); 
                $("#tipoimpuesto").val(dat.tipoimpuesto_id); 
                $("#tipoimpuesto option").attr("selected", "selected");
                $("#cate_imp").val(dat.categoria_impuesto_id);
                $("#cate_imp option").attr("selected", "selected");
                $("#porcimp").val(dat.impuesto);
                $("#impfeact").val(dat.fecha_at);
                $('#modal_form_imp').modal('show');
                $('#modal_form_imp .modal-title').text('Editar Impuesto '+dat.id+" "+dat.tipoimpuesto_id+" "+dat.categoria_impuesto_id);
                get_tipoimpuesto_categoria(dat.tipoimpuesto_id); 
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

function reload_table_imp() {
    table_imp.ajax.reload(null, false);
}

function save_imp() { 
    var url;
    if (save_method_imp == 'add') {
        url = "Configuracion/Impuestos_control/ajax_add";
    } else {
        url = "Configuracion/Impuestos_control/ajax_update";
    }
   
    $.ajax({
        url: url,
        type: "POST",
        data: $('#form_imp').serialize(),
        dataType: "JSON",
        beforeSend: function() {
            loadshowmodal();
        },
        success: function(data) {
            loadhidenmodal();
            if (data.status === true) {
                $('#modal_form_imp').modal('hide');
                reload_table_imp();
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

function delete_imp(id) {
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
                url: "Configuracion/Impuestos_control/ajax_delete",
                type: "POST",
                data: { id: id },
                dataType: "JSON",
                beforeSend: function() {
                    loadshowmodal();
                },
                success: function(data) {
                    loadhidenmodal();
                    if (data.status === true) {
                        reload_table_imp();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Dato Eliminado :' + data.info,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#modal_form_imp').modal('hide');
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
function get_tipoimpuesto() {
    $.ajax({
        type: 'POST',
        url: 'Configuracion/Impuestos_control/ajax_all_tim',
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
                    colpad = dat['sigla'].toUpperCase()+' '+dat['nombre'];
                    str += '<option value="' + colpac + '">' + colpad + '</option>';
                }
            } else {
                str += '<option value="">No hay resultados</option>';
            }
            
            $('#tipoimpuesto').html(str);

        },
        error: function(jqXHR, xhr, textStatus, errorThrown) {
            var msgerror = textStatus + ' ' + errorThrown + ' ' + jqXHR + ' ' + xhr + ' ' + xhr.statusText + ' ' + xhr.responseText + ' ' + xhr.status;
            $('#tipoimpuesto').html(msgerror);
        }
    });
}

function get_tipoimpuesto_categoria(id_timp) {
    var str="";
    if(id_timp!="2"){
        str = '<option value="">Sin categoria</option>'; 
    $('#cate_imp').html(str);
    $('#cate_imp').attr('readonly', 'readonly');
    }else{
    $.ajax({
        type: 'POST',
        url: 'Configuracion/Impuestos_control/ajax_all_tim_cat',
        dataType: 'json',
        data: { data: '0' },
        success: function(json) {
             str = '<option value="">--Seleccione--</option>';
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
            $("#cate_imp").removeAttr("readonly");
            $('#cate_imp').html(str);

        },
        error: function(jqXHR, xhr, textStatus, errorThrown) {
            var msgerror = textStatus + ' ' + errorThrown + ' ' + jqXHR + ' ' + xhr + ' ' + xhr.statusText + ' ' + xhr.responseText + ' ' + xhr.status;
            $('#cate_imp').html(msgerror);
        }
    });
}
}
    

