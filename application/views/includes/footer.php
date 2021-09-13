 </div>
 <!-- /page content -->
 <!-- Small modal -->
 <?php
$this->load->view('includes/modal');
?>
 <!-- /modals -->
 <!-- footer content -->
 <footer>
     <div class="pull-right">
         AppVilla - 2021</a>
     </div>
     <div class="clearfix"></div>
 </footer>
 <!-- /footer content -->
 </div>
 </div>

 <!-- jQuery -->
 <script src="assest/vendors/jquery/dist/jquery.min.js"></script>
 <!-- jQuery ui -->
 <!-- Bootstrap -->
 <script src="assest/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
 <!-- FastClick -->
 <script src="assest/vendors/fastclick/lib/fastclick.js"></script>
 <!-- NProgress -->
 <script src="assest/vendors/nprogress/nprogress.js"></script>
 <!-- jQuery custom content scroller -->
 <script src="assest/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
 <!-- Completando -->
 <!-- bootstrap-progressbar -->
 <script src="assest/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
 <!-- iCheck -->
 <script src="assest/vendors/iCheck/icheck.min.js"></script>
 <!-- bootstrap-daterangepicker -->
 <script src="assest/vendors/moment/min/moment.min.js"></script>
 <script src="assest/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
 <!-- bootstrap-wysiwyg -->
 <script src="assest/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
 <script src="assest/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
 <script src="assest/vendors/google-code-prettify/src/prettify.js"></script>
 <!-- jQuery Tags Input -->
 <script src="assest/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
 <!-- jquery-ui.min -->
 <script src="assest/vendors/jquery-ui/jquery-ui.min.js"></script>
 <!-- Switchery -->
 <script src="assest/vendors/switchery/dist/switchery.min.js"></script>
 <!-- Select2 -->
 <script src="assest/vendors/select2/dist/js/select2.full.min.js"></script>
 <!-- Parsley -->
 <script src="assest/vendors/parsleyjs/dist/parsley.min.js"></script>
 <!-- Autosize -->
 <script src="assest/vendors/autosize/dist/autosize.min.js"></script>
 <!-- jQuery autocomplete -->
 <script src="assest/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
 <!-- starrr -->
 <script src="assest/vendors/starrr/dist/starrr.js"></script>
 <!-- Custom Theme Scripts -->
 <script src="assest/build/js/custom.min.js"></script>
 <!-- sweetalert2-master -->
 <script src="assest/vendors/sweetalert2-master/js/sweetalert2.min.js"></script>
 <!-- bootstrap-sweetalert -->
 <script src="assest/vendors/bootstrap-sweetalert/js/sweetalert.min.js"></script>

 <!-- Datatables -->
 <script src="assest/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
 <script src="assest/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
 <script src="assest/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
 <script src="assest/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
 <script src="assest/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
 <script src="assest/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
 <script src="assest/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
 <script src="assest/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
 <script src="assest/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
 <script src="assest/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
 <script src="assest/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
 <script src="assest/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
 <!-- gloables -->

 <script src="assest/appjs/general.js"></script>

 <script src="assest/appjs/util.js"></script>

 <?php foreach ($filesjs as $filejs) {?>
 <script src="assest/appjs/<?php echo $filejs; ?>.js"></script>
 <?php }?>
 </body>

 </html>