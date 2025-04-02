<?php

namespace Modules\Billing\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;
use CodeIgniter\Files\File;
use Config\MyApp;
//use Modules\Pricing\Models\PriceModel;
use Modules\Billing\Models\CorpModel;
use chillerlan\QRCode\{QRCode, QROptions};
use Picqer;

class CorpBillController extends BaseController
{
    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Billing\Config\Corp::class);
        $this->session = \Config\Services::session();
		$this->model = new CorpModel;	
		$this->ProdiModel = model(\Modules\Akademik\Models\ProdiModel::class);
		$this->data['site_title'] = 'Corporate Billing';
		$this->data['opsi'] 	  = $this->dconfig->opsi;
	//	$this->data['opsi']['id_prodi'] = $this->ProdiModel->getDropdown();
		$this->data['key'] = setting()->get('Corp.primarykey');
		helper(['cookie', 'form']);
    }

    public function index()
    {
        $data= $this->data;
        $data['title']	= "Manajemen Corporate Billing";
        $rdata = $this->model->asArray()->findAll();
        $rd = [];
        foreach($rdata as $rs)
        {
            $rs['state'] = (is_null($rs['billId'])||strlen($rs['billId'])<1)?0:1;
            $rd[]=(object)$rs;
        }
		$data['rsdata']	= $rd;
		$data['fields'] = setting()->get('Corp.fields');
		$data['actions']= $this->dconfig->actions;
		$data['condActDet']= $this->dconfig->condActDet;
		$data['allowimport']= $this->dconfig->importallowed;
		$data['allowADD']= $this->dconfig->addAllowed;
		$data['isplainText']= TRUE;
		echo $this->_render('datalist',$data);
    }

    public function getDetCorp()
    {
        //cek keabsahan data
        if (isset($_GET['ids'])) 
		{
			$ids = $_GET['ids'];
		}else{
			$this->session->setFlashdata('warning','INVALID REQUEST');
			return redirect()->to(base_url(),301);
		}
		// 
		if(is_hex($ids))
		{
			$cid = decrypt($ids);
		}else{
			$this->session->setFlashdata('warning','ILEGAL REQUEST');
			return redirect()->to(base_url(),301);
		}

        $data = $this->data;
		
		$dtbill =  $this->model->find($cid)->toarray();
		
		$resFields = setting()->get('Corp.ResumeFields');
		//AMBIL DATA BILLING
		if(is_null($dtbill['billId'])||strlen($dtbill['billId'])<1 || $dtbill['billId']=="NOT SET")
		{
			//BILING BELUM DIBUAT
			unset($resFields['issued']);
			$dtbill['amount'] = "N/A";
			$state = 0;
			$Keys = setting()->get('Corp.primarykey');
		}else{
			//ambil data billing
			$billModel = model(\Modules\Billing\Models\BillModel::class);
			$bill = $billModel->find($dtbill['billId']);
			 
			$dtbill['amount'] = "IDR " .format_angka($bill->amount - $bill->diskon);
			$dtbill['issued'] = format_date($bill->issued);
			$state = 1;
			$Keys = setting()->get('Corp.BillKeys');
		}		
		//RESUME DATA
		$data['resume']['field'] = $resFields;
		$data['resume']['data'] = $dtbill;
		$data['resume']['subtitle'] = "Detail Data Billing";//.$addTitle;
		 
		//AMBIL DATA KURIKULUM MEMILIKI PROJEK ATAU TIDAK
		//$addOnAct = $this->dconfig->panelAct;
		
	    $opsi1 = setting()->get('Siswa.opsi');
	    $opsi2 = setting()->get('Rombel.opsi');
	//	$data['addOnACt'] = $this->dconfig->detAddOnACt;
	//	$dtmember = $this->model->getAll(['a.roomid'=>$id]);
		$siswaModel = model(\Modules\Siswa\Models\SiswaModel::class);
		$dtmember = $siswaModel->getAll(['b.sumber_info'=>$cid],false);
		$qty = count($dtmember);
		$data['resume']['data']['tagihan']=$qty * 100000;
		$data['rsdata']	= $dtmember;
		$data['msg'] 	= "";
		$data['isplainText'] = false;
		$data['key'] 	= setting()->get('Siswa.primarykey');
		$data['keys'] 	= $Keys;
		$data['opsi']   = array_merge($opsi1, $opsi2);
		$data['fields'] = setting()->get('Datadik.fields');
		$data['condAddOnAct']= setting()->get('Corp.panelAct');
		$data['dataStated'] = $state;
		echo $this->_render('frmdatalist',$data);
    }

	function editView($ids)
	{
		$id = decrypt($ids); 
		$data=$this->data;
		$rs =  $this->model->find($id)->toarray();
		$data['error']  = [];
		$data['fields'] = $this->dconfig->editfields;
		$data['rsdata'] = $rs;
		echo $this->_render('form',$data);
	}

	function editAction($ids): RedirectResponse
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		$roles = $rules = $this->dconfig->roles;
		
		if ($this->validate($roles)) {
			
			//$this->model->update($id, $data);
			$data = $this->request->getPost();
		//	test_result($data);
			$rsdata= new \Modules\Billing\Entities\Corp();
			$rsdata->fill($data);
			$simpan = $this->model->update($id, $rsdata);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil diperbaharui');
			}else{
				$this->session->setFlashdata('warning','Data gagal diperbaharui');
			}
			
			return redirect()->to(base_url('bill/corporate'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}

    public function mkcorpBill()
    {
		//cek keabsahan data
        if (isset($_GET['ids'])) 
		{
			$ids = $_GET['ids'];
		}else{
			$this->session->setFlashdata('warning','INVALID REQUEST');
			return redirect()->to(base_url(),301);
		}
		// 
		if(is_hex($ids))
		{
			$cid = decrypt($ids);
		}else{
			$this->session->setFlashdata('warning','ILEGAL REQUEST');
			return redirect()->to(base_url(),301);
		}

		//ambil data Corporate
		$dtbill =  $this->model->find($cid)->toarray();
		//ambil jumlah peserta
		$parm = ['b.sumber_info'=>$cid, 'd.komponen'=>0];
		$siswaModel = model(\Modules\Siswa\Models\SiswaModel::class);
		$price = $siswaModel->getSpecial($parm, $dtbill['created_at']);
	//	test_result($price);
		//Hitung Total Tagihan
		$amount = 0; $desc = [];
		foreach($price as $P)
		{
			$j = $P['qty'] * $P['harga'];
			$amount +=$j;
			$unit = $P['unit']; $jenis = $P['jns_bayar'];
			$desc[]="Biaya ".$P['nm_program']." ".$P['nm_prodi']." untuk ".$P['qty']." orang @ Rp.".format_angka($P['harga']);
		}
		
		if($jenis == 1)
		{
			//cek keberadaan bill
			$billModel = model(\Modules\Billing\Models\BillModel::class);
			if($billModel->is_exist(['nipd'=>$cid]))
			{
				$this->session->setFlashdata('warning','Data Sudah ada di sistem');
				return redirect()->to(base_url('bill'));
			}
		}

		//persiapan menampilkan data : 'id', 'nipd', 'issued', 'due_date', 'amount', 'coupon'
	//	$amount = $price['qty']*$price['amount'];
		$rsdata['name'] 	= $dtbill['corporate_name'];
		$rsdata['issued'] 	= $dtbill['created_at']->toDateString();
		$rsdata['amount'] 	= "IDR. ".format_angka($amount);
		$rsdata['coupon']	= "";
		$rsdata['deskripsi']= implode('##>',$desc);
	//	test_result($rsdata);
		$data = $this->data;
		$data['title']	= "Pembuatan Coorporate Billing";
		$data['fields']  = setting()->get('Billing.field2');
		$data['rsdata']  = $rsdata;
		$data['error']  = [];
		$data['hidden']	= ['nipd'=>encrypt($cid), "amount"=>(string)$amount, 'biltype'=>'c', 'useNotif'=>"yes", 'unit'=>$unit];
		echo $this->_render('form',$data);
    }

	function printBill()
	{
		//cek keabsahan data
        if (isset($_GET['ids'])) 
		{
			$ids = $_GET['ids'];
		}else{
			$this->session->setFlashdata('warning','INVALID REQUEST');
			return redirect()->to(base_url(),301);
		}
		// 
		if(is_hex($ids))
		{
			$cid = decrypt($ids);
		}else{
			$this->session->setFlashdata('warning','ILEGAL REQUEST');
			return redirect()->to(base_url(),301);
		}
		//ambil data billing
		$rs =  $this->model->find($cid)->toarray();
		//test_result($rs);
		$billID = encrypt($rs['billId']);
		return redirect()->to(base_url('bill/print?ids='.$billID), null, 'refresh');
	}
}
