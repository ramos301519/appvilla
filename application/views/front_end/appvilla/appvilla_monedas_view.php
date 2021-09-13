  <!-- page content -->
  <div class="right_col" role="main">
      <div class="col-md-12 col-sm-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>Configuracion/<small>Monedas </small></h2>
                  <h5 class="nav navbar-right panel_toolbox"><button class="btn btn-success" onclick="add_mda()">Moneda
                          <i class="glyphicon glyphicon-plus"></i></button></h5>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <div class="row">

                      <div class="col-sm-12">
                          <div class="card-box table-responsive">
                              <p class="text-muted font-13 m-b-30">
                              </p>
                              <table id="tablamda" class="table table-striped table-bordered" style="width:100%">
                                  <thead>
                                      <tr>
                                          <th>Nombre</th>
                                          <th>sigla</th>
                                          <th>Codigo</th>
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
      <!-- Bootstrap modal -->
      <div class="modal fade" id="modal_formmda" role="dialog">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h3 class="modal-title">Registro Marcas</h3>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                              aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modal-body form">
                      <form action="#" id="formmda" class="form-horizontal">
                          <input type="hidden" value="" name="id" />
                          <div class="form-body">
                              <div class="form-group">
                                  <label class="control-label col-md-3 required">Nombre</label>
                                  <div class="col-md-9">
                                      <input name="nommda" required="" placeholder="Nombre Moneda" class="form-control"
                                          type="text" minlength="1" maxlength="45">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-md-3 required">Sigla</label>
                                  <div class="col-md-9">
                                      <input name="sglamda" required="" placeholder="Sigla Moneda" class="form-control"
                                          type="text" minlength="1" maxlength="5">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-md-3 required">Codigo</label>
                                  <div class="col-md-9">
                                      <input name="codimda" placeholder="Codigo Moneda" required="" class="form-control"
                                          type="text" minlength="1" maxlength="4">
                                  </div>
                              </div>                          
                          </div>
                      </form>
                  </div>
                  <div class="modal-footer">
                      <button type="button" id="btnSave" onclick="savemda()" class="btn btn-primary">Guardar</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                  </div>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
      <!-- End Bootstrap modal -->
  </div>
  <!-- /page content -->