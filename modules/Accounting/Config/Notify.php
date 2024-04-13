<?php

namespace Modules\Account\Config;

use CodeIgniter\Config\BaseConfig;

class Notify extends BaseConfig
{
    /**
	 * --------------------------------------------------------------------
	 * akun_grup : 'deskripsi', 'aksi', 'created_at'
	 * --------------------------------------------------------------------
	 *
	 * @var array
	 */
	public $opsi = [];

	/**
	* ---------------------------------------------------------------------
	* FIELD NAME 
	* ---------------------------------------------------------------------
	* @var array
	* 
	*/
	public $fields = [
		'created_at'	=> ['label' => 'tanggal','width'=>20,'extra'=>['id' => 'nama','class' => '', 'required' => true],'type'=>'text', ],
		'deskripsi'		=> ['label' => 'Deskripsi','width'=>60,'extra'=>['id' => 'nama','class' => '', 'required' => true],'type'=>'text', ],
		'aksi'			=> ['label' => 'Aksi','width'=>20,'extra'=>['id' => 'aksi'],'type'=>'text', ],
	];
	
	/**
	* ---------------------------------------------------------------------
	* ROLE DATA
	* ---------------------------------------------------------------------
	* 
	* @var 
	* 
	*/
	public $roles = [];  
	
	public $roleEdit = [];  
	
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
	public $importallowed = false;
	
	/**
	* ---------------------------------------------------------------------
	* action boolean
	* ---------------------------------------------------------------------
	* 
	* @var array
	*/
	public $actions = [
		'detail'	=> false,
		'edit'		=> false,
		'delete'	=> false,
	];
}
