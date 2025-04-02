<?php

$routes->group("enroll", ["namespace" => "\Modules\Register\Controllers"], function ($routes) {
	$routes->get("/", "Enroll::addView");
	$routes->post("/", "Enroll::addAction");
	$routes->add("self/(:any)", "Enroll::addView/$1");
	$routes->get("ctkreg/(:any)", "Enroll::ctkbukti/$1");
	$routes->get("ctkreg/(:any)", "Enroll::ctkbukti/$1");
	$routes->get("bygroup", "Enroll::addByGroupView");
	$routes->post("bygroup", "Enroll::addByGroupAcction");
	$routes->get("konfirm", "Enroll::simpanmasal");
	$routes->get("konfirm/(:any)", "Enroll::simpanmasal/$1");
	$routes->get("tempgroup", "Enroll::tmpobyek");
});

$routes->group("enrollment", ["namespace" => "\Modules\Register\Controllers"], function ($routes) {
	// welcome page - URL: /student
	$routes->get("/", "Enrollment::index");
	$routes->get("dtlist", "Enrollment::dtlist");
	$routes->post("dtlist", "Enrollment::dtlist");
	$routes->get("add/", "Enrollment::addView/$1");
	$routes->get("edit/(:any)", "Enrollment::updateView/$1");
	$routes->post("edit/(:any)", "Enrollment::updateAction/$1");
	$routes->get("hapus/(:any)", "Enrollment::delete/$1");
	$routes->get("import", "Enrollment::fromxlsx");
	$routes->post("import", "Enrollment::fromxlsx");
	$routes->get("tempxls", "Enrollment::tmpobyek");
	$routes->get("temp", "Enrollment::tmpobyek");
	$routes->get("konfirm", "Enrollment::simpanmasal");
	$routes->get("ctkreg/(:any)", "Enrollment::ctkbukti/$1");
	$routes->get("konfirm/(:any)", "Enrollment::simpanmasal/$1");
	$routes->get("check/(:any)", "Enrollment::updateView/$1");
	$routes->post("check/(:any)", "Enrollment::updateAction/$1");
	$routes->get("detail/(:any)", "Enrollment::detail/$1");
});
