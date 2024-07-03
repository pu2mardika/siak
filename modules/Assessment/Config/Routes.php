<?php
$routes->group("nilai", ["namespace" => "\Modules\Assessment\Controllers"], function ($routes) {
	$routes->get("/", "LogNilai::index");
	$routes->get("detail", "LogNilai::showMapel");
	
	$routes->get("rem/(:any)", "LogNilai::delete/$1");
	$routes->get("edit/(:any)", "LogNilai::editView/$1");
	$routes->post("edit/(:any)", "LogNilai::editAction/$1");
	
	$routes->get("vroom/(:any)", "LogNilai::getRoom/$1");
	$routes->get("vdata", "LogNilai::showPD");

	$routes->get("import/(:any)", "LogNilai::fromxlsx/$1");
	$routes->post("import/(:any)", "LogNilai::importAction/$1");
	$routes->get("tempxls", "LogNilai::tmpobyek");
	$routes->get("temp", "LogNilai::tmpobyek");
	$routes->get("konfirm", "LogNilai::simpanmasal");
	$routes->get("konfirm/(:any)", "LogNilai::simpanmasal/$1");
});
$routes->addRedirect('lognilai', 'nilai');

$routes->group("atp", ["namespace" => "\Modules\Assessment\Controllers"], function ($routes) {
	$routes->get("/", "Atp::index");
	$routes->get("show", "Atp::showAtp");
	
	$routes->get("add", "Atp::addView");
	$routes->post("add", "Atp::addAction");
	$routes->get("getID", "Atp::GetID");
	$routes->get("edit/(:any)", "Atp::editView/$1");
	$routes->post("edit/(:any)", "Atp::updateAction/$1");
	$routes->get("hapus/(:any)", "Atp::delete/$1");
	$routes->get("import/(:any)", "Atp::fromxlsx/$1");
	$routes->post("import/(:any)", "Atp::importAction/$1");
	$routes->get("tempxls", "Atp::tmpobyek");
	$routes->get("temp", "Atp::tmpobyek");
	$routes->get("konfirm", "Atp::simpanmasal");
	$routes->get("konfirm/(:any)", "Atp::simpanmasal/$1");
	$routes->get("reset/(:any)", "Atp::resetData/$1");
});