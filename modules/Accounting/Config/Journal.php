<?php

namespace Modules\Account\Config;

use CodeIgniter\Config\BaseConfig;

class Journal extends BaseConfig
{
    /**
	 * --------------------------------------------------------------------
	 * FIELDS : `trx_id`, `tanggal`, `deskripsi`, `no_bukti`, `amount`, `created_at`, `updated_at`, `deleted_at` FROM `jurnal`
	 * 
	 * FIELDS-2 : `trx_id`, `kode_akun`, `debet`, `kredit`, `indek` FROM `jurnal_detail`
	 * --------------------------------------------------------------------
	 *
	 * @var array
	 */
	public $opsi = [
		'pos' => ['Db' => 'Kurang', 'Kr'  => 'Tambah',],
		'posValue' => ['Db' => ['indeks' => -1, 'desc'=>"Pengambilan Saham"],
					   'Kr'  => ['indeks' => 1, 'desc'=>"Penambahan Saham"],
		],
		'aksi' => ['add' => ['side'=>'Kr', 'title'=>'Penerimaan'],
				   'rem' => ['side'=>'Db', 'title'=>'Pengeluaran'],
		 ],
		 'jnstrx' =>['cash'=>'Tunai', 'ovb'=>'Non Tunai'],
	];
	
	public array $akunBB = [
		'othrev'  => ['accID'=>['cash' => 'kas', 'ovb' => 'bank'], 'pos'=>"Db", "xpos"=>'Kr','route'=>'othrev'],
		'cashout' => ['accID'=>['cash' => 'kas', 'ovb' => 'bank'], 'pos'=>"Kr", "xpos"=>'Db','route'=>''],
	];

	/**
	* ---------------------------------------------------------------------
	* FIELD NAME 
	* ---------------------------------------------------------------------
	* @var array
	* 
	*/
	public $fields = [
		'tanggal'	=> ['label' => 'Tanggal','extra'=>['id' => 'tgltrx','class' => '', 'required' => true],'type'=>'date', ], 
		'no_bukti'	=> ['label' => 'Nomor Bukti','extra'=>['id' => 'rfId','class' => '', 'required' => true],'type'=>'text', ],  
		'jnstrx'	=> ['label' => 'Jenis Transaksi','extra'=>['id' => 'jtrx','class' => '', 'required' => true],'type'=>'dropdown',],
		'deskripsi'	=> ['label' => 'Uraian/Keterangan','extra'=>['id' => 'desk','class' => '', 'required' => true],'type'=>'text', ],
		'accId'		=> ['label' => 'Akun Buku Besar','extra'=>['id' => 'accId','class' => '', 'required' => true],'type'=>'dropdown',],
		'amount'	=> ['label' => 'Jumlah','extra'=>['id' => 'jml','class' => '', 'required' => true],'type'=>'number'],  
	];
	
	public $actFields = [
		'tanggal'	=> ['label' => 'Tanggal', 'extra'=>['id' => 'tgltrx','class' => '', 'readonly' => true],'type'=>'date', ], 
		'no_bukti'	=> ['label' => 'Nomor Bukti','extra'=>['id' => 'rfId','class' => '', 'readonly' => true],'type'=>'text', ],  
		'jnstrx'	=> ['label' => 'Jenis Transaksi','extra'=>['id' => 'jtrx','class' => '', 'readonly' => true],'type'=>'text',],
		'deskripsi'	=> ['label' => 'Uraian/Keterangan','extra'=>['id' => 'desk','class' => '', 'readonly' => true],'type'=>'text', ],
		'accId'	=> ['label' => 'Akun Buku Besar','extra'=>['id' => 'accId','class' => '', 'required' => true],'type'=>'dropdown',],
		'amount'	=> ['label' => 'Jumlah','extra'=>['id' => 'jml','class' => '', 'required' => true],'type'=>'number'],  
	];
	
	public $fdtList = [  
		'nama_akun'	=> ['label' => 'URAIAN / KETERANGAN','width'=>60,'type'=>'text'], 
		'accId'		=> ['label' => 'Ref','width'=>10,'type'=>'text'],
		'amount'	=> ['label' => 'Jumlah','width'=>25,'type'=>'text'], 
	];
	
