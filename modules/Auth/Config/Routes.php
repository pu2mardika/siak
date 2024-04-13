<?php

$routes->group("auths", ["namespace" => "\Modules\Auth\Controllers"], function ($routes) {

	// welcome page - URL: /student
	$routes->get("/", "Auth::index");
	$routes->get("signout", "Auth::logout");
	$routes->get("pos", "Auth::test");
	$routes->add("proses", "Auth::proses");
	$routes->add("register", "Auth::register");

});