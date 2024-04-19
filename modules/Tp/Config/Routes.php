<?php

$routes->group("tp", ["namespace" => "\Modules\Tp\Controllers"], function ($routes) {

	// welcome page - URL: /student
	$routes->get("/", "Tp::index");
  
    // other page - URL: /student/other-method
	$routes->get("dtlist", "Tp::dtlist");
	$routes->post("dtlist", "Tp::dtlist");
	$routes->get("add", "Tp::addView");
	$routes->post("add", "Tp::addAction");
	$routes->get("hapus/(:any)", "Tp::delete/$1");
	$routes->get("import", "Tp::fromxlsx");
	$routes->post("import", "Tp::fromxlsx");
	$routes->get("tempxls", "Tp::tmpobyek");
	$routes->get("temp", "Tp::tmpobyek");
	$routes->get("konfirm", "Tp::simpanmasal");
	$routes->get("konfirm/(:any)", "Tp::simpanmasal/$1");
	$routes->get("edit/(:any)", "Tp::updateView/$1");
	$routes->post("edit/(:any)", "Tp::updateAction/$1");
	$routes->get("detail/(:any)", "Tp::detail/$1");
});
