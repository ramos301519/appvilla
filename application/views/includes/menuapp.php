<div class="col-md-3 left_col menu_fixed">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="index.html" class="site_title"><i class="fa
                                    fa-paw"></i> <span>AppVilla</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->

        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side
                            hidden-print main_menu">
            <div class="menu_section">
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-gear"></i> Configuracion<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="appempresa">Empresa Clientes</a></li>
                            <li><a href="modulos">Modulos</a></li>
                            <li><a href="modulosempresa">Empresa Modulo</a></li>
                            <li><a href="licencia">Licencias</a></li>
                            <li><a href="integraose">Integracion OSE</a></li>
                            <li><a href="svrmail">Servicion Mail</a></li>
                            <li><a href="usuariovilla">Usuarios</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-cogs"></i>
                    Maestros Base<span class="fa
                                                    fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="tipoidentificacion">Tipos de identificacion</a></li>
                            <li><a href="tipocomprobante">Tipos de comprobante</a></li>
                            <li><a href="tipoimpuesto">Tipos de impuesto</a></li>
                            <li><a href="modalidadpago">Modalidades de Pago</a></li>
                            <li><a href="moneda">Monedas</a></li>
                            <li><a href="unidadmedida">Unidad de Medida</a></li>
                            <li><a href="Perfiles">Perfiles</a></li>
                        </ul>
                    </li>
                </ul>
            </div>


        </div>
        <!-- /sidebar menu -->

    </div>
</div>

<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-arrows-h"></i></a>
        </div>
        <nav class="nav navbar-nav">
            <ul class="navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;"> &nbsp;
                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown"
                        data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user fa-2x"></i>&nbsp;<?php echo $this->session->userdata('usuaper'); ?>
                    </a>
                    <div class="dropdown-menu
                                            dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">

                        <a class="dropdown-item" href="salir"><i class="fa
                                                    fa-sign-out pull-right"></i>
                            Salir</a>
                    </div>
                </li>

            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->