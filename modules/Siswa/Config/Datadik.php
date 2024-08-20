<?php

namespace Modules\Siswa\Config;

use CodeIgniter\Config\BaseConfig;

class Datadik extends BaseConfig
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
		'nik'			=> ['label' => 'NIK','width'=>12, 'extra'=>['id'=>'noktp','class' => '', 'required' => true],'type'=>'text'], 
		'idreg'			=> ['label' => 'No. Register','width'=>0,'extra'=>['id'=>'regid','class' => '', 'required' => true],'type'=>'text', ], 
		'nama'			=> ['label' => 'Nama Lengkap','width'=>15,'extra'=>['id'=>'namasiswa','class' => '', 'required' => true],'type'=>'text'], 
		'nisn'			=> ['label' => 'NISN','width'=>0,'extra'=>['id'=>'nisnx','class' => '', 'required' => true],'type'=>'text'], 
		'tempatlahir'	=> ['label' => 'Tempat Lahir','width'=>0,'extra'=>['id'=>'tmptlhr','class' => '', 'required' => true],'type'=>'text'], 
		'tgllahir'		=> ['label' => 'Tanggal Lahir','width'=>0,'extra'=>['id'=>'tgllhr','class' => '', 'required' => true],'type'=>'date'], 
		'jk'			=> ['label' => 'Jenis Kelamin','width'=>0, 'extra'=>['id'=>'jks','class' => '', 'required' => true],'type'=>'dropdown'], 
		'agama'			=> ['label' => 'Agama','width'=>0, 'extra'=>['id'=>'religi','class' => '', 'required' => true],'type'=>'dropdown'], 
		'email'			=> ['label' => 'Email','width'=>0, 'extra'=>['id'=>'demail','class' => '', 'required' => true],'type'=>'email'],
		'alamat'		=> ['label' => 'ALamat','width'=>0,'extra'=>['id'=>'adrs','class' => '', 'style' => 'height: 100px','required' => true],'type'=>'textarea'], 
		'nohp'			=> ['label' => 'No. HP','width'=>10, 'extra'=>['id'=>'noph','class' => '', 'required' => true],'type'=>'tel'], 
		'nama_ayah'		=> ['label' => 'Nama Ayah','width'=>12, 'extra'=>['id'=>'nm','class' => '', 'required' => true],'type'=>'text'], 
		'nama_ibu'		=> ['label' => 'Nama Ibu','width'=>0, 'extra'=>['id'=>'nmibu','class' => '', 'required' => true],'type'=>'text'], 
		'alamat_ortu'	=> ['label' => 'Alamat Orang Tua','width'=>0, 'extra'=>['id'=>'addrortu','class' => '', 'required' => true],'type'=>'text'], 
		'nohp_ayah'		=> ['label' => 'No. HP Ayah','width'=>8, 'extra'=>['id'=>'hpayh','class' => '', 'required' => true],'type'=>'tel'], 
		'nohp_ibu'		=> ['label' => 'No. HP Ibu','width'=>0, 'extra'=>['id'=>'hpibu','class' => '', 'required' => true],'type'=>'tel'],
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
			'noinduk' => "required|is_unique[tbl_siswa.noinduk,noinduk]",
            'nama'  => 'required',
		]; 
	
	public $roleEdit = [
			'nik' => "required",
			'noinduk' => "required",
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
	public $importallowed = TRUE;
	

	public $addAllowed = FALSE;
	/**
	* ---------------------------------------------------------------------
	* action boolean
	* ---------------------------------------------------------------------
	* 
	* @var array
	*/
	public $actions = [
		'detail' 	=> ['icon'=>'list-alt','src'=>'datadik/detail/', 'label'=>'Detail', 'extra'=>''],
		'edit' 		=> ['icon'=>'edit','src'=>'datadik/edit/', 'label'=>'Detail', 'extra'=>''],
		'delete'	=> ['icon'=>'trash','src'=>'datadik/detail/', 'label'=>'Detail', 'extra'=>"onclick='confirmation(event)'"],
	];
}
