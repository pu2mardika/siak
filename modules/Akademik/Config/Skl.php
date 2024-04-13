<?php

namespace Modules\Akademik\Config;

use CodeIgniter\Config\BaseConfig;

class Skl extends BaseConfig
{
     public $opsi = [];

    /**
	* ---------------------------------------------------------------------
	* FIELD NAME : 'grade, subgrade, grade_name, skl, curr_id',
	* ---------------------------------------------------------------------
	* @var array
	* 
	*/
	public array $fields = [
		'grade'		=> ['label' => 'Level','width'=>5,'extra'=>['id' => 'grade','class' => '', 'required' => true],'type'=>'text', ], 
		'subgrade'	=> ['label' => 'Sub Level','width'=>5,'extra'=>['id' => 'subgrad','class' => '', 'required' => true],'type'=>'text'], 
		'grade_name'=> ['label' => 'Sub Level','width'=>5,'extra'=>['id' => 'subgrad','class' => '', 'required' => true],'type'=>'text'], 
		'skl'		=> ['label' => 'Standar Kompetensi','width'=>40,'extra'=>['id' => 'editor','class' => ''],'type'=>'textarea', ], 
		'curr_id'	=> ['label' => 'Kurikulum','width'=>0,'extra'=>['id' => 'tmt','class' => '', 'required' => true],'type'=>'dropdown',],  
	];

	public string $resume_descrip_field = '';

	public array $res_addON_fields = [  //MAKS: 3 FIELDS
	];
    
	public array $roles = [
        'grade'   	=> ['label' => 'Nama Prodi', 'rules' =>'required'],
		'subgrade'   	=> ['label' => 'Level', 'rules' =>'required'],
		'grade_name'  	=> ['label' => 'Sub Level', 'rules' =>'required'],
		'skl'   		=> ['label' => 'Standar Kompetensi/Capaian Hasil', 'rules' =>'required'],
        'curr_id'   	=> ['label' => 'Kurikulum', 'rules' =>'required'],
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
		'detail'	=> false,
		'edit'		=> true,
		'delete'	=> true,
	];
	
	public array $addOnACt = [
		//'spk' => ['icon'=>'file-word','src'=>'kurikulum/detail/', 'label'=>'Detail'],
	];
	
	public array $detAddOnACt = [
		//'print' => ['icon'=>'print','src'=>'skl/cetak/', 'label'=>'Cetak', 'btn_type'=>'success'],
	];
}