	//balance sheet
	public $balanceFields = [
		'tanggal'	=> ['label' => 'Tanggal','width'=>0,'extra'=>['id' => 'nama','class' => '', 'required' => true],'type'=>'date', ],
		'kode_akun'	=> ['label' => 'Kode Akun','width'=>10,'extra'=>['id' => 'jk','class' => '', 'required' => true],'type'=>'dropdown'], 
		'debet'		=> ['label' => 'Debet','width'=>20,'extra'=>['id' => 'jk','class' => '', 'required' => true],'type'=>'text'], 
		'kredit'	=> ['label' => 'Kredit','width'=>20,'extra'=>['id' => 'jk','class' => '', 'required' => true],'type'=>'text'], 
	];
	
	public $BSListField = [  
		'kode_akun'	=> ['label' => 'Kode','width'=>15,'type'=>'text'], 
		'nama_akun'	=> ['label' => 'Nama Perkiraan','width'=>40,'type'=>'text'], 
		'debet'		=> ['label' => 'Debet','width'=>20,'type'=>'text'],
		'kredit'	=> ['label' => 'Kredit','width'=>20,'type'=>'text'], 
	];
	
	public array $rptBShasTot = ['debet','kredit'];
	/**
	* ---------------------------------------------------------------------
	* ROLE DATA
	* ---------------------------------------------------------------------
	* 
	* @var 
	* 
	*/
	public $roles = [
        'no_bukti'  => ['label' => 'Nomor Bukti', 'rules' =>'required'],
        'tanggal'  	=> ['label' => 'Tanggal', 'rules' =>'required'],
        'jnstrx'  	=> ['label' => 'Jenis Transaksi', 'rules' =>'required'],
        'deskripsi' => ['label' => 'Uraian/Keterangan', 'rules' =>'required'],
        'accId' 	=> ['label' => 'Akun Buku Besar', 'rules' =>'required'],
        'amount'  	=> ['label' => 'Jumlah', 'rules' =>'required'],
	];  
	
	public $roleBS = [
		'tanggal'  	=> ['label' => 'Tanggal', 'rules' =>'required'],
        'kode_akun'	=> ['label' => 'Jenis Transaksi', 'rules' =>'required'],
        'debet' 	=> ['label' => 'Uraian/Keterangan', 'rules' =>'required'],
        'kredit' 	=> ['label' => 'Akun Buku Besar', 'rules' =>'required'],
	];  
	
	public $rolePos = []; 
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
	public $actions = [
		'detail'	=> false,
		'edit'		=> true,
		'delete'	=> true,
	];
	
	public array $addOnACt = [
		'hapus' => ['icon'=>'trash','src'=>'gleger/hapus/', 'title'=>'Hapus', 'label'=>'Hapus', 'attr'=>'onclick="confirmation(event)"'],
	];
	
	public array $detAddOnACt = [
		'add' => ['icon'=>'plus-square','src'=>'', 'label'=>'Tambah', 'btn_type'=>'success'],
		'rem' => ['icon'=>'minus-square','src'=>'', 'label'=>'Ambil', 'btn_type'=>'danger'],
	];
	
	public array $condActDet = [
		0 => [
				'edit'	=> ['icon'=>'edit','src'=>'gleger/edit/', 'label'=>'Edit', 'attr'=>''],
				'del'	=> ['icon'=>'trash','src'=>'gleger/hapus/', 'label'=>'Hapus', 'attr'=>'onclick="confirmation(event)"'],
			],
		1=> [
				'det'	=> ['icon'=>'list-alt','src'=>'#', 'label'=>'Manage', 'attr'=>''],
			],
	];
	
	/**
	* BOD dan VALIDATOR 
	*/
	public array $bod = [
    	'lp' 	=> ['nama'],
    	'glc1' 	=> ['nama'],
    	'bend1' => ['nama']
    ];
    
    public array $validator = [
    	'ks' 	=> ['nama', 'nik', 'nip'],
    ];
}
