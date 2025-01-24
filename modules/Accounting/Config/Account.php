<?php

namespace Modules\Account\Config;

use CodeIgniter\Config\BaseConfig;

class Account extends BaseConfig
{
    /**
	 * --------------------------------------------------------------------
	 * akun_grup : 'kode_akun', 'nama_akun', 'grup_akun', 'norm_balance'
	 * --------------------------------------------------------------------
	 *
	 * @var array
	 */
	public $opsi = [
		'gtype' => [1=>'Acctiva/Assets', 2=>'Kewajiban / Liabilities', 3=>'Modal/Equity', 4=>'Income',
				  5=>'Operating Expenses', 6=>'Laba-Rugi', 7=>'Other Income and Expenses', 8=>'Post Luar Biasa',
				  9=>'Pajak'],
		'norm_balance' => ['Db' => 'Sisi Debet', 'Kr'  => 'Sisi Kredit',],
	];

	/**
	* ---------------------------------------------------------------------
	* FIELD NAME 
	* ------------------------nama_akun---------------------------------------------
	* @var array
	* 
	*/
	public $fields = [
		'kode_akun'		=> ['label' => 'Kode Akun','width'=>15,'extra'=>['id' => 'nama','class' => '', 'required' => true],'type'=>'text', ],
		'nama_akun'		=> ['label' => 'Nama Akun','width'=>35,'extra'=>['id' => 'nama','class' => '', 'required' => true],'type'=>'text', ],
		'grup_akun'		=> ['label' => 'Kelompok Akun','width'=>25,'extra'=>['id' => 'jk','class' => '', 'required' => true],'type'=>'dropdown'], 
		'norm_balance'	=> ['label' => 'Saldo Normal','width'=>15,'extra'=>['id' => 'jk','class' => '', 'required' => true],'type'=>'dropdown'], 
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
        'kode_akun'   	=> ['label' => 'Kode Grup', 'rules' =>'required'],
        'nama_akun'  	=> ['label' => 'Nama Grup', 'rules' =>'required'],
        'grup_akun'  	=> ['label' => 'Jenis', 'rules' =>'required'],
        'norm_balance'  => ['label' => 'Jenis', 'rules' =>'required'],
	];  
	
	public $roleEdit = [
		'kode_akun'   	=> ['label' => 'Kode Grup', 'rules' =>'required'],
        'nama_akun'  	=> ['label' => 'Nama Grup', 'rules' =>'required'],
        'grup_akun'  	=> ['label' => 'Jenis', 'rules' =>'required'],
        'norm_balance'  => ['label' => 'Jenis', 'rules' =>'required'],
	];  
	/**
	 * --------------------------------------------------------------------
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
	public $importallowed = TRUE;
	
	/**
	* ---------------------------------------------------------------------
	* action boolean
	* ---------------------------------------------------------------------
	* 
	* @var array
	*/
	public $actions = [
		'edit' 		=> ['icon'=>'edit','src'=>'akun/edit/', 'label'=>'Detail', 'extra'=>''],
		'delete'	=> ['icon'=>'trash','src'=>'akun/hapus/', 'label'=>'Detail', 'extra'=>"onclick='confirmation(event)'"],
	];
}
