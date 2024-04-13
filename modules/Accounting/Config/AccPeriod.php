<?php

namespace Modules\Account\Config;

use CodeIgniter\Config\BaseConfig;

class AccPeriod extends BaseConfig
{
    /**
	 * --------------------------------------------------------------------
	 * akun_grup : 'awal', 'akhir'
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
		'awal'	=> ['label' => 'Awal Periode','width'=>35,'extra'=>['id' => 'awalp','class' => '', 'required' => true],'type'=>'date', ],
		'akhir'	=> ['label' => 'Akhir Peruide','width'=>35,'extra'=>['id' => 'akhirp','class' => '', 'required' => true],'type'=>'date', ],
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
        'awal'   	=> ['label' => 'Awal Periode', 'rules' =>'required'],
        'akhir'  	=> ['label' => 'Akhir Periode', 'rules' =>'required'],
	];  
	
	public $roleEdit = [
		'awal'   	=> ['label' => 'Awal Periode', 'rules' =>'required'],
        'akhir'  	=> ['label' => 'Akhir Periode', 'rules' =>'required'],
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
		'edit'		=> true,
		'delete'	=> true,
	];
}
