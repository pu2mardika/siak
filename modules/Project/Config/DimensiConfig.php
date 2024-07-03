<?php

namespace Modules\Project\Config;

use CodeIgniter\Config\BaseConfig;

class DimensiConfig extends BaseConfig
{
    //
    public $opsi = [];

    /**
	* ---------------------------------------------------------------------
	* FIELD NAME :  'curr_id', 'nama_dimensi'
	* ---------------------------------------------------------------------
	* @var array
	* 
	*/
	public array $fields = [
		'curr_id'		=> ['label' => 'Kurikulum','width'=>20,'extra'=>['id' => 'grupID','class' => '', 'required' => true],'type'=>'dropdown'], 
		'nama_dimensi'	=> ['label' => 'Nama Dimensi Project','width'=>35,'extra'=>['id' => 'namaMP','class' => '', 'required' => true],'type'=>'text'],   
	];

	public string $resume_descrip_field = '';

	public array $res_addON_fields = [  //MAKS: 3 FIELDS
	];
    
	public array $roles = [
        'curr_id'   	=> ['label' => 'Kurikulum', 'rules' =>'required'],
		'nama_dimensi'	=> ['label' => 'Nama Dimensi', 'rules' =>'required'],
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
		'edit' 		=> ['icon'=>'edit','src'=>'dimensi/edit/', 'label'=>'Detail', 'extra'=>''],
		'delete'	=> ['icon'=>'trash','src'=>'dimensi/hapus/', 'label'=>'Detail', 'extra'=>"onclick='AjaxConfirm(event)' data-target='mapel-content'"],
	];
	
	public array $addOnACt = [
		//'spk' => ['icon'=>'list-alt','src'=>'petakd/show/', 'label'=>'Detail'],
	];
	
	public array $detAddOnACt = [
		//'print' => ['icon'=>'print','src'=>'skl/cetak/', 'label'=>'Cetak', 'btn_type'=>'success'],
	];
	
	public string $arrDelimeter = '++VHV++';
}
