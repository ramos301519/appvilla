// APPVILLA venta
$(function() {

    $(".ruc").hide();
    $(".dni").hide();
    document.getElementById("btnsavecli").disabled = false;
    $('#frmcliente').submit(function(e) {
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
        tipoidenc = $('#tipoidentificacion').val();
        nrotipoidenc = $.trim($('#nroidentificacion').val());
        razonsocc = $.trim($('#nombreempresarialc').val());
        apellidosc = $.trim($('#apellidosc').val());
        nombresc = $.trim($('#nombresc').val());
        direccionc = $.trim($('#direccionc').val());
        correoc = $.trim($('#correoc').val());
        telefonoc = $.trim($('#telefonoc').val());
        contactoc = $.trim($('#contactoc').val());
        departamentoc = $.trim($('#departamentoc').val());
        provinciac = $.trim($('#provinciac').val());
        distritoc = $.trim($('#distritoc').val());
        var dat = {
            tipoidenc: tipoidenc,
            nrotipoidenc: nrotipoidenc,
            razonsocc: razonsocc,
            apellidosc: apellidosc,
            nombresc: nombresc,
            direccionc: direccionc,
            correoc: correoc,
            telefonoc: telefonoc,
            contactoc: contactoc,
            departamentoc: departamentoc,
            provinciac: provinciac,
            distritoc: distritoc
        };

        set_savecliente(dat)

    });
    $('#nroidentificacion').keyup(function() {
        let ti = $('#tipoidentificacion').val();
        let ni = $('#nroidentificacion').val();
        let dat = {
            tipoidenc: ti,
            nrotipoidenc: ni
        };
        get_existecliente(dat);
    });

    get_tipoidentificacion();
    get_departamentos();
});

function get_tipoidentificacion() {
    $.ajax({
        type: 'POST',
        url: 'utilidad_control/get_TipoIdentificacion',
        dataType: 'json',
        data: { data: '0' },
        success: function(json) {
            var str = '<option selected value="">--Seleccione--</option>';
            var datiden = "";
            if (json.validate === true) {
                cad = json.info;
                num = cad.length;
                for (e = 0; e < num; e++) {
                    dat = cad[e];
                    colpac = dat['codigo'];
                    colpad = dat['sigla'];
                    str += '<option value="' + colpac + '">' + colpad + '</option>';
                    if (colpac === '6') {
                        datiden += '<option value="' + colpac + '">' + colpad + '</option>';
                    }
                }
            } else {
                str += '<option value="">No hay resultados</option>';
                datiden += '<option value="">No hay resultados</option>';
            }
            $('#tipoidentificacion').html(str);
            $('#tipoidentificacione').html(datiden);
        },
        error: function(jqXHR, xhr, textStatus, errorThrown) {
            var msgerror = textStatus + ' ' + errorThrown + ' ' + jqXHR + ' ' + xhr + ' ' + xhr.statusText + ' ' + xhr.responseText + ' ' + xhr.status;
            $('#tipoidentificacion').html(msgerror);
            $('#tipoidentificacione').html(msgerror);
        }

    });
}

function get_departamentos() {
    $.ajax({
        type: 'POST',
        url: 'utilidad_control/get_departamentos',
        dataType: 'json',
        data: { data: '0' },
        success: function(json) {
            let str = '<option selected value="">--Seleccione--</option>';
            if (json.validate === true) {
                cad = json.info;
                num = cad.length;
                for (e = 0; e < num; e++) {
                    dat = cad[e];
                    colpac = dat['id'];
                    colpad = dat['name'];
                    str += '<option value="' + colpac + '">' + colpad + '</option>';
                }
            } else {
                str += '<option value="">No hay resultados</option>';
            }
            $('#departamentoc').html(str);
            $('#departamentoe').html(str);
            $('#departamentovce').html(str);

        },
        error: function(jqXHR, xhr, textStatus, errorThrown) {
            var msgerror = textStatus + ' ' + errorThrown + ' ' + jqXHR + ' ' + xhr + ' ' + xhr.statusText + ' ' + xhr.responseText + ' ' + xhr.status;
            $('#departamentoc').html(msgerror);
            $('#departamentoe').html(msgerror);
            $('#departamentovce').html(msgerror);
        }
    });
}

