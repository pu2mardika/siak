<?php

$routes->group("tendik", ["namespace" => "\Modules\Tendik\Controllers"], function ($routes) {

	// welcome page - URL: /student
	$routes->get("/", "Tendik::index");
  
    // other page - URL: /student/other-method
	$routes->get("dtlist", "Tendik::dtlist");
	$routes->post("dtlist", "Tendik::dtlist");
	$routes->add("add", "Tendik::tambah");
	$routes->get("hapus/(:any)", "Tendik::delete/$1");
	$routes->get("import", "Tendik::fromxlsx");
	$routes->post("import", "Tendik::fromxlsx");
	$routes->get("tempxls", "Tendik::tmpobyek");
	$routes->get("temp", "Tendik::tmpobyek");
	$routes->get("konfirm", "Tendik::simpanmasal");
	$routes->get("konfirm/(:any)", "Tendik::simpanmasal/$1");
	$routes->get("edit/(:any)", "Tendik::update/$1");
	$routes->post("edit/(:any)", "Tendik::update/$1");
	$routes->get("detail/(:any)", "Tendik::detail/$1");
});
