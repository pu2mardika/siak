<?php

namespace Modules\Billing\Config;

use CodeIgniter\Config\BaseConfig;

class Couppon extends BaseConfig
{
    /**
     * 'id', 'code', 'deskripsi', 'issued', 'due_date', 'discont', 'disc_type'
     */
    public $opsi = [
		'disc_type'  => [''=>'[ - PILIH - ]', 'fx'=>"Nilai Tetap (Rp)", 'fl'=>"Floating (%)"],
	];


	/**
	* 
	* @var array
	* 
	*/
	public $fields = [
		'code'	    => ['label' => 'Kode Kupon','width'=>15, 'extra'=>['id'=>'codex','class' => '', 'required' => true, 'pattern'=>"[0-9A-Z]+",'autofocus'],'type'=>'text'],
		'deskripsi'	=> ['label' => 'Deskripsi','width'=>35,'extra'=>['id'=>'descript','class' => '', 'required' => true],'type'=>'text'], 
		'discont'	=> ['label' => 'Besar Diskon','width'=>20,'extra'=>['id'=>'discVal','class' => '', 'required' => true, 'step'=>'5'],'type'=>'number'], 
		'disc_type'	=> ['label' => 'Type Diskon','width'=>0,'extra'=>['id'=>'discType','class' => '', 'required' => true],'type'=>'dropdown'], 
        'issued'	=> ['label' => 'Tgl Terbit','width'=>20,'extra'=>['id'=>'tglTerbit','class' => '', 'required' => true],'type'=>'date', ],
		'due_date'	=> ['label' => 'Kedaluarsa','width'=>20,'extra'=>['id'=>'expdate','class' => '', 'required' => true],'type'=>'date', ], 		 
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
		'code' 	   => ['label' => 'Kode Kupon', 
					   'rules' => 'required|max_length[10]|min_length[6]|alpha_numeric', 
					   'errors'=> 'Kode Kupon hanya boleh diisi dengan huruf dan harus 6 huruf'
					  ],
        'deskripsi'=> ['label' => 'Deskripsi', 
					   'rules' => 'required|max_length[100]',
					   'errors'=> 'Deskripsi harus tersedia dan maksimal 100 huruf'
					  ],
		'discont'  => ['label' => 'Besaran Diskon', 
					   'rules' => 'required',
					   'errors'=> 'Besaran Diskon harus tersedia dan harus angka'
					  ],
		'disc_type'=> ['label' => 'Jenis Pembayaran', 
				       'rules' => 'required',
					   'errors'=> 'Jenis Pembayaran harus ada'
					  ],
        'issued'   => ['label' => 'Tgl Terbit',  
				       'rules' => 'required',
					   'errors'=> 'Tgl Terbit wajib diisi'
					  ],
	]; 
	
	
	 /* --------------------------------------------------------------------
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
		//'detail' 	=> ['icon'=>'list-alt','src'=>'tp/detail/', 'label'=>'Detail', 'extra'=>''],
		'edit' 		=> ['icon'=>'edit','src'=>'couppon/edit/', 'label'=>'Edit', 'extra'=>''],
		'delete'	=> ['icon'=>'trash','src'=>'couppon/rem/', 'label'=>'Hapus', 'extra'=>"onclick='confirmation(event)'"],
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
}
