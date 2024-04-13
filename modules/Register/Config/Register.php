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
		'id_prodi' => [],
		'sumber_info' => ['teman' =>'Teman', 'family' => 'Keluarga', 
				'web' => 'Website', 'se' => 'Google Search', 
				'fb' => 'facebook', 'ig' => 'Instagram',
				'wag' => 'Whathaspp', 'twiter' => 'Twitter',
				'iklan'=>'Iklan Radio', 'other' => 'Lain-lain',
			],
		'status' => [1 => 'approved', 2 => 'rejected',],
	];

	/**
	* ---------------------------------------------------------------------
	* FIELD NAME 
	* ---------------------------------------------------------------------
	* @var array
	* 
	*/
	public $fields = [
		'id_prodi'		=> ['label' => 'Program Pilihan','width'=>0,'extra'=>['class' => '', 'required' => true],'type'=>'dropdown', ],
		'nik'			=> ['label' => 'NIK','width'=>12, 'extra'=>['class' => '', 'required' => true],'type'=>'text'],  
		'nama'			=> ['label' => 'Nama Lengkap','width'=>15,'extra'=>['class' => '', 'required' => true],'type'=>'text'], 
		'nisn'			=> ['label' => 'NISN','width'=>0,'extra'=>['class' => '', 'required' => true],'type'=>'text'], 
		'tempatlahir'	=> ['label' => 'Tempat Lahir','width'=>0,'extra'=>['class' => '', 'required' => true],'type'=>'text'], 
		'tgllahir'		=> ['label' => 'Tanggal Lahir','width'=>0,'extra'=>['class' => '', 'required' => true],'type'=>'date'], 
		'jk'			=> ['label' => 'Jenis Kelamin','width'=>0, 'extra'=>['class' => '', 'required' => true],'type'=>'dropdown'], 
		'alamat'		=> ['label' => 'ALamat','width'=>0,'extra'=>['class' => '', 'style' => 'height: 100px','required' => true],'type'=>'textarea'], 
		'nohp'			=> ['label' => 'No. HP','width'=>10, 'extra'=>['class' => '', 'required' => true],'type'=>'tel'], 
		'nama_ayah'		=> ['label' => 'Nama Ayah','width'=>12, 'extra'=>['class' => '', 'required' => true],'type'=>'text'], 
		'nama_ibu'		=> ['label' => 'Nama Ibu','width'=>0, 'extra'=>['class' => '', 'required' => true],'type'=>'text'], 
		'alamat_ortu'	=> ['label' => 'Alamat Orang Tua','width'=>0, 'extra'=>['class' => '', 'required' => true],'type'=>'text'], 
		'nohp_ayah'		=> ['label' => 'No. HP Ayah','width'=>8, 'extra'=>['class' => '', 'required' => true],'type'=>'tel'], 
		'nohp_ibu'		=> ['label' => 'No. HP Ibu','width'=>0, 'extra'=>['class' => '', 'required' => true],'type'=>'tel'],
		'sumber_info'	=> ['label' => 'Sumber Informasi','width'=>0, 'extra'=>['class' => '', 'required' => true],'type'=>'dropdown'],
	];

	public $printfield = [
		'nik'			=> ['label' => 'NIK','type'=>'text'], 
		'nama'			=> ['label' => 'Nama Lengkap','type'=>'text'],  
	//	'tempatlahir'	=> ['label' => 'Tempat Lahir','type'=>'text'], 
		'tgllahir'		=> ['label' => 'Tempat, Tgl Lahir','type'=>'text'], 
		'jk'			=> ['label' => 'Jenis Kelamin','type'=>'dropdown'], 
		'alamat'		=> ['label' => 'ALamat','type'=>'text'],
		'nohp'			=> ['label' => 'No. HP','type'=>'text'],  
		'created_at' 	=> ['label' => 'Tgl. Register','type'=>'date', ],
	];

	public $validasi_fields = [
		'id_prodi'		=> ['label' => 'Program Pilihan','width'=>0,'extra'=>['class' => '', 'disabled'],'type'=>'dropdown', ],
		'nik'			=> ['label' => 'NIK','width'=>12, 'extra'=>['class' => '', 'disabled'],'type'=>'text'],  
		'nama'			=> ['label' => 'Nama Lengkap','width'=>15,'extra'=>['class' => '', 'disabled'],'type'=>'text'], 
		'nisn'			=> ['label' => 'NISN','width'=>0,'extra'=>['class' => '', 'disabled'],'type'=>'text'], 
		'tempatlahir'	=> ['label' => 'Tempat Lahir','width'=>0,'extra'=>['class' => '', 'disabled'],'type'=>'text'], 
		'tgllahir'		=> ['label' => 'Tanggal Lahir','width'=>0,'extra'=>['class' => '', 'disabled'],'type'=>'date'], 
		'jk'			=> ['label' => 'Jenis Kelamin','width'=>0, 'extra'=>['class' => '', 'disabled'],'type'=>'dropdown'], 
		'alamat'		=> ['label' => 'ALamat','width'=>0,'extra'=>['class' => '', 'style' => 'height: 100px', 'disabled'],'type'=>'textarea'], 
		'nohp'			=> ['label' => 'No. HP','width'=>10, 'extra'=>['class' => '', 'disabled'],'type'=>'tel'], 
		'nama_ayah'		=> ['label' => 'Nama Ayah','width'=>12, 'extra'=>['class' => '', 'disabled'],'type'=>'text'], 
		'nama_ibu'		=> ['label' => 'Nama Ibu','width'=>0, 'extra'=>['class' => '', 'disabled'],'type'=>'text'], 
		'alamat_ortu'	=> ['label' => 'Alamat Orang Tua','width'=>0, 'extra'=>['class' => '', 'disabled'],'type'=>'text'], 
		'nohp_ayah'		=> ['label' => 'No. HP Ayah','width'=>8, 'extra'=>['class' => '', 'disabled'],'type'=>'tel'], 
		'nohp_ibu'		=> ['label' => 'No. HP Ibu','width'=>0, 'extra'=>['class' => '', 'disabled'],'type'=>'tel'],
		'sumber_info'	=> ['label' => 'Sumber Informasi','width'=>0, 'extra'=>['class' => '', 'disabled'],'type'=>'dropdown'],
		'status'		=> ['label' => 'Approval','width'=>0, 'extra'=>['class' => '', 'required' => true],'type'=>'dropdown'],
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
			'nik' => "required|is_unique[tbl_siswa.nik,nik]",
            'nama'  => 'required',
		]; 
	
	public $roleEdit = [
			'nik' => "required",
            'nama'  => 'required',
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
	public $importallowed = false;
	
	/**
	* ---------------------------------------------------------------------
	* action boolean
	* ---------------------------------------------------------------------
	* 
	* @var array
	*/
	public $actions = [
		'detail'	=> true,
		'edit'		=> true,
		'delete'	=> true,
	];
	//public $actiondetail = true; 
	//public $actionedit   = true; 
	//public $actiondelete = true; 
		
}
