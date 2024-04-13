<?php

namespace Modules\Akademik\Config;

use CodeIgniter\Config\BaseConfig;

class Program extends BaseConfig
{
    //OPSI
    public $opsi = [
		'unit_kerja' => [
			'lkp' 	=> "LKP Mandiri Bina Cipta",
			'pkbm'	=> "PKBM Mandiri Bina Cipta"
		]
	];

    /**
	* ---------------------------------------------------------------------
	* FIELD NAME : 'nm_program', 'desc'
	* ---------------------------------------------------------------------
	* @var array
	* 
	*/
	public array $fields = [
		'nm_program'	=> ['label' => 'Jenis Program','width'=>20,'extra'=>['id' => 'nama','class' => '', 'required' => true],'type'=>'text'], 
		'desc'		    => ['label' => 'Deskripsi/Keterangan','width'=>40,'extra'=>['id' => 'editor','class' => ''],'type'=>'textarea', ], 
		'unit_kerja'	=> ['label' => 'Unit Organisasi','width'=>20,'extra'=>['id' => 'unit','class' => '', 'required' => true],'type'=>'dropdown', ], 
	];
    
	public array $roles = [
        'nm_program'   	=> ['label' => 'Jumlah Pembayaran', 'rules' =>'required'],
		'desc'   		=> ['label' => 'Deskripsi', 'rules' =>'required'],
		'unit_kerja'   	=> ['label' => 'Unit Organisasi', 'rules' =>'required'],
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
		'spk' => ['icon'=>'file-word','src'=>'pinjaman/spk/', 'label'=>'Cetak SPK'],
	];
	
	public array $detAddOnACt = [
		'print' => ['icon'=>'print','src'=>'payment/cetak/', 'label'=>'Cetak', 'btn_type'=>'success'],
	];
	
	public array $condAddOnACt = [
		0 => [
			    'lunas' => ['icon'=>'file-invoice-dollar','src'=>'payment/acquit/', 'label'=>'Pelunasan', 'btn_type'=>'primary'],
			 ],
		1 => [],
	];
}
