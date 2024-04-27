<?php

namespace Modules\Akademik\Config;

use CodeIgniter\Config\BaseConfig;

class Rating extends BaseConfig
{
    public $opsi = [];

    /**
	* ---------------------------------------------------------------------
	* FIELD NAME : 'id', 'curr_id', 'nm_komponen', 'no_urut', 'jns_nilai', 'type_nilai', 'is_mapel', 'tbl_stored_name', 'has_descript'
	* ---------------------------------------------------------------------
	* $lang['type_nilai_arr']=array("NR"=>'Nilai Raport', "NA"=>"Nilai Ujian Akhir Sekolah");

	  $lang['tbl_stored_name']="Lokasi Penyimpanan";
	  $lang['tbl_stored_name_arr']=array("tbl_leger_nilai"=>'LEGER NILAI', 
									   "tbl_nilai_sikap"=>"SIKAP"
								  );

	* 
	*/
	public array $fields = [
		'nm_komponen' => ['label' => 'Nama Komponen Penilaian','width'=>35,'extra'=>['id' => 'nmgrup','class' => '', 'required' => true],'type'=>'text'], 
		'no_urut' 	  => ['label' => 'No. Urut','width'=>10,'extra'=>['id' => 'nOrder','class' => '', 'required' => true],'type'=>'text',],  
		'jns_nilai'   => ['label' => 'Model Nilai','width'=>10,'extra'=>['id' => 'nOrder','class' => '', 'required' => true],'type'=>'dropdown',],  
		'type_nilai'  => ['label' => 'Model Nilai','width'=>10,'extra'=>['id' => 'nOrder','class' => '', 'required' => true],'type'=>'dropdown',],  
		'is_mapel'    => ['label' => 'Model Nilai','width'=>10,'extra'=>['id' => 'nOrder','class' => '', 'required' => true],'type'=>'dropdown',],  
		'has_descript'    => ['label' => 'Model Nilai','width'=>10,'extra'=>['id' => 'nOrder','class' => '', 'required' => true],'type'=>'dropdown',],
		'tbl_stored_name' => ['label' => 'Model Nilai','width'=>10,'extra'=>['id' => 'nOrder','class' => '', 'required' => true],'type'=>'dropdown',],  
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
