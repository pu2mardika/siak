<?php
$routes->group("cuppon", ["namespace" => "\Modules\Billing\Controllers"], function ($routes) {

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
$routes->addRedirect('couppon', 'cuppon');

$routes->group("bill", ["namespace" => "\Modules\Billing\Controllers"], function ($routes) {
	$routes->get("/", "Bill::index");
	$routes->get("dtlist", "Bill::dtlist");
	$routes->get("add", "Bill::AddNew");
	$routes->post("add", "Bill::addAction");
	$routes->get("print", "Bill::PrintBill");
	$routes->get("rem/(:any)", "Bill::delete/$1");
	$routes->get("edit/(:any)", "Bill::editView/$1");
	$routes->post("edit/(:any)", "Bill::editAction/$1");
	$routes->get("acc/(:any)", "Bill::akunView/$1");
	$routes->post("acc", "Bill::akunAct");	
	$routes->get("getprofil/(:any)", "Bill::getSiswa/$1");	


	$routes->get("corporate", "CorpBillController::index");	
	$routes->get("corpdet", "CorpBillController::getDetCorp");	
	$routes->get("update/(:any)", "CorpBillController::editView/$1");
	$routes->post("update/(:any)", "CorpBillController::editAction/$1");
	$routes->get("mkcorpbil", "CorpBillController::mkcorpBill");
	$routes->post("mkcorpbil", "Bill::addAction");
	$routes->get("print2", "CorpBillController::PrintBill");
});
$routes->addRedirect('corpbillcontroller', 'bill/corporate');

//TAMBAHAN BARU DISINI
$routes->group("payment", ["namespace" => "\Modules\Billing\Controllers"], function ($routes) {
	$routes->get("/", "BillPayment::index");
	$routes->post("/", "BillPayment::showBill");  //Aksi Pembayaran	
	$routes->post("konfirm", "BillPayment::payAction");  //konfirm Pembayaran	
	
	$routes->get("hapus/(:any)", "BillPayment::delete/$1");
	$routes->get("detail/(:any)", "BillPayment::detail/$1");
	$routes->get("cetak/(:any)", "BillPayment::viewPdf/$1");
	$routes->get("acquit/(:any)", "BillPayment::showAcquittance/$1");
	
	//AKUNTANSI
	$routes->get("acc/(:any)", "Payment::akunview/$1");
	$routes->post("acc", "Payment::akunact");
	
	$routes->get("getcustumer/(:any)", "Payment::getCust/$1");
	
	$routes->get("test/(:any)", "Payment::test/$1");
	$routes->get("test", "Payment::test");	
});