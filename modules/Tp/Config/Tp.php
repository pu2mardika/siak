<?php namespace Modules\Tp\Config;

use CodeIgniter\Config\BaseConfig;

class Tp extends BaseConfig
{
	/**
	 * --------------------------------------------------------------------
	 * Libraries :SELECT 'thid', 'deskripsi', 'awal', 'akhir' FROM 'tbl_tp' WHERE 1
	 * --------------------------------------------------------------------
	 *
	 * @var array
	 */
	public $opsi = [];

	/**
	* ---------------------------------------------------------------------
	* FIELD NAME 
	* ---------------------------------------------------------------------
	* 'thid', 'deskripsi', 'awal', 'akhir'
	* @var array
	* 
	*/
	public $fields = [
		'deskripsi'		=> ['label' => 'Deskripsi','width'=>40, 'extra'=>['class' => '', 'required' => true],'type'=>'text'],
		'awal'			=> ['label' => 'Awal Tahun Pelajaran','width'=>20,'extra'=>['class' => '', 'required' => true],'type'=>'date'], 
		'akhir'			=> ['label' => 'Akhir Tahun Pelajaran','width'=>20,'extra'=>['class' => '', 'required' => true],'type'=>'date', ], 		 
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
		'deskripsi' => ['label' => 'Deskripsi', 'rules' => "required"],
        'awal'  	=> ['label' => 'Awal Tahun Pelajaran', 'rules' =>'required'],
        'akhir'  	=> ['label' => 'Akhir Tahun Pelajaran', 'rules' =>'required'],
	]; 
	
	public $roleEdit = [
		'deskripsi' => ['label' => 'Deskripsi', 'rules' => "required"],
        'awal'  	=> ['label' => 'Awal Tahun Pelajaran', 'rules' =>'required'],
        'akhir'  	=> ['label' => 'Akhir Tahun Pelajaran', 'rules' =>'required'],
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
	//	'detail'	=> true,
		'edit'		=> true,
		'delete'	=> true,
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
	//public $actiondetail = true; 
	//public $actionedit   = true; 
	//public $actiondelete = true; 
		
}
