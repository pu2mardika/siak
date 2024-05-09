<?php

$routes->group("siswa", ["namespace" => "\Modules\Siswa\Controllers"], function ($routes) {

	// welcome page - URL: /student
	$routes->get("/", "Siswa::index");
  
    // other page - URL: /student/other-method
	$routes->get("dtlist", "Siswa::dtlist");
	$routes->post("dtlist", "Siswa::dtlist");
	$routes->get("add", "Siswa::addView");
	$routes->post("add", "Siswa::addAction");
	$routes->get("hapus/(:any)", "Siswa::delete/$1");
	$routes->get("import", "Siswa::fromxlsx");
	$routes->post("import", "Siswa::fromxlsx");
	$routes->get("tempxls", "Siswa::tmpobyek");
	$routes->get("temp", "Siswa::tmpobyek");
	$routes->get("konfirm", "Siswa::simpanmasal");
	$routes->get("konfirm/(:any)", "Siswa::simpanmasal/$1");
	$routes->get("edit/(:any)", "Siswa::updateView/$1");
	$routes->post("edit/(:any)", "Siswa::updateAction/$1");
	$routes->get("detail/(:any)", "Siswa::detail/$1");
});

$routes->group("datadik", ["namespace" => "\Modules\Siswa\Controllers"], function ($routes) {

	// welcome page - URL: /student
	$routes->get("/", "Datadik::index");
  
    // other page - URL: /student/other-method
	$routes->get("dtlist", "Datadik::dtlist");
	$routes->post("dtlist", "Datadik::dtlist");
	$routes->get("add", "Datadik::addView");
	$routes->post("add", "Datadik::addAction");
	$routes->get("hapus/(:any)", "Datadik::delete/$1");
	$routes->get("import", "Datadik::fromxlsx");
	$routes->post("import", "Datadik::fromxlsx");
	$routes->get("tempxls", "Datadik::tmpobyek");
	$routes->get("temp", "Datadik::tmpobyek");
	$routes->get("konfirm", "Datadik::simpanmasal");
	$routes->get("konfirm/(:any)", "Datadik::simpanmasal/$1");
	$routes->get("edit/(:any)", "Datadik::updateView/$1");
	$routes->post("edit/(:any)", "Datadik::updateAction/$1");
	$routes->get("detail/(:any)", "Datadik::detail/$1");
});
