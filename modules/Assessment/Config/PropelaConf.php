<?php

namespace Modules\Assessment\Config;

use CodeIgniter\Config\BaseConfig;

class PropelaConf extends BaseConfig
{
    public $opsi = [
		'subgrade' 	  => [""=>'[--Pilih--]',1 =>"Semester I / Ganjil", 2 =>'Semester II/Genap'],
		'nilai_huruf' => [0=>"E", "D", "C", "B", "A"],
		'nilai_sikap' => [
			"E" => "E = Belum Berkembang/Perlu Pembinaan", 
			"D" => "D = Mulai Berkembang", 
			"C" => "C = Sedang Berkembang", 
			"B" => "B = Berkembang Sesuai Harapan", 
			"A" => "A = Sangat Berkembang"
		],
		'descNilai' => [
			0 => "E = Belum Berkembang/Perlu Pembinaan", 
			1 => "D = Mulai Berkembang", 
			2 => "C = Sedang Berkembang", 
			3 => "B = Berkembang Sesuai Harapan", 
			4 => "A = Sangat Berkembang"
		],
		'reserv_nilai' => ["A"=>4, "B"=>3, "C"=>2, "D"=>1, "E"=>0]
	];

	public $dom = 'flrtip';

	/**
	* ---------------------------------------------------------------------
	* FIELD NAME `member_id`, `subgrade`, `rating_id`, `idx`, `nilai
	* ---------------------------------------------------------------------
	* @var array
	* 
	*/
	public $fields = [
		'deskripsi'	=> ['label' => 'Deskripsi Projek','width'=>25, 'type'=>'text'], 
		'elemen'	=> ['label' => 'Elemen','width'=>55, 'type'=>'text'], 
	];

	public array $ResumeFields = [
		'nama_rombel'=> ['label' => 'Nama Rombel','perataan'=>'left'], 
		'grade'	 	 => ['label' => 'Grade','perataan'=>'left'], 
	//	'nama_project' => ['label' => 'Nama Project','perataan'=>'left'], 
		'deskripsi' => ['label' => 'Deskripsi','perataan'=>'left'], 
		'wali'		 => ['label' => 'Nama Wali','perataan'=>'left'], 
	];

	public $Addfields = [
		'TaPel'		=> ['label' => 'Tahun Pelajaran','extra'=>['id'=>'dttapel','class' => '', 'required' => true],'type'=>'dropdown'],  
		'rombel'	=> ['label' => 'Rombel','extra'=>['id'=>'bsroom','class' => '', 'required' => true],'type'=>'dropdown'],  
		'subgrade'	=> ['label' => 'Semester','extra'=>['id'=>'sgrade','class' => '', 'required' => true],'type'=>'dropdown'],  
	];

	public $markFields = [
		'noinduk'	=> ['label' => 'No Induk', 'width'=>15, 'extra'=>['id'=>'idmapel','class' => ''],'type'=>'hidden'], 
		'nama'		=> ['label' => 'Nama PD','width'=>25,'extra'=>['id'=>'namasiswa','class' => '', 'required' => true],'type'=>'disp'], 
		'nisn'		=> ['label' => 'NISN','width'=>10,'extra'=>['id'=>'nisnx','class' => '', 'required' => true],'type'=>'disp'], 
		'nilai'		=> ['label' => 'Nilai','width'=>30,'extra'=>['id'=>'nisnx','class' => '', 'required' => true],'type'=>'disp'], 
	];

	public string $addMark = "XCP20";
	public string $addMarkDsc = "Catatan Proses";
	public $addMarkDesk = [
		"XSP"=>["desc"=>"Catatan Proses", "resv"=>"CP"]
	];

	/**
	* ---------------------------------------------------------------------
	* ROLE DATA
	* ---------------------------------------------------------------------
	* 
	* @var 
	* 
	*/
	public $roles = [
        'ptk'	=> ['label' => 'Pendidik', 'rules' =>'required'],
        'kkm'  	=> ['label' => 'KKM/KKTP', 'rules' =>'required'],
	];  
	
	public $roleEdit = [];  
	/**
	 * --------------------------------------------------------------------
	 * Layout for the views to extend
	 * --------------------------------------------------------------------
	 *
	 * @var string
	 */
	public $primarykey = 'id';
	
	
	/**
	* ---------------------------------------------------------------------
	* Export and Import data allowed
	* ---------------------------------------------------------------------
	* 
	* @var boelean
	*/
	public $importallowed = false;
	
	/**
	* ---------------------------------------------------------------------
	* action boolean
	* ---------------------------------------------------------------------
	* 
	* @var array
	*/
	public $addAllowed = FALSE;
	
	public $panelAct = [
		'detail' 	=> ['icon'=>'list-alt','src'=>'nilai/detail?ids=', 'label'=>'Detail', 'extra'=>'', 'btn_type'=>''],
	];

	public $actions = [];

	public array $AddOnACt = [
		'import' => ['icon'=>'file-excel-o','src'=>'nilai/import/', 'label'=>'Upload Nilai', 'btn_type'=>'success'],
	];

	public array $detAddOnACt = [
		'add'	=> ['icon'=>'list-alt','src'=>'propela/show?ids=', 'label'=>'Detail', 'extra'=>""],
	];

	public $condActions = [
		0 =>[
			'import' => ['icon'=>'file-excel-o','src'=>'propela/import?ids=', 'label'=>'Upload Nilai', 'extra'=>'', 'btn_type'=>''],
		],
		1=>	[
			'reset'	 => ['icon'=>'rotate-right','src'=>'propela/reset?ids=', 'label'=>'Reset Nilai', 'extra'=>"onclick='confirmation(event)'", 'btn_type'=>''],
			'update' => ['icon'=>'file-excel-o','src'=>'propela/update?ids=', 'label'=>'Update Nilai', 'extra'=>'', 'btn_type'=>'']
		]
	];

	public array $dtfilter = [
		'source'=>'TaPel',
		'action'=>'nilai?tp=',
		'cVal'	=>'',
		'title'	=>'Ganti Tahun Pelajaran'
	];

	public array $footNav = [
		'nav' => 'n'
	];

	public string $arrDelimeter = '++VHV++';
}
