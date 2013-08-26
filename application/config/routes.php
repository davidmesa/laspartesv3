<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

//$route['preguntas'] = "taller_en_linea/ver_preguntas";

$route['preguntas/no_activar_pregunta/(.+)'] = "taller_en_linea/no_activar_pregunta/$1";
$route['preguntas/activar_pregunta/(.+)'] = "taller_en_linea/activar_pregunta/$1";
$route['preguntas'] = "taller_en_linea";
$route['preguntas/(\d+)-(.+)'] = "taller_en_linea/ver_pregunta/$1/$2";
$route['preguntas/(\d+)-(.+)/buscar/(:any)'] = "taller_en_linea/ver_pregunta/$1/$2";
$route['preguntas/(.+)'] = "taller_en_linea/index/(.+)";
$route['preguntas/index/(.+)'] = "taller_en_linea/index/(.+)";


$route['autopartes/index/(.+)'] = "autopartes/index/(.+)";
$route['autopartes/ver_autoparte/(\d+)-(.+)'] = "autopartes/ver_autoparte/$1/$2";
$route['autopartes/ver_autoparte/(\d+)-(.+)/(:any)'] = "autopartes/ver_autoparte/$1/$2";
$route['autopartes/(\d+)-(.+)'] = "autopartes/ver_autoparte/$1/$2";
$route['autopartes/(\d+)-(.+)/(:any)'] = "autopartes/ver_autoparte/$1/$2";
$route['autopartes/buscar/(.+)'] = "autopartes/index/(.+)";
$route['autopartes/buscar'] = "autopartes/index";

$route['promociones/index/(.+)'] = "promociones/index/(.+)";
$route['promociones/buscar/(.+)'] = "promociones/index/(.+)";
$route['promociones/buscar'] = "promociones/index";
$route['promociones/ver_promocion/(\d+)-(.+)'] = "promociones/ver_promocion/$1/$2";
$route['promociones/ver_promocion/(\d+)-(.+)/(:any)'] = "promociones/ver_promocion/$1/$2";
$route['promociones/(\d+)-(.+)'] = "promociones/ver_promocion/$1/$2";
$route['promociones/(\d+)-(.+)/(:any)'] = "promociones/ver_promocion/$1/$2";


$route['talleres'] = "establecimientos";
$route['talleres/ver_establecimiento/(\d+)-(.+)'] = "establecimientos/ver_establecimiento/$1/$2";
$route['talleres/ver_establecimiento/(\d+)-(.+)/(:any)'] = "establecimientos/ver_establecimiento/$1/$2";
$route['talleres/(\d+)-(.+)'] = "establecimientos/ver_establecimiento/$1/$2";
$route['talleres/(\d+)-(.+)/buscar/(:any)'] = "establecimientos/ver_establecimiento/$1/$2";
$route['talleres/(.+)'] = "establecimientos/index/(.+)";
$route['talleres/index/(.+)'] = "establecimientos/index/(.+)";



$route['establecimientos/buscar/(.+)'] = "establecimientos/index/(.+)";
$route['establecimientos/buscar'] = "establecimientos/index";

$route['aprende/noticia/(\d+)/(.+)'] = "aprende/noticia/$1/(.+)";
$route['noticias/(\d+)/(.+)'] = "aprende/noticia/$1/(.+)";
$route['noticias/(\d+)-(.+)'] = "aprende/noticia/$1";

$route['aprende/tip/(\d+)/(.+)'] = "aprende/tip/$1/(.+)";
$route['tips/(\d+)/(.+)'] = "aprende/tip/$1/(.+)";
$route['tips/(\d+)-(.+)'] = "aprende/tip/$1";

$route['registro'] = "usuario/registrate";

$route['buscar'] = "buscar/general";
$route['buscar/(.+)'] = "buscar/general/$1";
$route['buscar/(.+)/pagina/(\d+)'] = "buscar/general/$1/(.+)/$2";

$route['carrito'] = "usuario/ver_carrito_compras";
$route['carrito/datos_envio'] = "usuario/datos_envio";
$route['carrito/pago_confirmacion'] = "usuario/pago_confirmacion";
$route['usuario/recibo/(.+)'] = "usuario/recibo/$1";
$route['usuario/califica_tu_experiencia/(.+)'] = "usuario/califica_tu_experiencia/$1";

$route['usuario/cronograma_flotas/(\d+)'] = "usuario/cronograma_flotas/$1";

$route['ofertas/(\d+)/(.+)'] = "ofertas/dar_oferta/$1/$2";

$route['default_controller'] = "inicio";
$route['404_override'] = '';


//admin

$route['admin/usuario/recibo/(\d+)/(.+)'] = "admin/usuario/recibo/$1/$2";
$route['admin/usuario/recibo/(\d+)/vehiculo/(.+)'] = "admin/usuario/recibo/$1/vehiculo/$2";
$route['admin/usuario/recibo/(\d+)/vehiculo'] = "admin/usuario/recibo/$1";

$route['admin/usuario/bono/(\d+)/(.+)'] = "admin/usuario/bono/$1/$2";

$route['admin/vehiculo/ver_hoja_mantenimiento/(\d+)'] = "admin/vehiculo/ver_hoja_mantenimiento/$1";


//OPERACIONES
/*inicio cotización*/
$route['operacion/cotizaciones/mostrar_cotizaciones/(.+)/(\d+)'] = "operacion/cotizaciones/mostrar_cotizaciones/$1/$2";
$route['operacion/cotizaciones/mostrar_cotizaciones/(.+)/(\d+)/(\d+)'] = "operacion/cotizaciones/mostrar_cotizaciones/$1/$2/$3";
/*fin cotización*/
/*inicio link de pago*/
$route['operacion/linkPago/mostrar_links/(.+)/(\d+)'] = "operacion/linkPago/mostrar_links/$1/$2";
$route['operacion/linkPago/mostrar_links/(.+)/(\d+)/(.+)'] = "operacion/linkPago/mostrar_links/$1/$2/$3";
$route['operacion/linkPago/form_links/(.+)/(\d+)/(.+)'] = "operacion/linkPago/form_links/$1/$2/$3";
$route['operacion/linkPago/editar_link/(\d+)/(\d+)'] = "operacion/linkPago/editar_link/$1/$2";
$route['operacion/ordenRemision/mostrar_ordedes/(.+)/(\d+)/(.+)'] = "operacion/ordenRemision/mostrar_ordedes/$1/$2/$3";
/*fin link de pago */



/* End of file routes.php */
/* Location: ./application/config/routes.php */