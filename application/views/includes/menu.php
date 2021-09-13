<div class="col-md-3 left_col menu_fixed">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="index.html" class="site_title"><i class="fa
                                    fa-paw"></i> <span>AppVilla</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">

                <?php 
                $logo = $this->session->userdata('cialogo');
                $ciaiden  = $this->session->userdata('ciaiden');
                $sinlogo=
                $conlogo="multimedia\\".$ciaiden."\\logo\\".$logo;
                $urlima=$logo != "" ? $conlogo : 'imag/imgemp.jpg';
                ?>
                <img src="assest/<?php echo $urlima; ?>" alt="logo cia"
                    class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span><?php echo $this->session->userdata('cianom'); ?></span>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side
                            hidden-print main_menu">
            <div class="menu_section">
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-home"></i> Principal
                        </a>
                    <li><a><i class="fa fa-cart-plus"></i>
                            Ventas <span class="fa
                                                    fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="cliente">Clientes</a></li>
                            <li><a href="venta">Generar Venta</a></li>
                            <li><a href="Listarventas">Ventas</a></li>
                            <li><a href="cotizacion">Cotizaciones</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-truck"></i>
                            Compras <span class="fa
                                                    fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="form.html">Proveedores</a></li>
                            <li><a href="form_advanced.html">Generar
                                    Compra</a></li>
                            <li><a href="form_validation.html">Compras</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-cubes"></i>
                            Almacen <span class="fa
                                                    fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="categorias">Categoria</a></li>
                            <li><a href="subcategorias">Sub
                                    Categoria</a></li>
                            <li><a href="marcas">Marca</a></li>
                            <li><a href="productos">Producto</a></li>
                            <li><a href="widgets.html">Inventario</a></li>
                            <li><a href="invoice.html">Kardex</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-money"></i> Caja
                            <span class="fa
                                                    fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="tables.html">Administracion</a></li>
                            <li><a href="tables_dynamic.html">Movimientos</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-bar-chart-o"></i>
                            Analitica <span class="fa
                                                    fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="chartjs.html">Ventas</a></li>
                            <li><a href="chartjs2.html">Compras</a></li>
                            <li><a href="morisjs.html">Almacen</a></li>
                            <li><a href="echarts.html">Caja</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="menu_section">
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-gear"></i>
                            Configuracion<span class="fa
                                                    fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="empresa">Empresa</a></li>
                            <li><a href="seriecorrelativo">Serie y Correlativo</a></li>
                            <li><a href="tiposcambio">Tipo
                                    de Cambios</a></li>
                            <li><a href="impuesto">Impuestos</a></li>
                            <li><a href="almacen">Almacenes</a></li>
                            <li><a href="tienda">Tiendas</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-group"></i>
                            Colaborador <span class="fa
                                                    fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="page_403.html">Personal</a></li>
                            <li><a href="page_404.html">Cargo</a></li>
                            <li><a href="page_404.html">Usuarios</a></li>
                        </ul>
                    </li>
                    <!--  <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li>
                              -->
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
                <li class="nav-item dropdown open" style="padding-left: 15px;"> <i class="fa fa-home"></i>
                    <?php echo $this->session->userdata('local_nom'); ?> &nbsp;
                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown"
                        data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user fa-2x"></i>Vendedor&nbsp;<?php echo $this->session->userdata('usuaper'); ?>
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