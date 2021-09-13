<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html lang="es-ES">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#">
<head>

 <meta charset=utf-8>
  <meta name="viewport" content="width=device-width, initial-scale=1"></meta>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <?php date_default_timezone_set('America/Lima');?>
    <base href="<?php echo base_url(); ?>">
    <title><?php echo $titulo ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="assest/imagen/iconomshw.ico" />
   
    <!-- Bootstrap -->
    <link href="assest/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- Bootstrap -->
  <!-- Datatables -->    
  <link href="assest/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="assest/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="assest/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="assest/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet" />
    <!-- completamos -->
    <!-- iCheck -->
    <link href="assest/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
    <link href="assest/vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="assest/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <!-- Switchery -->
    <link href="assest/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
     <!-- starrr -->
     <link href="assest/vendors/starrr/dist/starrr.css" rel="stylesheet">
    <!-- jquery-ui -->
    <link href="assest/vendors/jquery-ui/jquery-ui.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="assest/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="assest/build/css/custom.min.css" rel="stylesheet">
     <!-- sweetalert2-master -->
     <link href="assest/vendors/sweetalert2-master/css/sweetalert2.min.css" rel="stylesheet">
    <!-- bootstrap-Sweetalert -->
    <link href="assest/vendors/bootstrap-sweetalert/css/sweetalert.css" rel="stylesheet">
    <!-- bootstrap-Sweetalert -->
    <link href="assest/appcss/general.css" rel="stylesheet">
</head>
<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <?php
 $valid = $this->session->userdata('validated');
 if ($valid == true) {
     $flag = $this->session->userdata('flag');
     if($flag==0){
        $this->load->view('includes/menuapp');
     }else{
        $this->load->view('includes/menu');
     }
 }

?>