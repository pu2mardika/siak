<?php namespace Modules\Tendik\Config;

use CodeIgniter\Config\BaseConfig;

class Tendik extends BaseConfig
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
		'status' => [0 => 'Tidak Kawin', 1 => 'Kawin', 2 => 'Cerai Hidup', 3 => 'Cerai Mati',],
		'sts_kepeg' => [1 => 'PNS', 2 => 'P3K', 3 => 'Kontrak Daerah', 4 => 'Kontrak Sekolah', 5 => 'Pengabdi'],
		'state' => [0 => 'Pindah', 1 => 'Aktif', 2 => 'Purna Tugas',],
	];

	/**
	* ---------------------------------------------------------------------
	* FIELD NAME 
	* ---------------------------------------------------------------------
	* 'nik', 'noid', 'nama', 'tempatlahir', 'tgllahir', 'jk', 'status', 'sts_kepeg', 'alamat', 'nohp', 'npwp', 'rekeningbank', 'namabank', 'holdname', 'tmt', 'state'
	* @var array
	* 
	*/
	public $fields = [
		'nik'			=> ['label' => 'NIK','width'=>12, 'extra'=>['id' => 'nik','class' => '', 'required' => true],'type'=>'text'],
		'nama'			=> ['label' => 'Nama Lengkap','width'=>15,'extra'=>['id' => 'nama','class' => '', 'required' => true],'type'=>'text'], 
		'noid'			=> ['label' => 'NIP','width'=>6,'extra'=>['id' => 'rid','class' => '', 'required' => true],'type'=>'text', ], 		 
		'tempatlahir'	=> ['label' => 'Tempat Lahir','width'=>0,'extra'=>['id' => 'ttl','class' => '', 'required' => true],'type'=>'text'], 
		'tgllahir'		=> ['label' => 'Tanggal Lahir','width'=>0,'extra'=>['id' => 'tglh','class' => '', 'required' => true],'type'=>'date'], 
		'jk'			=> ['label' => 'Jenis Kelamin','width'=>0, 'extra'=>['id' => 'jks','class' => '', 'required' => true],'type'=>'dropdown'], 
		'status'		=> ['label' => 'Status Perkawinan','width'=>0, 'extra'=>['id' => 'sts','class' => '', 'required' => true],'type'=>'dropdown'], 
		'sts_kepeg'		=> ['label' => 'Status Kepegawaian','width'=>0, 'extra'=>['id' => 'stskp','class' => '', 'required' => true],'type'=>'dropdown'], 
		'alamat'		=> ['label' => 'ALamat','width'=>0,'extra'=>['id' => 'addrs','class' => '', 'style' => 'height: 100px','required' => true],'type'=>'textarea'], 
		'nohp'			=> ['label' => 'No. HP','width'=>10, 'extra'=>['id' => 'hp','class' => '', 'required' => true],'type'=>'tel'], 
		'npwp'			=> ['label' => 'NPWP','width'=>12, 'extra'=>['id' => 'npwpx','class' => '', 'required' => false],'type'=>'text'], 
		'rekeningbank'	=> ['label' => 'No. Rekening','width'=>0, 'extra'=>['id' => 'accbank','class' => '', 'required' => true],'type'=>'text'], 
		'namabank'		=> ['label' => 'Nama Bank','width'=>0, 'extra'=>['id' => 'namabank','class' => '', 'required' => true],'type'=>'text'], 
		'holdname'		=> ['label' => 'Nama Pemilik Rek','width'=>0, 'extra'=>['id' => 'holdAcc','class' => '', 'required' => true],'type'=>'text'], 
		'tmt'			=> ['label' => 'TMT Tugas','width'=>0, 'extra'=>['id' => 'issued','class' => '', 'required' => true],'type'=>'date'],
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
			'nik' => "required|is_unique[tbl_ptk.nik,nik]",
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
	public $importallowed = TRUE;
	
	/**
	* ---------------------------------------------------------------------
	* action boolean
	* ---------------------------------------------------------------------
	* 
	* @var array
	*/
	public $actions = [
		'detail' 	=> ['icon'=>'list-alt','src'=>'tendik/detail/', 'label'=>'Detail', 'extra'=>''],
		'edit' 		=> ['icon'=>'edit','src'=>'tendik/edit/', 'label'=>'Detail', 'extra'=>''],
		'delete'	=> ['icon'=>'trash','src'=>'tendik/hapus/', 'label'=>'Detail', 'extra'=>"onclick='confirmation(event)'"],
	];
	
	/**
	* --------------------------------------------------------------------
	* index colom/field  untuk mengurutkan data
	* --------------------------------------------------------------------
	* 
	* @var 
	* 
	*/
	public $sortby = 1;
	//public $actiondetail = true; 
	//public $actionedit   = true; 
	//public $actiondelete = true; 
		
}
