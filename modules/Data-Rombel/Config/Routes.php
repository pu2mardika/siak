<?php

$routes->group("rombel", ["namespace" => "\Modules\Room\Controllers"], function ($routes) {

	// welcome page - URL: /student
	$routes->get("/", "Rombel::index");
    // other page - URL: /student/other-method
	$routes->get("dtlist", "Rombel::dtlist");
	$routes->post("dtlist", "Rombel::dtlist");
	$routes->get("add", "Rombel::addView");
	$routes->post("add", "Rombel::addAction");
	$routes->get("rem/(:any)", "Rombel::delete/$1");
	$routes->get("edit/(:any)", "Rombel::editView/$1");
	$routes->post("edit/(:any)", "Rombel::editAction/$1");
	$routes->get("dtwali/(:any)", "Rombel::getwali/$1");
	$routes->get("dtcurr/(:any)", "Rombel::getcurr/$1");
	$routes->get("shgrade/(:any)", "Rombel::getGrade/$1");

	$routes->get("detail", "RoomMember::index");
	$routes->get("enroll/(:any)", "RoomMember::addView/$1");
	$routes->post("enroll/(:any)", "RoomMember::addAction");
	$routes->get("action", "RoomMember::doAction");
	$routes->get("scrmember", "RoomMember::getDataMember");
	$routes->get("del/(:any)", "RoomMember::delete/$1");
	$routes->get("mutasi/(:any)", "RoomMember::editView/$1");
	$routes->post("mutasi/(:any)", "RoomMember::editAction/$1");
	$routes->get("doPost", "RoomMember::cekTuton");
	
});
$routes->addRedirect('roommember', 'rombel');

$routes->group("tuton", ["namespace" => "\Modules\Kbm\Controllers"], function ($routes) {

	// welcome page - URL: /student
	$routes->get("/", "Tuton::index");
	$routes->get("dtsiswa", "Tuton::getPD");
	$routes->get("dtguru", "Tuton::getPD");
});
//$routes->resource('rfsiswa');