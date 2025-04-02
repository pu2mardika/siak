<?php

namespace Modules\Billing\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;
use CodeIgniter\Files\File;
use Config\MyApp;
use Modules\Billing\Models\BillModel;
use chillerlan\QRCode\{QRCode, QROptions};
use Picqer;

class Bill extends BaseController
{
    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Billing\Config\Billing::class);
        $this->session = \Config\Services::session();
		$this->model = new BillModel;	
		$this->data['site_title'] = 'Manajemen Biling';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['opsi'] 	  = $this->dconfig->opsi;
		$this->data['key']		  = $this->dconfig->primarykey;
		$this->DELIMETER 		  = setting()->get('Billing.arrDelimeter');
		helper(['cookie', 'form']);
    }

    public function index()
    {
        $data= $this->data;
        $data['title']	= "DAFTAR BILING";
		$rsdata = [];
		
		foreach($this->model->getAll([]) as $rs)
		{
			$ids = $rs->id;
			$r['id'] = $ids;
			$r['billId'] = decrypt($ids);
			$r['nipd']= $rs->nama." (".$rs->nipd.")";
			$r['deskripsi'] = $rs->deskripsi;
			$r['issued'] = formatTgl($rs->issued);
			$r['amount'] = format_angka($rs->amount-$rs->coupon);
			$r['diskon'] = format_angka($rs->coupon);
			$rsdata[]=(object)$r;
		}
		//test_result($rsdata);
		$data['rsdata']	= $rsdata;
		$data['actions']= $this->dconfig->actions;
		$data['allowimport']= $this->dconfig->importallowed;
		echo view($this->theme.'datalist',$data);
    }

	public function getSiswa($key="")
	{
		$siswaModel = model(\Modules\Siswa\Models\SiswaModel::class);
		$data = $siswaModel->getPDlike($key);
		echo json_encode($data);
		
	}

    public function AddNew()
    {
		$this->cekHakAkses('create_data');
    //    $this->addStyle(base_url().'vendors/easyautocomplate/easy-autocomplete.css');
	//	$this->addStyle(base_url().'vendors/easyautocomplate/easy-autocomplete.themes.css');
		$this->addJs (base_url().'js/modules/billing.js?r=' . time());
		$data=$this->data;
		$fields = $this->dconfig->addFields;
		$data['title']	= "Tambah Data Billing";
		$data['error']  = [];//validation_list_errors();
		$data['fields'] = $fields;
		$data['rsdata'] = [];
		$data['hidden']	= ['biltype'=>'p', 'useNotif'=>"yes", 'j'=>"yes"];
		$data['addONJs'] = "billing.init()";
		echo view($this->theme.'form',$data);
    }

    function addAction(): RedirectResponse
	{
		$rules = $this->dconfig->roles;
		//'id', 'nipd', 'issued', 'deskripsi', 'due_date', 'amount', 'diskon', 'biltype'
		if ($this->validate($rules)) {
			$rdata = $this->request->getPost();
			$jnsByr = (array_key_exists('jns_bayar',$rdata))?$rdata['jns_bayar']:1;
			if($jnsByr==1)
			{
				//cek keberadaan bill
				if($this->model->is_exist(['nipd'=>$rdata['nipd']]))
				{
					$this->session->setFlashdata('warning','Data Sudah ada di sistem');
					return redirect()->to(base_url('bill'));
				}
			}

			$data = $rdata;
			unset($data['useNotif']);
		
			$data['id'] = $this->setId();
			$data['nipd'] = (is_hex($rdata['nipd']))?decrypt($rdata['nipd']):$rdata['nipd'];
			$harga = $rdata['amount'];
			//ambil nilai cupon:
			$coupon = $rdata['diskon'];
			$CouponModel = model(\Modules\Billing\Models\CoupponModel::class);
			$Coupon = $CouponModel->where('code', $coupon)->find();

			if(count($Coupon)>0){
				$disc = ($Coupon[0]->disc_type === 'fl')?$harga * $Coupon[0]->discont / 100:$Coupon[0]->discont;
			}else{
				$disc = 0;
			}
			
			$status = ($rdata['useNotif']=='Noo')?1:0;  // 0 = blm aktif, 1 = aktif, 2 = lunas
			$data['diskon']=$disc;
			$data['status']=$status;
		//	$data['unit']=$status;
			//test_result($data);
			$MODEL = new BillModel();
			$rs= new \Modules\Billing\Entities\Bill();
			$rs->fill($data);
			$simpan = $MODEL->insert($rs,false); 
		//	$simpan = TRUE;
			if($simpan){
				//update data
				if($rdata['biltype']=="c")
				{
					//update billing id pada corporateBill
					$corpModel = new \Modules\Billing\Models\CorpModel();
					$rsbill= new \Modules\Billing\Entities\Corp();
					$rsbill->fill(['billId'=>$data['id']]);
					$R = $corpModel->update($data['nipd'], $rsbill); 
				}

				//CATAT BILLING DATA KE JURNAL TANPA NOTIFIKASI atau DENGAN NOTIF
				if($rdata['useNotif']=="yes"){				
					$notifdata['deskripsi'] = $data['deskripsi'];
					$notifdata['aksi'] = 'bill/acc';
					$notifdata['param'] = $data['id'];
					$notifModel = new \Modules\Account\Models\NotifyModel();
					$notify = new \Modules\Account\Entities\Notify();
					$notify->fill($notifdata);
					$notifModel->insert($notify);
				}

				/*PENCATATAN KE JURNAL*/
				if($rdata['useNotif']=="Noo"){		
					if(($harga-$disc)>0){
						$deskripsi = $data['deskripsi']." dengan Nomor Billing: ".$data['id'].
									" atas nama ".$data['nipd']." sebesar Rp".format_angka($harga) ;
						$rdata = ['issued'=>$data['issued'], 'deskripsi'=>$deskripsi,'amount'=>$harga, 'diskon'=>$disc] ;
						$this->akunAct($rdata);
					}
				}
				$this->session->setFlashdata('warning',"Data berhasil disimpan");
				return redirect()->to(base_url('bill/print?ids='.encrypt($data['id'])));
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
				return redirect()->to(base_url('bill'));
			}
			
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}

	function PrintBill()
	{
		//echo $this->theme;die();	
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
			$bill_ID = decrypt($ids);
		}else{
			$this->session->setFlashdata('warning','ILEGAL REQUEST');
			return redirect()->to(base_url(),301);
		}
	//	test_result($bill_ID);
		$data['company']['name']=setting('MyApp.companyName');
		$data['company']['address1']=setting('MyApp.address1');
		$data['company']['address2']=setting('MyApp.address2');
		$data['company']['desa']=setting('MyApp.desa');
		$data['company']['kecamatan']=setting('MyApp.kecamatan');
		$data['company']['city']=setting('MyApp.city');
		$data['company']['postal']=setting('MyApp.postalcode');
		$data['company']['phone']=setting('MyApp.phone');
		$data['company']['email']=setting('MyApp.primary_contact_email');
		$data['company']['website']=setting('MyApp.website');
		$data['company']['mobile']=setting('MyApp.mobile');
		$data['company']['npwp']=setting('MyApp.npwp');
		$image ='images/' . setting('MyApp.logo');
		$data['company']['logo'] 	= base_url($image);
		$data['company']['locus'] 	= setting('MyApp.locus');
		//ambil data billing
		$BILL = $this->model->find($bill_ID)->toarray();
		//ambil data penerima billing sesuai type billing
		if($BILL['biltype']=="p"){
			$ModelPD = model(\Modules\Siswa\Models\SiswaModel::class);
			$dbill = $ModelPD->get($BILL['nipd']);
		//	test_result($reciver);
			$reciver['name']=$dbill['nama'];
			$reciver['nik']="NIK. ".$dbill['nik'];
			$reciver['alamat']=$dbill['alamat'];
			$reciver['nohp']=$dbill['nohp'];
			$BILL['regID']=$dbill['idreg'];
			$BILL['accID']=$dbill['noinduk'];
		}elseif($BILL['biltype']=='c'){
			$ModelCorp = model(\Modules\Billing\Models\CorpModel::class);
			$cbill = $ModelCorp->find($BILL['nipd'])->toarray();
			$reciver['cp']=$cbill['contact_person'];
			$reciver['name']=$cbill['corporate_name'];
			$reciver['alamat']=$cbill['alamat'];
			$reciver['nohp']=$cbill['nohp'];
			$BILL['regID']=$BILL['nipd'];
		}
	//	test_result($reciver);
		$BILL['id'] = decrypt($BILL['id']);
		$data['reciver'] = $reciver;
		$data['billing'] = $BILL;
		$dtbarcode =$BILL['id'];
		$dtQr = base_url('bill/print?ids='.$ids);
		$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
		$data['qrcode'] = '<img src="'.(new QRCode)->render($dtQr).'" alt="QR Code" height="150" width="150" />';
        $barcode   = $generator->getBarcode($dtbarcode, $generator::TYPE_CODE_128_B);
        $data['barcode'] = '<img src="data:image/png;base64,'. base64_encode($barcode).'" alt="Barcode" width="98%"/>';
		$data['user'] = $this->data['user'];
		
		$html =  view('Modules\Billing\Views\print_bill',$data);
		//echo $html; 
		
		$fname = "BILL_".$BILL['id'].".pdf";
		$this->makePdf($html, $fname);
		
	}

    function editView($ids)
	{
		$id = decrypt($ids); 
		$data=$this->data;
		
		$rs =  $this->model->find($id)->toarray();
	//	$data['hidden']	= ['id'=>$ids];
		$data['error']  = [];
		$data['fields'] = $this->dconfig->fields;
		$data['rsdata'] = $rs;
		echo view($this->theme.'form',$data);
	}

	function editAction($ids): RedirectResponse
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		$roles = $rules = $this->dconfig->roles;
		
		if ($this->validate($roles)) {
			
			//$this->model->update($id, $data);
			$data = $this->request->getPost();
			$data['code'] = strtoupper($data['code']);
		//	test_result($data);
			$rsdata= new \Modules\Billing\Entities\Bill();
			$rsdata->fill($data);
			$simpan = $this->model->update($id, $rsdata);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil diperbaharui');
			}else{
				$this->session->setFlashdata('warning','Data gagal diperbaharui');
			}
			
			return redirect()->to(base_url('bill'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function delete($ids){
		$id = decrypt($ids); 
		$rs =  $this->model->find($id)->toarray();
		$this->model->delete($id);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('bill'));
	}

	//BARIS KODE AKUNTANSI
	public function akunView($ids)
	{
		$id = explode(date('Dz')."H",decrypt($ids));  //id[0] = id billing --- id[1]=> id notif
		
		$rs1 = $rs =  $this->model->getArray($id[0]); //menemukan data bill personal
		//hapus notif jika bernilai null
		if(is_null($rs1)){
			//mencoba mendapatkan data dari corporate bil$)
			$rs = $this->model->getCorpBill($id[0]);
			if(is_null($rs)){
				$this->session->setFlashdata('konfirm',"Data tidak ditemukan dan direkomendasi untuk dihapus dari sistem");
				return redirect()->to(base_url('notify'));
			}
		}

		//test_result($rs);

		$notifModel = new \Modules\Account\Models\NotifyModel();
		$notif = $notifModel->find($id[1])->toarray();	 
				
		$deskripsi = $notif['deskripsi'];
		
		$tgl= getTgl($rs['issued']);
		$harga = $rs['amount'];
		$diskon = $rs['diskon'];
		
		$data			= $this->data;
		$data['title']	= "Kanfirmasi Pembukuan atas Pembuatan Billing";
		$rsdata['deskripsi'] = $deskripsi." dengan Nomor Billing: ".$id[0]." atas nama ".$rs['nama']." sebesar Rp".format_angka($harga) ;
		$rsdata['tagihan']	 = format_angka($harga);
		$rsdata['discont']	 = format_angka($diskon);
		$rsdata['jumlah']	 = format_angka($harga-$diskon);
		$rsdata['tanggal']	 = format_date($tgl);
		
		//gabung data menjadi 1 dengan delimeter
		
		$dtscreet = [$id[1],$id[0],$tgl,$harga,$diskon,$rs['unit']];
		$screet = implode($this->DELIMETER,$dtscreet);

		$data['fields'] = $this->dconfig->fieldAkun;
		$data['rsdata'] = $rsdata;
		$data['confirm_desc'] = "Berdasarkan data dan bukti transaksi yang ada, transaksi tersebut sah untuk dicatat dan dibukukan";
		$data['act'] = base_url('bill/acc'); //INGAT GANTI DISINI ACTIONNYA
		$data['hidden'] = ['screat' => encrypt($screet), 'deskripsi'=>$deskripsi];
		echo view($this->theme.'frm2konfirm',$data); 
	}
	
	public function akunAct()
	{
		$df = $this->request->getPost();
		//ambil data dari hidden data
		if(is_hex($df['screat']))
		{
			$ds = explode($this->DELIMETER,decrypt($df['screat']));
			//result: 0->notifID, 1->Bill_ID, 2->tgl, 3->harga, 4->diskon, 5->unit
			$rs=['bill_ID'=>$ds[1], 'tgl'=>$ds[2], 'pendapatan'=>$ds[3], 'diskon'=>$ds[4]];
		}else{
			$this->session->setFlashdata('warning','ILEGAL REQUEST');
			return redirect()->to(base_url(),301);
		}
		
		if(key_exists('confirm',$df) && $df['confirm']==1)
		{
			//INDUK : tanggal`, `deskripsi`, `no_bukti`, `amount`
			$induk['tanggal'] 	= $ds[2];
			$induk['deskripsi'] = $df['deskripsi'];
			$induk['no_bukti'] 	= $ds[1];
			$induk['amount'] 	= $ds[3];
			
			$rs['piutang'] = $ds[3]-$ds[4];
			//DETAIL : `kode_akun`, `debet`, `kredit`, `indek`		
			//ambil data systemAkun
			$SysAccModel = new \Modules\Account\Models\SysAccModel();
			$SAM = $SysAccModel->getDropdown();
			
			//ambil akunBB
			$akunBB = $this->dconfig->akunBB;
			
			$detail=[]; $i = 0;
			foreach($akunBB as $k => $det)
			{
				//input yang nilainya lebih dari NOL
				if($rs[$k] > 0){
					$D = ($det=='d')?$rs[$k]:0; 
					$K = ($det=='c')?$rs[$k]:0; 

					$dts['kode_akun'] = $SAM[$k."_".$ds[5]];
					$dts['debet'] = $D;
					$dts['kredit'] = $K;
					$dts['indek'] = $i;
					$i++;
					$detail[]=$dts;
				}
			}
			
			//simpan ke akuntansi
			$glModel = new \Modules\Account\Models\JournalModel();
			//$gl = new \Modules\Account\Entities\Journal();
			$saveGl = $glModel->setJurnal($induk,$detail);
			
			if($saveGl){		
				//update data billing
				$billModel = new BillModel();
				$rsBill= new \Modules\Billing\Entities\Bill();	
				$rsBill->fill(['status' => 1]);
				
				if($billModel->update($ds[1], $rsBill))
				{
					//update data notify
					$notifModel = new \Modules\Account\Models\NotifyModel();
					
					$simpan = $notifModel ->delete($ds[0]);
					
					if($simpan){
						$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
					}else{
						$this->session->setFlashdata('warning','Data gagal disimpan');
					}
				}
			}
		}else{
			$this->session->setFlashdata('warning','Transaksi ditolak');
		}
		return redirect()->to(base_url('notify'));
	}
	
	//BATAS BARIS KODE AKUNTANSI

	private function setId()
    {
        return  date('ymdhi').strtoupper(random_string('alpha',2));
       // return $this;
    } 

	private function makePdf($html, $fname="Raport")
	{
		$options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', TRUE);
        $options->set('enable_remote', TRUE);
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper("A4", "potrait");
        $dompdf->render();        
		$dirf 		 = setting()->get('MyApp.pdftmpDir');
		$path 		 = setting()->get('MyApp.pdfPath_Dir');     
		$hsl= $dompdf->output();
		file_put_contents($path.$fname, $hsl);
		$fn = base_url($dirf.$fname);
		$Data=$this->data;
        $Data['file_pdf'] = $fn;
        echo view($this->theme.'viewfile',$Data);
	}
}
