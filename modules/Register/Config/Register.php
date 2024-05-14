<?php

namespace Modules\Register\Config;

use CodeIgniter\Config\BaseConfig;

class Register extends BaseConfig
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
		'id_prodi'		=> ['label' => 'Program Pilihan','width'=>0,'extra'=>['id'=>'prodi','class' => '', 'required' => true],'type'=>'dropdown', ],
		'nik'			=> ['label' => 'NIK','width'=>12, 'extra'=>['id'=>'noktp','class' => '', 'onchange'=>'getData(this.value)','required' => true, 'minlength'=>16, 'maxlength'=>16],'type'=>'text'],  
		'nama'			=> ['label' => 'Nama Lengkap','width'=>15,'extra'=>['id'=>'name','class' => '', 'required' => true],'type'=>'text'], 
		'nisn'			=> ['label' => 'NISN','width'=>0,'extra'=>['id'=>'nis','class' => '', 'required' => true],'type'=>'text'], 
		'tempatlahir'	=> ['label' => 'Tempat Lahir','width'=>0,'extra'=>['id'=>'tplhr','class' => '', 'required' => true],'type'=>'text'], 
		'tgllahir'		=> ['label' => 'Tanggal Lahir','width'=>0,'extra'=>['id'=>'tglh','class' => '', 'required' => true],'type'=>'date'], 
		'jk'			=> ['label' => 'Jenis Kelamin','width'=>0, 'extra'=>['id'=>'sex','class' => '', 'required' => true],'type'=>'dropdown'], 
		'alamat'		=> ['label' => 'ALamat','width'=>0,'extra'=>['id'=>'addr','class' => '', 'style' => 'height: 100px','required' => true],'type'=>'textarea'], 
		'nohp'			=> ['label' => 'No. HP','width'=>10, 'extra'=>['id'=>'phone','class' => '', 'required' => true, 'minlength'=>10, 'maxlength'=>12],'type'=>'tel'], 
		'nama_ayah'		=> ['label' => 'Nama Ayah','width'=>12, 'extra'=>['id'=>'father','class' => '', 'required' => true],'type'=>'text'], 
		'nama_ibu'		=> ['label' => 'Nama Ibu','width'=>0, 'extra'=>['id'=>'mother','class' => '', 'required' => true],'type'=>'text'], 
		'alamat_ortu'	=> ['label' => 'Alamat Orang Tua','width'=>0, 'extra'=>['id'=>'perentadd','class' => '', 'required' => true],'type'=>'text'], 
		'nohp_ayah'		=> ['label' => 'No. HP Ayah','width'=>8, 'extra'=>['id'=>'phfth','class' => '', 'required' => true, 'minlength'=>10, 'maxlength'=>12],'type'=>'tel'], 
		'nohp_ibu'		=> ['label' => 'No. HP Ibu','width'=>0, 'extra'=>['id'=>'phmth','class' => '', 'required' => true, 'minlength'=>10, 'maxlength'=>12],'type'=>'tel'],
		'sumber_info'	=> ['label' => 'Sumber Informasi','width'=>0, 'extra'=>['id'=>'sinfo','class' => '', 'required' => true],'type'=>'dropdown'],
	];

	public $printfield = [
		'nik'			=> ['label' => 'NIK','type'=>'text'], 
		'nama'			=> ['label' => 'Nama Lengkap','type'=>'text'],  
	//	'tempatlahir'	=> ['label' => 'Tempat Lahir','type'=>'text'], 
		'tgllahir'		=> ['label' => 'Tempat, Tgl Lahir','type'=>'text'], 
		'jk'			=> ['label' => 'Jenis Kelamin','type'=>'dropdown'], 
		'alamat'		=> ['label' => 'ALamat','type'=>'text'],		
		'nohp'			=> ['label' => 'No. HP','type'=>'text'],  
		'id_prodi'		=> ['label' => 'Program Pilihan','type'=>'dropdown'], 
		'created_at' 	=> ['label' => 'Tgl. Register','type'=>'date', ],
	];

	public $validasi_fields = [
		'id_prodi'		=> ['label' => 'Program Pilihan','width'=>0,'extra'=>['id'=>'prodi','class' => '', 'disabled'],'type'=>'dropdown', ],
		'nik'			=> ['label' => 'NIK','width'=>12, 'extra'=>['id'=>'noktp','class' => '', 'disabled'],'type'=>'text'],  
		'nama'			=> ['label' => 'Nama Lenextragkap','width'=>15,'extra'=>['id'=>'name','class' => '', 'disabled'],'type'=>'text'], 
		'nisn'			=> ['label' => 'NISN','width'=>0,'extra'=>['id'=>'nis','class' => '', 'disabled'],'type'=>'text'], 
		'tempatlahir'	=> ['label' => 'Tempat Lahir','width'=>0,'extra'=>['id'=>'tmplhr','class' => '', 'disabled'],'type'=>'text'], 
		'tgllahir'		=> ['label' => 'Tanggal Lahir','width'=>0,'extra'=>['id'=>'tgllhr','class' => '', 'disabled'],'type'=>'date'], 
		'jk'			=> ['label' => 'Jenis Kelamin','width'=>0, 'extra'=>['id'=>'sex','class' => '', 'disabled'],'type'=>'dropdown'], 
		'alamat'		=> ['label' => 'ALamat','width'=>0,'extra'=>['id'=>'addrs','class' => '', 'style' => 'height: 100px', 'disabled'],'type'=>'textarea'], 
		'nohp'			=> ['label' => 'No. HP','width'=>10, 'extra'=>['id'=>'phone','class' => '', 'disabled'],'type'=>'tel'], 
		'nama_ayah'		=> ['label' => 'Nama Ayah','width'=>12, 'extra'=>['id'=>'father','class' => '', 'disabled'],'type'=>'text'], 
		'nama_ibu'		=> ['label' => 'Nama Ibu','width'=>0, 'extra'=>['id'=>'mother','class' => '', 'disabled'],'type'=>'text'], 
		'alamat_ortu'	=> ['label' => 'Alamat Orang Tua','width'=>0, ''=>['id'=>'prntaddrs','class' => '', 'disabled'],'type'=>'text'], 
		'nohp_ayah'		=> ['label' => 'No. HP Ayah','width'=>8, 'extra'=>['id'=>'phfth','class' => '', 'disabled'],'type'=>'tel'], 
		'nohp_ibu'		=> ['label' => 'No. HP Ibu','width'=>0, 'extra'=>['id'=>'phmth','class' => '', 'disabled'],'type'=>'tel'],
		'sumber_info'	=> ['label' => 'Sumber Informasi','width'=>0, 'extra'=>['id'=>'sinfo','class' => '', 'disabled'],'type'=>'dropdown'],
		'status'		=> ['label' => 'Approval','width'=>0, 'extra'=>['id'=>'state','class' => '', 'required' => true],'type'=>'dropdown'],
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
		'nik' 	=> "required|is_unique[tbl_register.nik,nik]|is_unique[tbl_datadik.nik,nik]|max_length[16]|min_length[16]",
		'nama'  => 'required',
		'nohp'  => 'required|max_length[12]|min_length[10]',
	]; 

	public $roleEdit = [
		'nik' 	=> "required|max_length[16]|min_length[16]",
		'nama'  => 'required',
		'nohp'  => 'required|max_length[12]|min_length[10]',
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
		'konfirm' 	=> ['icon'=>'th-list','src'=>'siswa/validasi?idx=', 'label'=>'Detail', 'extra'=>''],
		'edit' 		=> ['icon'=>'edit','src'=>'enrollment/edit/', 'label'=>'Detail', 'extra'=>''],
		'delete'	=> ['icon'=>'trash','src'=>'enrollment/hapus/', 'label'=>'Detail', 'extra'=>"onclick='confirmation(event)'"],
	];

	public string $addonJS = 'function getData(val){
		window.location.replace(base_url+"enroll?idx="+val);
	}';
}
