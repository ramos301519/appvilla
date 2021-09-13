  <!-- page content -->
  <div class="right_col" role="main">
      <div class="col-md-12 col-sm-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>Configuracion\Empresas (ClientesApp)<small> </small></h2>
                  <h5 class="nav navbar-right panel_toolbox"><button class="btn btn-success" onclick="add_empresa()"><i
                              class="glyphicon glyphicon-plus"></i> Empresa</button></h5>

                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <div class="row">

                      <div class="col-sm-12">
                          <div class="card-box table-responsive">
                              <p class="text-muted font-13 m-b-30">
                              </p>
                              <table id="tablaempresa" class="table table-striped table-bordered" style="width:100%">
                                  <thead>
                                      <tr>
                                          <th>Identificacion</th>
                                          <th>Descripcion</th>
                                          <th>email</th>
                                          <th>telefono</th>
                                          <th>Contacto</th>
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
      <div class="modal fade" id="modal_formape" role="dialog">
          <div class="modal-dialog modal-lg modal-dialog-centeres">
              <div class="modal-content">
                  <div class="modal-header">
                      <h3 class="modal-title">Registro Empresa</h3>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                              aria-hidden="true">&times;</span></button>
                  </div>
                  <form id="formape" class="form-horizontal">
                      <div class="modal-body form">
                          <input type="hidden" value="" name="empresaid" id="empresaid" />
                          <div class="msg"></div>
                          <br />
                          <div class="item form-group">
                              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Tipo
                                  Identificacion <span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 ">
                                  <select class="form-control" required="required" name="tipoidentificacione"
                                      id="tipoidentificacione" onchange="get_muestrarazonnombrescliente(this.value)">
                                  </select>
                              </div>
                          </div>
                          <div class="item form-group">
                              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nro
                                  Identificacion
                                  <span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 ">
                                  <input type="text" class="form-control" id="nroidentificacione"
                                      name="nroidentificacione" required="required" pattern="[0-9]+" autofocus="autofocus" />
                              </div>
                          </div>
                          <div class="item form-group">
                              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Razon
                                  Social <span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 ">
                                  <input type="text" class="form-control" id="nombreempresae" name="nombreempresae"
                                      placeholder="EMPRESA SAC" required="required" />                              </div>
                          </div>

                          <div class="item form-group">
                              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Direccion
                                  <span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 ">
                                  <input type="text" class="form-control" id="direccione" name="direccione"
                                      placeholder="Av. Peru 123" required="required" />
                              </div>
                          </div>
                          <div class="item form-group">
                              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Correo <span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 ">
                                  <input type="email" class="form-control" id="correoe" name="correoe"
                                      placeholder="contacto@empresa.com" required="required" />
                              </div>
                          </div>
                          <div class="item form-group">
                              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Telefono
                              </label>
                              <div class="col-md-6 col-sm-6 ">
                                  <input type="tel" class="form-control" id="telefonoe" name="telefonoe"
                                      placeholder="987654321" />
                              </div>
                          </div>
                          <div class="item form-group">
                              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Contacto
                              </label>
                              <div class="col-md-6 col-sm-6 ">
                                  <input type="text" class="form-control" id="contactoe" name="contactoe"
                                      placeholder="Pedro Lopez" />
                              </div>
                          </div>

                          <div class="item form-group">
                              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Departamento
                                  <span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 ">
                                  <select class="form-control" required="required" id="departamentoe"
                                      name="departamentoe" onchange="get_provincias(this.value)">
                                  </select>
                              </div>
                          </div>
                          <div class="item form-group">
                              <label class="col-form-label col-md-3 col-sm-3 label-align"
                                  for="first-name">Provincia<span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 ">
                                  <select class="form-control" required="required" name="provinciae" id="provinciae"
                                      onchange="get_distritos(this.value)">

                                  </select>
                              </div>
                          </div>
                          <div class="item form-group">
                              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Distrito
                                  <span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 ">
                                  <select class="form-control" required="required" name="distritoe" id="distritoe">
                                  </select>
                              </div>
                          </div>
                          <div class="item form-group" id="photo-preview">
                              <label class="col-form-label col-md-3 col-sm-3 label-align"></label>
                              <div class="col-md-6 col-sm-6 ">
                                  (No Hay Logo)
                                  <span class="help-block"></span>
                              </div>
                          </div>
                          <div class="item form-group">
                              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name"
                                  id="label-photo">Logo
                              </label>
                              <div class="col-md-6 col-sm-6 ">
                                  <div class="media">
                                      <img class="align-self-center mr-3 img-thumbnail" src="assest/img/default.png"
                                          alt="PreVisual Logo Empresa" id="imagePreview" style="width:100px">
                                      <div class="media-body">
                                          <input type="file" class="form-control" id="logoe" name="logoe"
                                              placeholder="Logo" accept=".png,.jpg,.svg,.gif" size="5120" />

                                      </div>

                                  </div>

                              </div>
                          </div>


                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-danger" id="btnCancelare"
                              data-dismiss="modal">Cancelar</button>
                          <button class="btn btn-info" type="reset" id="btnResete">Reset</button>
                          <button type="button" id="btnSavee" onclick="save()" class="btn btn-primary">Guardar</button>

                      </div>
                  </form>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
      <!-- /page content -->