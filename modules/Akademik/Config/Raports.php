<?php

namespace Modules\Akademik\Config;

use CodeIgniter\Config\BaseConfig;

class Raports extends BaseConfig
{
    public $opsi = [];

    /**
	* ---------------------------------------------------------------------
	* FIELD NAME : 'id', 'curr_id', 'hal', 'block', 'comp_nilai', 'judul' FROM 'comp_rpt'
	* ---------------------------------------------------------------------
	* 
	*/
	public array $fields = [
		'judul' 	 => ['label' => 'Judul Section','width'=>25,'extra'=>['id' => 'nmsectp','class' => '', 'required' => true],
						 'type'=>'text'], 
		'comp_nilai' => ['label' => 'Komponen Nilai','width'=>10,'extra'=>['id' => 'jNilai','class' => '', 'required' => true],'type'=>'dropdown',],
		'hal'  	     => ['label' => 'Nomor Halaman','width'=>15,'extra'=>['id' => 'typN','class' => '', 'required' => true],'type'=>'number',],
		'block'    	 => ['label' => 'Nomor block','width'=>5,'extra'=>['id' => 'isMP','class' => '', 'required' => true],'type'=>'number',],
	];

	public array $roles = [
		'judul'  	  => ['label' => 'Nama Komponen', 'rules' =>'required'],
		'comp_nilai'  => ['label' => 'Model Nilai', 'rules' =>'required'],
		'hal'	      => ['label' => 'No. Urut', 'rules' =>'required'],
		'block' 	  => ['label' => 'Tipe Nilai', 'rules' =>'required'],
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
		'edit' 		=> ['icon'=>'edit','src'=>'raports/edit/', 'label'=>'Detail', 'extra'=>''],
		'delete'	=> ['icon'=>'trash','src'=>'raports/hapus/', 'label'=>'Detail', 'extra'=>"onclick='confirmation(event)'"],
	];
	
	public string $arrDelimeter = '++VHV++';
}
