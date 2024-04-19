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
