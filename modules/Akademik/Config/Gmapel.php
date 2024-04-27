<?php

namespace Modules\Akademik\Config;

use CodeIgniter\Config\BaseConfig;

class Gmapel extends BaseConfig
{
    public $opsi = [];

    /**
	* ---------------------------------------------------------------------
	* FIELD NAME : 'curr_id', 'nm_grup', 'parent_grup'
	* ---------------------------------------------------------------------
	* @var array
	* 
	*/
	public array $fields = [
		'curr_id'	  => ['label' => 'Kurikulum','width'=>0,'extra'=>['id' => 'currID','class' => '', 'required' => true],'type'=>'dropdown', ], 
		'nm_grup'	  => ['label' => 'Nama Grup Mapel','width'=>35,'extra'=>['id' => 'nmgrup','class' => '', 'required' => true],'type'=>'text'], 
		'parent_grup' => ['label' => 'Parent','width'=>15,'extra'=>['id' => 'parentg','class' => '', 'required' => true],'type'=>'dropdown',],  
	];

	public string $resume_descrip_field = '';

	public array $res_addON_fields = [  //MAKS: 3 FIELDS
	];
    
	public array $roles = [
		'curr_id'  => ['label' => 'Sub Level', 'rules' =>'required'],
		'nm_grup'=> ['label' => 'Nama Level', 'rules' =>'required'],
		'parent_grup' => ['label' => 'Parent Grup', 'rules' =>'required'],
	];  

	public string $primarykey = 'grup_id';
	
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
		'edit' 		=> ['icon'=>'edit','src'=>'gmapel/edit/', 'label'=>'Detail', 'extra'=>''],
		'delete'	=> ['icon'=>'trash','src'=>'gmapel/hapus/', 'label'=>'Detail', 'extra'=>"onclick='confirmation(event)'"],
	];
	
	public array $addOnACt = [
		//'spk' => ['icon'=>'list-alt','src'=>'petakd/show/', 'label'=>'Detail'],
	];
	
	public array $detAddOnACt = [
		//'print' => ['icon'=>'print','src'=>'skl/cetak/', 'label'=>'Cetak', 'btn_type'=>'success'],
	];
	
	public string $arrDelimeter = '++VHV++';
}
