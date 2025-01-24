<?php
$routes->group("couppon", ["namespace" => "\Modules\Billing\Controllers"], function ($routes) {

	// welcome page - URL: /student
	$routes->get("/", "Couppon::index");
    // other page - URL: /student/other-method
	$routes->get("dtlist", "Couppon::dtlist");
	$routes->get("add", "Couppon::AddNew");
	$routes->post("add", "Couppon::addAction");
	$routes->get("rem/(:any)", "Couppon::delete/$1");
	$routes->get("edit/(:any)", "Couppon::editView/$1");
	$routes->post("edit/(:any)", "Couppon::editAction/$1");	
});

$routes->group("bill", ["namespace" => "\Modules\Billing\Controllers"], function ($routes) {

	// welcome page - URL: /student
	$routes->get("/", "Bill::index");
    // other page - URL: /student/other-method
	$routes->get("dtlist", "Bill::dtlist");
	$routes->get("add", "Bill::AddNew");
	$routes->post("add", "Bill::addAction");
	$routes->get("rem/(:any)", "Bill::delete/$1");
	$routes->get("edit/(:any)", "Bill::editView/$1");
	$routes->post("edit/(:any)", "Bill::editAction/$1");	
});
