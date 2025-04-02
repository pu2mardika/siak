<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


// Create a new instance of our RouteCollection class.
//$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
//$routes->setDefaultNamespace('App\Controllers');
//$routes->setDefaultController('Home');
//$routes->setDefaultMethod('index');
//$routes->setTranslateURIDashes(false);
//$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
//routes->get('tuton/(:any)', 'RoomMember::cekTuton/$1');
$routes->post('user-login', 'Api\AuthController::userLogin', ['filter' => 'tokens']);
$routes->group('api', ['filter' => 'jwt'], static function ($routes) {
    $routes->resource('ResfSiswa');
 });
 
 $routes->group('apix', ['filter' => 'tokens'], static function ($routes) {
     $routes->resource('ResfSiswa');
 });

service('auth')->routes($routes, ['except' => ['login','user-login', 'auth/a/*','api/*','apix/*','tuton','tuton/*']]);
$routes->get('login', '\App\Controllers\LoginController::loginView');  // 
$routes->post('login', '\CodeIgniter\Shield\Controllers\LoginController::loginAction');

//$routes->get('register', '\App\Controllers\Auth\RegisterController::registerView');

$routes->group('tuton', static function ($routes) {
    $routes->get('cek', "RoomMember::cekTuton");
    $routes->get("doPost", "RoomMember::cekTuton");
});

$routes->group('menu', static function ($routes) {
    $routes->get('/', 'Menu::index');
    $routes->post('/', 'Menu::index');
    $routes->get('add', 'Menu::add');
    $routes->post('edit', 'Menu::edit');
    $routes->get('menuDetail', 'Menu::menuDetail');
});

$routes->group('role', static function ($routes) {
    $routes->get('/', 'Role::index');
    $routes->post('/', 'Role::index');
    $routes->get('add', 'Role::add');
    $routes->post('edit', 'Role::edit');
//    $routes->get('Detail', 'Role::menuDetail');
});

$routes->group('menu-role', static function($routes){
    $routes->get('/', 'Menu_role::index');
    $routes->get('add', 'Menu_role::add');
    $routes->post('edit', 'Menu_role::edit');
    $routes->get('edit', 'Menu_role::editView');
    $routes->get('menuDetail', 'Menu_role::menuDetail');
});

$routes->group('module', static function ($routes) {
    $routes->get('/', 'Module::index');
    $routes->get('add', 'Module::add');
    $routes->post('add', 'Module::add');
    $routes->post('edit', 'Module::edit');
    $routes->get('edit', 'Module::edit');
    $routes->get("edit/(:any)", "Module::edit/$1");
	$routes->post("edit/(:any)", "Module::edit/$1");
});

$routes->group('module-role', static function ($routes) {
    $routes->get('/', 'Module_role::index');
    $routes->get('add', 'Module_role::add');
    $routes->post('edit', 'Module_role::edit');
    $routes->get('detail', 'Module_role::detail');
    $routes->get("edit", "Module_role::edit");
});

$routes->group('seting', static function ($routes) {
    $routes->get('/', 'Setting_web::index');
    $routes->get('add', 'Setting_web::add');
    $routes->post('edit', 'Setting_web::edit');
    $routes->get('detail', 'Setting_web::detail');
});

/**
* ---------------------------------------------------------------------
* ROUTE KHUSUS UNTUK MODULE
* ---------------------------------------------------------------------
*/
// Including all module routes

$modules_path = ROOTPATH . 'modules/';
$modules = scandir($modules_path);

foreach ($modules as $module) {
	if ($module === '.' || $module === '..') {
		continue;
	}

	if (is_dir($modules_path) . '/' . $module) {
		$routes_path = $modules_path . $module . '/Config/Routes.php';
		if (file_exists($routes_path)) {
			require $routes_path;
		} else {
			continue;
		}
	}
}
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
