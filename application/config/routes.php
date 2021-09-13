<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login_control';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
/*Usuario */
$route['valida'] = 'login_control/process';
$route['salir'] = 'login_control/do_logout';
/*
Almacen
*/
$route['appvilla'] = 'AppVilla/appvilla/index';
/*
Ventas
*/
$route['venta'] = 'Ventas/Ventas_control/index'; 
$route['ventaformapago'] = 'ventas/formapago';
$route['ventapago'] = 'ventas/pago';
$route['Listarventas'] = 'Ventas/Ventas_control/ventas'; 
$route['cliente'] = 'Cliente/Clientes_control/index';
$route['cotizacion'] = 'Cotizacion_control';
/*
Almacen
*/
$route['categorias'] = 'Almacen/Categoria_control/index';
$route['subcategorias'] = 'Almacen/Subcategoria_control/index';
$route['marcas'] = 'Almacen/Marcas_control/index';
$route['productos'] = 'Almacen/Productos_control/index';
/*
Compras
*/
//$route['compra'] = 'appvilla';
/*
Caja
*/
//$route['default_controller'] = 'appvilla';
/*
ConfiguracionApp
*/
$route['appempresa'] = 'AppVilla/AppVilla_empresa_control/index';
$route['modulos'] = 'AppVilla/AppVilla_modulos_control/index';
$route['modulosempresa'] = 'AppVilla/Appvilla_moduloempresa_control/index';
$route['licencia'] = 'AppVilla/Appvilla_licencias_control/index';
$route['integraose'] = 'AppVilla/Appvilla_integraose_control/index';
$route['svrmail'] = 'AppVilla/Appvilla_mail_control/index';
$route['usuariovilla'] = 'AppVilla/Appvilla_usuario_control/index';
 
$route['tipoimpuesto'] = 'AppVilla/Appvilla_tipoimpuestos_control/index';
$route['tipocomprobante'] = 'AppVilla/Appvilla_maestrobase_control/tiposcomprobante';

$route['tipoidentificacion'] = 'AppVilla/Appvilla_maestrobase_control/index';
$route['modalidadpago'] = 'AppVilla/Appvilla_maestrobase_control/modalidadpago';
$route['unidadmedida'] = 'AppVilla/Appvilla_maestrobase_control/unidadmedida';
$route['moneda'] = 'AppVilla/Appvilla_moneda_control/index';
/*
Configuracion_Standar
*/

/*
Configuracion
*/
$route['empresa'] = 'Configuracion/Empresa_control/index';
$route['tienda'] = 'Configuracion/Tiendas_control/index';
$route['almacen'] = 'Configuracion/Almacenes_control/index';
$route['impuesto'] = 'Configuracion/Impuestos_control/index';
$route['tiposcambio'] = 'Configuracion/Tiposcambio_control/index';
$route['seriecorrelativo'] = 'Configuracion/Seriecorrelativos_control/index';







