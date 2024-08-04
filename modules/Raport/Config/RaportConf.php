<?php

namespace Modules\Raport\Config;

use CodeIgniter\Config\BaseConfig;

class RaportConf extends BaseConfig
{
    public $opsi = [
		'subgrade' => [""=>'[--Pilih--]',1 =>"Semester I / Ganjil", 2 =>'Semester II/Genap'],
	];

	public $dom = 'flrtip';

	/**
	* ---------------------------------------------------------------------
	* FIELD NAME : 'id', 'curr_id', 'kode_ta', 'subgrade', 'issued', 'otorized_by'
	* ---------------------------------------------------------------------
	* @var array
	* 
	*/
	public $fields = [
		'subgrade'	=> ['label' => 'Subgrade','width'=>10, 'type'=>'dropdown'], 
		'curr_name'	=> ['label' => 'Kurikulum','width'=>25, 'type'=>'text'], 
		'issued'    => ['label' => 'Tanggal','width'=>15, 'type'=>'text'], 
		'otorized_by'=> ['label' => 'Pengesahan','width'=>30, 'type'=>'text'], 
	];

	public $Addfields = [
		'subgrade'	 => ['label' => 'Sub Grade','extra'=>['id'=>'sgrade','class' => '', 'required' => true],'type'=>'dropdown'],  
		'curr_id'	 => ['label' => 'Kurikulum','extra'=>['id'=>'currID','class' => '', 'required' => true],'type'=>'dropdown'],  
		'issued'	 => ['label' => 'Tanggal Penerbitan','extra'=>['id'=>'tglEx','class' => '', 'required' => true],'type'=>'date'],  
		'otorized_by'=> ['label' => 'Penandatangan','extra'=>['id'=>'otoriser','class' => '', 'required' => true],'type'=>'text'],  
	];

    public $fields2 = [
		'nama_rombel'=> ['label' => 'Nama Rombel','width'=>25,'type'=>'text'], 
		'grade'		 => ['label' => 'Jenjang','width'=>10,'type'=>'text'], 
		'walikelas'		 => ['label' => 'Wali Kelas','width'=>40, 'type'=>'dropdown'],  
	];
	
	public array $ResumeFields = [
		'nama_rombel'=> ['label' => 'Nama Rombel', 'perataan'=>'left'], 
		'curr_id'	 => ['label' => 'Kurikulum', 'perataan'=>'left'],
		'grade'		 => ['label' => 'Grade/Tingkat', 'perataan'=>'left'],
		'subgrade'	 => ['label' => 'Subgrade/Semester', 'perataan'=>'left'],
		'wali'	 	 => ['label' => 'Wali Kelas', 'perataan'=>'left'],  
	//	'learn_metode' => ['label' => 'Metode Belajar', 'perataan'=>'left'],  
	];

	public $fields3 = [
		'noinduk'	=> ['label' => 'No. Induk (NIPD)','width'=>12, 'extra'=>['id'=>'noktp', 'class' => '', 'required' => true],'type'=>'checkbox'], 
		'nama'		=> ['label' => 'Nama Lengkap','width'=>25,'extra'=>['id'=>'namasiswa','class' => '', 'required' => true],'type'=>'text'], 
		'nisn'		=> ['label' => 'N.I.S.N','width'=>10,'extra'=>['id'=>'nisnx','class' => '', 'required' => true],'type'=>'text'], 
		'jk'		=> ['label' => 'Jenis Kelamin','width'=>8, 'extra'=>['id'=>'jks','class' => '', 'required' => true],'type'=>'dropdown'], 
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
        'subgrade'	  => ['label' => 'Subgrade', 'rules' =>'required'],
        'curr_id'  	  => ['label' => 'Kurikulum', 'rules' =>'required'],
        'issued'  	  => ['label' => 'Tanggal Penerbitan', 'rules' =>'required'],
        'otorized_by' => ['label' => 'Penandatangan', 'rules' =>'required'],
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
	public $addAllowed = TRUE;
	
	public $panelAct = [
		'add' 	=> ['icon'=>'plus','src'=>'rapor/add', 'label'=>'Tambah Data', 'extra'=>'', 'btn_type'=>'btn-success', 'param'=>['tp'=>'kode_ta'], 'method'=>'POST'],
	];

	public $actions = [
		'room' 	 => ['icon'=>'list-alt','src'=>'rapor/showroom/', 'label'=>'Tampilkan Data', 'extra'=>'', 'btn_type'=>''],
		'edit' 	 => ['icon'=>'edit','src'=>'rapor/edit/', 'label'=>'Edit Data', 'extra'=>'', 'btn_type'=>''],
		'delete' => ['icon'=>'remove','src'=>'rapor/rem/', 'label'=>'Hapus Data', 'extra'=>"onclick='confirmation(event)'", 'btn_type'=>''],
	];

	public array $AddOnACt = [
		'show' => ['icon'=>'list-alt','src'=>'rapor/shwpd?ids=', 'label'=>'Tampilkan Peserta Didik', 'extra'=>''],
	];

	public array $AddOnAct2 = [
		'cover' => ['icon'=>'list-alt','src'=>'rapor/vcover?ids=', 'label'=>'Cetak Sampul', 'extra'=>'', 'btn_type'=>'btn-success'],
	];

	public array $condAddOnACt = [
		1 => [
			'rekap'	=> ['icon'=>'remove','src'=>'rapor/rekap/', 'label'=>'Rekap Nilai', 'extra'=>""]
		]
	];

	public $condDetActions = [
		0 =>[
			'cetak' => ['icon'=>'file-pdf-o','src'=>'rapor/vrept?', 'label'=>'Tampilkan Raport', 'extra'=>'', 'btn_type'=>''],
		],
		1=>	[
			'cetak' => ['icon'=>'file-pdf-o','src'=>'rapor/vrept?', 'label'=>'Tampilkan Raport', 'extra'=>'', 'btn_type'=>''],
			'proj'  => ['icon'=>'file-excel-o','src'=>'rapor/project?', 'label'=>'Rapor Projek', 'extra'=>'', 'btn_type'=>'']
		]
	];

	public array $dtfilter = [
		'source'=>'TaPel',
		'action'=>'rapor?tp=',
		'cVal'	=>'',
		'title'	=>'Ganti Tahun Pelajaran'
	];

	public string $arrDelimeter = '++VHV++';
}
