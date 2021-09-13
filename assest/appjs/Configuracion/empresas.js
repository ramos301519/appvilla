var save_method; //for save method string
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
    edit_empresa();

});


function edit_empresa() {
    save_method = 'update';
    $("#nroidentificacionv").removeAttr("readonly");
    $('#imagePreview').html('');
    $("#imagePreview").hide();
    $.ajax({
        url: "Configuracion/Empresa_control/ajax_edit/",
        type: "GET",
        dataType: "JSON",
        success: function(json) {
            if (json.status === true) {
                var data = json.info;
                get_provincias(data.departamento_code);
                get_distritosem(data.departamento_code, data.provincia_code);
                $("#empresavid").val(data.id);
                $("#tipoidentificacionv").val(data.tipoidentificacion);
                $('#tipoidentificacionv').attr('readonly', 'readonly');
                $("#nroidentificacionv").val(data.numero_identificacion);
                $('#nroidentificacionv').attr('readonly', 'readonly');
                $("#nombreempresav").val(data.razon_social);
                $("#direccionv").val(data.direccion);
                $("#correov").val(data.email);
                $("#telefonov").val(data.telefono);
                $("#contactov").val(data.contacto);
                $("#departamentovce").val(data.departamento_code);
                $("#provinciavce").val(data.provincia_code);
                $("#distritovce").val(data.distrito_code);

                if (data.logo) {
                    $('#label-photo').text('Modificar Logo');
                    $('#photo-preview div').html('<img src="assest/multimedia/' + data.numero_identificacion + '/logo/' + data.logo + '" class="img-responsive" style="width:180px">');
                } else {
                    $('#label-photo').text('Cargar Logo');
                    $('#photo-preview div').text('(No Hay Logo)');
                }
            } else {

            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
}

function save() {
    var url = "Configuracion/Empresa_control/ajax_update";
    var formData = new FormData($('#formem')[0]);
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data) {
            if (data.status === true) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Mensaje :' + data.info,
                    showConfirmButton: false,
                    timer: 2000
                });
                load_();
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

            var msgerr = "<p>" + xhr + " :: " + textStatus + " :: " + errorThrown + ' ' + xhr + ' ' + xhr.statusText + ' ' + xhr.responseText + ' Codigohtp:' + xhr.status + "</p>";
            Swal.fire({
                icon: 'error',
                title: 'Error en actualizacion de datos',
                text: 'Datos por actualizacion ... :' + textStatus,
                html: msgerr,
            });
        }
    });
}