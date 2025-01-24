<?php

namespace Modules\Pricing\Config;

use CodeIgniter\Config\BaseConfig;
use Modules\Room\Config\Rombel;

class Pricing extends BaseConfig
{
    
	/**
	 * Data tabel yang digunakan 
	 * fields: 
	 */
	public $table = "price";
	//
    /**
	 * --------------------------------------------------------------------
	 * Libraries : 'id', 'id_prodi', 'komponen', 'amount', 'jns_bayar', 'tmt'
	 * --------------------------------------------------------------------
	 *
	 * @var array
	 */
	public $opsi = [
		'komponen'  => [''=>'[ - PILIH - ]', 1=>"Biaya Pendaftaran", 2=>"Biaya Pendidikan", 9=>"Biaya Lain-Lain"],
		'jns_bayar' => [''=>'[ - PILIH - ]', 1=>'Single Payment', 2=>'Bulanan', 3=>'Semesteran'],
	];

	public function getOpsi(): array
    {
        $opsi = setting('Pricing.opsi');
		$opsi['komponen'] = setting('Rombel.opsi')['learn_metode'];
        return $opsi;
    }

	/**
	* 
	* @var array
	* 
	*/
	public $fields = [
		'id_prodi'	=> ['label' => 'Program','width'=>40, 'extra'=>['id'=>'desc','class' => '', 'required' => true],'type'=>'dropdown'],
		'komponen'	=> ['label' => 'Metode Belajar','width'=>20,'extra'=>['id'=>'txtawal','class' => '', 'required' => true],'type'=>'dropdown'], 
		'amount'	=> ['label' => 'Besaran Harga','width'=>20,'extra'=>['id'=>'txtawal','class' => '', 'required' => true, 'step'=>'1000'],'type'=>'number'], 
		'jns_bayar'	=> ['label' => 'Jenis Pembayaran','width'=>20,'extra'=>['id'=>'txtawal','class' => '', 'required' => true],'type'=>'dropdown'], 
		'tmt'		=> ['label' => 'Terhitung Mulai Tanggal','width'=>20,'extra'=>['id'=>'txtakh','class' => '', 'required' => true],'type'=>'date', ], 		 
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
	public $sortby = 1; 
}
