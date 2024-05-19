<?php

namespace Modules\Room\Config;

use CodeIgniter\Config\BaseConfig;

class RoomMember extends BaseConfig
{
    /**
	 * --------------------------------------------------------------------
	 * Libraries :`roomid`, `nama_rombel`, `walikelas`, `kode_ta`, `grade`
	 * --------------------------------------------------------------------
	 *
	 * @var array
	 */
	public $opsi = [
		'sumber' => [""=>'[--Pilih Sumber--]',"sb"=>"Siswa Baru","nk"=>'Naik Kelas'],
	];

    public array $tofunc = [
        'sb' => "newPartisipan",
        'nk' => 'prevGrade',
		'vr' => 'viewRombel'
    ];

	/**
	* ---------------------------------------------------------------------
	* FIELD NAME 
	* ---------------------------------------------------------------------
	* @var array
	* 
	*/
	public $fields = [
		'noinduk'		=> ['label' => 'No. Induk (NIPD)','width'=>12, 'extra'=>['id'=>'noktp','class' => '', 'required' => true],'type'=>'text'], 
		'nama'			=> ['label' => 'Nama Lengkap','width'=>25,'extra'=>['id'=>'namasiswa','class' => '', 'required' => true],'type'=>'text'], 
		'nisn'			=> ['label' => 'N.I.S.N','width'=>10,'extra'=>['id'=>'nisnx','class' => '', 'required' => true],'type'=>'text'], 
		'jk'			=> ['label' => 'Jenis Kelamin','width'=>8, 'extra'=>['id'=>'jks','class' => '', 'required' => true],'type'=>'dropdown'], 
	];
	
	public array $ResumeFields = [
		'nama_rombel'=> ['label' => 'Nama Rombel', 'perataan'=>'left'], 
		'curr_id'	 => ['label' => 'Kurikulum', 'perataan'=>'left'],
		'grade'		 => ['label' => 'Grade/Tingkat', 'perataan'=>'left'],
		'wali'	 	 => ['label' => 'Wali Kelas', 'perataan'=>'left'],  
		'learn_metode' => ['label' => 'Metode Belajar', 'perataan'=>'left'],  
	];

	public $Addfields = [
		'sumber'		=> ['label' => 'Sumber Data','extra'=>['id'=>'bsdrommb','class' => '', 'required' => true],'type'=>'dropdown'],  
	];

	public $srcFields = [
		'noinduk'		=> ['label' => 'No. Induk (NIPD)','width'=>10], 
		'nama'			=> ['label' => 'Nama Lengkap','width'=>50], 
		'jk'			=> ['label' => 'JK','width'=>5],
	];

	public $suportFields = [
		'room'		=> ['label' => 'Nama Rombel','extra'=>['id'=>'srcroom','class' => '', 'onchange'=>'getData(this.value)', 'required' => true],'type'=>'dropdown']
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
      //  'sumber'=> ['label' => 'Sumber', 'rules' =>'required'],
        'pd'  	=> ['label' => 'Peserta Didik', 'rules' =>'required'],
	];  
	
	public $roleEdit = [
		'nama_rombel'   => ['label' => 'Nama Rombel', 'rules' =>'required'],
        'walikelas'  	=> ['label' => 'Nama Wali Kelas', 'rules' =>'required'],
        'kode_ta'  		=> ['label' => 'Tahun Pelajaran', 'rules' =>'required'],
        'grade'  		=> ['label' => 'Grade/Tingkat', 'rules' =>'required'],
	];  
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
	public $importallowed = TRUE;
	
	/**
	* ---------------------------------------------------------------------
	* action boolean
	* ---------------------------------------------------------------------
	* 
	* @var array
	*/
	public $actions = [
		'mutasi'	=> ['icon'=>'exchange','src'=>'rombel/mutasi/', 'label'=>'Detail', 'extra'=>''],
		'delete'	=> ['icon'=>'trash','src'=>'rombel/rem/', 'label'=>'Detail', 'extra'=>"onclick='confirmation(event)'"],
	];

	public array $detAddOnACt = [
		'add' => ['icon'=>'plus-square','src'=>'rombel/pos/', 'label'=>'Tambah', 'btn_type'=>'success'],
	];
	
}