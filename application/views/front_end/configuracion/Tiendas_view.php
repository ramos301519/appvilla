  <!-- page content -->
  <div class="right_col" role="main">
      <div class="col-md-12 col-sm-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>Configuracion/Tiendas<small> </small></h2>                  
                  <h5 class="nav navbar-right panel_toolbox"><button class="btn btn-success" onclick="add_tda()">Tienda <i
                              class="glyphicon glyphicon-plus"></i></button></h5>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <div class="row">

                      <div class="col-sm-12">
                          <div class="card-box table-responsive">
                              <p class="text-muted font-13 m-b-30">
                              </p>
                              <table id="tablatda" class="table table-striped table-bordered" style="width:100%">
                                  <thead>
                                      <tr>
                                          <th>Nombre</th>
                                          <th>Direccion</th>
                                          <th>Telefono</th>
                                          <th>Email</th>                                        
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
  <div class="modal fade" id="modal_formtda" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h3 class="modal-title">Registrar Tienda</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 </div>
                <div class="modal-body form">
                    <form action="#" id="formtda" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3 required">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" name="nomtda" required="" placeholder="Nombre" class="form-control"  minlength="4" maxlength="199" >
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="control-label col-md-3">direccion</label>
                                <div class="col-md-9">
                                    <input type="text" name="diretda" placeholder="Direccion" class="form-control"  maxlength="255">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Telefono</label>
                                <div class="col-md-9">
                                    <input type="telephone" name="telftda" placeholder="Telefono" class="form-control"  maxlength="15">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Email</label>
                                <div class="col-md-9">
                                    <input type="email" name="emailtda" placeholder="Email" class="form-control"  maxlength="255">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save_tda()" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Bootstrap modal -->
  </div>
  <!-- /page content -->
