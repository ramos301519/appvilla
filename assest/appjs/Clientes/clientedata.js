var save_method; //for save method string
var table;
$(function() {
    table = $('#tablaCliente').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "Cliente/Clientes_control/ajax_list",
            "type": "POST"
        },
        "columnDefs": [{
            "targets": [-1],
            "orderable": false,
        }, ],
    });
});

function add_cliente() {
    $('#verimag').hide();
    save_method = 'add';
    $('#frmcliente')[0].reset();
    $('#mdalcliente').modal('show');
    $('.modal-title').text('Agregar Cliente');
}

function set_savecliente(dat) {
    $.ajax({
        url: "Cliente/Clientes_control/savecliente",
        type: "POST",
        datatype: "json",
        data: dat,
        success: function(json) {
            if (json.validate === true) {
                var msgd = '<div class="alert alert-success"><strong>Registrado:</strong> Correctamente </div>';
                $('#mdalcliente .msg').html(msgd);
                setTimeout(function() {
                    $("#mdalcliente .msg").html('')
                    $('#mdalcliente').modal('hide');
                }, 5000);

            } else {
                let msgd = '<div class="alert alert-warning"><strong>Error!</strong> ' + json.info + '</div>';
                $('#mdalcliente .msg').html(msgd);
                setTimeout(function() { $("#mdalcliente .msg").html('') }, 9000);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            var erdat = jqXHR + "  " + textStatus + "  " + errorThrown + ' ' + jqXHR;

            var msgd = '<div class="alert alert-danger"><strong>Error!</strong> ' + erdat + '</div>';
            $('#mdalcliente .msg').html(msgd);
            setTimeout(function() { $("#mdalcliente .msg").html('') }, 9000);
        }
    });
}

function get_existecliente(dat) {
    $.ajax({
        url: "Cliente/Clientes_control/get_existecliete",
        type: "POST",
        datatype: "json",
        data: dat,
        success: function(json) {
            if (json.validate === true) {
                var msgd = '<div class="alert alert-info"><strong>Ya existe el cliente:</strong> Registrado con el numero ' + dat.nrotipoidenc + ' </div>';
                $('#mdalcliente .msg').html(msgd);
                document.getElementById("btnsavecli").disabled = true;
                setTimeout(function() {
                    $("#mdalcliente .msg").html('');
                    $('#mdalcliente').modal('hide');
                }, 8000);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            var erdat = jqXHR + "  " + textStatus + "  " + errorThrown + ' ' + jqXHR;
            var msgd = '<div class="alert alert-danger"><strong>Error!</strong> ' + erdat + '</div>';
            $('#mdalcliente .msg').html(msgd);
            setTimeout(function() { $("#mdalcliente .msg").html('') }, 9000);
        }
    });
}