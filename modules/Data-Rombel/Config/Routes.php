<?php

$routes->group("rombel", ["namespace" => "\Modules\Room\Controllers"], function ($routes) {

	// welcome page - URL: /student
	$routes->get("/", "Rombel::index");
    // other page - URL: /student/other-method
	$routes->get("dtlist", "Rombel::dtlist");
	$routes->post("dtlist", "Rombel::dtlist");
	$routes->get("add", "Rombel::addView");
	$routes->post("add", "Rombel::addAction");
	$routes->get("rem/(:any)", "Rombel::delete/$1");
	$routes->get("import", "Rombel::fromxlsx");
	$routes->post("import", "Rombel::fromxlsx");
	$routes->get("tempxls", "Rombel::tmpobyek");
	$routes->get("temp", "Rombel::tmpobyek");
	$routes->get("konfirm", "Rombel::simpanmasal");
	$routes->get("konfirm/(:any)", "Rombel::simpanmasal/$1");
	$routes->get("edit/(:any)", "Rombel::editView/$1");
	$routes->post("edit/(:any)", "Rombel::editAction/$1");
	$routes->get("detail/(:any)", "Rombel::detail/$1");
	$routes->get("dtwali/(:any)", "Rombel::getwali/$1");
	$routes->get("dtcurr/(:any)", "Rombel::getcurr/$1");
	$routes->get("shgrade/(:any)", "Rombel::getGrade/$1");
});
