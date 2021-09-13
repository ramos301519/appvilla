  <!-- page content -->
  <div class="right_col" role="main">
      <div class="col-md-12 col-sm-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>Configuracion/Serie Correlativo<small> </small></h2>
                  <h5 class="nav navbar-right panel_toolbox"><button class="btn btn-success" onclick="add_srco()">Serie y correlativo <i class="glyphicon glyphicon-plus"></i></button></h5>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <div class="row">

                      <div class="col-sm-12">
                          <div class="card-box table-responsive">
                              <p class="text-muted font-13 m-b-30">
                              </p>
                              <table id="tabla_srco" class="table table-striped table-bordered" style="width:100%">
                                  <thead>
                                      <tr>                                          
                                          <th>Tipo Comprobante</th>
                                          <th>Serie</th>
                                          <th>Digitos</th>                                          
                                          <th>Inicia</th>
                                          <th>Actual</th>
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
          var ses= '<?php $valid = $this->session->userdata('validated');?>';
          '<?php
           if($valid ==false){
           redirect('salir');
           }
           ?>';

      </script>
      <!-- Bootstrap modal -->
      <div class="modal fade" id="modal_form_srco" role="dialog">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h3 class="modal-title">Registrar Serie y correlativo</h3>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modal-body form">
                      <form action="#" id="form_srco" class="form-horizontal">
                          <input type="hidden" value="" name="id" />
                          <div class="form-body">
                              <div class="form-group">
                                  <label class="control-label col-md-3 required">TipoComprobante</label>
                                  <div class="col-md-9">
                                      <select class="form-control" required="required" name="typevoucher_srco" id="typevoucher_srco" >
                                      </select>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-md-3">Sereie</label>
                                  <div class="col-md-9">
                                      <input type="text" name="ser_srco" id="ser_srco" placeholder="Serie" class="form-control" minlength="1" maxlength="5">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-md-3">Digitos</label>
                                  <div class="col-md-9">
                                      <input type="number" name="digit_srco" id="digit_srco" placeholder="Digitos" class="form-control" value="" min="1" pattern="^\d*,?\d*$" max="999.99">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-md-3">Inicia</label>
                                  <div class="col-md-9">
                                      <input type="number" name="start_srco" id="start_srco" placeholder="Inicia" class="form-control" value="1" min="1" pattern="^\d*,?\d*$" max="9999.99">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-md-3">Actual</label>
                                  <div class="col-md-9">
                                      <input type="number" name="last_srco" id="last_srco" placeholder="Ultimo" class="form-control" value="0" min="0" pattern="^\d*,?\d*$" max="9999.99">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-md-3">Seguiente</label>
                                  <div class="col-md-9">
                                      <input type="number" name="next_srco" id="next_srco" placeholder="Siguiente" class="form-control" value="1" min="1" pattern="^\d*,?\d*$" max="9999.99">
                                  </div>
                              </div>
   
                          </div>
                      </form>
                  </div>
                  <div class="modal-footer">
                      <button type="button" id="btnSave_tcmb" onclick="save_srco()" class="btn btn-primary">Guardar</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                  </div>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
      <!-- End Bootstrap modal -->
  </div>
  <!-- /page content -->