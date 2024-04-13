<?php

$routes->group("docregister", ["namespace" => "\Modules\Docregister\Controllers"], function ($routes) {

	// welcome page - URL: /student
	$routes->get("/", "Docregister::index");
  
    // other page - URL: /student/other-method
	$routes->get("dtlist", "Docregister::listdoc");
	$routes->post("dtlist", "Docregister::listdoc");
	
	$routes->add("add", "Docregister::tambah");

});
