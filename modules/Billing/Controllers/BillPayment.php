<?php

namespace Modules\Billing\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;
use CodeIgniter\Files\File;
use Modules\Billing\Models\PaymentModel;
use Modules\Billing\Models\BillModel;
use chillerlan\QRCode\{QRCode, QROptions};
use Picqer;

class BillPayment extends BaseController
{
    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Billing\Config\Payment::class);
        $this->session = \Config\Services::session();
		$this->model = new PaymentModel;	
		$this->billModel = new BillModel;	
			
		$this->data['site_title'] = 'Pembayaran';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['opsi'] 	  = $this->dconfig->opsi;
		$this->data['key']		  = $this->dconfig->primarykey;
		helper(['cookie', 'form','date','text']);
    }
    
    public function index()
    {
        $this->cekHakAkses('create_data');	
		$data			=$this->data;
		$data['title']	= "Tambah Data Pembayaran"; 
		$data['error'] 	= [];
		$data['fields'] =  $this->dconfig->fields;
		$data['instruction'] = "Pilih Jenis Identitas yang dimiliki (No KTP atau Nomor Induk) lalu klik lanjutkan!!";
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['rsdata'] = [];
		echo $this->_render('frmsearch',$data);
    }

	/* Tidank Lanjut Pembayran
	* 
	* @return
	*/
	 public function showBill()
	{
		$data			= $this->data;
		$data['title']	= "Rincian Pembayaran";
	 	$rules 	= $this->dconfig->rolesrchID;
		if ($this->validate($rules)) {
			$post = $this->request->getPost();
			$Id = $post['accountID'];
			$billing =  $this->get_billing($Id, $post['jenisID']);
			
			if($billing){
				
				$data['resume'] = $billing['resume'];
				$dtAngs = $billing['dtAngs'];
				$denda = 0;
				
				//action form
				If($dtAngs['saldo'] > 0){
					$Angs['pokok'] = format_angka($dtAngs['pokok']);
					$Angs['bunga'] = format_angka($dtAngs['bunga']);
					$Angs['total'] = format_angka($dtAngs['total']);
					$Angs['saldo'] = format_angka($dtAngs['saldo']);
					$Angs['payment'] =0;
					$Angs['denda'] = $denda;
					$Angs['tanggal'] =date("Y-m-d");
					$data['actionform']['fields'] = $this->dconfig->actfield;
					$data['actionform']['data'] = $Angs;
					$data['actionform']['subtitle'] = "Detail Pembayaran";
					$data['dataStated'] = 0;  //diisi jika menggunakan condAddOnAct
				}else{
					$data['alerts']['subtitle'] = "Lunass";
					$data['alerts']['contextual'] = "success";
					$data['alerts']['text'] = "Pinjaman Telah Lunas";
					$data['dataStated'] = 1; //diisi jika menggunakan condAddOnAct
				}
				//detail angsuran
				$data['act'] = base_url('payment/konfirm');
				$data['keys'] = 'id';
				$data['fields'] = $this->dconfig->detfields;
				$data['rsdata'] = $pinjaman['detail'];
				$data['addOnACt'] = $this->dconfig->detAddOnACt;
				$data['condAddOnAct'] = $this->dconfig->condAddOnACt;
				$data['condActDet'] = $this->dconfig->condActDet;
				$data['hidden'] = ['accountID' => $accId,'dpokok' => $dtAngs['pokok'],'dbunga' => $dtAngs['bunga'],
								   'ddenda' => $denda,'nama'=>$pinjaman['resume']['data']['nama'], 'stated' => 0];
				echo view($this->theme.'frmdatalist',$data); 
			}else{
				$data['fields'] = [];
				$data['act'] = base_url('payment');
				$data['error'] = "Data Pinjaman tidak ditemukan, kemungkinan belum terdaftar sebagai nasabah atau dana belum dicairkan. Silakan di cek kembali";
				echo view($this->theme.'frm2konfirm',$data);
			}
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}

	private function get_billing($Id, string $k = 'nis'){
			
		$func = [
			'nis' 	=> ['a.nipd'=>$Id], 
			'nik'	=> ['b.nik'=>$Id]
		];
		$funct = $func[$k];
	//	$billModel = model(Modules\Billing\Models\BillModel::class);
		//$billing =  $this->billModel->getsData($funct);
		$billing = $this->model->getData($funct);
		
		$result = [];
		if($billing){
			
			//detail angsuran
			$result['resume']['subtitle'] = "Daftar Billing";
			
			$rsdet=[];
			$jml = 0; $saldo = 0;
			foreach($billing as $k => $row)
			{
				//'amount', 'diskon'
				$result['resume']['nama']  = $row['nama'];
				$result['resume']['nik']   = $row['nik'];
				$result['resume']['alamat']= $row['alamat'];
				$result['resume']['nohp']= $row['nohp'];
				$result['resume']['title'] = "Detail Pinjaman";

				$row['issued']=format_date($row['issued'],false);
				$saldo -= $row['pokok'];
				$row['deskripsi']=$row['deskripsi'];
				$row['amount']=$row['amount'];
				$row['diskon']=$row['diskon'];
				
				$rsdet[]=$row;
			}
			$result['detail']=$rsdet;
			return $result;
		}else{
			return NULL;	
		}
	}
}
