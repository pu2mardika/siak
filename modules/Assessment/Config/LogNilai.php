<?php

namespace Modules\Assessment\Config;

use CodeIgniter\Config\BaseConfig;

class LogNilai extends BaseConfig
{
    public $opsi = [
		'subgrade' => [""=>'[--Pilih--]',1 =>"Semester I / Ganjil", 2 =>'Semester II/Genap'],
	];

	public $dom = 'flrtip';

	/**
	* ---------------------------------------------------------------------
	* FIELD NAME 
	* ---------------------------------------------------------------------
	* @var array
	* 
	*/
	public $fields = [
		'nama_rombel'	=> ['label' => 'Nama Rombel','width'=>20, 'type'=>'text'], 
		'level      '	=> ['label' => 'Jenjang','width'=>25, 'type'=>'text'], 
		'grade'	 	    => ['label' => 'Grade','width'=>10, 'type'=>'text'], 
		'walikelas'		=> ['label' => 'Nama Wali','width'=>30, 'type'=>'dropdown'], 
	];

    public $fields2 = [
		'subject_name'	=> ['label' => 'Nama Mapel','width'=>25,'extra'=>['id'=>'namasiswa','class' => '', 'required' => true],'type'=>'text'], 
		'id_mapel'		=> ['label' => 'Kode Mapel','width'=>10,'extra'=>['id'=>'nisnx','class' => '', 'required' => true],'type'=>'text'], 
		'skk'			=> ['label' => 'SKK','width'=>8, 'extra'=>['id'=>'jks','class' => '', 'required' => true],'type'=>'dropdown'], 
		'kkm'			=> ['label' => 'KKM/KKTP','width'=>8, 'extra'=>['id'=>'jks','class' => '', 'required' => true],'type'=>'dropdown'], 
	];
	
	public array $ResumeFields = [
		'nama_rombel'	=> ['label' => 'Nama Rombel','perataan'=>'left'], 
	//	'subject_name'	=> ['label' => 'Nama Mapel','perataan'=>'left'],
		'skk'			=> ['label' => 'SKK','perataan'=>'left'],
		'kkm'			=> ['label' => 'KKM/KKTP', 'perataan'=>'left'],
		'subgrade'		=> ['label' => 'Sub Grade','perataan'=>'left'],
		'nama'			=> ['label' => 'Guru Pengampu','perataan'=>'left']
	];

	public $Addfields = [
		'TaPel'		=> ['label' => 'Tahun Pelajaran','extra'=>['id'=>'dttapel','class' => '', 'required' => true],'type'=>'dropdown'],  
		'rombel'	=> ['label' => 'Rombel','extra'=>['id'=>'bsroom','class' => '', 'required' => true],'type'=>'dropdown'],  
		'subgrade'	=> ['label' => 'Semester','extra'=>['id'=>'sgrade','class' => '', 'required' => true],'type'=>'dropdown'],  
	];

	public $markFields = [
		'noinduk'	=> ['label' => 'No Induk', 'width'=>15, 'extra'=>['id'=>'idmapel','class' => ''],'type'=>'hidden'], 
		'nama'		=> ['label' => 'Nama PD','width'=>25,'extra'=>['id'=>'namasiswa','class' => '', 'required' => true],'type'=>'disp'], 
		'nisn'		=> ['label' => 'NISN','width'=>10,'extra'=>['id'=>'nisnx','class' => '', 'required' => true],'type'=>'disp'], 
		'nilai'		=> ['label' => 'Nilai','width'=>30,'extra'=>['id'=>'nisnx','class' => '', 'required' => true],'type'=>'disp'], 
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
        'ptk'	=> ['label' => 'Pendidik', 'rules' =>'required'],
        'kkm'  	=> ['label' => 'KKM/KKTP', 'rules' =>'required'],
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
	public $addAllowed = FALSE;
	
	public $panelAct = [
		'detail' 	=> ['icon'=>'list-alt','src'=>'nilai/detail?ids=', 'label'=>'Detail', 'extra'=>'', 'btn_type'=>''],
	];

	public $actions = [
		0	=>['AddAtp'   => ['icon'=>'list-alt','src'=>'atp/show?ids=', 'label'=>'Input ATP', 'extra'=>'', 'btn_type'=>'']],
		1	=>['shpd'     => ['icon'=>'list-alt','src'=>'nilai/vdata?ids=', 'label'=>'Input Nilai', 'extra'=>'', 'btn_type'=>'']],
		2	=>[
				'editAtp' => ['icon'=>'edit','src'=>'atp/edit?ids=', 'label'=>'Edit ATP', 'extra'=>'', 'btn_type'=>''],
				'shpd'    => ['icon'=>'list-alt','src'=>'nilai/vdata?ids=', 'label'=>'Input Nilai', 'extra'=>'', 'btn_type'=>'']
			  ],
	];

	public array $AddOnACt = [
		'import' => ['icon'=>'file-excel-o','src'=>'nilai/import/', 'label'=>'Upload Nilai', 'btn_type'=>'success'],
	];

	public array $detAddOnACt = [
		'delete'	=> ['icon'=>'remove','src'=>'rombel/del/', 'label'=>'Hapus Siswa', 'extra'=>"onclick='confirmation(event)'"],
	];

	public $condActions = [
		0 =>[
				'import' => ['icon'=>'file-excel-o','src'=>'nilai/import/', 'label'=>'Upload Nilai', 'extra'=>'', 'btn_type'=>''],
			],
		1=>	[]
	];

	public array $dtfilter = [
		'source'=>'TaPel',
		'action'=>'nilai?tp=',
		'cVal'	=>'',
		'title'	=>'Ganti Tahun Pelajaran'
	];

	public array $footNav = [
		'nav' => 'n'
	];

	public string $arrDelimeter = '++VHV++';

	public string $addonJSfunc = "function getData(){
		var k=$(this).val(); load('ptm/vdata?ids='+k,'#dtviews');
	}
	function getroom(){
		var k=$(this).val(); load('ptm/vroom/'+k,'#bsroom');
	}";

	public string $addonJS = '
		$("#dttapel").change(function(){
			var k=$(this).val();
			load("ptm/vroom/"+k,"#bsroom");
		});	
		$("#bsroom").change(function(){
			var k=$(this).val();
			load("ptm/vsgrade?ids="+k,"#sgrade");
		});	
		$("#sgrade").change(function(){
			var k=$("#bsroom").val(); var sg=$("#sgrade").val();
			load("ptm/vdata?ids="+k+"&sgr="+sg,"#dtviews");
		});	
	';

	public function opsiData($var):string
	{
		return base_url($var);
	}
}
