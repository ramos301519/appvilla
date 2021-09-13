<!-- page content -->
<div class="right_col" role="main">
    <div class="col-md-8 col-sm-8">
        <div class="x_panel">
            <div class="x_title">
                <h2>Registrar Forma Pago<small> </small></h2>

                <h5 class="nav navbar-right panel_toolbox">Moneda PEN S/ &nbsp; Tipo Cambio 3.560 &nbsp;</h5>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="form-group has-feedback input-group">
                        <input type="text" class="form-control has-feedback-left" id="exampleInputAmount"
                            placeholder="Trending Solutions   RUC: 20601675219 ">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-success"><i class="fa fa-user-plus"></i></button>
                        </span>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                <?php
            if($this->session->userdata('venta')){
            $carrito= $this->session->userdata('venta');
            if(count($carrito)>0){;
           $importe=0;
           $subtotal=0;
           $igv=0;
           $total=0;
            
            ?>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                            <?php
                        foreach($carrito as $cad){                       
                        ?>
                         <tr>
                            <?php $importe=$cad['cantidad']*$cad['precio'];?>
                                <td><?php echo $cad['cantidad'];?></td>
                                <th style="width:50%"><a href="#"><?php echo $cad['nombre'];?></a></th>
                                <td><?php echo $cad['precio'];?></td>
                                <td><a href="#" class="btn btn-link btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                                <?php 
                            $subtotal=$subtotal+$importe; 
                            } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>Descuento:</td>
                                    <td>0.00</td>
                                </tr>
                                <tr>
                                 <td colspan="2"></td>
                                    <td style="width:50%">Subtotal:</td>
                                    <td><?php echo number_format($subtotal, 2, '.', ',');?></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>IGV (18 %)</td>

                                    <td><?php $igv= $subtotal*0.18;
                                echo number_format($igv, 2, '.', ',');?></td>
                                </tr>
                                <tr class="success">
                                    <td colspan="2"></td>
                                    <td>Total:</td>
                                    <td><?php 
                                $total=$subtotal+$igv;
                                echo number_format($total, 2, '.', ','); ?></td>
                                </tr>
                                </tfoot>
                        </table>
                    </div>
                    <?php }else{?>

                        <?php }}?>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-4 col-sm-4  ">
        <div class="x_panel">
            <div class="x_title">
                <h5 class="nav navbar-right panel_toolbox">Forma de Pago &nbsp;</h5>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <p> Contado :
                    <input type="radio" class="flat" name="gender" id="genderM" value="C" checked=""
                        required /></br></br>
                    Credito&nbsp;&nbsp;&nbsp;:
                    <input type="radio" class="flat" name="gender" id="genderF" value="R" />
                </p>
                <br>
                <br>
                <div class="table-responsive">
                    <table class="table ">
                        <tbody>
                            <tr>
                                <td><input type="number" class="form-control" name="gender" id="genderF12345" value=""
                                        placeholder="33.63" /></td>
                                <td><input type="date" class="form-control" name="gender" id="genderF12345" value=""
                                        style="width:90%" /></td>
                            </tr>
                            <tr>
                                <td><input type="number" class="form-control" name="gender" id="genderF12345" value=""
                                        placeholder="33.63" /></td>
                                <td><input type="date" class="form-control" name="gender" id="genderF12345" value=""
                                        style="width:90%" /></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td><a class="btn btn-success" href="#" style="float:right;"><i
                                            class="fa fa-plus"></i></a>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <br>
                <a class="btn btn-success btn-lg btn-block" href="#"> Cotizacion</a>
                <a class="btn btn-success btn-lg btn-block" href="#"> Facturar</a>
                <a class="btn btn-success btn-lg btn-block" href="ventapago"> Cobrar</a>
            </div>
        </div>
    </div>
</div>