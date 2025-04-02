<?php

namespace Modules\Billing\Config;

use CodeIgniter\Config\BaseConfig;

class Payment extends BaseConfig
{
    public $opsi = [
		'jenisID' => ['nik'=>"Nomor Induk Kependudukan / No. KTP", 'nis'=>"Nomor Induk Peserta Didik"],
		'state' => [0=>'Pembayaran Angsuran', 1 => "Pelunasan Pinjaman", 2=>"Kompensasi Pinjaman"],
	];
	
	public array $akunBB = ['kas' => 'd', 'pokok' => 'c', 'bunga' => 'c', 'denda' => 'c',];

	/**
	* ---------------------------------------------------------------------
	* FIELD NAME : `id`, `accountID`, `tanggal`, `pokok`, `bunga`, `denda`, `trxId`, `opid`
	* ---------------------------------------------------------------------
	* 
	*/
	public array $fields = [
		'jenisID'	=> ['label' => 'Jenis Identitas','width'=>40,'extra'=>['id' => 'jnsID','class' => '', 'required' => true],'type'=>'dropdown', ],
		'accountID'	=> ['label' => 'Nomor Induk atau NIK','width'=>40,'extra'=>['id' => 'accountID','class' => '', 'required' => true],'type'=>'text', ],
	];
	
	public array $resumefields = [
		'accountID'	=> ['label' => 'Nomor Pinjaman','perataan'=>'left'], 
		'nik'		=> ['label' => 'NIK','perataan'=>'left'], 
		'nama'		=> ['label' => 'Nama Nasabah','perataan'=>'left'], 
		'tanggal'	=> ['label' => 'Tanggal Pinjaman','perataan'=>'left'], 
		'plafond'	=> ['label' => 'Plafond','perataan'=>'left'],
		'saldo'		=> ['label' => 'Sisa Pinjaman','perataan'=>'left'],
		'tenor'		=> ['label' => 'Tenor','perataan'=>'left'],
		'rate'		=> ['label' => 'Suku Bunga','perataan'=>'left'],
		'overdue'	=> ['label' => 'Jatuh Tempo','perataan'=>'left'],
		'xangsuran'	=> ['label' => 'Sudah Diangsur','perataan'=>'left'],
	];
	
	public array $actfield =[					
		'pokok'		=> ['label' => 'Angsuran Pokok','extra'=>['id' => 'pokok','class' => '','disabled' =>'disabled readonly'],'type'=>'text'],
		'bunga'		=> ['label' => 'Bunga Pinjaman','extra'=>['bunga' => 'rate','class' => '','disabled' =>'disabled readonly'],'type'=>'text'],
		'denda'		=> ['label' => 'Denda', 'extra'=>['id' => 'denda','class' => '','disabled' =>'disabled readonly'],'type'=>'text'],   
		'total'		=> ['label' => 'Total Tagihan','extra'=>['id' => 'total','class' => '',	'disabled' =>'disabled readonly'],'type'=>'text'], 
		'payment'	=> ['label' => 'Jml Dibayar','extra'=>['id' => 'payment','class' => '', 'required' => true],'type'=>'text'],
		'tanggal'	=> ['label' => 'Tanggal Bayar','extra'=>['id' => 'tglByr','class' => '', 'required' => true],'type'=>'date', ],
	];
	
	public array $akunfield =[					
		'apokok'	=> ['label' => 'Angsuran Pokok','extra'=>['id' => 'apokok','class' => '','disabled' =>'disabled readonly'],'type'=>'text'],
		'rate'		=> ['label' => 'Bunga Pinjaman','extra'=>['id' => 'arate','class' => '','disabled' =>'disabled readonly'],'type'=>'text'],
		'bdenda'	=> ['label' => 'Sanksi/Denda', 'extra'=>['id' => 'bdenda','class' => '','disabled' =>'disabled readonly'],'type'=>'text'],   
		'total'		=> ['label' => 'Jumlah Pembayaran','extra'=>['id' => 'total','class' => '',	'disabled' =>'disabled readonly'],'type'=>'text'], 
		'tgltrx'	=> ['label' => 'Tanggal Bayar','extra'=>['id' => 'tglByr','class' => '', 'required' => true],'type'=>'date', ],
	];
	
	public array $detfields = [
		'tanggal'	=> ['label' => 'Tanggal Pembayaran','width'=>20,'type'=>'date'], 
		'pokok'		=> ['label' => 'Angsuran Pokok','width'=>20, 'type'=>'text'],
		'bunga'		=> ['label' => 'Bunga Pinjaman','width'=>20, 'type'=>'text'],
		'saldo'		=> ['label' => 'Sisa Pinjaman','width'=>20, 'type'=>'text'],
		'trxId'		=> ['label' => 'No Pembayaran','width'=>20,'type'=>'text'], 
	];
	
	/**
	* ---------------------------------------------------------------------
	* ROLE DATA
	* ---------------------------------------------------------------------
	* 
	* @var 
	* 
	*/
	public array $roles = [
        'payment'   	=> ['label' => 'Jumlah Pembayaran', 'rules' =>'required'],
	];  
	
	public $rolesrchID = [
        'accountID'   	=> ['label' => 'Nomor Pinjaman', 'rules' =>'required'],
	]; 
	
	public array $finaltiRole = [
		'key' 		=> 'saldo',
		'condition' => ['operand' => 'gt', 'value' => 0.5],
		'based'		=> 'plafond',
		'finalty' 	=> 2,
		'terget'	=> 'bunga'
	];
	
	public bool $parsialPayment = TRUE;
	/**
	 * --------------------------------------------------------------------
	 * Layout for the views to extend
	 * --------------------------------------------------------------------
	 *
	 * @var string
	 */
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
		'edit'		=> false,
		'delete'	=> false,
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
	
	public array $condActDet = [
		'field'  => 'trxId',
		'title'	 => 'Aksi',
		'state'  => 'state',
		'actdet' => [
		0 => [
				//'edit'	=> ['icon'=>'edit','src'=>'payment/edit/', 'label'=>'Edit', 'attr'=>'','useRow'=>false],
				'del'	=> ['icon'=>'trash','src'=>'payment/hapus/', 'label'=>'Hapus', 'attr'=>'onclick="confirmation(event)"','useRow'=>false],
			 ],
		1 => [
				'det'	=> ['icon'=>'list-alt','src'=>'payment/detail/', 'label'=>'Manage', 'attr'=>'', 'useRow'=>false],
			 ],
		],
	];
}
