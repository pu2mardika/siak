<?php

$routes->group("akungrup", ["namespace" => "\Modules\Account\Controllers"], function ($routes) {
	$routes->get("/", "GrupAcc::index");
	$routes->get("dtlist", "GrupAcc::dtlist");
	$routes->post("dtlist", "GrupAcc::dtlist");
	$routes->get("add", "GrupAcc::addView");
	$routes->post("add", "GrupAcc::addAction");
	$routes->get("hapus/(:any)", "GrupAcc::delete/$1");
	$routes->get("import", "GrupAcc::importView");
	$routes->post("import", "GrupAcc::fromxlsx");
	$routes->get("tempxls", "GrupAcc::tmpobyek");
	$routes->get("temp", "GrupAcc::tmpobyek");
	$routes->get("konfirm", "GrupAcc::simpanmasal");
	$routes->get("konfirm/(:any)", "GrupAcc::simpanmasal/$1");
	$routes->get("edit/(:any)", "GrupAcc::updateView/$1");
	$routes->post("edit/(:any)", "GrupAcc::updateACtion/$1");	
});
$routes->addRedirect('grupacc', 'akungrup');

/**
* ROute untuk Akun Buku Besar
*/
$routes->group("akun", ["namespace" => "\Modules\Account\Controllers"], function ($routes) {
	$routes->get("/", "Account::index",['as' => 'akun']); 
	$routes->get("dtlist", "Account::dtlist");
	$routes->post("dtlist", "Account::dtlist");
	$routes->get("add", "Account::addView");
	$routes->post("add", "Account::addAction");
	$routes->get("hapus/(:any)", "Account::delete/$1");
	$routes->get("import", "Account::importView");
	$routes->post("import", "Account::fromxlsx");
	$routes->get("tempxls", "Account::tmpobyek");
	$routes->get("temp", "Account::tmpobyek");
	$routes->get("konfirm", "Account::simpanmasal");
	$routes->get("konfirm/(:any)", "Account::simpanmasal/$1");
	$routes->get("edit/(:any)", "Account::updateView/$1");
	$routes->post("edit/(:any)", "Account::updateACtion/$1");	
});
$routes->addRedirect('account', 'akun');

/**
* Route untuk JURNAL
*/
$routes->group("gleger", ["namespace" => "\Modules\Account\Controllers"], function ($routes) {
	$routes->get("/", "Journal::bukuBesar",['as' => 'gleger']); 
	$routes->get("dtlist", "Journal::dtlist");
	$routes->post("dtlist", "Journal::dtlist");
	
	//PENERIMAAN LAIN-LAIN
	$routes->get("othrev", "Journal::adrevenue");
	$routes->post("othrev", "Journal::addAction");
	
	//PENGELUARAN
	$routes->get("cashout", "Journal::addCashOut");
	$routes->post("cashout", "Journal::addAction");
	
	//KONFIRMASI PENERIMAAN DAN PENGELUARAN
	$routes->post("konfirm", "Journal::setTempGl");
	$routes->get("konfirm/(:any)", "Journal::addAction/$1");
	$routes->get("fup", "Journal::followUP");
	
	
	//MENAMPILKAN JURNAL
	$routes->get("show", "Journal::glView");
	$routes->get("hapus/(:any)", "Journal::delete/$1");
	
	//NERACA
	$routes->get("nawal", "Journal::viewNa");
	$routes->get("nrawal", "Journal::addNAwView");
	$routes->post("nrawal", "Journal::addNrAction");
	$routes->get("nsaldo", "Journal::vNeracaSaldo");
	//BUKU BESAR

	$routes->get("import", "Journal::importView");
	$routes->post("import", "Journal::fromxlsx");
	$routes->get("tempxls", "Journal::tmpobyek");
	$routes->get("temp", "Journal::tmpobyek");
	
});
$routes->addRedirect('Journal', 'gleger');

/**
* Rute untuk periode akuntansi
* 
*/
$routes->group("fperiod", ["namespace" => "\Modules\Account\Controllers"], function ($routes) {
	$routes->get("/", "AccPeriod::index");
	$routes->get("dtlist", "AccPeriod::dtlist");
	$routes->post("dtlist", "AccPeriod::dtlist");
	$routes->get("add", "AccPeriod::addView");
	$routes->post("add", "AccPeriod::addAction");
	$routes->get("hapus/(:any)", "AccPeriod::delete/$1");
	$routes->get("edit/(:any)", "AccPeriod::updateView/$1");
	$routes->post("edit/(:any)", "AccPeriod::updateACtion/$1");	
});
$routes->addRedirect('AccPeriod', 'fperiod');

/**
* ROute untuk Notify
*/
$routes->group("notify", ["namespace" => "\Modules\Account\Controllers"], function ($routes) {
	$routes->get("/", "Notify::index",['as' => 'notify']); 
});

$routes->group("report", ["namespace" => "\Modules\Account\Controllers"], function ($routes) {
	$routes->get("lra", "Journal::lrReport"); 
	$routes->get("equitas", "Journal::tmpobyek"); 
	$routes->get("blsheet", "Journal::tmpobyek"); 
});

$routes->group("accsystem", ["namespace" => "\Modules\Account\Controllers"], function ($routes) {
	$routes->get("/", "Accsys::index");
	$routes->get("add", "Accsys::addView");
	$routes->post("add", "Accsys::addAction");
	$routes->get("rem/(:any)", "Accsys::delete/$1");
	$routes->get("edit/(:any)", "Accsys::updateView/$1");
	$routes->post("edit/(:any)", "Accsys::updateAction/$1");	
});
$routes->addRedirect('Accsys', 'accsystem');