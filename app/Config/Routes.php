<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Login::index');
$routes->post('/auth', 'Login::auth');
$routes->post('HCbpms/auth', 'Login::auth');
$routes->get('/logout', 'Login::logout');
$routes->get('HCbpms/logout', 'Login::logout'); 
$routes->post('/cambiarEmpresa', 'Login::cambiarEmpresa');
$routes->post('HCbpms/cambiarEmpresa', 'Login::cambiarEmpresa');
//$routes->post('HCbpms/auth', 'Login::auth');
//$routes->post('/auth', 'Login::auth');

//$routes->post('HCbpms/empresa', 'Empresa::index');
//$routes->post('/empresa', 'Empresa::index');
//$routes->get('HCbpms/empresa/index/(:any)', 'Empresa::index/$1');
//$routes->post('HCbpms/empresa/index/(:any)', 'Empresa::index/$1');
//$routes->post('HCbpms/empresa/index/(:any)', 'Empresa::index/$1');
//$routes->post('HCbpms/empresa/nuevo/(:any)', 'Empresa::nuevo/$1');
//$routes->post('HCbpms/empresa/actualizar/(:any)', 'Empresa::actualizar/$1');

//$routes->post('HCbpms/empresa/recibirdatos/(:any)/(:any)/(:any)/(:any)/(:any)', 'Empresa::recibirdatos/$1/$2/$3/$4/$5');

//$routes->post('HCbpms/empresa/eliminar/(:any)/(:any)/(:any)', 'Empresa::eliminar/$1/$2/$3');
//$routes->post('HCbpms/empresa/eliminar/(:any)/(:any)/(:any)/(:any)/(:any)', 'Empresa::eliminar/$1/$2/$3/$4/$5');
//$routes->post('HCbpms/empresa/Modificardatos/(:any)/(:any)/(:any)/(:any)/(:any)', 'Empresa::Modificardatos/$1/$2/$3/$4/$5');
//$routes->post('HCbpms/empresa/actualizar/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Empresa::actualizar/$1/$2/$3/$4/$5/$6');
//$routes->post('HCbpms/empresa/nuevo/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Empresa::nuevo/$1/$2/$3/$4/$5/$6');
//$routes->post('HCbpms/empresa/detalle/(:any)/(:any)/(:any)', 'Empresa::detalle/$1/$2/$3');
////$routes->post('empresa/detalle/(:any)/(:any)/(:any)', 'Empresa::detalle/$1/$2/$3');
//$routes->get('HCbpms/empresa/obtenerNuevoContenido', 'Empresa::obtenerNuevoContenido');



$routes->post('empresa/index/(:any)', 'Empresa::index/$1');
$routes->post('empresa/nuevo/(:any)', 'Empresa::nuevo/$1');
$routes->post('empresa/actualizar/(:any)', 'Empresa::actualizar/$1');

$routes->post('empresa/recibirdatos/(:any)/(:any)/(:any)/(:any)/(:any)', 'Empresa::recibirdatos/$1/$2/$3/$4/$5');

$routes->post('empresa/eliminar/(:any)/(:any)/(:any)', 'Empresa::eliminar/$1/$2/$3');
$routes->post('empresa/eliminar/(:any)/(:any)/(:any)/(:any)/(:any)', 'Empresa::eliminar/$1/$2/$3/$4/$5');
$routes->post('empresa/Modificardatos/(:any)/(:any)/(:any)/(:any)/(:any)', 'Empresa::Modificardatos/$1/$2/$3/$4/$5');
$routes->post('empresa/actualizar/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Empresa::actualizar/$1/$2/$3/$4/$5/$6');
$routes->post('empresa/nuevo/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Empresa::nuevo/$1/$2/$3/$4/$5/$6');
$routes->post('empresa/detalle/(:any)/(:any)/(:any)', 'Empresa::detalle/$1/$2/$3');
//$routes->post('empresa/detalle/(:any)/(:any)/(:any)', 'Empresa::detalle/$1/$2/$3');
$routes->get('empresa/obtenerNuevoContenido', 'Empresa::obtenerNuevoContenido');

$routes->get('register', 'Users::index');
$routes->post('register', 'Users::create');

$routes->get('activate-user/(:any)', 'Users::activateUser/$1');

$routes->get('password-request', 'Users::linkRequestForm');
$routes->post('password-email', 'Users::sendRequestLinkEmail');

$routes->get('password-reset/(:any)', 'Users::resetForm/$1');
$routes->post('password/reset', 'Users::resetPassword');

//$routes->get('home', 'Home::index',['filter'=>'auth']); 
//admin/home
$routes->group('/',['filter'=>'auth'], function($routes){
  $routes->get('/home', 'Home::index');
  $routes->get('HCbpms/home', 'Home::index'); 
}); 
