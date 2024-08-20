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
		'noinduk'		=> ['label' => 'No. Induk (NIPD)','width'=>12, 'extra'=>['id'=>'noktp', 'class' => '', 'required' => true],'type'=>'checkbox'], 
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
		'nipd'		=> ['label' => 'No. Induk (NIPD)','width'=>10,'extra'=>['id'=>'bsdrommb', 'name'=>'pd[]'], 'type'=>'checkbox'], 
		'noinduk'	=> ['label' => 'No. Induk (NIPD)','width'=>15, 'type'=>'display'], 
		'nama'		=> ['label' => 'Nama Lengkap','width'=>50, 'type'=>'display'], 
		'jk'		=> ['label' => 'JK','width'=>5,'type'=>'display'],
	];

	public $suportFields = [
		'room'		=> ['label' => 'Nama Rombel','extra'=>['id'=>'srcroom','class' => '', 'onchange'=>'getData(this.value)', 'required' => true],'type'=>'dropdown']
	];

	public $Mutasaifields = [
		'noinduk'	=> ['label' => 'No. Induk (NIPD)', 'extra'=>['id'=>'noktp','class' => '', 'disabled' => true],'type'=>'text'], 
		'nama'		=> ['label' => 'Nama Lengkap', 'extra'=>['id'=>'namasiswa','class' => '', 'disabled' => true],'type'=>'text'], 
		'nisn'		=> ['label' => 'N.I.S.N','extra'=>['id'=>'nisnx','class' => '', 'disabled' => true],'type'=>'text'], 
		'jk'		=> ['label' => 'Jenis Kelamin','extra'=>['id'=>'jks','class' => '', 'disabled' => true],'type'=>'dropdown'], 
		'nama_rombel'=> ['label' => 'Rombel Awal','extra'=>['id'=>'srcroom','class' => '', 'disabled' => true],'type'=>'text'], 
		'roomid'	=> ['label' => 'Rombel Tujuan','extra'=>['id'=>'dstroom','class' => '', 'required' => true],'type'=>'dropdown'], 
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
        'roomid'  		=> ['label' => 'Rombel Tujuan', 'rules' =>'required'],
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

	public $panelAct = [
		'add' => ['icon'=>'plus-square','src'=>'rombel/enroll/', 'label'=>'Enroll Siswa', 'btn_type'=>'success'],
	];

	public $addOnPanelAct = [
		1=>[
			'tuton' => ['icon'=>'file-code-o','src'=>'rombel/genakun/', 'label'=>'Generate Data Daring', 'extra'=>'', 'btn_type'=>'success'],
		],
		2=>[]
	];

	public $actions = [
		'mutasi'	=> ['icon'=>'exchange','src'=>'rombel/mutasi/', 'label'=>'Pindah Rombel', 'extra'=>''],
	];

	public array $detAddOnACt = [
		'delete'	=> ['icon'=>'remove','src'=>'rombel/del/', 'label'=>'Hapus Siswa', 'extra'=>"onclick='confirmation(event)'"],
	];
	
}