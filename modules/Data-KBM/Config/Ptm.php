<?php

namespace Modules\Kbm\Config;

use CodeIgniter\Config\BaseConfig;

class Ptm extends BaseConfig
{
    public $opsi = [
		'subgrade' => [""=>'[--Pilih--]',1 =>"Semester I / Ganjil", 2 =>'Semester II/Genap'],
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
		'nama_rombel'	=> ['label' => 'Nama Rombel','width'=>12, 'extra'=>['id'=>'noktp','class' => '', 'required' => true],'type'=>'text'], 
		'subject_name'	=> ['label' => 'Nama Mapel','width'=>25,'extra'=>['id'=>'namasiswa','class' => '', 'required' => true],'type'=>'text'], 
		'id_mapel'		=> ['label' => 'Kode Mapel','width'=>10,'extra'=>['id'=>'nisnx','class' => '', 'required' => true],'type'=>'text'], 
		'skk'			=> ['label' => 'SKK','width'=>8, 'extra'=>['id'=>'jks','class' => '', 'required' => true],'type'=>'dropdown'], 
		'kkm'			=> ['label' => 'KKM/KKTP','width'=>8, 'extra'=>['id'=>'jks','class' => '', 'required' => true],'type'=>'dropdown'], 
	];
	
	public array $ResumeFields = [];

	public $Addfields = [
		'TaPel'		=> ['label' => 'Tahun Pelajaran','extra'=>['id'=>'dttapel','class' => '', 'required' => true],'type'=>'dropdown'],  
		'rombel'	=> ['label' => 'Rombel','extra'=>['id'=>'bsroom','class' => '', 'required' => true],'type'=>'dropdown'],  
		'subgrade'	=> ['label' => 'Semester','extra'=>['id'=>'sgrade','class' => '', 'required' => true],'type'=>'dropdown'],  
	];

	public $srcFields = [
		'id_mapel'		=> ['label' => 'Kode Mapel', 'width'=>12, 'extra'=>['id'=>'idmapel','class' => ''],'type'=>'hidden'], 
		'subject_name'	=> ['label' => 'Nama Mapel','width'=>35,'extra'=>['id'=>'namasiswa','class' => '', 'required' => true],'type'=>'disp'], 
		'skk'			=> ['label' => 'SKK','width'=>10,'extra'=>['id'=>'nisnx','class' => '', 'required' => true],'type'=>'disp'], 
		'ptk'			=> ['label' => 'Tendik','width'=>30, 'extra'=>['id'=>'idptk','class' => '', 'required' => true],'type'=>'dropdown'], 
		'kkm'			=> ['label' => 'KKM/KKTP','width'=>8, 'extra'=>['id'=>'idkkm','class' => '', 'required' => true],'type'=>'text'], 
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

	public $panelAct = [
		'add' => ['icon'=>'plus-square','src'=>'ptm/add/', 'label'=>'Tambah Data', 'btn_type'=>'btn-primary btn-xs'],
	];

	public $actions = [];

	public array $detAddOnACt = [];

	public array $dtfilter = [
		'source'=>'TaPel',
		'action'=>'ptm?tp=',
		'cVal'	=>'',
		'title'	=>'Ganti Tahun Pelajaran'
	];

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
}
