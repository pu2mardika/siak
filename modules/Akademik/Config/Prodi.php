<?php

namespace Modules\Akademik\Config;

use CodeIgniter\Config\BaseConfig;

class Prodi extends BaseConfig
{
    //OPSI
    public $opsi = [
        'jenjang'=> [
            0 => "Non Jenjang",
            1 => "Pendidikan Dasar/Setara SD",
            2 => "Pendidikan Dasar/Setara SMP",
            3 => "Pendidikan Menengah/Setara SMA",
            4 => "Pendidikan Setara D1",
            5 => "Pendidikan Setara D2",
            6 => "Pendidikan Setara D3",
            7 => "Pendidikan Setara D4",
        ]
    ];

    /**
	* ---------------------------------------------------------------------
	* FIELD NAME : 'nm_prodi', 'skl', 'jurusan', 'jenjang'
	* ---------------------------------------------------------------------
	* @var array
	* 
	*/
	public array $fields = [
		'nm_prodi'	=> ['label' => 'Nama Program','width'=>20,'extra'=>['id' => 'nama','class' => '', 'required' => true],'type'=>'text'], 
		'skl'		=> ['label' => 'Deskripsi/SKL','width'=>40,'extra'=>['id' => 'editor','class' => ''],'type'=>'textarea', ], 
		'jurusan'	=> ['label' => 'Jenis Program','width'=>20,'extra'=>['id' => 'program','class' => '', 'required' => true],'type'=>'dropdown', ], 
        'jenjang'	=> ['label' => 'Jenjang','width'=>10,'extra'=>['id' => 'grades','class' => '', 'required' => true],'type'=>'dropdown', ], 
	];
    
	public array $roles = [
        'nm_prodi'   	=> ['label' => 'Nama Prodi', 'rules' =>'required'],
		'skl'   		=> ['label' => 'Deskripsi/SKL', 'rules' =>'required'],
		'jurusan'   	=> ['label' => 'Jenis Program', 'rules' =>'required'],
        'jenjang'   	=> ['label' => 'Jenjang', 'rules' =>'required'],
	];  

	public string $primarykey = 'id_prodi';
	
	/**
	* ---------------------------------------------------------------------
	* Export and Import data allowed
	* ---------------------------------------------------------------------
	* 
	* @var boelean
	*/
	public bool $importallowed = false;
	
	/**
	* ---------------------------------------------------------------------
	* action boolean
	* ---------------------------------------------------------------------
	* 
	* @var array
	*/
	public $actions = [
		'detail'	=> false,
		'edit'		=> true,
		'delete'	=> true,
	];
	
	public array $addOnACt = [
		'spk' => ['icon'=>'file-word','src'=>'pinjaman/spk/', 'label'=>'Cetak SPK'],
	];
	
	public array $detAddOnACt = [
		'print' => ['icon'=>'print','src'=>'payment/cetak/', 'label'=>'Cetak', 'btn_type'=>'success'],
	];
}