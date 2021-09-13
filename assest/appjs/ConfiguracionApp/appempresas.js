var save_method; //for save method string
var table;
$(function() {
    //$(document).ready(function() {
    $("#imagePreview").hide();
    $("#logoe").change(function() {
        var sizeByte = this.files[0].size;
        var siezekiloByte = parseInt(sizeByte / 1024);

        if (siezekiloByte > $(this).attr('size')) {
            alert('El tamaño supera el limite permitido');
            $(this).val('');
        }
        readImage(this);
    });

    table = $('#tablaempresa').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "Appvilla/AppVilla_empresa_control/ajax_list_emp",
            "type": "POST"
        },
        "columnDefs": [{
            "targets": [-1],
            "orderable": false,
        }, ],
    });



    function readImage(input) {
        if (input.files && input.files[0]) {
            $("#imagePreview").show();
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result); // Renderizamos la imagen
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

});

function add_empresa() {
    save_method = 'add';
    $('#formape')[0].reset();
    $("#nroidentificacione").removeAttr("readonly");
    $('#photo-preview').hide();
    $("#imagePreview").hide();
    $('#imagePreview').html('');
    $('#label-photo').text('Cargar Logo');
    $('#modal_formape').modal('show');
    $('.modal-title').text('Agregar Empresa');
}

function edit_empresa(id) {
    save_method = 'update';
    $('#formape')[0].reset();
    $("#nroidentificacione").removeAttr("readonly");
    $('#imagePreview').html('');
    $("#imagePreview").hide();
    $.ajax({
        url: "appvilla/appvilla_empresa_control/ajax_edit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            get_provincias(data.departamento_code);
            get_distritosem(data.departamento_code, data.provincia_code);
            $('[name="empresaid"]').val(data.id);
            $('[name="tipoidentificacione"]').val(data.tipoidentificacion_code);
            $('[name="nroidentificacione"]').val(data.numero_identificacion);
            $('#nroidentificacione').attr('readonly', 'readonly');
            $('[name="nombreempresae"]').val(data.razon_social);
            $('[name="direccione"]').val(data.direccion);
            $('[name="correoe"]').val(data.email);
            $('[name="telefonoe"]').val(data.telefono);
            $('[name="contactoe"]').val(data.contacto);
            $('[name="departamentoe"]').val(data.departamento_code);
            $('[name="provinciae"]').val(data.provincia_code);
            $('[name="distritoe"]').val(data.distrito_code);
            $('#modal_formape').modal('show');
            $('.modal-title').text('Editar Empresa');
            $('#photo-preview').show(); // show photo preview modal

            if (data.logo) {
                $('#label-photo').text('Modificar Logo');
                $('#photo-preview div').html('<img src="assest/multimedia/' + data.numero_identificacion + '/logo/' + data.logo + '" class="img-responsive" style="width:180px">');

            } else {
                $('#label-photo').text('Cargar Logo');
                $('#photo-preview div').text('(No Hay Logo)');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
}

function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax
}

function save() {
    var url;
    if (save_method == 'add') {
        url = "appvilla/appvilla_empresa_control/ajax_add";
    } else {
        url = "appvilla/appvilla_empresa_control/ajax_update";
    }

    var formData = new FormData($('#formape')[0]);
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data) {
            $("#imagePreview").hide();
            $('#modal_formape').modal('hide');
            alert('Datos Registrados ' + data.status);
            reload_table();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error con los datos Ingresados ... :' + textStatus);
            $('#btnSavee').text('save'); //change button text
            $('#btnSavee').attr('disabled', false);
        }
    });
}

function delete_person(id) {
    if (confirm('Esta Seguro de Eliminar Este Dato?')) {
        // ajax delete data to database
        $.ajax({
            url: "appvilla/appvilla_empresa_control/ajax_delete/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                //if success reload ajax table
                $('#modal_formape').modal('hide');
                alert('Dato Eliminado :' + data.status);
                reload_table();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error en la eliminacion :' + textStatus);
            }
        });

    }
}