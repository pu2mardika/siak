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
		'nik'			=> ['label' => 'NIK','width'=>12, 'extra'=>['class' => '', 'required' => true],'type'=>'text'], 
		'idreg'			=> ['label' => 'No. Register','width'=>0,'extra'=>['class' => '', 'required' => true],'type'=>'text', ], 
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
