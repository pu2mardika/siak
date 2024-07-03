<?php

namespace Modules\Project\Config;

use CodeIgniter\Config\BaseConfig;

class SubElemen extends BaseConfig
{
    //
    public $opsi = [];

    /**
	* ---------------------------------------------------------------------
	* FIELD NAME : 'elemen_id','deskripsi','tujuan'
	* ---------------------------------------------------------------------
	* @var array
	* 
	*/
	public array $fields = [
		'elemen_id'=> ['label' => 'Dimensi','width'=>20,'extra'=>['id' => 'elId','class' => '', 'required' => true],'type'=>'dropdown'], 
		'deskripsi'	=> ['label' => 'Nama Elemen Project','width'=>35,'extra'=>['id' => 'desc','class' => '', 'required' => true],'type'=>'text'],   
		'tujuan'	=> ['label' => 'Target Capaian ','width'=>30,'extra'=>['id' => 'target','class' => '', 'required' => true],'type'=>'text'],   
	];

	public array $fieldCells = [
		'deskripsi'	=> ['label' => 'Sub Elemen Project','width'=>40,'type'=>'text'], 
		'tujuan'	=> ['label' => 'Target Capaian','width'=>30,'type'=>'text' ],  
	];

	public string $resume_descrip_field = '';

	public array $res_addON_fields = [  //MAKS: 3 FIELDS
	];
    
	public array $roles = [
        'elemen_id' => ['label' => 'Elemen Project', 'rules' =>'required'],
		'deskripsi'	=> ['label' => 'Nama Elemen', 'rules' =>'required'],
		'tujuan'	=> ['label' => 'Target Capaian', 'rules' =>'required'],
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
		'edit' 		=> ['icon'=>'edit','src'=>'subelemen/edit/', 'label'=>'Detail', 'extra'=>''],
		'delete'	=> ['icon'=>'trash','src'=>'subelemen/hapus/', 'label'=>'Detail', 'extra'=>"onclick='AjaxConfirm(event)' data-target='mapel-content'"],
	];
	
	public array $addOnACt = [
		
	];
	
	public array $detAddOnACt = [
		
	];
	
	public string $arrDelimeter = '++VHV++';
}
