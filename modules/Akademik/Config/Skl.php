<?php
namespace Modules\Akademik\Config;

use CodeIgniter\Config\BaseConfig;

class Skl extends BaseConfig
{
     public $opsi = [];

    /**
	* ---------------------------------------------------------------------
	* FIELD NAME : 'grade', 'subgrade', 'grade_name', 'skl, curr_id',
	* ---------------------------------------------------------------------
	* @var array
	* 
	*/
	public array $fields = [
		'grade'		=> ['label' => 'Level','width'=>5,'extra'=>['id' => 'grade','class' => '', 'required' => true],'type'=>'text', ], 
		'subgrade'	=> ['label' => 'Sub Level','width'=>5,'extra'=>['id' => 'subgrad','class' => '', 'required' => true],'type'=>'text'], 
		'grade_name'=> ['label' => 'Nama Level','width'=>15,'extra'=>['id' => 'subgrad','class' => '', 'required' => true],'type'=>'text'], 
		'deskripsi'	=> ['label' => 'Capaian Pembelajaran','width'=>40,'extra'=>['id' => 'editor','class' => ''],'type'=>'textarea', ], 
		'currId'	=> ['label' => 'Kurikulum','width'=>20,'extra'=>['id' => 'tmt','class' => '', 'required' => true],'type'=>'dropdown',],  
	];
	
	public array $fields2 = [
		'grade'		=> ['label' => 'Level','width'=>5,'extra'=>['id' => 'grade','class' => '', 'required' => true],'type'=>'dropdown', ], 
		'subgrade'	=> ['label' => 'Sub Level','width'=>5,'extra'=>['id' => 'subgrad','class' => '', 'required' => true],'type'=>'dropdown'], 
		'grade_name'=> ['label' => 'Nama Level','width'=>20,'extra'=>['id' => 'subgrad','class' => '', 'required' => true],'type'=>'text'], 
		'deskripsi'	=> ['label' => 'Capaian Pembelajaran','width'=>40,'extra'=>['id' => 'editor','class' => '','rows'=>5],'type'=>'textarea'],
	];
	
	public array $fieldcels = [
		//'grade'		=> ['label' => 'Level','width'=>0,'extra'=>['id' => 'grade','class' => '', 'required' => true],'type'=>'text', ], 
		//'subgrade'	=> ['label' => 'Sub Level','width'=>0,'extra'=>['id' => 'subgrad','class' => '', 'required' => true],'type'=>'text'], 
		'grade_name'=> ['label' => 'Nama Level','width'=>25,'type'=>'text'], 
		'deskripsi'	=> ['label' => 'Capaian Pembelajaran','width'=>40,'type'=>'text', 'hasChild' => true],   
	];

	public string $resume_descrip_field = '';

	public array $res_addON_fields = [  //MAKS: 3 FIELDS
	];
    
	public array $roles = [
        'grade'   	=> ['label' => 'Level', 'rules' =>'required'],
		'subgrade'  => ['label' => 'Sub Level', 'rules' =>'required'],
		'grade_name'=> ['label' => 'Nama Level', 'rules' =>'required'],
		'deskripsi' => ['label' => 'Standar Kompetensi/Capaian Hasil', 'rules' =>'required|max_length[250]'],
        'currId'   	=> ['label' => 'Kurikulum', 'rules' =>'required'],
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
		'edit' 	 => ['icon'=>'edit','src'=>'skl/edit/', 'label'=>'Detail', 'extra'=>''],
		'delete' => ['icon'=>'trash','src'=>'skl/hapus/', 'label'=>'Detail', 'extra'=>"onclick='AjaxConfirm(event)' data-target='skl-content'"],
	];
	
	public array $addOnACt = [
		'spk' => ['icon'=>'list-alt','src'=>'petakd/show/', 'label'=>'Detail'],
	];
	
	public array $detAddOnACt = [
		//'print' => ['icon'=>'print','src'=>'skl/cetak/', 'label'=>'Cetak', 'btn_type'=>'success'],
	];
	
	public string $arrDelimeter = '++VHV++';
}
