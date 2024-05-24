<?php

$routes->group("ptm", ["namespace" => "\Modules\Kbm\Controllers"], function ($routes) {
	$routes->get("/", "Ptm::index");
	$routes->get("dtlist", "Ptm::dtlist");
	$routes->post("dtlist", "Ptm::dtlist");
	$routes->get("add", "Ptm::addView");
	$routes->post("add", "Ptm::addAction");
	$routes->get("rem/(:any)", "Ptm::delete/$1");
	$routes->get("edit/(:any)", "Ptm::editView/$1");
	$routes->post("edit/(:any)", "Ptm::editAction/$1");
	$routes->get("dtwali/(:any)", "Ptm::getwali/$1");
	$routes->get("dtcurr/(:any)", "Ptm::getcurr/$1");
	$routes->get("vroom/(:any)", "Ptm::getRoom/$1");
	$routes->get("vsgrade", "Ptm::getSubGrade");
	$routes->get("vdata", "Ptm::getDataPtm");
});
$routes->addRedirect('roommember', 'rombel');