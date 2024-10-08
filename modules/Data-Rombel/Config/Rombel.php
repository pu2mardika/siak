<?php namespace Modules\Room\Config;

use CodeIgniter\Config\BaseConfig;

class Rombel extends BaseConfig
{
	/**
	 * --------------------------------------------------------------------
	 * Libraries :`roomid`, `nama_rombel`, `walikelas`, `kode_ta`, `grade`
	 * --------------------------------------------------------------------
	 *
	 * @var array
	 */
	public $opsi = [
		'grade' => [1 => 'Tingkat Pertama', 2 => 'Tingkat Kedua', 3 => 'Tingkat Ketiga',],
		'learn_metode' => [0 => 'Tatap Muka', 1 => 'Tutorial Online', 2 => 'Mandiri',],
	];

	/**
	* ---------------------------------------------------------------------
	* FIELD NAME 
	* ---------------------------------------------------------------------
	* @var array
	* 
	*/
	public $fields = [
		'kode_ta'	 => ['label' => 'Tahun Pelajaran','width'=>0,'extra'=>['id' => 'kodeta','class' => '', 'required' => true],'type'=>'dropdown'], 
		'prodi'		 => ['label' => 'Prodi','width'=>0,'extra'=>['id' => 'vprodi','class' => '', 'required' => true],'type'=>'dropdown', ], 
		'nama_rombel'=> ['label' => 'Nama Rombel','width'=>40,'extra'=>['id' => 'namarombel','class' => '', 'required' => true],'type'=>'text', ], 
		'curr_id'	 => ['label' => 'Kurikulum','width'=>0,'extra'=>['id' => 'currID','class' => '', 'required' => true],'type'=>'dropdown'],
		'grade'		 => ['label' => 'Grade/Tingkat','width'=>5,'extra'=>['id' => 'vgrade','class' => '', 'required' => true],'type'=>'dropdown'],
		'learn_metode'	 => ['label' => 'Metode Belajar','width'=>0,'extra'=>['id' => 'lmetode','class' => '', 'required' => true],'type'=>'dropdown'],
		'wali'	 	 => ['label' => 'Wali Kelas','width'=>40,'extra'=>['id' => 'srcwalikelas','class' => '', 'required' => true],'type'=>'text'],  
		'walikelas'	 => ['label' => '','width'=>0,'extra'=>['id' => 'walikelas','class' => '', 'required' => true],'type'=>'hidden'],  
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
        'nama_rombel'   => ['label' => 'Nama Rombel', 'rules' =>'required'],
        'walikelas'  	=> ['label' => 'Nama Wali Kelas', 'rules' =>'required'],
        'kode_ta'  		=> ['label' => 'Tahun Pelajaran', 'rules' =>'required'],
        'grade'  		=> ['label' => 'Penerimaan Negara', 'rules' =>'required'],
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
		'detail' 	=> ['icon'=>'list-alt','src'=>'rombel/detail?ids=', 'label'=>'Detail', 'extra'=>''],
		'edit' 		=> ['icon'=>'edit','src'=>'rombel/edit/', 'label'=>'Detail', 'extra'=>''],
		'delete'	=> ['icon'=>'trash','src'=>'rombel/rem/', 'label'=>'Detail', 'extra'=>"onclick='confirmation(event)'"],
	];

	public array $dtfilter = [
		'source'=>'TaPel',
		'action'=>'rombel?tp=',
		'cVal'	=>'',
		'title'	=>'Ganti Tahun Pelajaran'
	];
		
}
