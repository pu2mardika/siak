<?php

namespace Modules\Akademik\Config;

use CodeIgniter\Config\BaseConfig;

class Kurikulum extends BaseConfig
{
    //OPSI
    public $opsi = [
        'curr_system'=> [1=>"Paket", 2=>"Semester", 3=>"Catur Wulan", 4=>"Quarter"],
    ];

    /**
	* ---------------------------------------------------------------------
	* FIELD NAME : 'curr_id', 'id_prodi', 'curr_name', 'curr_desc', 'issued', 
	*              'l_duration', 'curr_system', 'instance_rpt', 'ch_level', 'state',
	* ---------------------------------------------------------------------
	* @var array
	* 
	*/
	public array $fields = [
		'id_prodi'		=> ['label' => 'Program Studi','width'=>0,'extra'=>['id' => 'idprodi','class' => '', 'required' => true],'type'=>'dropdown', ], 
		'curr_name'		=> ['label' => 'Nama Kurikulum','width'=>20,'extra'=>['id' => 'nama','class' => '', 'required' => true],'type'=>'text'], 
		'curr_desc'		=> ['label' => 'Deskripsi/SKL','width'=>40,'extra'=>['id' => 'editor','class' => ''],'type'=>'textarea', ], 
		'issued'		=> ['label' => 'Tgl Mulai Berlaku','width'=>0,'extra'=>['id' => 'tmt','class' => '', 'required' => true],'type'=>'date', ], 
        'l_duration'	=> ['label' => 'Lama Belajar','width'=>8,'extra'=>['id' => 'durasi','class' => '', 'required' => true],'type'=>'number', ], 
		'curr_system'	=> ['label' => 'Sistem Kurikulum','width'=>10,'extra'=>['id' => 'cursytem','class' => '', 'required' => true],'type'=>'dropdown', ],
		'instance_rpt'	=> ['label' => 'Akronim Kurikulum','width'=>0,'extra'=>['id' => 'instances','class' => '', 'required' => true],'type'=>'text'],  
	];

	public string $resume_descrip_field = 'curr_desc';

	public array $res_addON_fields = [  //MAKS: 3 FIELDS
		'issued'		=>['label' => 'TMT', 'type'=>'text'], 
		'l_duration'	=>['label' => 'Lama Belajar', 'type'=>'text'], 
		'curr_system'	=>['label' => 'Sistem Kurikulum', 'type'=>'dropdown']
	];
    
	public array $roles = [
        'id_prodi'   	=> ['label' => 'Nama Prodi', 'rules' =>'required'],
		'curr_name'   	=> ['label' => 'Nama Kurikulum', 'rules' =>'required'],
		'curr_desc'  	=> ['label' => 'Deskripsi/SKL', 'rules' =>'required'],
		'issued'   		=> ['label' => 'Tgl Mulai Berlaku', 'rules' =>'required'],
        'l_duration'   	=> ['label' => 'Lama Belajar', 'rules' =>'required'],
		'curr_system'  	=> ['label' => 'Sistem Kurikulum', 'rules' =>'required'],
		'instance_rpt' 	=> ['label' => 'Akronim Kurikulum', 'rules' =>'required'],
	];  

	public string $primarykey = 'id';
	
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
		'spk' => ['icon'=>'file-word','src'=>'kurikulum/detail/', 'label'=>'Detail'],
	];
	
	public array $detAddOnACt = [
		'print' => ['icon'=>'print','src'=>'payment/cetak/', 'label'=>'Cetak', 'btn_type'=>'success'],
	];
}