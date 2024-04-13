<?php

$routes->group("rombel", ["namespace" => "\Modules\Room\Controllers"], function ($routes) {

	// welcome page - URL: /student
	$routes->get("/", "Rombel::index");
    // other page - URL: /student/other-method
	$routes->get("dtlist", "Rombel::dtlist");
	$routes->post("dtlist", "Rombel::dtlist");
	$routes->add("add", "Rombel::tambah");
	$routes->get("hapus/(:any)", "Rombel::delete/$1");
	$routes->get("import", "Rombel::fromxlsx");
	$routes->post("import", "Rombel::fromxlsx");
	$routes->get("tempxls", "Rombel::tmpobyek");
	$routes->get("temp", "Rombel::tmpobyek");
	$routes->get("konfirm", "Rombel::simpanmasal");
	$routes->get("konfirm/(:any)", "Rombel::simpanmasal/$1");
	$routes->get("edit/(:any)", "Rombel::update/$1");
	$routes->post("edit/(:any)", "Rombel::update/$1");
	$routes->get("detail/(:any)", "Rombel::detail/$1");
	$routes->get("dtwali/(:any)", "Rombel::getwali/$1");
});
