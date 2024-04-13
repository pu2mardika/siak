<?php namespace Modules\Akademik\Room\Config;

use CodeIgniter\Config\BaseConfig;

class Jurusan extends BaseConfig
{
	/**
	 * --------------------------------------------------------------------
	 * Libraries : `id_jur`, `satker`, `nm_jurusan`, `desc`, `prasyarat`, `state` tbl_jurusan`
	 * --------------------------------------------------------------------
	 *
	 * @var array
	 */
	public $opsi = [
		'state' => [1 => 'Tidak Aktif', 2 => 'Aktif', 3 => 'Tingkat Ketiga',],
		'satker' => [1 => 'LKP', 2 => 'PKBM', 3 => 'Pasraman',],
	];

	/**
	* ---------------------------------------------------------------------
	* FIELD NAME 
	* ---------------------------------------------------------------------
	* @var array
	* 
	*/
	public $fields = [
		'nm_jurusan'=> ['label' => 'Nama Jenis Program','width'=>40,'extra'=>['id' => 'namajurusan','class' => '', 'required' => true],'type'=>'text', ],
		'satker'	=> ['label' => 'Unit Pelaksana','width'=>0,'extra'=>['id' => 'saatker','class' => '', 'required' => true],'type'=>'dropdown'],
		'desc'		=> ['label' => 'Deskripsi','width'=>40,'extra'=>['class' => '', 'style' => 'height: 100px','required' => true],'type'=>'textarea'],
		'prasyarat' => ['label' => 'Syarat Mengikuti','width'=>0,'extra'=>['id' => 'grade','class' => '', 'required' => false],'type'=>'text'],
		'state'	 	=> ['label' => 'Status','width'=>0,'extra'=>['id' => 'kodeta','class' => '', 'required' => false],'type'=>'dropdown'], 
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
        'nm_jurusan'=> ['label' => 'Nama Jenis Program', 'rules' =>'required'],
        'satker'  	=> ['label' => 'Unit Pelaksana', 'rules' =>'required'],
        'desc'  	=> ['label' => 'Deskripsi Jenis Program', 'rules' =>'required'],
        'prasyarat' => ['label' => 'Syarat Mengikuti', 'rules' =>'required'],
	];  
	
	public $roleEdit = [
		'nm_jurusan'=> ['label' => 'Nama Jenis Program', 'rules' =>'required'],
        'satker'  	=> ['label' => 'Unit Pelaksana', 'rules' =>'required'],
        'desc'  	=> ['label' => 'Deskripsi Jenis Program', 'rules' =>'required'],
        'prasyarat' => ['label' => 'Syarat Mengikuti', 'rules' =>'required'],
	];  
	/**
	 * --------------------------------------------------------------------
	 * Layout for the views to extend
	 * --------------------------------------------------------------------
	 *
	 * @var string
	 */
	public $primarykey = 'id_jur';
	
	
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
		'detail'	=> true,
		'edit'		=> true,
		'delete'	=> true,
	];
		
}
