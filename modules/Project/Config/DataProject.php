<?php

namespace Modules\Project\Config;

use CodeIgniter\Config\BaseConfig;

class DataProject extends BaseConfig
{
    //
    public $opsi = [];

    /**
	* ---------------------------------------------------------------------
	* FIELD NAME :  'curr_id', 'nama_project', 'deskripsi'
	* ---------------------------------------------------------------------
	* @var array
	* 
	*/
	public array $fields = [
		'curr_id'	    => ['label' => 'Kurikulum','width'=>20,'extra'=>['id' => 'curID','class' => '', 'required' => true],'type'=>'dropdown'], 
		'nama_project'	=> ['label' => 'Nama Projek','width'=>35,'extra'=>['id' => 'nmproject','class' => '', 'required' => true,'maxlength'=>100],'type'=>'text'],   
		'deskripsi'	    => ['label' => 'Deskripsi Singkat','width'=>35,'extra'=>['id' => 'my-input','class' => '', 'required' => true, 'rows'=>4, 'maxlength'=>250, 'title'=>'Maks 250 character'],'type'=>'textarea'],   
	];

	public string $resume_descrip_field = '';

	public array $res_addON_fields = [  //MAKS: 3 FIELDS
	];
    
	public array $roles = [
        'curr_id'   	=> ['label' => 'Kurikulum', 'rules' =>'required'],
		'nama_project'	=> ['label' => 'Nama Projek', 'rules' =>'required'],
		'deskripsi'	    => ['label' => 'Deskpripsi', 'rules' =>'required'],
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
		'edit' 		=> ['icon'=>'edit','src'=>'project/edit/', 'label'=>'Edit', 'extra'=>''],
		'delete'	=> ['icon'=>'trash','src'=>'project/hapus/', 'label'=>'Hapus', 'extra'=>"onclick='AjaxConfirm(event)' data-target='mapel-content'"],
	];
	
	public array $addOnACt = [
		//'spk' => ['icon'=>'list-alt','src'=>'petakd/show/', 'label'=>'Detail'],
	];

	public array $ajxAction = [
		'detail' 	=> ['icon'=>'list-alt','src'=>'project/map?ids=', 'label'=>'Detail', 'extra'=>''],
	];
	
	public array $detAddOnACt = [
		//'print' => ['icon'=>'print','src'=>'skl/cetak/', 'label'=>'Cetak', 'btn_type'=>'success'],
	];
	
	public string $arrDelimeter = '++VHV++';
}
