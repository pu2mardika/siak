<?php

$routes->group("program", ["namespace" => "\Modules\Akademik\Controllers"], function ($routes) {

	// welcome page - URL: /student
	$routes->get("/", "Jurusan::index");
  
    // other page - URL: /student/other-method
	$routes->get("dtlist", "Jurusan::dtlist");
	$routes->post("dtlist", "Jurusan::dtlist");
	$routes->get("add", "Jurusan::addView");
	$routes->post("add", "Jurusan::addAction");
	$routes->get("hapus/(:any)", "Jurusan::delete/$1");
	$routes->get("import", "Jurusan::fromxlsx");
	$routes->post("import", "Jurusan::fromxlsx");
	$routes->get("tempxls", "Jurusan::tmpobyek");
	$routes->get("temp", "Jurusan::tmpobyek");
	$routes->get("konfirm", "Jurusan::simpanmasal");
	$routes->get("konfirm/(:any)", "Jurusan::simpanmasal/$1");
	$routes->get("edit/(:any)", "Jurusan::update/$1");
	$routes->post("edit/(:any)", "Jurusan::update/$1");
	$routes->get("detail/(:any)", "Jurusan::detail/$1");
});
$routes->addRedirect('jurusan', 'program');

$routes->group("prodi", ["namespace" => "\Modules\Akademik\Controllers"], function ($routes) {

	// welcome page - URL: /student
	$routes->get("/", "Prodi::index");
  
    // other page - URL: /student/other-method
	$routes->get("dtlist", "Prodi::listdoc");
	$routes->post("dtlist", "Prodi::listdoc");
	
	$routes->add("add", "Prodi::tambah");

});
