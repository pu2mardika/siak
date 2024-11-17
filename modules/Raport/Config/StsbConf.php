<?php

namespace Modules\Raport\Config;

use CodeIgniter\Config\BaseConfig;

class StsbConf extends BaseConfig
{
    public $opsi = [
		'grade' => [1=>"Dasar", "Lanjut", "Mahir"],
		'jenis' => [1 =>'Surat Tanda Selesai Belajar', 'Sertifikat Kompetensi', 'Sertifikat Keterampilan Kerja']
	];

	public function viewtmp($jenis):array
	{
		$view = [
			1=>['sttb_fs', 'sttb_bs'], 
			2=>['sert_fs', 'sert_bs'],
			3=>['skko_fs', 'skko_bs'],
		];
		return $view[$jenis];
	}

	public $dom = 'flrtip';

	/**
	* ---------------------------------------------------------------------
	* FIELD NAME : 'id', 'jenis', 'kode_ta', 'exam', 'issued', 'otorized_by'
	* ---------------------------------------------------------------------
	* @var array
	* 
	*/
	public $fields = [ 
		'id'   		 => ['label' => 'Kode','width'=>10, 'type'=>'date'], 
		'jenis'	 	 => ['label' => 'Kategori','width'=>25, 'type'=>'dropdown'],
		'issued'     => ['label' => 'Tgl Diterbitkan','width'=>15, 'type'=>'date'], 
		'exam'	     => ['label' => 'Tgl Ujian','width'=>15, 'type'=>'date'],
		'otorized_by'=> ['label' => 'Pengesahan','width'=>25, 'type'=>'text'], 
	];

	public $Addfields = [
		'jenis'	 	 => ['label' => 'Kategori ','extra'=>['id'=>'currID','class' => '', 'required' => true],'type'=>'dropdown'],  
		'exam'	     => ['label' => 'Tanggal Ujian','extra'=>['id'=>'idExam','class' => '', 'required' => true],'type'=>'date'],  
        'issued'	 => ['label' => 'Tanggal Penerbitan','extra'=>['id'=>'tglEx','class' => '', 'required' => true],'type'=>'date'],  
		'otorized_by'=> ['label' => 'Penandatangan','extra'=>['id'=>'otoriser','class' => '', 'required' => true],'type'=>'text'],  
	];

    public $fields2 = [
		'nama_rombel'=> ['label' => 'Nama Rombel','width'=>25,'type'=>'text'], 
		'grade'		 => ['label' => 'Jenjang','width'=>10,'type'=>'text'], 
		'walikelas'		 => ['label' => 'Wali Kelas','width'=>40, 'type'=>'dropdown'],  
	];
	
	public array $ResumeFields = [
		'kode'	 	 => ['label' => 'Nomor', 'perataan'=>'left'],   
		'issued'     => ['label' => 'Tanggal Penerbitan','perataan'=>'left'], 
		'jenis'	 	 => ['label' => 'Kategori','perataan'=>'left'],
		'exam'	     => ['label' => 'Tgl Ujian','perataan'=>'left'],
		'otorized_by'=> ['label' => 'Pengesahan','perataan'=>'left'], 
	];

	public $fields3 = [
		'id'		=> ['label' => 'No. Seri','width'=>12, 'extra'=>['id'=>'noktp', 'class' => '', 'required' => true],'type'=>'checkbox'], 
		'nama'		=> ['label' => 'Nama Lengkap','width'=>25,'extra'=>['id'=>'namasiswa','class' => '', 'required' => true],'type'=>'text'], 
		'noinduk'	=> ['label' => 'No. Induk (NIPD)','width'=>12, 'extra'=>['id'=>'noktp', 'class' => '', 'required' => true],'type'=>'text'],  
		'nm_prodi'		=> ['label' => 'Program','width'=>25, 'extra'=>['id'=>'jks','class' => '', 'required' => true],'type'=>'text'], 
	];

	public $fields4 = [
		'roomid'	=> ['label' => 'Rombel','width'=>12, 'extra'=>['id'=>'rombel', 'class' => '', 'required' => true],'type'=>'dropdown'], 
	];

	public $srcFields = [
		'memberId'		=> ['label' => 'ID','width'=>5,'extra'=>['id'=>'membID', 'name'=>'pd[]'], 'type'=>'checkbox'], 
		'noinduk'	    => ['label' => 'No. Induk','width'=>12, 'type'=>'display'], 
		'nama'		    => ['label' => 'Nama Lengkap','width'=>30, 'type'=>'display'], 
	//	'learn_metode'	=> ['label' => 'Metode Belajar','width'=>17, 'extra'=>['id'=>'lm', 'name'=>'lm[]'],'type'=>'dropdown'],
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
        'exam'	      => ['label' => 'Tanggal Ujian', 'rules' =>'required'],
        'jenis'  	  => ['label' => 'Kategori', 'rules' =>'required'],
        'issued'  	  => ['label' => 'Tanggal Penerbitan', 'rules' =>'required'],
        'otorized_by' => ['label' => 'Penandatangan', 'rules' =>'required'],
	];  

	public $ndroles = [
        'pd'  	=> ['label' => 'Peserta Didik', 'rules' =>'required'],
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
		'add' 	=> ['icon'=>'plus','src'=>'cert/add', 'label'=>'Tambah Data', 'extra'=>'', 'btn_type'=>'btn-success', 'param'=>['tp'=>'kode_ta'], 'method'=>'POST'],
	];

	public $actions = [
		'detail' => ['icon'=>'list-alt','src'=>'cert/shwdet?ids=', 'label'=>'Tampilkan Data', 'extra'=>'', 'btn_type'=>''],
		'edit' 	 => ['icon'=>'edit','src'=>'cert/edit/', 'label'=>'Edit Data', 'extra'=>'', 'btn_type'=>''],
		'delete' => ['icon'=>'remove','src'=>'cert/rem/', 'label'=>'Hapus Data', 'extra'=>"onclick='confirmation(event)'", 'btn_type'=>''],
	];

	public array $AddOnACt = [
		'show' => ['icon'=>'list-alt','src'=>'cert/shwpd?ids=', 'label'=>'Tampilkan Peserta Didik', 'extra'=>''],
	];

	public array $condAddOnACt = [
		1 => [
			'asesi'	=> ['icon'=>'remove','src'=>'cert/addasesi/', 'label'=>'Tambah Peserta', 'extra'=>""]
		],
		2 => [
			'rekap'	=> ['icon'=>'remove','src'=>'cert/rekap/', 'label'=>'Rekap Nilai', 'extra'=>""]
		]
	];

	public $condDetActions = [
		0 =>[
			'cetak' => ['icon'=>'file-pdf-o','src'=>'cert/vrept?ids=', 'label'=>'Tampilkan Raport', 'extra'=>'', 'btn_type'=>''],
		],
		1=>	[
			'cetak' => ['icon'=>'file-pdf-o','src'=>'cert/vrept?', 'label'=>'Tampilkan Raport', 'extra'=>'', 'btn_type'=>''],
			'proj'  => ['icon'=>'file-excel-o','src'=>'cert/project?', 'label'=>'Rapor Projek', 'extra'=>'', 'btn_type'=>'']
		]
	];

	public array $dtfilter = [
		'source'=>'TaPel',
		'action'=>'rapor?tp=',
		'cVal'	=>'',
		'title'	=>'Ganti Tahun Pelajaran'
	];

	public string $addonJS = 'function getData(val){
		window.location.replace(base_url+"enroll?idx="+val);
	}';
	
	public string $arrDelimeter = '++VHV++';
}
