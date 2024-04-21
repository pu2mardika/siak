<?php

namespace Modules\Akademik\Config;

use CodeIgniter\Config\BaseConfig;

class Subject extends BaseConfig
{
    public $opsi = [
    	'form_nilai'=>[0=>"Nilai Tunggal", 1=>'Modular'];
    ];

    /**
	* ---------------------------------------------------------------------
	* FIELD NAME : 'subjectid', 'grup_id', 'subject_name', 'item_order', 'tot_skk', 'form_nilai'
	* ---------------------------------------------------------------------
	* @var array
	* 
	*/
	public array $fields = [
		'subjectid'		=> ['label' => 'Kode','width'=>0,'extra'=>['id' => 'sbjID','class' => '', 'required' => true,'minlength'=>4, 'maxlength'=>4, 'size'=>4],'type'=>'text', ], 
		'grup_id'		=> ['label' => 'Level','width'=>0,'extra'=>['id' => 'grupID','class' => '', 'required' => true],'type'=>'dropdown'], 
		'subject_name'	=> ['label' => 'Nama Mata Pelajaran','width'=>35,'extra'=>['id' => 'namaMP','class' => '', 'required' => true],'type'=>'text'], 
		'item_order'	=> ['label' => 'No Urut','width'=>10,'extra'=>['id' => 'noUrt','class' => ''],'type'=>'text', ], 
		'tot_skk'		=> ['label' => 'Jml SKK','width'=>10,'extra'=>['id' => 'skk','class' => '', 'required' => true],'type'=>'text',],  
		'form_nilai'	=> ['label' => 'Format Nilai','width'=>15,'extra'=>['id' => 'frmnilai','class' => '', 'required' => true],'type'=>'dropdown',],  
	];

	public string $resume_descrip_field = '';

	public array $res_addON_fields = [  //MAKS: 3 FIELDS
	];
    
	public array $roles = [
        'grade'   	=> ['label' => 'Level', 'rules' =>'required|max_length[4]'],
		'subgrade'  => ['label' => 'Sub Level', 'rules' =>'required'],
		'grade_name'=> ['label' => 'Nama Level', 'rules' =>'required'],
		'deskripsi' => ['label' => 'Standar Kompetensi/Capaian Hasil', 'rules' =>'required|max_length[250]'],
        'currId'   	=> ['label' => 'Kurikulum', 'rules' =>'required'],
	];  

	public string $primarykey = 'subjectid';
	
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
		'edit' 		=> ['icon'=>'edit','src'=>'subject/edit/', 'label'=>'Detail', 'extra'=>''],
		'delete'	=> ['icon'=>'trash','src'=>'subject/hapus/', 'label'=>'Detail', 'extra'=>"onclick='confirmation(event)'"],
	];
	
	public array $addOnACt = [
		//'spk' => ['icon'=>'list-alt','src'=>'petakd/show/', 'label'=>'Detail'],
	];
	
	public array $detAddOnACt = [
		//'print' => ['icon'=>'print','src'=>'skl/cetak/', 'label'=>'Cetak', 'btn_type'=>'success'],
	];
	
	public string $arrDelimeter = '++VHV++';
}