function get_muestrarazonnombrescliente(id) {
    var nomtipiden = $('select[name="tipoidentificacion"] option:selected').text();
    $("#nroidentificacion").removeAttr("placeholder");
    $("#nroidentificacion").removeAttr("minlength");
    $("#nroidentificacion").removeAttr("maxlength");
    if (id === '6') {
        $("#nroidentificacion").val('');
        $('#nroidentificacion').attr('placeholder', '20000000010');
        $('#nroidentificacion').attr('minlength', '10');
        $('#nroidentificacion').attr('maxlength', '11');
        $(".dni").hide();
        $(".ruc").show();
    } else {
        $("#nroidentificacion").val('');
        $('#nroidentificacion').attr('placeholder', '80000001');
        $('#nroidentificacion').attr('minlength', '7');
        $('#nroidentificacion').attr('maxlength', '8');
        $(".ruc").hide();
        $(".dni").show();
    }
}

function get_provincias(id) {
    $.ajax({
        type: 'POST',
        url: 'utilidad_control/get_provincias',
        dataType: 'json',
        data: { depaid: id },
        success: function(json) {
            var str;
            if (json.validate === true) {
                cad = json.info;
                num = cad.length;
                for (e = 0; e < num; e++) {
                    dat = cad[e];
                    colpac = dat['id'];
                    colpad = dat['name'];
                    str += '<option value="' + colpac + '">' + colpad + '</option>';
                }
            } else {
                str += '<option value="">No hay resultados</option>';
            }
            $('#provinciac').html(str);
            $('#provinciae').html(str);
            $('#provinciavce').html(str);
        },
        error: function(jqXHR, xhr, textStatus, errorThrown) {
            var msgerror = textStatus + ' ' + errorThrown + ' ' + jqXHR + ' ' + xhr + ' ' + xhr.statusText + ' ' + xhr.responseText + ' ' + xhr.status;
            $('#provinciac').html(msgerror);
            $('#provinciae').html(msgerror);
            $('#provinciavce').html(msgerror);
        }
    });
}

function get_distritos(id) {
    var iddep = "";
    var iddepc = $("#departamentoc").val();
    var iddepe = $("#departamentoe").val();
    var iddepvce = $("#departamentovce").val();
    if (iddepc != "") {
        iddep = iddepc;
    } else if (iddepe != "") {
        iddep = iddepe;
    } else if (iddepvce != "") {
        iddep = iddepvce;
    } else {
        iddep = "";
    }
    //iddep = iddepc === "" ? iddepe : iddepc;
    $.ajax({
        type: 'POST',
        url: 'utilidad_control/get_distritos',
        dataType: 'json',
        data: { depaid: iddep, provid: id },
        success: function(json) {
            var str;
            if (json.validate === true) {
                cad = json.info;
                num = cad.length;
                for (e = 0; e < num; e++) {
                    dat = cad[e];
                    colpac = dat['id'];
                    colpad = dat['name'];
                    str += '<option value="' + colpac + '">' + colpad + '</option>';
                }
            } else {
                str += '<option value="">No hay resultados</option>';
            }
            $('#distritoc').html(str);
            $('#distritoe').html(str);
            $('#distritovce').html(str);

        },
        error: function(jqXHR, xhr, textStatus, errorThrown) {
            var msgerror = textStatus + ' ' + errorThrown + ' ' + jqXHR + ' ' + xhr + ' ' + xhr.statusText + ' ' + xhr.responseText + ' ' + xhr.status;
            $('#distritoc').html(msgerror);
            $('#distritoe').html(msgerror);
            $('#distritovce').html(msgerror);
        }
    });
}

function get_distritosem(iddep, id) {

    $.ajax({
        type: 'POST',
        url: 'utilidad_control/get_distritos',
        dataType: 'json',
        data: { depaid: iddep, provid: id },
        success: function(json) {
            var str;
            if (json.validate === true) {
                cad = json.info;
                num = cad.length;
                for (e = 0; e < num; e++) {
                    dat = cad[e];
                    colpac = dat['id'];
                    colpad = dat['name'];
                    str += '<option value="' + colpac + '">' + colpad + '</option>';
                }
            } else {
                str += '<option value="">No hay resultados</option>';
            }

            $('#distritoe').html(str);
            $('#distritovce').html(str)
        },
        error: function(jqXHR, xhr, textStatus, errorThrown) {
            var msgerror = textStatus + ' ' + errorThrown + ' ' + jqXHR + ' ' + xhr + ' ' + xhr.statusText + ' ' + xhr.responseText + ' ' + xhr.status;

            $('#distritoe').html(msgerror);
            $('#distritovce').html(msgerror);
        }
    });
}