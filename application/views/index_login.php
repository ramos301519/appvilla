<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?php echo base_url(); ?>">
    <title><?php echo $titulo; ?></title>
    <!-- Bootstrap -->
    <link href="assest/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="assest/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="assest/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="assest/vendors/animate.css/animate.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="assest/build/css/custom.min.css" rel="stylesheet">
</head>

<body class="login">
    <div>
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>

        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <h1>Iniciar Session</h1>
                    <?php echo validation_errors('<p class="error">'); ?>
                    <form class="form col-md-12 center-block" role="form" name="forlogin" action="valida" method="POST"
                        id="forlogin" onsubmit="return validaFormlogin()">

                        <div>
                            <input type="email" name="email" id="email" class="form-control"
                                placeholder="correo electronico" required />
                        </div>
                        <div>
                            <input type="password" name="clave" id="clave" class="form-control" placeholder="clave"
                                required />
                        </div>
                        <div>
                            <button class="btn btn-default" type="submit">Ingresar</button>
                            <a class="reset_pass" href="#">Olvidaste tu clave?</a>

                        </div>
                        <br />
                        <?php
echo $mensaje;
/*$this->load->helper('general_helpers');
$nroiden = 'abc123';
$pass = generatePassword($nroiden);
$password = password_hash($pass, PASSWORD_BCRYPT);
$remember_token = fRand(61);
print_r($password);
echo '</br>';
print_r($password); */
?>
                    </form>
                    <div class="clearfix"></div>
                    <div class="separator">
                        <p class="change_link">Nuevo?
                            <a href="#signup" class="to_register"> Crear Cuenta </a>
                        </p>
                        <div class="clearfix"></div>
                        <br />
                        <div>
                            <h1><i class="fa fa-paw"></i> AppVilla!</h1>
                        </div>
                    </div>
                </section>
            </div>
           
        </div>
    </div>
    <!-- jQuery -->
    <script src="assest/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="assest/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- appvilla -->
    <script src="assest/appjs/usuario/usuario.js"></script>
    <script src="assest/appjs/util.js"></script>
</body>

</html>