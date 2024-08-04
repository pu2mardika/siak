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