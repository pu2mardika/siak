<?php

namespace Modules\Project\Config;

use CodeIgniter\Config\BaseConfig;

class MapConfig extends BaseConfig
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
		'dimensi_id'=> ['label' => 'Dimensi','width'=>20,'extra'=>['id' => 'grupID','class' => '', 'required' => true],'type'=>'dropdown'], 
		'deskripsi'	=> ['label' => 'Nama Elemen Project','width'=>35,'extra'=>['id' => 'namaMP','class' => '', 'required' => true],'type'=>'text'],   
	];

	public $srcFields = [
		'id'		=> ['label' => 'elemenID','width'=>2,'extra'=>['id'=>'elID', 'name'=>'subelemen_id[]'], 'type'=>'checkbox'], 
		'deskripsi'	=> ['label' => 'Elemen yang Dinilai','width'=>60, 'type'=>'display'], 
	];

	public string $resume_descrip_field = '';

	public array $res_addON_fields = [  //MAKS: 3 FIELDS
	];
    
	public array $roles = [
        'subelemen_id'=> ['label' => 'Elemen Projek', 'rules' =>'required'],
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
		'edit' 		=> ['icon'=>'edit','src'=>'mapping/edit/', 'label'=>'Detail', 'extra'=>''],
		'delete'	=> ['icon'=>'trash','src'=>'elemen/hapus/', 'label'=>'Detail', 'extra'=>"onclick='AjaxConfirm(event)' data-target='mapel-content'"],
	];
	
	public array $addOnACt = [
		
	];
	
	public array $detAddOnACt = [
		
	];
	
	public string $arrDelimeter = '++VHV++';
}
