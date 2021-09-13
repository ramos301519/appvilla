  <!-- page content -->
  <div class="right_col" role="main">
      <div class="col-md-12 col-sm-12">
          <div class="x_panel">
              <div class="x_title">
                  <h2>Configuracion\Empresa<small></small></h2>
                  <h5 class="nav navbar-right panel_toolbox"> </h5>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <div class="row">
                      <div class="col-sm-12">
                          <div class="card-box table-responsive">
                              <p class="text-muted font-13 m-b-30">
                              </p>
                              <form id="formem" class="form-horizontal">
                      <div class="modal-body form">
                          <input type="hidden" value="" name="empresavid" id="empresavid" />
                          <div class="msg"></div>
                          <br />
                          <div class="item form-group">
                              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Tipo
                                  Identificacion 
                              </label>
                              <div class="col-md-6 col-sm-6 ">
                                 
                                  <input type="text" class="form-control" id="tipoidentificacionv"
                                      name="tipoidentificacionv" required="required"  />
                              </div>
                          </div>
                          <div class="item form-group">
                              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nro
                                  Identificacion
                              </label>
                              <div class="col-md-6 col-sm-6 ">
                                  <input type="text" class="form-control" id="nroidentificacionv"
                                      name="nroidentificacionv" required="required" pattern="[0-9]+" autofocus="autofocus" />
                              </div>
                          </div>
                          <div class="item form-group">
                              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Razon
                                  Social <span class="required"></span>
                              </label>
                              <div class="col-md-6 col-sm-6 ">
                                  <input type="text" class="form-control" id="nombreempresav" name="nombreempresav"
                                      placeholder="EMPRESA SAC" required="required" />                              </div>
                          </div>

                          <div class="item form-group">
                              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Direccion
                                  <span class="required"></span>
                              </label>
                              <div class="col-md-6 col-sm-6 ">
                                  <input type="text" class="form-control" id="direccionv" name="direccionv"
                                      placeholder="Av. Peru 123" required="required" />
                              </div>
                          </div>
                          <div class="item form-group">
                              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Correo <span class="required"></span>
                              </label>
                              <div class="col-md-6 col-sm-6 ">
                                  <input type="email" class="form-control" id="correov" name="correov"
                                      placeholder="contacto@empresa.com" required="required" />
                              </div>
                          </div>
                          <div class="item form-group">
                              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Telefono
                              </label>
                              <div class="col-md-6 col-sm-6 ">
                                  <input type="tel" class="form-control" id="telefonov" name="telefonov"
                                      placeholder="987654321" />
                              </div>
                          </div>
                          <div class="item form-group">
                              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Contacto
                              </label>
                              <div class="col-md-6 col-sm-6 ">
                                  <input type="text" class="form-control" id="contactov" name="contactov"
                                      placeholder="Pedro Lopez" />
                              </div>
                          </div>

                          <div class="item form-group">
                              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Departamento
                                  <span class="required"></span>
                              </label>
                              <div class="col-md-6 col-sm-6 ">
                                  <select class="form-control" required="required" id="departamentovce"
                                      name="departamentovce" onchange="get_provincias(this.value)">
                                  </select>
                              </div>
                          </div>
                          <div class="item form-group">
                              <label class="col-form-label col-md-3 col-sm-3 label-align"
                                  for="first-name">Provincia<span class="required"></span>
                              </label>
                              <div class="col-md-6 col-sm-6 ">
                                  <select class="form-control" required="required" name="provinciavce" id="provinciavce"
                                      onchange="get_distritos(this.value)">

                                  </select>
                              </div>
                          </div>
                          <div class="item form-group">
                              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Distrito
                                  <span class="required"></span>
                              </label>
                              <div class="col-md-6 col-sm-6 ">
                                  <select class="form-control" required="required" name="distritovce" id="distritovce">
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
                                          <input type="file" class="form-control" id="logoev" name="logoev"
                                              placeholder="Logo" accept=".png,.jpg,.svg,.gif" size="5120" />

                                      </div>
                                  </div>
                              </div>
                          </div>
                          </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-danger" id="btnCancelare"
                              data-dismiss="modal">Cancelar</button>
                          <button class="btn btn-info" type="reset" id="btnResetem">Reset</button>
                          <button type="button" id="btnSaveem" onclick="save()" class="btn btn-primary">Guardar</button>

                      </div>
                  </form>
                          </div>

                      </div>
                  </div>
              </div>

          </div>

      </div>
     