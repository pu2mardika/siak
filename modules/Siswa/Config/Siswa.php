<?php namespace Modules\Siswa\Config;

use CodeIgniter\Config\BaseConfig;

class Siswa extends BaseConfig
{
	/**
	 * --------------------------------------------------------------------
	 * Libraries
	 * --------------------------------------------------------------------
	 *
	 * @var array
	 */
	public $opsi = [
		'jk' => ['L' => 'Laki-Laki', 'P' => 'Perempuan',],
	];

	/**
	* ---------------------------------------------------------------------
	* FIELD NAME 
	* ---------------------------------------------------------------------
	* @var array
	* 
	*/
	public $fields = [
	//	'noinduk'		=> ['label' => 'NIPD','width'=>8, 'extra'=>['id'=>'noktp','class' => '', 'required' => true],'type'=>'text'], 
		'idreg'			=> ['label' => 'No. Register','width'=>0,'extra'=>['id'=>'regid','class' => '', 'required' => true],'type'=>'text', ], 
		'nama'			=> ['label' => 'Nama Lengkap','width'=>15,'extra'=>['id'=>'namasiswa','class' => '', 'required' => true],'type'=>'text'], 
		'nik'			=> ['label' => 'NIK','width'=>12, 'extra'=>['id'=>'noktp','class' => '', 'required' => true],'type'=>'text'], 
		'nisn'			=> ['label' => 'NISN','width'=>0,'extra'=>['id'=>'nisnx','class' => '', 'required' => true],'type'=>'text'], 
	//	'tempatlahir'	=> ['label' => 'Tempat Lahir','width'=>0,'extra'=>['id'=>'tmptlhr','class' => '', 'required' => true],'type'=>'text'], 
		'tgllahir'		=> ['label' => 'Tempat, Tgl Lahir','width'=>0,'extra'=>['id'=>'tgllhr','class' => '', 'required' => true],'type'=>'date'], 
		'jk'			=> ['label' => 'Jenis Kelamin','width'=>0, 'extra'=>['id'=>'jks','class' => '', 'required' => true],'type'=>'dropdown'], 
		'alamat'		=> ['label' => 'ALamat','width'=>0,'extra'=>['id'=>'adrs','class' => '', 'style' => 'height: 100px','required' => true],'type'=>'textarea'], 
		'nohp'			=> ['label' => 'No. HP','width'=>8, 'extra'=>['id'=>'noph','class' => '', 'required' => true],'type'=>'tel'], 
		'nama_ayah'		=> ['label' => 'Nama Ayah','width'=>0, 'extra'=>['id'=>'nm','class' => '', 'required' => true],'type'=>'text'], 
		'nama_ibu'		=> ['label' => 'Nama Ibu','width'=>0, 'extra'=>['id'=>'nmibu','class' => '', 'required' => true],'type'=>'text'], 
		'alamat_ortu'	=> ['label' => 'Alamat Orang Tua','width'=>0, 'extra'=>['id'=>'addrortu','class' => '', 'required' => true],'type'=>'text'], 
		'nohp_ayah'		=> ['label' => 'No. HP Ayah','width'=>0, 'extra'=>['id'=>'hpayh','class' => '', 'required' => true],'type'=>'tel'], 
		'nohp_ibu'		=> ['label' => 'No. HP Ibu','width'=>0, 'extra'=>['id'=>'hpibu','class' => '', 'required' => true],'type'=>'tel'],
		'nm_prodi'		=> ['label' => 'Program Studi','width'=>15, 'extra'=>['id'=>'hpibu','class' => '', 'required' => true],'type'=>'tel'],
		'no_ijazah'	=> ['label' => 'No. Ijazah','width'=>15, 'extra'=>['id'=>'tglReg','class' => '',],'type'=>'text'],
		'tgl_ijazah'=> ['label' => 'Tgl. Ijazah','width'=>15, 'extra'=>['id'=>'tglReg','class' => '',],'type'=>'date'],
		'tgl_diterima'	=> ['label' => 'Tgl Mulai Belajar','width'=>15, 'extra'=>['id'=>'tglReg','class' => '', 'required' => true],'type'=>'date'],
		'state'			=> ['label' => 'State','width'=>0, 'extra'=>['id'=>'hpibu','class' => '', 'required' => true],'type'=>'tel'],
	];

	public array $addFields = [
		'noktp'		=> ['label' => 'NIK','width'=>12, 'extra'=>['id'=>'srchsiswa','class' => '', 'required' => true],'type'=>'search'], 
		'prodi'		=> ['label' => 'Program Studi','width'=>15, 'extra'=>['id'=>'ps	','class' => '', 'required' => true],'type'=>'dropdown'],
		'no_ijazah'	=> ['label' => 'No. Ijazah Terakhir','width'=>15, 'extra'=>['id'=>'tglReg','class' => ''],'type'=>'text'],
		'tgl_ijazah'=> ['label' => 'Tgl. Ijazah Terakhir','width'=>15, 'extra'=>['id'=>'tglReg','class' => ''],'type'=>'date'],
		'tgl_diterima'	=> ['label' => 'Tgl Mulai Belajar','width'=>15, 'extra'=>['id'=>'tglReg','class' => '', 'required' => true],'type'=>'date'],
		'tgl_reg'	=> ['label' => 'Tanggal','width'=>15, 'extra'=>['id'=>'tglReg','class' => '', 'required' => true],'type'=>'date'],
		'nik'	 	=> ['label' => '','width'=>0,'extra'=>['id' => 'noktp','class' => '', 'required' => true],'type'=>'hidden'],
	];

	public array $addOnFields = [
		'idreg'		=> ['label' => 'No. Register','width'=>0,'extra'=>['id'=>'regid','class' => '', 'disabled' =>true],'type'=>'text', ],
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
            'prodi'  => 'required',
		]; 
	
	public $roleEdit = [
            'prodi'  => 'required',
		]; 
	/**
	 * --------------------------------------------------------------------
	 * Layout for the views to extend
	 * --------------------------------------------------------------------
	 *
	 * @var string
	 */
	public $primarykey = 'noinduk';
	
	
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
		'detail' 	=> ['icon'=>'list-alt','src'=>'siswa/detail/', 'label'=>'Detail', 'extra'=>''],
		'edit' 		=> ['icon'=>'edit','src'=>'siswa/edit/', 'label'=>'Detail', 'extra'=>''],
		'delete'	=> ['icon'=>'trash','src'=>'siswa/hapus/', 'label'=>'Detail', 'extra'=>"onclick='confirmation(event)'"],
	];
	
	public array $condActDet = [
		0 => [
				'detail'=> ['icon'=>'list-alt','src'=>'siswa/detail/', 'label'=>'Detail', 'attr'=>''],
				'cetak' => ['icon'=>'print','src'=>'siswa/ctkreg/', 'label'=>'Cetak', 'attr'=>''],
				'del'	=> ['icon'=>'trash','src'=>'siswa/hapus/', 'label'=>'Hapus', 'attr'=>'onclick="confirmation(event)"'],
			],
		1=> [
				'det'	=> ['icon'=>'funnel-dollar','src'=>'siswa/detail/', 'label'=>'Manage', 'attr'=>''],
				'cetak' => ['icon'=>'print','src'=>'siswa/ctkreg/', 'label'=>'Cetak', 'attr'=>''],
			],
	];
	
	public array $dtfilter = [
		'source'=>'ps',
		'action'=>'siswa?ps=',
		'cVal'	=>'',
		'title'	=>'Ganti Program Studi'
	];
}
