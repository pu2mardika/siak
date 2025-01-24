<?php

namespace Modules\Billing\Config;

use CodeIgniter\Config\BaseConfig;

class Billing extends BaseConfig
{
   /**
	 * Data tabel yang digunakan 
	 * fields: 
	 */
	public $tables = [
        'bill'  =>'billing',
        'pay'   =>'payment',
        'cupon' =>'cuppon',
    ];
	//
    /**
	 * --------------------------------------------------------------------
	 * Libraries : 'id', 'nik', 'issued', 'due_date', 'amount', 'coupon'
	 * --------------------------------------------------------------------
	 *
	 * @var array
	 */
	public $opsi = [];

	/**
	* 
	* @var array
	* 
	*/
	public $fields = [
		'id'		=> ['label' => 'Kode Billing','width'=>20, 'extra'=>['id'=>'idx','class' => '', 'required' => true],'type'=>'text'],
		'nik'		=> ['label' => 'Nama','width'=>40,'extra'=>['id'=>'txtawal','class' => '', 'required' => true],'type'=>'text'], 
		'issued'	=> ['label' => 'Tanggal Bill','width'=>15,'extra'=>['id'=>'txtawal','class' => '', 'required' => true, 'step'=>'1000'],'type'=>'number'], 
		'amount'	=> ['label' => 'Jml Tagihan','width'=>25,'extra'=>['id'=>'txtawal','class' => '', 'required' => true],'type'=>'text'], 
		'coupon'	=> ['label' => 'Terhitung Mulai Tanggal','width'=>0,'extra'=>['id'=>'txtakh','class' => '', 'required' => true],'type'=>'date', ], 		 
	];
	
	/**
	* ---------------------------------------------------------------------
	* ROLE DATA
	* ---------------------------------------------------------------------
	* 
	* @var 
	* 
	*/
	public $roles = [
		'id_prodi' => ['label' => 'Program', 'rules' => "required"],
        'komponen' => ['label' => 'Metode Belajar', 'rules' =>'required'],
		'amount'   => ['label' => 'Besaran Harga', 'rules' =>'required'],
		'jns_bayar'=> ['label' => 'Jenis Pembayaran', 'rules' =>'required'],
        'tmt'      => ['label' => 'TMT', 'rules' =>'required'],
	]; 
	
	public $roleEdit = [
		'id_prodi' => ['label' => 'Program', 'rules' => "required"],
        'komponen' => ['label' => 'Metode Belajar', 'rules' =>'required'],
		'amount'   => ['label' => 'Besaran Harga', 'rules' =>'required'],
		'jns_bayar'=> ['label' => 'Jenis Pembayaran', 'rules' =>'required'],
        'tmt'      => ['label' => 'TMT', 'rules' =>'required'],
	]; 
	
	 /* --------------------------------------------------------------------
	 * Layout for the views to extend
	 * --------------------------------------------------------------------
	 *
	 * @var string
	 */
	public $primarykey = 'id';
	
	
	/**
	* ---------------------------------------------------------------------
	* Export and Import data allowed
	* ---------------------------------------------------------------------
	* 
	* @var boelean
	*/
	public $importallowed = false;
	
	/**
	* ---------------------------------------------------------------------
	* action boolean
	* ---------------------------------------------------------------------
	* 
	* @var array
	*/
	public $actions = [
		//'detail' 	=> ['icon'=>'list-alt','src'=>'tp/detail/', 'label'=>'Detail', 'extra'=>''],
		'edit' 		=> ['icon'=>'edit','src'=>'pricing/edit/', 'label'=>'Edit', 'extra'=>''],
		'delete'	=> ['icon'=>'trash','src'=>'pricing/rem/', 'label'=>'Hapus', 'extra'=>"onclick='confirmation(event)'"],
	];
	
	/**
	* --------------------------------------------------------------------
	* index colom/field  untuk mengurutkan data
	* --------------------------------------------------------------------
	* 
	* @var 
	* 
	*/
	public $sortby = 3; 
}
