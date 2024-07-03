<?php

namespace Modules\Akademik\Config;

use CodeIgniter\Config\BaseConfig;

class Mapel extends BaseConfig
{
    public $opsi = [];

    /**
	* ---------------------------------------------------------------------
	* FIELD NAME : 'id_mapel', 'id_skl', 'skk' FROM 'mapel'
	* ---------------------------------------------------------------------
	* @var array
	* 
	*/
	public array $fields = [
		'id_subject'=> ['label' => 'Mata Pelajaran','width'=>35,'extra'=>['id' => 'mpid','class' => '', 'required' => true],'type'=>'dropdown'],
		'skk'	=> ['label' => 'Jumlah SKK','width'=>10,'extra'=>['id' => 'jskk','class' => '', 'required' => true],'type'=>'text'], 
	];
	
	public array $fieldCells = [
		'subject_name'	=> ['label' => 'Nama Mata Pelajaran','width'=>35,'type'=>'text'], 
		'akronim'		=> ['label' => 'Akronim','width'=>10,'type'=>'text' ], 
		'skk'		=> ['label' => 'Jml SKK','width'=>10,'type'=>'number'],   
	];


	public string $resume_descrip_field = '';

	public array $res_addON_fields = [  //MAKS: 3 FIELDS
	];
    
	public array $roles = [
        'id_skl'   	=> ['label' => 'Kode/Akronim', 'rules' =>'required'],
		'id_subject'	=> ['label' => 'Nama Mata Pelajaran', 'rules' =>'required'],
        'skk'  	=> ['label' => 'Jumlah SKK', 'rules' =>'required'],
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
		'edit' 		=> ['icon'=>'edit','src'=>'mapel/edit/', 'label'=>'Detail', 'extra'=>''],
		'delete'	=> ['icon'=>'trash','src'=>'mapel/hapus/', 'label'=>'Detail', 'extra'=>"onclick='AjaxConfirm(event)' data-target='mapel-content'"],
	];
	
	public string $arrDelimeter = '++VHV++';
	
}
