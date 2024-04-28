<?php

namespace Modules\Akademik\Config;

use CodeIgniter\Config\BaseConfig;

class Subject extends BaseConfig
{
    public $opsi = [
    	'form_nilai'=>[0=>"Nilai Tunggal", 1=>'Modular'],
    ];

    /**
	* ---------------------------------------------------------------------
	* FIELD NAME : 'id', 'grup_id', 'subject_name', 'akronim', 'item_order', 'tot_skk', 'form_nilai'
	* ---------------------------------------------------------------------
	* @var array
	* 
	*/
	public array $fields = [
		'grup_id'		=> ['label' => 'Level','width'=>0,'extra'=>['id' => 'grupID','class' => '', 'required' => true],'type'=>'dropdown'], 
		'subject_name'	=> ['label' => 'Nama Mata Pelajaran','width'=>35,'extra'=>['id' => 'namaMP','class' => '', 'required' => true],'type'=>'text'], 
		'akronim'		=> ['label' => 'Akronim','width'=>10,'extra'=>['id' => 'sbjID','class' => '', 'required' => true,'minlength'=>3, 'maxlength'=>3, 'size'=>3],'type'=>'text', ], 
		'item_order'	=> ['label' => 'No Urut','width'=>0,'extra'=>['id' => 'noUrt','class' => ''],'type'=>'text', ], 
		'tot_skk'		=> ['label' => 'Jml SKK','width'=>10,'extra'=>['id' => 'skk','class' => '', 'required' => true],'type'=>'text',],  
		'form_nilai'	=> ['label' => 'Format Nilai','width'=>15,'extra'=>['id' => 'frmnilai','class' => '', 'required' => true],'type'=>'dropdown',],  
	];

	public string $resume_descrip_field = '';

	public array $res_addON_fields = [  //MAKS: 3 FIELDS
	];
    
	public array $roles = [
        'akronim'   	=> ['label' => 'Kode/Akronim', 'rules' =>'required|max_length[3]'],
		//'grup_id'  		=> ['label' => 'Level', 'rules' =>'required'],
		'subject_name'	=> ['label' => 'Nama Mapel', 'rules' =>'required'],
		'item_order' 	=> ['label' => 'No Urut', 'rules' =>'required'],
        'tot_skk'   	=> ['label' => 'Total SKK', 'rules' =>'required'],
        'form_nilai'   	=> ['label' => 'Format Nilai', 'rules' =>'required'],
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
		'edit' 		=> ['icon'=>'edit','src'=>'subject/edit/', 'label'=>'Detail', 'extra'=>''],
		'delete'	=> ['icon'=>'trash','src'=>'subject/hapus/', 'label'=>'Detail', 'extra'=>"onclick='AjaxConfirm(event)' data-target='mapel-content'"],
	];
	
	public array $addOnACt = [
		//'spk' => ['icon'=>'list-alt','src'=>'petakd/show/', 'label'=>'Detail'],
	];
	
	public array $detAddOnACt = [
		//'print' => ['icon'=>'print','src'=>'skl/cetak/', 'label'=>'Cetak', 'btn_type'=>'success'],
	];
	
	public string $arrDelimeter = '++VHV++';
}
