<?php

namespace Modules\Akademik\Config;

use CodeIgniter\Config\BaseConfig;

class Rating extends BaseConfig
{
    public $opsi = [
    	'jns_nilai'		 => ["A"=>"Angka","H"=>"Huruf"],
    	'type_nilai'	 => ["NR"=>'Nilai Raport', "NA"=>"Nilai Ujian Akhir Sekolah", "NE"=>"Nilai Ekstrakurikuler", "ON"=>"Nilai Lainnya"],
    	'is_mapel'		 => [1=>"YA",0=>"TIDAK"],
    	'has_descript' 	 => [1=>"YA",0=>"TIDAK"],
    	'tbl_stored_name'=> ["leger_nilai" => "LEGER NILAI", "nilai_sikap" =>"NILAI SIKAP"],
    ];

	public function tbl_stored_name($jenis):string
	{
		$storage = ['A'=>'leger_nilai', 'H'=>'nilai_deskripsi'];
		return $storage[$jenis];
	}

    /**
	* ---------------------------------------------------------------------
	* FIELD NAME : 'id', 'curr_id', 'nm_komponen', 'no_urut', 'jns_nilai', 'type_nilai', 'is_mapel', 'tbl_stored_name', 'has_descript'
	* ---------------------------------------------------------------------
	* 
	*/
	public array $fields = [
		'nm_komponen' 	  => ['label' => 'Nama Komponen Penilaian','width'=>25,'extra'=>['id' => 'nmgrup','class' => '', 'required' => true],
							  'type'=>'text'], 
		'jns_nilai'   	  => ['label' => 'Model Nilai','width'=>10,'extra'=>['id' => 'jNilai','class' => '', 'required' => true],'type'=>'dropdown',],
		'type_nilai'  	  => ['label' => 'Tipe Nilai','width'=>15,'extra'=>['id' => 'typN','class' => '', 'required' => true],'type'=>'dropdown',],
		'is_mapel'    	  => ['label' => 'Nilai Mapel?','width'=>5,'extra'=>['id' => 'isMP','class' => '', 'required' => true],'type'=>'dropdown',],
		'has_descript'    => ['label' => 'Berdeskripsi','width'=>5,'extra'=>['id' => 'hdesc','class' => '', 'required' => true],'type'=>'dropdown',],
		'no_urut' 	  	  => ['label' => 'No. Urut','width'=>0,'extra'=>['id' => 'nOrder','class' => '', 'required' => true],'type'=>'text',],  
		'bobot' 	  	  => ['label' => 'Bobot','width'=>5,'extra'=>['id' => 'nOrder','class' => '', 'required' => true, "min"=>0, "max"=>100],'type'=>'number',],  
		'akronim' 	  	  => ['label' => 'Alias','width'=>5,'extra'=>['id' => 'akro','class' => '', 'required' => true, 'maxlength'=>3],'type'=>'text',],  
	];

	public array $roles = [
		'nm_komponen'  	  => ['label' => 'Nama Komponen', 'rules' =>'required'],
		'jns_nilai'		  => ['label' => 'Model Nilai', 'rules' =>'required'],
		'no_urut'		  => ['label' => 'No. Urut', 'rules' =>'required'],
		'type_nilai' 	  => ['label' => 'Tipe Nilai', 'rules' =>'required'],
		'is_mapel' 		  => ['label' => 'Menjadi Nilai Mapel', 'rules' =>'required'],
		'has_descript' 	  => ['label' => 'Memiliki Deskripsi', 'rules' =>'required'],
		'bobot' 		  => ['label' => 'Bobot Nilai', 'rules' =>'required'],
		'akronim' 		  => ['label' => 'Alias', 'rules' =>'required|max_length[3]'],
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
		'edit' 		=> ['icon'=>'edit','src'=>'rating/edit/', 'label'=>'Detail', 'extra'=>''],
		'delete'	=> ['icon'=>'trash','src'=>'rating/hapus/', 'label'=>'Detail', 'extra'=>"onclick='confirmation(event)'"],
	];
	
	public string $arrDelimeter = '++VHV++';
}
