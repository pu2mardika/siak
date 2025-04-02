<?php

namespace Modules\Account\Config;

use CodeIgniter\Config\BaseConfig;

class SysAccount extends BaseConfig
{
    /**
	 * Data tabel yang digunakan 
	 * fields: 
	 */
	public $table = "akun_system";
	//
    /**
	 * --------------------------------------------------------------------
	 * Libraries : key_item`, `deskripsi`, `kode_akun`, `is_mpn`,
	 * --------------------------------------------------------------------
	 *
	 * @var array
	 */
	public $opsi = [
		'is_mpn'=> [0 =>"Tidak...", 1 =>"Ya...",]
	];

	/**
	* 
	* @var array
	* `key_item`, `deskripsi`, `kode_akun`, `is_mpn`,
	*/
	public $fields = [
		'key_item'	=> ['label' => 'Keyword','width'=>0, 'extra'=>['id'=>'kyitem','class' => '', 'required' => true],'type'=>'text'],
		'kode_akun'	=> ['label' => 'Kode Perkiraan','width'=>35,'extra'=>['id'=>'kdakun','class' => '', 'required' => true,],'type'=>'dropdown'],
		'deskripsi'	=> ['label' => 'Keterangan','width'=>35,'extra'=>['id'=>'desk','class' => '', 'required' => true],'type'=>'text'],  
		'is_mpn'	=> ['label' => 'MPN','width'=>8,'extra'=>['id'=>'ismpn','class' => '', 'required' => true],'type'=>'dropdown'],  		 
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
		'key_item' => ['label' => 'Keyword', 'rules' => "required"],
        'deskripsi' => ['label' => 'Keterangan', 'rules' =>'required'],
		'kode_akun'   => ['label' => 'BKode Perkiraan', 'rules' =>'required'],
		'is_mpn'=> ['label' => 'MPN', 'rules' =>'required'],
	]; 
	
	public $roleEdit = [
        'deskripsi' => ['label' => 'Keterangan', 'rules' =>'required'],
		'kode_akun'   => ['label' => 'Kode Perkiraan', 'rules' =>'required'],
		'is_mpn'=> ['label' => 'MPN', 'rules' =>'required'],
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
		'edit' 		=> ['icon'=>'edit','src'=>'accsystem/edit/', 'label'=>'Edit', 'extra'=>''],
		'delete'	=> ['icon'=>'trash','src'=>'accsystem/rem/', 'label'=>'Hapus', 'extra'=>"onclick='confirmation(event)'"],
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
