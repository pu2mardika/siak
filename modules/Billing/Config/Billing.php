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
        'bill'  	=>'billing',
        'pay'   	=>'payment',
        'cupon' 	=>'cuppon',
        'grup_bill' =>'corporate_bill',
    ];
	//
    /**
	 * --------------------------------------------------------------------
	 * Libraries : 'id', 'nipd', 'issued', 'due_date', 'amount', 'coupon'
	 * --------------------------------------------------------------------
	 *
	 * @var array
	 */
	public $opsi = [];

	/**
	* 
	* AKUN BUKU BESAR 
	* 
	*/
	
	public array $akunBB = ['piutang' => 'd', 'diskon' => 'd', 'pendapatan' =>'c'];

	/**
	* 
	* @var array
	* 
	*/
	public $fields = [
		'id'		=> ['label' => '','width'=>0,'extra'=>['id'=>'txtawal','class' => '', 'required' => true],'type'=>'hidden'], 
		'billId'	=> ['label' => 'Kode Billing','width'=>10,'extra'=>['id'=>'txtawal','class' => '', 'required' => true],'type'=>'text'], 
		'nipd'		=> ['label' => 'Nama','width'=>30,'extra'=>['id'=>'txtawal','class' => '', 'required' => true],'type'=>'text'], 
		'deskripsi'	=> ['label' => 'Uraian','width'=>30,'extra'=>['id'=>'txtdesc','class' => '', 'required' => true, 'rows'=>4, 'maxlength'=>250, 'title'=>'Maks 250 character'],'type'=>'textarea'], 
		'issued'	=> ['label' => 'Tanggal Bill','width'=>10,'extra'=>['id'=>'txtawal','class' => '', 'required' => true],'type'=>'date'], 
		'amount'	=> ['label' => 'Jml Tagihan','width'=>15,'extra'=>['id'=>'txtawal','class' => '', 'required' => true],'type'=>'number'], 
		'diskon'	=> ['label' => 'Diskon','width'=>0,'extra'=>['id'=>'txtakh','class' => '', 'required' => true],'type'=>'text', ], 		 
	];

	public $addFields = [
		'nama'		=> ['label' => 'No ID | Nama','width'=>30,'extra'=>['id'=>'dtname','class' => '', 'required' => true],'type'=>'search'], 
		'deskripsi'	=> ['label' => 'Uraian','width'=>30,'extra'=>['id'=>'txtdesc','class' => '', 'required' => true, 'rows'=>4, 'maxlength'=>250, 'title'=>'Maks 250 character'],'type'=>'textarea'], 
		'issued'	=> ['label' => 'Tanggal Bill','width'=>10,'extra'=>['id'=>'txtdttglawal','class' => '', 'required' => true],'type'=>'date'], 
		'amount'	=> ['label' => 'Jml Tagihan','width'=>15,'extra'=>['id'=>'dtJml','class' => '', 'required' => true],'type'=>'number'], 
		'diskon'	=> ['label' => 'Diskon','width'=>0,'extra'=>['id'=>'dtdisc','class' => '', 'required' => true],'type'=>'text', ], 
		'nipd'	 	=> ['label' => '','width'=>0,'extra'=>['id' => 'dtnipd','class' => '', 'required' => true],'type'=>'hidden'],		 
		'unit'	 	=> ['label' => '','width'=>0,'extra'=>['id' => 'dtuker','class' => '', 'required' => true],'type'=>'hidden'],		 
	];

	public $field2 = [
		'name'		=> ['label' => 'Nama','width'=>30,'extra'=>['id'=>'txtawal','class' => '', 'required' => true, 'disabled'=>true],'type'=>'text'], 
		'deskripsi'	=> ['label' => 'Uraian','width'=>30,'extra'=>['id'=>'txtdesc','class' => '', 'required' => true, 'rows'=>4, 'maxlength'=>250, 'title'=>'Maks 250 character'],'type'=>'textarea'], 
		'issued'	=> ['label' => 'Tanggal Bill','width'=>10,'extra'=>['id'=>'txtawal','class' => '', 'required' => true],'type'=>'date'], 
		'amount'	=> ['label' => 'Jml Tagihan','width'=>15,'extra'=>['id'=>'txtawal','class' => '', 'required' => true, 'disabled'=>true],'type'=>'text'], 
		'diskon'	=> ['label' => 'Kupon Diskon','width'=>0,'extra'=>['id'=>'txtakh','class' => '', 'required' => true],'type'=>'text', ], 		 
	];

	public $fieldAkun = [
		'deskripsi'	=> ['label' => 'Uraian','width'=>0,'extra'=>['id' => 'desc','class' => '', 
						'disabled' =>'disabled readonly'],'type'=>'text', ], 
		'tagihan'	=> ['label' => 'Nilai Billing','width'=>0,'extra'=>['id' => 'harga','class' => '', 
						'disabled' =>'disabled readonly'],'type'=>'text', ], 
		'discont'	=> ['label' => 'Diskon','width'=>0,'extra'=>['id' => 'harga','class' => '', 
						'disabled' =>'disabled readonly'],'type'=>'text', ], 
		'jumlah'	=> ['label' => 'Jumlah Tagihan','width'=>0,'extra'=>['id' => 'harga','class' => '', 
						'disabled' =>'disabled readonly'],'type'=>'text', ],  
		'tanggal'	=> ['label' => 'Tanggal','width'=>20,'extra'=>['id' => 'tanggal','class' => '', 
						'disabled' =>'disabled readonly'],'type'=>'date', ], 
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
		'nipd' 		=> ['label' => 'Program', 'rules' => "required"],
        'deskripsi' => ['label' => 'Uraian Billing', 'rules' =>'required'],
        'issued' 	=> ['label' => 'Metode Belajar', 'rules' =>'required'],
		'amount'   	=> ['label' => 'Besaran Harga', 'rules' =>'required'],
	]; 
	
	public $roleEdit = [
		'nipd' => ['label' => 'Program', 'rules' => "required"],
        'issued' => ['label' => 'Metode Belajar', 'rules' =>'required'],
		'amount'   => ['label' => 'Besaran Harga', 'rules' =>'required'],
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
		'cetak' 	=> ['icon'=>'print','src'=>'bill/print?ids=', 'label'=>'Detail', 'extra'=>''],
	//	'delete'	=> ['icon'=>'trash','src'=>'pricing/rem/', 'label'=>'Hapus', 'extra'=>"onclick='confirmation(event)'"],
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

	public string $arrDelimeter = '#++VHV++#';
}
