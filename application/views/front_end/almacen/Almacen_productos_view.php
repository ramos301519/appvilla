  <!-- page content -->
  <div class="right_col" role="main">
      <div class="col-md-12 col-sm-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>Almacen/<small> </small>Producto</h2>
                  <h5 class="nav navbar-right panel_toolbox"><button class="btn btn-success" onclick="add_p()">Productos
                          <i class="glyphicon glyphicon-plus"></i></button></h5>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <div class="row">

                      <div class="col-sm-12">
                          <div class="card-box table-responsive">
                              <p class="text-muted font-13 m-b-30">
                              </p>
                              <table id="tablap" class="table table-striped table-bordered" style="width:100%">
                                  <thead>
                                      <tr>
                                          <th>Sku</th>
                                          <th>Nombre</th>
                                          <th>Categoria</th>
                                          <th>SubCategoria</th>
                                          <th>Marca</th>
                                          <th>presentacion</th>
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
      <div class="modal fade" id="modal_formp" role="dialog">
          <div class="modal-dialog modal-lg modal-dialog-centeres">
              <div class="modal-content">
                  <div class="modal-header">
                      <h3 class="modal-title">Registro Marcas</h3>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                              aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modal-body form">
                      <form action="#" id="formp" class="form-horizontal" enctype="multipart/form-data">
                          <input type="hidden" value="" name="id" />
                          <div class="form-body">
                              <div class="form-group">
                                  <label class="control-label col-md-3 required">SKU</label>
                                  <div class="col-md-9">
                                      <input name="SKU" required="" placeholder="SKU" class="form-control" type="text"
                                          minlength="1" maxlength="45">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-md-3 required">Nombre</label>
                                  <div class="col-md-9">
                                      <input name="nomp" required="" placeholder="Nombre producto max 60 caracteres"
                                          class="form-control" type="text" minlength="1" maxlength="60">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-md-3">Descripcion</label>
                                  <div class="col-md-9">
                                      <input name="descp" placeholder="Descripcion producto max 255 caracteres"
                                          class="form-control" type="text" maxlength="255">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-md-3">Caracteristicas</label>
                                  <div class="col-md-9">
                                      <textarea class="form-control" name="caracp"
                                          placeholder="Caracteristicas producto max 500 caracteres" id="caracp" rows="2"
                                          maxlength="500"></textarea>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-md-3">Especificaciones Tecnicas</label>
                                  <div class="col-md-9">
                                      <textarea class="form-control" name="espetecp"
                                          placeholder="Especificaciones Tecnicas producto max 500 caracteres"
                                          id="espetecp" rows="2" maxlength="500"></textarea>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label class="col-form-label col-md-3 " for="first-name">Categoria
                                      <span class="required"></span>
                                  </label>
                                  <div class="col-md-9">
                                      <select class="form-control" required="required" id="departamentovce"
                                          name="departamentovce" onchange="get_provincias(this.value)">
                                      </select>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-form-label col-md-3" for="first-name">SubCategoria<span
                                          class="required"></span>
                                  </label>
                                  <div class="col-md-9">
                                      <select class="form-control" required="required" name="provinciavce"
                                          id="provinciavce">
                                      </select>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-form-label col-md-3" for="first-name">Marca
                                      <span class="required"></span>
                                  </label>
                                  <div class="col-md-9">
                                      <select class="form-control" required="required" name="distritovce"
                                          id="distritovce">
                                      </select>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-form-label col-md-3" for="first-name">Presentacion
                                      <span class="required"></span>
                                  </label>
                                  <div class="col-md-9 ">
                                      <select class="form-control" required="required" name="distritovce"
                                          id="distritovce">
                                      </select>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-form-label col-md-3" for="first-name">Peresible
                                      <span class="required"></span>
                                  </label>
                                  <div class="col-md-9 ">                                      
                                      <p>											No:
											<input type="radio" class="flat" name="ppere" id="ppere" value="0" checked="" />
                                            Si:
											<input type="radio" class="flat" name="ppere" id="ppere" value="1" />
										</p>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-form-label col-md-3" for="first-name">Stock Minimo
                                      <span class="required"></span>
                                  </label>
                                  <div class="col-md-9 ">
                                  <input name="stockmin" required="" placeholder="Stock Minimo del producto "
                                          class="form-control" type="number" value="" min="0" step="1">                                     
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-form-label col-md-3" for="first-name">Imagen/Imagenes
                                      <span class="required"></span>
                                  </label>
                                  <div class="col-md-9 ">
                                  <div class="media">
                                      <img class="align-self-center mr-3 img-thumbnail" src="assest/img/default.png"
                                          alt="PreVisual Logo Producto" id="imagePreview" style="width:100px">
                                      <div class="media-body">
                                          <input type="file" class="form-control" id="imangenp[]" name="imangenp[]"
                                              placeholder="Imagenes Productos" accept=".png,.jpg,.svg,.gif" size="5120" multiple />
                                      </div>
                                  </div>
                                  </div>
                              </div>

                          </div>
                      </form>
                  </div>
                  <div class="modal-footer">
                      <button type="button" id="btnSave" onclick="savemp()" class="btn btn-primary">Guardar</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                  </div>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
      <!-- End Bootstrap modal -->
  </div>
  <!-- /page content -->
 <!-- Almacen productos -->
  <script src="assest/appjs/Almacen/productos.js"></script>
