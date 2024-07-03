<?php

namespace Modules\Assessment\Config;

use CodeIgniter\Config\BaseConfig;

class AtpConfig extends BaseConfig
{
    public $opsi = [];

    /**
	* ---------------------------------------------------------------------
	* FIELD NAME : 'id_mengajar', 'rating_id', 'idx', 'atp'
	* ---------------------------------------------------------------------
	* 
	*/
	public array $fields = [
		'rating_id'   => ['label' => 'Komponen Nilai','width'=>25,'extra'=>['id' => 'ratingID','class' => '', 'required' => true], 'type'=>'dropdown'], 
		'idx'   	  => ['label' => 'No','width'=>10,'extra'=>['id' => 'jIDX','class' => '', 'required' => true],'type'=>'text',],
		'atp'   	  => ['label' => 'Tujuan','width'=>60,'extra'=>['id' => 'cpAtp','class' => '', 'required' => true],'type'=>'textarea',],
	];

	public array $Editfields = [
		'rating_id'   => ['label' => 'Komponen Nilai','width'=>25,'extra'=>['id' => 'ratingID','class' => '', 'disabled' => true], 'type'=>'dropdown'], 
		'atp'   	  => ['label' => 'Tujuan','width'=>60,'extra'=>['id' => 'cpAtp','class' => '', 'required' => true],'type'=>'textarea',],
	];

	public array $roles = [
		'rating_id'   => ['label' => 'Komponen Nilai', 'rules' =>'required'],
		'idx'		  => ['label' => 'No', 'rules' =>'required'],
		'atp'		  => ['label' => 'Tujuan', 'rules' =>'required'],
	];  

	public array $rolesEdit = [
		'atp'		  => ['label' => 'Tujuan', 'rules' =>'required'],
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
		'edit' 		=> ['icon'=>'edit','src'=>'atp/edit/', 'label'=>'Detail', 'extra'=>''],
		'delete'	=> ['icon'=>'trash','src'=>'atp/hapus/', 'label'=>'Detail', 'extra'=>"onclick='confirmation(event)'"],
	];
	
	public $cpActions = [
		'add' 		=> ['icon'=>'plus','src'=>'atp/add?idm=', 'label'=>'Tambah', 'extra'=>''],
	];

	public $condActions = [
		0 =>[
				'import' => ['icon'=>'file-excel-o','src'=>'atp/import/', 'label'=>'Import CP/ATP', 'extra'=>'', 'btn_type'=>''],
			],
		1 =>[
				'import' => ['icon'=>'file-excel-o','src'=>'atp/import/', 'label'=>'Import CP/ATP', 'extra'=>'', 'btn_type'=>''],
				'reset' => ['icon'=>'refresh','src'=>'atp/reset/', 'label'=>'Reset ATP', 'extra'=>"onclick='confirmation(event)'", 'btn_type'=>''],
				'shpd'  => ['icon'=>'list-alt','src'=>'nilai/vdata?ids=', 'label'=>'Input Nilai', 'extra'=>'', 'btn_type'=>'']
			]
	];
	
	public string $arrDelimeter = '++VHV++';

	public string $addonJS = '
		$("#ratingID").change(function(){
			var r=$(this).val();
			var m=$("[name=\'id_mengajar\']").val(); 
			load("atp/getID?idr="+r+"&idm="+m,"#addOnInput");
		});	
	';
}
