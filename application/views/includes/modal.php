 <div id="detalleproduc" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title" id="myModalLabel2">Cerveza Cusqueña</h4>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                         aria-hidden="true">×</span>
                 </button>
             </div>
             <div class="modal-body">

             </div>
             <div class="modal-footer">
             </div>
         </div>
     </div>
 </div>

 <div id="confirmacionpago" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title" id="myModalLabel2">Pago Realizado</h4>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                         aria-hidden="true">×</span>
                 </button>
             </div>
             <div class="modal-body">
                 <p style="float:midle;"><i class="fa fa-check-circle size:5x"></i></p>

                 <div class="table-responsive">
                     <table class="table ">
                         <tbody>
                             <tr>
                                 <td>
                                     <p><strong>MONTO TOTAL</strong></P>
                                 </td>
                                 <td>
                                     <p style="float:right;">67.26</p>
                                 </td>
                             </tr>
                             <tr>
                                 <td>
                                     <P><strong>MONTO RECIBIDO</strong></P>
                                 </td>
                                 <td>
                                     <p style="float:right;">68.00</p>
                                 </td>
                             </tr>
                             <tr>
                                 <td>
                                     <P><strong>SALDO</strong></P>
                                 </td>
                                 <td>
                                     <p style="float:right;">-0.74</p>
                                 </td>
                             </tr>
                         </tbody>
                     </table>
                 </div>

             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                 <button type="button" class="btn btn-success"><i class="fa fa-save"> </i> GRABAR</button>
             </div>

         </div>
     </div>
 </div>
 <!-- Modal Mensaje -->

 <div class="modal-backdrop modal" id="mdalload" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
     aria-hidden="true" style="padding-top: 18%; overflow-y: visible;">
     <div class="modal-dialog modal-sm">
         <div class="modal-content">
             <div class="modal-body">
             <p class="text-center"><img src="assest/img/loading_onepage.gif" /></p><br><div class="alert alert-primary" role="alert"><p class="text-center"><strong>Procesando...</strong></p></div>
        
             </div>
         </div>
     </div>
 </div>
 <!-- Modal Mensaje -->
 <div class="modal fade" id="mdalmsg" role="dialog">
     <div class="modal-dialog modal-md">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title">Modal Header</h4>
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
             </div>
             <div class="modal-body">
                 <p>This is a small modal.</p>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
             </div>
         </div>
     </div>
 </div>
 <!-- Modal Cliente -->
 <div class="modal fade" id="mdalcliente" role="dialog">
     <div class="modal-dialog modal-lg modal-dialog-centeres">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title">Crear Cliente</h4>
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
             </div>
             <form id="frmcliente" data-parsley-validate class="form-horizontal form-label-left">
                 <div class="modal-body">
                     <div class="msg"></div>
                     <br />
                     <div class="item form-group">
                         <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Tipo
                             Identificacion <span class="required">*</span>
                         </label>
                         <div class="col-md-6 col-sm-6 ">
                             <select class="form-control" required="required" name="tipoidentificacion"
                                 id="tipoidentificacion" onchange="get_muestrarazonnombrescliente(this.value)">

                             </select>
                         </div>
                     </div>
                     <div class="item form-group">
                         <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nro Identificacion
                             <span class="required">*</span>
                         </label>
                         <div class="col-md-6 col-sm-6 ">
                             <input type="text" class="form-control" id="nroidentificacion" name="nroidentificacion"
                                 required="" pattern="[0-9]+" />
                         </div>
                     </div>
                     <div class="ruc">
                         <div class="item form-group">
                             <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Razon Social
                             </label>
                             <div class="col-md-6 col-sm-6 ">
                                 <input type="text" class="form-control" id="nombreempresarialc"
                                     name="nombreempresarialc" placeholder="EMPRESA SAC" />
                             </div>
                         </div>
                     </div>
                     <div class="dni">
                         <div class="item form-group">
                             <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Apellidos
                             </label>
                             <div class="col-md-6 col-sm-6 ">
                                 <input type="text" class="form-control" id="apellidosc" name="apellidosc"
                                     placeholder="APELLIDOS" />
                             </div>
                         </div>
                         <div class="item form-group">
                             <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nombres
                             </label>
                             <div class="col-md-6 col-sm-6 ">
                                 <input type="text" class="form-control" id="nombresc" name="nombresc"
                                     placeholder="NOMBRES" />
                             </div>
                         </div>
                     </div>

                     <div class="item form-group">
                         <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Direccion <span
                                 class="required">*</span>
                         </label>
                         <div class="col-md-6 col-sm-6 ">
                             <input type="text" class="form-control" id="direccionc" name="direccionc"
                                 placeholder="Av. Peru 123" required="" />

                         </div>
                     </div>
                     <div class="item form-group">
                         <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Correo
                         </label>
                         <div class="col-md-6 col-sm-6 ">
                             <input type="text" class="form-control" id="correoc" name="correoc"
                                 placeholder="contacto@empresa.com" />

                         </div>
                     </div>
                     <div class="item form-group">
                         <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Telefono
                         </label>
                         <div class="col-md-6 col-sm-6 ">
                             <input type="text" class="form-control" id="telefonoc" name="telefonoc"
                                 placeholder="987654321" />

                         </div>
                     </div>
                     <div class="item form-group">
                         <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Contacto
                         </label>
                         <div class="col-md-6 col-sm-6 ">
                             <input type="text" class="form-control" id="contactoc" name="contactoc"
                                 placeholder="Pedro Lopez" />

                         </div>
                     </div>

                     <div class="item form-group">
                         <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Departamento <span
                                 class="required">*</span>
                         </label>
                         <div class="col-md-6 col-sm-6 ">
                             <select class="form-control" required="required" id="departamentoc" name="departamentoc"
                                 onchange="get_provincias(this.value)">
                             </select>
                         </div>
                     </div>
                     <div class="item form-group">
                         <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Provincia<span
                                 class="required">*</span>
                         </label>
                         <div class="col-md-6 col-sm-6 ">
                             <select class="form-control" required="required" name="provinciac" id="provinciac"
                                 onchange="get_distritos(this.value)">

                             </select>
                         </div>
                     </div>
                     <div class="item form-group">
                         <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Distrito <span
                                 class="required">*</span>
                         </label>
                         <div class="col-md-6 col-sm-6 ">
                             <select class="form-control" required="required" name="distritoc" id="distritoc">
                             </select>
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <div class="item form-group">
                         <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                         <button class="btn btn-info" type="reset">Reset</button>
                         <button type="submit" class="btn btn-success" id="btnsavecli">Guardar</button>
                     </div>
                 </div>
             </form>
         </div>
     </div>
 </div>

 <!-- Modal Lista Producto Vendedor -->
 <div class="modal fade" id="mdalproductoVendedor" role="dialog">
     <div class="modal-dialog modal-lg modal-dialog-centeres">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title">Lista Productos</h4>
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                 </br>
                 <div class="msg"></div>
             </div>
             <div class="modal-body">

             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
             </div>
         </div>
     </div>
 </div>
