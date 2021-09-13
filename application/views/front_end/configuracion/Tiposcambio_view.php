  <!-- page content -->
  <div class="right_col" role="main">
      <div class="col-md-12 col-sm-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>Configuracion/Tipos Cambio<small> </small></h2>
                  <h5 class="nav navbar-right panel_toolbox"><button class="btn btn-success" onclick="add_tcmb()">Tipo Cambio <i class="glyphicon glyphicon-plus"></i></button></h5>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <div class="row">

                      <div class="col-sm-12">
                          <div class="card-box table-responsive">
                              <p class="text-muted font-13 m-b-30">
                              </p>
                              <table id="tabla_tcmb" class="table table-striped table-bordered" style="width:100%">
                                  <thead>
                                      <tr>                                          
                                          <th>Fecha alta</th>
                                          <th>Moneda</th>
                                          <th>Venta</th>
                                          <th>Compra</th>
                                          <th>Promedio</th>
                                          <th>Acciones</th>
                                      </tr>
                                  </thead>
                                  <tbody>

                                  </tbody>
                              </table>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <script type="text/javascript">
          var fechaactual = '<?php echo gmdate("Y-m-d", time() - 18000) ?>';
          var ses= '<?php $valid = $this->session->userdata('validated');?>';
          '<?php
           if($valid ==false){
           redirect('salir');
           }
           ?>';

      </script>
      <!-- Bootstrap modal -->
      <div class="modal fade" id="modal_form_tcmb" role="dialog">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h3 class="modal-title">Registrar Tipo cambio</h3>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modal-body form">
                      <form action="#" id="form_tcmb" class="form-horizontal">
                          <input type="hidden" value="" name="id" />
                          <div class="form-body">
                              <div class="form-group">
                                  <label class="control-label col-md-3 required">Moneda</label>
                                  <div class="col-md-9">
                                      <select class="form-control" required="required" name="moneda_tcmb" id="moneda_tcmb">
                                      </select>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-md-3">Fecha</label>
                                  <div class="col-md-9">
                                      <input type="date" name="fecha_tcmb" id="fecha_tcmb" placeholder="Fecha registro" class="form-control">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-md-3">Venta</label>
                                  <div class="col-md-9">
                                      <input type="number" name="venta_tcmb" id="venta_tcmb" placeholder="Tipo cambio venta" class="form-control" min="0.001" pattern="^\d*,?\d*$" max="99.99">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-md-3">Compra</label>
                                  <div class="col-md-9">
                                      <input type="number" name="compra_tcmb" id="compra_tcmb" placeholder="Tipo cambio compra" class="form-control" min="0.001" pattern="^\d*,?\d*$" max="99.99">
                                  </div>
                              </div>
                          </div>
                      </form>
                  </div>
                  <div class="modal-footer">
                      <button type="button" id="btnSave" onclick="save_tcmb()" class="btn btn-primary">Guardar</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                  </div>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
      <!-- End Bootstrap modal -->
  </div>
  <!-- /page content -->