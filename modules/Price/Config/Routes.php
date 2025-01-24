<?php
$routes->group("pricing", ["namespace" => "\Modules\Pricing\Controllers"], function ($routes) {

	// welcome page - URL: /student
	$routes->get("/", "Pricing::index");
    // other page - URL: /student/other-method
	$routes->get("dtlist", "Pricing::dtlist");
	$routes->get("add", "Pricing::AddNew");
	$routes->post("add", "Pricing::addAction");
	$routes->get("rem/(:any)", "Pricing::delete/$1");
	$routes->get("edit/(:any)", "Pricing::editView/$1");
	$routes->post("edit/(:any)", "Pricing::editAction/$1");	
});
