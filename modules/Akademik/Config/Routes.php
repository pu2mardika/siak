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

$routes->group("grupmp", ["namespace" => "\Modules\Akademik\Controllers"], function ($routes) {
	$routes->get("/", "Gmapel::index");
	$routes->add("add", "Gmapel::addView");
    $routes->post("add", "Gmapel::addAction");
    $routes->add("add/(:any)", "Gmapel::addView/$1");
    $routes->post("add/(:any)", "Gmapel::addAction/$1");
    $routes->get("edit/(:any)", "Gmapel::updateView/$1");
	$routes->post("edit/(:any)", "Gmapel::updateAction/$1");
	$routes->get("hapus/(:any)", "Gmapel::delete/$1");
});
$routes->addRedirect('gmapel', 'grupmp');

$routes->group("subject", ["namespace" => "\Modules\Akademik\Controllers"], function ($routes) {
	$routes->get("/", "Subject::index");
	$routes->add("add", "Subject::addView");
    $routes->post("add", "Subject::addAction");
    $routes->add("add/(:any)", "Subject::addView/$1");
    $routes->post("add/(:any)", "Subject::addAction/$1");
    $routes->get("edit/(:any)", "Subject::updateView/$1");
	$routes->post("edit/(:any)", "Subject::updateAction/$1");
	$routes->get("hapus/(:any)", "Subject::delete/$1");
	$routes->get("show/(:any)", "Subject::showList/$1");
});

$routes->group("mapel", ["namespace" => "\Modules\Akademik\Controllers"], function ($routes) {
    $routes->add("add/(:any)", "Mapel::addView/$1");
    $routes->post("add/(:any)", "Mapel::addAction/$1");
    $routes->get("edit/(:any)", "Mapel::updateView/$1");
	$routes->post("edit/(:any)", "Mapel::updateAction/$1");
	$routes->get("hapus/(:any)", "Mapel::delete/$1");
});

$routes->group("rating", ["namespace" => "\Modules\Akademik\Controllers"], function ($routes) {
    $routes->add("add/(:any)", "Rating::addView/$1");
    $routes->post("add/(:any)", "Rating::addAction/$1");
    $routes->get("edit/(:any)", "Rating::updateView/$1");
	$routes->post("edit/(:any)", "Rating::updateAction/$1");
	$routes->get("hapus/(:any)", "Rating::delete/$1");
});
//$routes->addRedirect('rating', 'asscomp');

$routes->group("raports", ["namespace" => "\Modules\Akademik\Controllers"], function ($routes) {
    $routes->add("add/(:any)", "Raports::addView/$1");
    $routes->post("add/(:any)", "Raports::addAction/$1");
    $routes->get("edit/(:any)", "Raports::updateView/$1");
	$routes->post("edit/(:any)", "Raports::updateAction/$1");
	$routes->get("hapus/(:any)", "Raports::delete/$1");
});