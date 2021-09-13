function validaFormlogin() {
    var username = $('#email').val();
    var password = $('#clave').val();
    if (username.trim() == '') {
        alert('Ingrese un email');
        $('#email').focus();
        return false;
    } else if (password.trim() == '') {
        alert('Ingrese la clave.');
        $('#clave').focus();
        return false;
    } else if (username.trim() != '') {
        let vali = validarEmail(username);
        if (vali == false) {
            alert('Ingrese un email valido.');
            $('#email').focus();
            return false;
        }
    }

}