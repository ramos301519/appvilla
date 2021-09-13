<!-- page content -->
<div class="right_col" role="main">
    <?php
    $urlv = base_url();
    $ciaiden = $this->session->userdata('ciaiden');
    ?>
    <script language="JavaScript">
        var filesmulti = "multimedia/" + "<?php echo $ciaiden; ?>" + "/productos/";
        var urlbv = "<?php echo $urlv; ?>";
        var rulvs = urlbv + "ventas/buscarcliente"

        $(function() {
            //********BUSCAR CLIENTE********//
            $("#buscarclientegv").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        type: "POST",
                        contentType: "application/json; charset=utf-8",
                        url: rulvs,
                        dataType: "json",
                        data: {
                            codclieas400: request.term
                        },
                        cache: false,
                        beforeSend: function() {

                        },
                        success: function(data) {
                            console.log(data);

                            var ex = data.existe;
                            switch (ex) {
                                case 1:
                                    response($.map(data.datos, function(item) {
                                        return {
                                            label: item.AKCODCLI + ' ' + item
                                                .NUMIDEN + " " + item.AKRAZSOC,
                                            value: item.AKCODCLI,
                                            desclie: item.AKCODCLI + ' ' + item
                                                .NUMIDEN + " " + item.AKRAZSOC,
                                            codclie: item.AKCODCLI,
                                        };
                                    }))
                                    break;
                                case 0:
                                    response($.map(data, function(item) {
                                        return {
                                            label: data.men,
                                        };
                                    }))
                                    break;
                            }
                        }
                    });
                },
                delay: 200,
                minLength: 3,
                autoFocus: true,
                select: function(event, ui) {
                    $('#codclie').val(ui.item.codclie);
                    var datocli = ui.item.desclie;
                    var coloralert = '';
                    coloralert = (datocli === '') ? 'danger' : 'success';
                    var html = '<span class="label label-' + coloralert + '">' + datocli + '.</span>';
                    $('#resultac').html(html);

                    return false;
                },
                open: function() {
                    $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + ' ' + thrownError);
                },
                close: function() {
                    $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
                }
            });

        });
    </script>
    <div class="col-md-8 col-sm-8">
        <div class="x_panel">
            <div class="x_title">
                <h2>Ventas/<small>Registrar Venta</small></h2>
                <?php $moneda = $this->session->userdata('moneda');
                ?>
                <h5 class="nav navbar-right panel_toolbox"></h5>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="form-group has-feedback input-group">
                        <input type="text" autofocus="autofocus" autocomplete class="form-control has-feedback-left" placeholder="INGRESE CODIGO O NOMBRE DE PRODUCTO" name="txtbuscarproducto" id="txtbuscarproducto">
                        <!--<span class="fa fa-search form-control-feedback left" aria-hidden="true"></span>-->
                        <div class="btn-group">
                            <button type="button" class="btn btn-default" name="btnbuscar" id="btnbuscar"><i class="fa fa-search"></i></button>
                            <button type="button" class="btn btn-success" name="showcategoria" id="showcategoria" onclick="get_stock_categoria()"><i class="fa fa-th"></i></button>
                            <input type="hidden" id="cat_view" name="cat_view">
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row" id="accesodirecto">
                    <a class="btn btn-app" onclick="add_producto_acceso()">
                        <i class="fa fa-plus"></i> Agregar
                    </a>

                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <h4 class="brief"><i id="palabrasearch"></i></h4>
                    <div id="showprocesload">

                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row" id="resultsearch">

                </div>

            </div>
        </div>
    </div>

    <div class="col-md-4 col-sm-4  ">
        <div class="x_panel">
            <div class="x_title">
                <div class="form-group has-feedback input-group">
                    <input type="text" name="buscarcliente" id="buscarclientegv" class="form-control has-feedback-left" placeholder="BUSQUE UN CLIENTE AQUI">
                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-success" onclick="add_cliente()"><i class="fa fa-user-plus"></i></button>
                    </span>
                    <input type="hidden" value="" id="clienteidv" name="clienteidv">
                    <div id="showprocesloadsc"></div>
                </div>
            </div>
            <div class="x_content" id="view_venta">
                <?php
                if ($this->session->userdata('venta')) {
                    $carrito = $this->session->userdata('venta');
                    if (count($carrito) > 0) {
                        $importe = 0;
                        $subtotal = 0;
                        $igv = 0;
                        $total = 0;

                ?>
                        <div class="table-responsive">
                            <div id="showp"></div>
                            <table class="table  table-striped">
                                <tbody id="tblcar">
                                    <?php
                                    foreach ($carrito as $cad) {
                                    ?>
                                        <tr id="item<?php echo $cad['productoid']; ?>">
                                            <input type="hidden" value="<?php echo $cad['productoid']; ?>" id="productoidv" name="productoidv">
                                            <?php $importe = $cad['cantidad'] * $cad['precio']; ?>
                                            <td><?php echo $cad['cantidad']; ?></td>
                                            <td style="width:50%"><a href="javascript:void(0)" data-code='<?php echo $cad['productoid']; ?>' data-nombre='<?php echo $cad['nombre']; ?>' data-cante='<?php echo $cad['cantidad']; ?>' data-dscsimb='<?php echo $cad['dsctosimb']; ?>' data-dsctoimpo='<?php echo $cad['dsctoimpo']; ?>' class="edititem"><?php echo $cad['nombre']; ?></a></td>
                                            <td><?php echo $cad['precio']; ?></td>
                                            <td><a href="javascript:void(0)" title="Anular" onclick="set_delete_carrito(<?php echo $cad['productoid']; ?>)" class="btn btn-link btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php
                                        $subtotal = $subtotal + $importe;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive" id="edititemventa">

                        </div>
                        <a class="btn btn-success btn-lg btn-block" href="ventaformapago"> Detalle</a>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Descuento:</th>
                                        <td>0.00</td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td><?php echo number_format($subtotal, 2, '.', ','); ?></td>
                                    </tr>
                                    <tr>
                                        <th>IGV (18 %)</th>
                                        <td><?php $igv = $subtotal * 0.18;
                                            echo number_format($igv, 2, '.', ','); ?></td>
                                    </tr>
                                    <tr class="success">
                                        <th>Total:</th>
                                        <td><?php
                                            $total = $subtotal + $igv;
                                            echo number_format($total, 2, '.', ','); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>

                <?php }
                } ?>
            </div>

        </div>
    </div>

</div>

<div class="modal fade" id="staplesbmincart">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Cart
                    <button type="button" data-dismiss="modal" class="close"><i class="fa fa-close"></i>
                    </button>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row" id="myCart">

                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-6">
                    <a ID="hlCart" runat="server" class="btn btn-success pull-left">View Shipment <i class="fa fa-truck"></i></a>
                </div>
                <div class="col-md-6">
                    <button type="button" data-dismiss="modal" onclick="cart.clean()" class="btn btn-link">Clear</button>
                </div>
            </div>
        </div>
    </div>
</div>