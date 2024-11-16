<?php
$routes->group("rapor", ["namespace" => "\Modules\Raport\Controllers"], function ($routes) {

	$routes->get("/", "Raport::index");
  
	$routes->get("dtlist", "Raport::dtlist");
	$routes->post("dtlist", "Raport::dtlist");
	$routes->get("add/(:any)", "Raport::addView/$1");
	$routes->post("add/(:any)", "Raport::addAction/$1");
	$routes->get("rem/(:any)", "Raport::delete/$1");
	$routes->get("edit/(:any)", "Raport::updateView/$1");
	$routes->post("edit/(:any)", "Raport::editAction/$1");

	$routes->get("showroom/(:any)", "Raport::showDataRoom/$1");
	$routes->get("shwpd", "Raport::shwRoomMember");
	$routes->get("vrept", "Raport::shwReport");
	$routes->get("vcover", "Raport::coverPage");

	$routes->get("project", "Raport::r_project");
});

$routes->group("cert", ["namespace" => "\Modules\Raport\Controllers"], function ($routes) {

	$routes->get("/", "Cert::index");
  
	$routes->get("dtlist", "Cert::dtlist");
	$routes->post("dtlist", "Cert::dtlist");
	$routes->get("add/(:any)", "Cert::addView/$1");
	$routes->post("add/(:any)", "Cert::addAction/$1");
	$routes->get("rem/(:any)", "Cert::delete/$1");
	$routes->get("edit/(:any)", "Cert::updateView/$1");
	$routes->post("edit/(:any)", "Cert::editAction/$1");

	$routes->get("addasesi/(:any)", "Cert::dataAsessi/$1");
	$routes->get("addasesi", "Cert::dataAsessi");
	$routes->post("addasesi/(:any)", "Cert::NewPartAction");
	$routes->get("show/(:any)", "Cert::shwMembers/$1");
	$routes->get("shwdet", "Cert::shwDetail");
	$routes->get("vrept", "Cert::shwReport");
});