<?php

namespace Modules\Project\Config;

use CodeIgniter\Config\BaseConfig;

class DistribConf extends BaseConfig
{
    //
    public $opsi = [];

    /**
	* ---------------------------------------------------------------------
	* FIELD NAME :  'dimensi_id', 'deskripsi'
	* ---------------------------------------------------------------------
	* @var array
	* 
	*/
	public array $fields = [
	//	'project_id'=> ['label' => 'Dimensi','width'=>20,'extra'=>['id' => 'grupID','class' => '', 'required' => true],'type'=>'dropdown'], 
		'deskripsi'	=> ['label' => 'Nama Elemen Project','width'=>35,'extra'=>['id' => 'namaMP','class' => '', 'required' => true],'type'=>'text'],   
	];

	public $srcFields = [
		'project_id'=> ['label' => 'elemenID','width'=>2,'extra'=>['id'=>'elID', 'name'=>'project_id[]'], 'type'=>'checkbox'], 
		'deskripsi'	=> ['label' => 'Elemen yang Dinilai','width'=>60, 'type'=>'display'], 
	];

	public string $resume_descrip_field = '';

	public array $res_addON_fields = [  //MAKS: 3 FIELDS
	];
    
	public array $roles = [
        'project_id'=> ['label' => 'Projek', 'rules' =>'required'],
	];  

	public string $primarykey = 'id';
	
	/**
	* ---------------------------------------------------------------------
	* Export and Import data allowed
	* ---------------------------------------------------------------------
	* 
	* @var boelean
	*/
	public bool $importallowed = false;
	
	/**
	* ---------------------------------------------------------------------
	* action boolean
	* ---------------------------------------------------------------------
	* 
	* @var array
	*/
	public $actions = [
		'delete'	=> ['icon'=>'trash','src'=>'project/rem/', 'label'=>'Detail', 'extra'=>"onclick='AjaxConfirm(event)' data-target='mapel-content'"],
	];
	
	public array $addOnACt = [
		'add' 		=> ['icon'=>'plus-square','src'=>'project/set?idr=', 'label'=>'Tambah Projek', 'btn_type'=>'success btn-sm', 'extra'=>''],
	];
	
	public array $detAddOnACt = [
		
	];
	
	public string $arrDelimeter = '++VHV++';
}
