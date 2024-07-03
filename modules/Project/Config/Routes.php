<?php
$routes->group("dimensi", ["namespace" => "\Modules\Project\Controllers"], function ($routes) {

	// welcome page - URL: /student
	$routes->get("/", "DProject::index");
  
    // other page - URL: /student/other-method
	$routes->get("dtlist", "DProject::dtlist");
	$routes->post("dtlist", "DProject::dtlist");
	$routes->get("add/(:any)", "DProject::addView/$1");
	$routes->post("add/(:any)", "DProject::addAction/$1");
	$routes->get("hapus/(:any)", "DProject::delete/$1");
	$routes->get("edit/(:any)", "DProject::updateView/$1");
	$routes->post("edit/(:any)", "DProject::updateAction/$1");
});
$routes->addRedirect('dproject', 'dimensi');

$routes->group("elemen", ["namespace" => "\Modules\Project\Controllers"], function ($routes) {

	// welcome page - URL: /student
	$routes->get("/", "ElemenProject::index");
  
    // other page - URL: /student/other-method
	$routes->get("dtlist", "ElemenProject::dtlist");
	$routes->post("dtlist", "ElemenProject::dtlist");
	$routes->get("add/(:any)", "ElemenProject::addView/$1");
	$routes->post("add/(:any)", "ElemenProject::addAction/$1");
	$routes->get("hapus/(:any)", "ElemenProject::delete/$1");
	$routes->get("edit/(:any)", "ElemenProject::updateView/$1");
	$routes->post("edit/(:any)", "ElemenProject::updateAction/$1");
});
$routes->addRedirect('elemenproject', 'elemen');

$routes->group("subelemen", ["namespace" => "\Modules\Project\Controllers"], function ($routes) {

	// welcome page - URL: /student
	$routes->get("/", "SubElemen::index");
  
    // other page - URL: /student/other-method
	$routes->get("dtlist", "SubElemen::dtlist");
	$routes->post("dtlist", "SubElemen::dtlist");
	$routes->get("add/(:any)", "SubElemen::addView/$1");
	$routes->post("add/(:any)", "SubElemen::addAction/$1");
	$routes->get("hapus/(:any)", "SubElemen::delete/$1");
	$routes->get("edit/(:any)", "SubElemen::updateView/$1");
	$routes->post("edit/(:any)", "SubElemen::updateAction/$1");
});

$routes->group("project", ["namespace" => "\Modules\Project\Controllers"], function ($routes) {
	// welcome page - URL: /student
	$routes->get("/", "Project::index");
    // other page - URL: /student/other-method
	$routes->get("add", "Project::addView");
	$routes->post("add", "Project::addAction");
	$routes->get("hapus/(:any)", "Project::delete/$1");
	$routes->get("edit/(:any)", "Project::updateView/$1");
	$routes->post("edit/(:any)", "Project::updateAction/$1");
	$routes->get("map", "MapProject::index");
	$routes->post("map", "MapProject::saveAction");
	$routes->get("set", "SkenProject::addView");
	$routes->post("set", "SkenProject::addAction");
	$routes->get("rem/(:any)", "SkenProject::remove/$1");
});