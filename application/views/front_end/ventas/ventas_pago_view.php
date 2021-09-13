<!-- page content -->
<div class="right_col" role="main">
    <div class="col-md-7 col-sm-7">
        <div class="x_panel">
            <div class="x_title">
                <h2>Registrar Pago<small> </small></h2>

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
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>2</td>
                                    <th style="width:50%"><a href="#">Cerveza Cusqueña Botella 500 ml</a></th>
                                    <td>9.00</td>
                                    <td><a href="#" class="btn btn-link btn-danger btn-sm"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <th style="width:50%"><a href="#">Cerveza Cristal 500 ml caja</a></th>
                                    <td>48.00</td>
                                    <td><a href="#" class="btn btn-link btn-danger btn-sm"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <th>Descuento:</th>
                                    <td>0.00</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <th style="width:50%">Subtotal:</th>
                                    <td>57.00</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <th>IGV (18 %)</th>
                                    <td>10.26</td>
                                </tr>
                                <tr class="success">
                                    <td colspan="2"></td>
                                    <th>Total:</th>
                                    <td>67.26</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-5 col-sm-5  ">
        <div class="x_panel">
            <div class="x_title">
                <h5 class="nav navbar-right panel_toolbox">Pago &nbsp;</h5>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="item form-group">
                    <div id="gender" class="btn-group" data-toggle="buttons">
                        <label class="btn btn-success" data-toggle-class="btn-primary"
                            data-toggle-passive-class="btn-default">
                            <input type="radio" name="moneda" value="S" class="join-btn" checked=""> &nbsp; S/ &nbsp;
                        </label>
                        <label class="btn btn-secondary" data-toggle-class="btn-primary"
                            data-toggle-passive-class="btn-default">
                            <input type="radio" name="moneda" value="D" class="join-btn"> USD
                        </label>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="inputdefault">MONTO RECIBIDO</label>
                            <input class="form-control" id="inputdefault" type="text" placeholder="68.00">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="inputdefault">MONTO TOTAL VENTA</label>
                            <input class="form-control" id="inputdefault" type="text" placeholder="67.26" disabled>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="inputdefault">MONTO FALTANTE</label>
                            <input class="form-control" id="inputdefault" type="text" placeholder="-0.74" disabled>
                        </div>
                    </div>

                </div>
                <br>
                <div class="row">

                    <div class="form-group">
                        <label for="inputdefault">FORMAS DE PAGO</label>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="btn btn-secondary btn-lg" data-toggle-class="btn-primary"
                                data-toggle-passive-class="btn-default">
                                <input type="radio" name="fpago" value="E" class="join-btn"><i class="fa fa-money"></i>
                            </label>

                            <label for="inputdefault">EFECTIVO</label>

                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="btn btn-success btn-lg" data-toggle-class="btn-primary"
                                data-toggle-passive-class="btn-default">
                                <input type="radio" name="fpago" value="T" class="join-btn" checked="checked"> <i
                                    class="fa fa-credit-card"></i>
                            </label>

                            <label for="inputdefault">TARJETA</label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="btn btn-secondary btn-lg" disabled="" data-toggle-class="btn-primary"
                                data-toggle-passive-class="btn-default">
                                <input type="radio" name="fpago" value="N" class="join-btn"> <i
                                    class="fa fa-file-text-o"></i></label>
                            <label for="inputdefault">NOTA CREDITO</label>
                        </div>
                    </div>

                </div>
                <br>

                <div class="row">

                    <div class="col-sm-3">
                        <label for="heard">TARJETA Debito&nbsp;/&nbsp;Credito</label>
                        <label>
                            <input type="checkbox" class="js-switch" />
                        </label>

                    </div>                   

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="inputdefault">ULTIMOS 4 DIGITOS</label>
                            <input class="form-control" id="inputdefault" type="text" maxlength="4" placeholder="1234">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="inputdefault">NUMERO OPERACION</label>
                            <input class="form-control" id="inputdefault" type="text" placeholder="2312456">
                        </div>
                    </div>
                </div>
                <br>

                <a class="btn btn-success btn-lg btn-block" data-toggle="modal" data-target="#confirmacionpago" href="#"> CONFIRMAR PAGO</a>
                

            </div>
        </div>
    </div>

</div>