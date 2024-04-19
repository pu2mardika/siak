<?php

$routes->group("program", ["namespace" => "\Modules\Akademik\Controllers"], function ($routes) {

	// welcome page - URL: /student
	$routes->get("/", "Program::index");
  
	$routes->get("dtlist", "Program::dtlist");
	$routes->post("dtlist", "Program::dtlist");
	$routes->get("add", "Program::addView");
	$routes->post("add", "Program::addAction");
	$routes->get("hapus/(:any)", "Program::delete/$1");
	$routes->get("edit/(:any)", "Program::updateView/$1");
	$routes->post("edit/(:any)", "Program::updateAction/$1");
	$routes->get("detail/(:any)", "Program::detail/$1");
});
$routes->addRedirect('jurusan', 'program');

$routes->group("prodi", ["namespace" => "\Modules\Akademik\Controllers"], function ($routes) {
	$routes->get("/", "Prodi::index");
	$routes->add("add", "Prodi::addView");
    $routes->post("add", "Prodi::addAction");
    $routes->get("edit/(:any)", "Prodi::updateView/$1");
	$routes->post("edit/(:any)", "Prodi::updateAction/$1");

});

$routes->group("kurikulum", ["namespace" => "\Modules\Akademik\Controllers"], function ($routes) {
	$routes->get("/", "Kurikulum::index");
	$routes->add("add", "Kurikulum::addView");
    $routes->post("add", "Kurikulum::addAction");
    $routes->get("edit/(:any)", "Kurikulum::updateView/$1");
	$routes->post("edit/(:any)", "Kurikulum::updateAction/$1");
	$routes->get("detail/(:any)", "Kurikulum::detView/$1");
});

$routes->group("skl", ["namespace" => "\Modules\Akademik\Controllers"], function ($routes) {
	$routes->get("/", "Skl::index");
	$routes->add("add", "Skl::addView");
    $routes->post("add", "Skl::addAction");
    $routes->add("add/(:any)", "Skl::addView/$1");
    $routes->post("add/(:any)", "Skl::addAction/$1");
    $routes->get("edit/(:any)", "Skl::updateView/$1");
	$routes->post("edit/(:any)", "Skl::updateAction/$1");
	$routes->get("hapus/(:any)", "Skl::delete/$1");
});
