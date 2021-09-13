function validarEmail(valor) {
    var valido;
    if (/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(valor)) {
        valido = true;
    } else {
        valido = false;
    }
    return valido;
}

function loadshowmodal() {
    $('#mdalload').modal('show');
}

function loadhidenmodal() {
    $('#mdalload').modal('hide');

}

function validaVacio(valor) {
    valor = valor.replace("&nbsp;", "");
    valor = valor == undefined ? "" : valor;
    if (!valor || 0 === valor.trim().length) {
        return true;
    } else {
        return false;
    }
}