<?php

$routes->group("enroll", ["namespace" => "\Modules\Register\Controllers"], function ($routes) {

	// welcome page - URL: /student
	$routes->get("/", "Register::addView");
	$routes->post("/", "Register::addAction");
	$routes->add("self/(:any)", "Register::addView/$1");
	$routes->get("ctkreg/(:any)", "Register::ctkbukti/$1");
});

$routes->group("enrollment", ["namespace" => "\Modules\Register\Controllers"], function ($routes) {
	// welcome page - URL: /student
	$routes->get("/", "Register::index");
	$routes->get("dtlist", "Register::dtlist");
	$routes->post("dtlist", "Register::dtlist");
	$routes->add("add/", "Register::addView/$1");
	$routes->get("hapus/(:any)", "Register::delete/$1");
	$routes->get("import", "Register::fromxlsx");
	$routes->post("import", "Register::fromxlsx");
	$routes->get("tempxls", "Register::tmpobyek");
	$routes->get("temp", "Register::tmpobyek");
	$routes->get("konfirm", "Register::simpanmasal");
	$routes->get("ctkreg/(:any)", "Register::ctkbukti/$1");
	$routes->get("konfirm/(:any)", "Register::simpanmasal/$1");
	$routes->get("check/(:any)", "Register::updateView/$1");
	$routes->post("check/(:any)", "Register::updateAction/$1");
	$routes->get("detail/(:any)", "Register::detail/$1");
});
