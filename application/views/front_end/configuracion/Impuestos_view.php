  <!-- page content -->
  <div class="right_col" role="main">
      <div class="col-md-12 col-sm-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>Configuracion/Impuestos<small> </small></h2>
                  <h5 class="nav navbar-right panel_toolbox"><button class="btn btn-success" onclick="add_imp()">Impuesto <i class="glyphicon glyphicon-plus"></i></button></h5>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <div class="row">

                      <div class="col-sm-12">
                          <div class="card-box table-responsive">
                              <p class="text-muted font-13 m-b-30">
                              </p>
                              <table id="tabla_imp" class="table table-striped table-bordered" style="width:100%">
                                  <thead>
                                      <tr>
                                          <th>Porcentaje %</th>
                                          <th>Impuesto</th>
                                          <th>Nombre</th>
                                          <th>Ctaegoria</th>
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
var fechaactual = '<?php echo gmdate("Y-m-d", time() - 18000)?>';
</script>
      <!-- Bootstrap modal -->
      <div class="modal fade" id="modal_form_imp" role="dialog">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h3 class="modal-title">Registrar Impuestos</h3>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modal-body form">
                      <form action="#" id="form_imp" class="form-horizontal">
                          <input type="hidden" value="" name="idimp" id="idimp" />
                          <div class="form-body">
                              <div class="form-group">
                                  <label class="control-label col-md-3">Tipo impuesto</label>
                                  <div class="col-md-9">
                                      <select class="form-control" required="required" name="tipoimpuesto" id="tipoimpuesto" onchange="get_tipoimpuesto_categoria(this.value)">
                                      </select>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-md-3">Categoria</label>
                                  <div class="col-md-9">
                                      <select class="form-control" required="required" name="cate_imp" id="cate_imp">
                                      </select>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-md-3 required">Procentaje %</label>
                                  <div class="col-md-9">
                                      <input type="number" required="required" name="porcimp" id="porcimp" required="" placeholder="Porcenta 0.0 " class="form-control" min="0.001" pattern="^\d*,?\d*$" max="99.99">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-md-3">Fecha Alta</label>
                                  <div class="col-md-9">
                                      <input type="date" name="impfeact" id="impfeact" placeholder="Fecha Alta" class="form-control">
                                  </div>
                              </div>

                          </div>
                      </form>
                  </div>
                  <div class="modal-footer">
                      <button type="button" id="btnSave" onclick="save_imp()" class="btn btn-primary">Guardar</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                  </div>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
      <!-- End Bootstrap modal -->
  </div>
  <!-- /page content -->

 