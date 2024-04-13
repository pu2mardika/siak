<?php

namespace Modules\Account\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\RedirectResponse;
use Modules\Account\Models\JournalModel;
//use Modules\Account\Models\AccountModel;
use Config\Services;
use CodeIgniter\Files\File;
use Config\MyApp;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Dompdf\Dompdf;
use chillerlan\QRCode\{QRCode, QROptions};
use chillerlan\QRCode\Output\QROutputInterface;
use chillerlan\QRCode\Data\QRMatrix;


class Journal extends BaseController
{
    public  $keys='';
	protected $dconfig;
	protected $session;
	protected $theme;
	protected $model;
	protected $accModel ;
	
    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Account\Config\Journal::class);
        $this->session = \Config\Services::session();
		$this->model = new JournalModel;	
		$this->accModel 		  = model('Modules\Account\Models\AccountModel');
		$this->data['site_title'] = 'Manajemen Data Journal';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['opsi'] 	  = $this->dconfig->opsi;
		$this->data['key']		  = $this->dconfig->primarykey;
	//	$this->theme = $this->data[]
		helper(['cookie', 'form','date', 'bootbox']);
		$this->addJs (base_url().'/js/jquery.easy-autocomplete.min.js?r=' . time());
		$this->addJs (base_url().'/js/bootbox.min.js?r=' . time());
    }
	
	function index()
	{
	//	$this->cekHakAkses('read_data');
		$dtaccount = $this->model->findAll();
		$data = $this->data;
		$data['title']	= "Manajemen Data Journal";
		$data['rsdata']	= $dtaccount;
		$data['msg'] 	= "";
		$data['opsi'] 	= $this->dconfig->opsi;
		$dt= $this->model->idTrx(date("Y-m-d"));
		test_result($dt);
		//$data['opsi']['grup_akun'] 	= $this->accModel->getDropdown();
		$data['actions']= $this->dconfig->actions;
		$data['allowimport']= $this->dconfig->importallowed;
		echo view($this->theme.'datalist',$data);
    }
    
    public function adrevenue()
    {
    	$this->cekHakAkses('create_data');	
		$data	=$this->data;
	
		$tmpModel = model('Modules\Account\Models\TmpGlModel');
		$data['title']	= "PENERIMAAN KAS";
		
		//AMBIL TEMP DATA
		$uid = $data['user']['id'];
		//$rdata = $tmpModel->where('uid', $uid)->asArray()->findAll();
		$rdata = $tmpModel->getData($uid);
		$sesId = $this->session->session_id;
		
		$actData = [];
		$actfield = $this->dconfig->fields;
		$data['error']  = [];
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['accId'] 	= $this->accModel->getDropdown();
		$data['hidden'] = ['uid' => $uid, 'activity'=>'othrev'];
		if(count($rdata) > 0){
			$actData = $rdata[0];
			$data['hidden']['jnstrx']=$actData['jnstrx'];
			$actfield = $this->dconfig->actFields;
			$actData['djnstrx'] = $data['opsi']['jnstrx'][$actData['jnstrx']];
			$actData['amount'] = 0;
			
			$ur_i = 'gleger/konfirm/'.$sesId;
			$data['finalAction'] = ['icon'=>'save','src'=>$ur_i, 'label'=>'Simpan'];
			$data['addONJs'] = "$('#btnfinal').click(function(){load('".$ur_i."','#xcontent');});";
			$data['mode'] ='ajax';
			$data['subtotal'] = format_angka($tmpModel->getTotal($uid));
		}
		//ACTION FORM
		$data['actionform']['fields'] 	= $actfield;
		$data['actionform']['data'] 	= $actData;
		$data['actionform']['btnAction'] = ['icon'=>'plus-circle', 'label'=>'Lanjut'];
		
		//detail 
		$data['act'] = base_url('gleger/konfirm');
		$data['keys'] = 'id';
		$data['fields'] = $this->dconfig->fdtList ;
		$data['rsdata'] = $rdata;
		$data['addOnACt'] = $this->dconfig->addOnACt;
		$data['dataTable'] = FALSE;
		
		echo view($this->theme.'frmdatalist',$data);
    }
    
    function addCashOut()
    {
    	$this->cekHakAkses('create_data');	
		$data	=$this->data;
	
		$tmpModel = model('Modules\Account\Models\TmpGlModel');
		$data['title']	= "PENGELUARAN KAS";
		
		//AMBIL TEMP DATA
		$uid = $data['user']['id'];
		//$rdata = $tmpModel->where('uid', $uid)->asArray()->findAll();
		$rdata = $tmpModel->getData($uid);
		$sesId = $this->session->session_id;
		
		$actData = [];
		$actfield = $this->dconfig->fields;
		$data['error']  = [];
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['accId'] 	= $this->accModel->getDropdown();
		$data['hidden'] = ['uid' => $uid, 'activity'=>'cashout'];
		if(count($rdata) > 0){
			$actData = $rdata[0];
			$data['hidden']['jnstrx']=$actData['jnstrx'];
			$actfield = $this->dconfig->actFields;
			$actData['djnstrx'] = $data['opsi']['jnstrx'][$actData['jnstrx']];
			$actData['amount'] = 0;
			
			$ur_i = 'gleger/konfirm/'.$sesId;
			$data['finalAction'] = ['icon'=>'save','src'=>$ur_i, 'label'=>'Simpan'];
			$data['addONJs'] = "$('#btnfinal').click(function(){load('".$ur_i."','#xcontent');});";
			$data['mode'] ='ajax';
			$data['subtotal'] = format_angka($tmpModel->getTotal($uid));
		}
		//ACTION FORM
		$data['actionform']['fields'] 	= $actfield;
		$data['actionform']['data'] 	= $actData;
		$data['actionform']['btnAction'] = ['icon'=>'plus-circle', 'label'=>'Lanjut'];
		
		//detail 
		$data['act'] = base_url('gleger/konfirm');
		$data['keys'] = 'id';
		$data['fields'] = $this->dconfig->fdtList ;
		$data['rsdata'] = $rdata;
		$data['addOnACt'] = $this->dconfig->addOnACt;
		$data['dataTable'] = FALSE;
		
		echo view($this->theme.'frmdatalist',$data);
    }
	
	public function setTempGl(): RedirectResponse
	{
		$rules = $this->dconfig->roles;
		if ($this->validate($rules)) {
			$data = $this->request->getPost();	
			$data['id'] = $data['uid'].date("ymdhis");
			
			$TmpModel = new \Modules\Account\Models\TmpGlModel();;
			//test_result($data);
			$tmpData= new \Modules\Account\Entities\TmpGl();
			$tmpData->fill($data);
			$simpan = $TmpModel->insert($tmpData,false);
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			$route='gleger/'.$data['activity'];
			return redirect()->to(base_url($route));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	public function addAction($id): RedirectResponse
	{
		$sesId = $this->session->session_id;
		$uid = $this->data['user']['id'];
		$tmpModel = model('Modules\Account\Models\TmpGlModel');
		//$rdata = $tmpModel->where('uid', $uid)->asArray()->findAll();
		$rdata = $tmpModel->getData($uid);
		
		if ($sesId == $id && count($rdata)>0) {
			$rs = $rdata[0];
			$total = $tmpModel->getTotal($uid);
			//Ambil data akun BB
			$BB = service('settings')->get('Journal.akunBB');
			
			//mendata INDUK : `tanggal`, `deskripsi`, `no_bukti`, `amount`
			$induk = ['tanggal'=>$rs['tanggal'], 'deskripsi'=>$rs['deskripsi'], 'no_bukti'=>$rs['no_bukti'],'amount'=>$total,];
			show_result($induk);
			show_result($rs);
			
			//DETAIL : `kode_akun`, `debet`, `kredit`, `indek`		
			//ambil data systemAkun
			$SysAccModel = model('Modules\Account\Models\SysAccModel');
			$SAM = $SysAccModel->getDropdown();
			//ambil data
			$acc = $BB[$rs['activity']]['accID'][$rs['jnstrx']];
			$pos = $BB[$rs['activity']]['pos'];
			if($pos=="Db")
			{
				$i = 0 ; $n = 1;
				$db = $total;
				$kr = 0;
			}else{
				$i = count($rdata); $n = 0;
				$db = 0;
				$kr = $total;
			}
			$detail[$i] = ['kode_akun'=>$SAM[$acc], 'debet'=>$db, 'kredit'=>$kr, 'indek'=>$i];
			
			//mengisikan data detail 
			foreach($rdata as $k => $dt)
			{
				$db = ($pos=='Db')?0:$dt['amount'];
				$kr = ($pos=='Db')?$dt['amount']:0;
				$detail[$n] = ['kode_akun'=>$dt['accId'], 'debet'=>$db, 'kredit'=>$kr, 'indek'=>$n];
				$n++;
			}
			
			//simpan ke akuntansi
			$glModel = new \Modules\Account\Models\JournalModel();
			//$gl = new \Modules\Account\Entities\Journal();
			$saveGl = $glModel->setJurnal($induk,$detail);
			
			if($saveGl){
				//menghapus tempJurnal
				$TmpModel = new \Modules\Account\Models\TmpGlModel();
				$TmpModel->where('uid', $uid)->delete();
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			$notice['msg']="Data telah berhasil disimpan";
			$notice['ur_i']="gleger/".$rs['activity'];
			$notice['state']="success";
		//	return redirect()->to(base_url('akun'));
		}else{
			$notice['msg']="Data tidak valid dan gagal  disimpan";
			$notice['ur_i']="gleger/".$rs['activity'];
			$notice['state']="warning";
		//	return redirect()->back()->withInput()->with('errors', "Data Tidak Valid dan Gagal disimpan");
		}
		return redirect()->to(base_url('gleger/fup'))->with('notice', $notice);
	}
	
	function followUP()
	{
		$notice = $this->session->getFlashdata('notice');
		$message = $notice['msg'];
		$state = $notice['state'];
		$tite = ($state == 'success')?"Berhasil....":"Oops";
		$rest = '<script>
	 			 swal("'.$tite.'", "'.$message.'","'.$state.'")
	 			 var timer = setTimeout(function() {
	 			 	window.location.replace("'.base_url($notice['ur_i']).'")
	 			 }, 5000);
				 </script>';
		echo $rest;
	}
	
	function delete($ids){
		$id = decrypt($ids); 
		$TmpModel = new \Modules\Account\Models\TmpGlModel();;
		$TmpModel->delete($id);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		//return redirect()->to(base_url('akun'));
		return redirect()->back()->with('sukses','Data telah dihapus');
	}
	
	//ALL ABOUT NERACA AWAL
	public function viewNa()
	{
		$this->cekHakAkses('read_data');
		$acc = $this->AccPeriode();
		$tglAwal = $acc['awal'];
		//$tglAkh  = (is_null($acc['akhir']))?date("Y-m-d"):$acc['akhir'];
		
		$Model = model('Modules\Account\Models\NawalModel');
		$parm = ['tanggal >=' => $tglAwal];
		$rdata = $Model->getData($parm);
		//$rdata = $Model->where('tanggal', $tglAwal)->findAll();
		//test_result($rdata);
		$data = $this->data;
		$data['fields'] = $this->dconfig->BSListField;
		$data['title']	= "Manajemen Data Neraca Awal";
		$data['rsdata']	= $rdata;
		$data['msg'] 	= "";
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['kode_akun'] 	= $this->accModel->getDropdown();
		$data['actions']= $this->dconfig->actions;
		$data['allowimport']= $this->dconfig->importallowed;
		echo view($this->theme.'datalist',$data);
	}
	
	function addNAwView()
	{
		$this->cekHakAkses('create_data');	
		$data	=$this->data;
		//$tmpModel = model('Modules\Account\Models\TmpGlModel');
		
		$data['title']	= "Tambah Data Neraca Awal";
		$fields = $this->dconfig->balanceFields;
		//unset($fields['nama_akun']);
		$data['error'] = [];
		$data['fields'] = $fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['kode_akun'] 	= $this->accModel->getDropdown();
		$data['rsdata'] = [];
		echo view($this->theme.'form',$data);
	}
	
	
	public function addNrAction(): RedirectResponse
	{
		$rules = $this->dconfig->roleBS;
		if ($this->validate($rules)) {
			$data = $this->request->getPost();
			$BsModel = new \Modules\Account\Models\NawalModel();;
			$tmpData= new \Modules\Account\Entities\Nawal();
			$tmpData->fill($data);
			$simpan = $BsModel->insert($tmpData,false);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('gleger/nrawal'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function updateView($ids)
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		$roles = $rules = $this->dconfig->roleEdit;
		$data=$this->data;
		$data['title']	= "Update Data Neraca Awal";
		$data['error'] = [];
		$data['fields'] = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['grup_akun'] 	= $this->accModel->getDropdown();
		$rs =  $this->model->find($id)->toarray();
		$data['rsdata'] = $rs;
		$data['addONJs'] = "account.init()";
		echo view($this->theme.'form',$data);
		
	}
	
	public function updateAction($ids)
	{
		$rules = $this->dconfig->roles;
		if ($this->validate($rules)) {
			$data = $this->request->getPost();
			$accountmodel = new JournalModel();
			$id = decrypt($ids); 
			$account= new \Modules\Account\Entities\account();
			$account->fill($data);
			$simpan = $accountmodel->update($id, $account);
			 
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil diperbaharui');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('akun'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	
	/**
	* ================================================================================================
	* REPORT ZONE 
	* @return
	* ================================================================================================
	*/
	
	function glView()
	{
		$GLeger = $this->getJurnal();
		$rsdata = $GLeger['rsdata'];
		
		$awal = $GLeger['periode']['awal'];
		$akhir = $GLeger['periode']['akhir'];
		$now = date("Y-m-d");
		//$subtitle = ($now < $akhir)?$now:$akhir;
		$subtitle = $akhir;
		
	//	$data['key'] 		= 'nik';
	//	$data['fields'] 	= $fields;
		$data['title_report']= "JURNAL UMUM";
		$data['subtitle']	= "Per ".format_date($subtitle);
		$data['rsdata']		= $rsdata;
		$data['opsi'] 		= $this->dconfig->opsi;
		$data['logo']		= $this->myconfig->base64Logo();
		$dtQR = base_url('report/capital');
		$data['qrcode'] 	= '<img src="'.(new QRCode)->render($dtQR).'" alt="QR Code" height="150" width="150" />';;
		
		//OTORISATOR<hr/>
		$group_name = setting('MyApp.bod')['group_name'];
		$jabatan = setting('MyApp.bod')['group_comp'];
		
		$data['otorisator'] = ['group_name'=>$group_name, 'komponen'=> getAuth(setting('Saham.bod'))];
		$data['validator'] 	= getAuth(setting('Saham.validator'));
		
		$filename = 'rpt_gleger';
		$html = view('Modules\Account\Views\glReport',$data);
		
		//echo $html;
		
		$pdf = new \App\Libraries\Pdfgenerator();
		$hsl = $pdf->create_pdf($html, $filename);
		
        //echo $hsl;
        $Data=$this->data;
        $Data['file_pdf'] = $hsl;
        echo view($this->theme.'viewfile',$Data);
	}
	
	public function bukuBesar()
	{
		$GLeger = $this->getDataBB();
		$rsdata = $GLeger['rsdata'];
		
		$awal = $GLeger['periode']['awal'];
		$akhir = $GLeger['periode']['akhir'];
		$now = date("Y-m-d");
		//$subtitle = ($now < $akhir)?$now:$akhir;
		$subtitle = $akhir;
		
	//	$data['key'] 		= 'nik';
	//	$data['fields'] 	= $fields;
		$data['title_report']= "BUKU BESAR";
		$data['subtitle']	= "Periode: ".format_date($awal)." s/d ".format_date($subtitle);
		$data['rsdata']		= $rsdata;
		$data['opsi'] 		= $this->dconfig->opsi;
		//$data['logo']		= $this->myconfig->base64Logo();
		$dtQR = base_url('report/capital');
		$data['qrcode'] 	= '<img src="'.(new QRCode)->render($dtQR).'" alt="QR Code" height="150" width="150" />';;
		
		//OTORISATOR<hr/>
		$group_name = setting('MyApp.bod')['group_name'];
		$jabatan = setting('MyApp.bod')['group_comp'];
		
		$data['otorisator'] = ['group_name'=>$group_name, 'komponen'=> getAuth(setting('Saham.bod'))];
		$data['validator'] 	= getAuth(setting('Saham.validator'));
		
		$filename = 'rptBBesar';
		$html = view('Modules\Account\Views\bbReport',$data);
		
		//echo $html;
		
		$pdf = new \App\Libraries\Pdfgenerator();
		$hsl = $pdf->create_pdf($html, $filename);
		
        //echo $hsl;
        $Data=$this->data;
        $Data['file_pdf'] = $hsl;
        echo view($this->theme.'viewfile',$Data);
        
	}
	
	function vNeracaSaldo()
	{
		$GLeger = $this->getSaldoBB();
		$rsdata = $GLeger['rsdata'];
		
		$awal = $GLeger['periode']['awal'];
		$akhir = $GLeger['periode']['akhir'];
		$now = date("Y-m-d");
		//$subtitle = ($now < $akhir)?$now:$akhir;
		$subtitle = $akhir;
		//AMBIL DATA SALDO dari REKANAN YNG ADA:
		//test_result($GLeger);	
	
		$data['title_report']= "NERACA SALDO";
		$data['subtitle']	= "PER ".format_date($subtitle);
		$data['fields'] 	= setting()->get('Journal.BSListField');;
		$data['rsdata']		= $rsdata;
		$data['total']		= $GLeger['total'];
		$data['hasTotal']	= setting()->get('Journal.rptBShasTot');
		$data['colspan'] 	= 0;
		//$data['logo']		= $this->myconfig->base64Logo();
		$dtQR = base_url('gleger/nsaldo');
		$data['qrcode'] 	= '<img src="'.(new QRCode)->render($dtQR).'" alt="QR Code" height="150" width="150" />';;
		
		//OTORISATOR<hr/>
		$group_name = setting('MyApp.bod')['group_name'];
		$jabatan = setting('MyApp.bod')['group_comp'];
		
		$data['otorisator'] = ['group_name'=>$group_name, 'komponen'=> getAuth(setting('Saham.bod'))];
		$data['validator'] 	= getAuth(setting('Saham.validator'));
		
		$filename = 'rptNeracaSaldo';
		$html = view($this->theme.'datareport',$data);
		
		//echo $html;
		
		$pdf = new \App\Libraries\Pdfgenerator();
		$hsl = $pdf->create_pdf($html, $filename);
		
        //echo $hsl;
        $Data=$this->data;
        $Data['file_pdf'] = $hsl;
        echo view($this->theme.'viewfile',$Data);
	}
	
	public function lrReport()
	{
		$GLeger = $this->getdtReport('lra');
		$rsdata = $GLeger['rsdata'];
		$gdata = $GLeger['opsi'];
		unset($gdata["component"]);
		//show_result($rsdata);
		//test_result($gdata);
		
		$awal = $GLeger['periode']['awal'];
		$akhir = $GLeger['periode']['akhir'];
		$now = date("Y-m-d");
		//$subtitle = ($now < $akhir)?$now:$akhir;
		$subtitle = $akhir;
	//	$data['key'] 		= 'nik';
	//	$data['fields'] 	= $fields;
		$data['title_report']= "Laporan Perhitungan SHU";
		$data['subtitle']	= "PER ".strtoupper(format_date($subtitle));
		$data['rsdata']		= $rsdata;
		$data['gdata'] 		= $gdata;
		//$data['logo']		= $this->myconfig->base64Logo();
		$dtQR = base_url('report/capital');
		$data['qrcode'] 	= '<img src="'.(new QRCode)->render($dtQR).'" alt="QR Code" height="150" width="150" />';;
		$data['periode'] 	= $GLeger['periode']; 
		//OTORISATOR<hr/>
		$group_name = setting('MyApp.bod')['group_name'];
		$jabatan = setting('MyApp.bod')['group_comp'];
		
		$data['otorisator'] = ['group_name'=>$group_name, 'komponen'=> getAuth(setting('Journal.bod'))];
		$data['validator'] 	= getAuth(setting('Journal.validator'));
		
		$filename = 'rptLRA';
		$html = view('Modules\Account\Views\lraReport',$data);
		
		//echo $html;
		
		$pdf = new \App\Libraries\Pdfgenerator();
		$hsl = $pdf->create_pdf($html, $filename, "A4");
		
        //echo $hsl;
        $Data=$this->data;
        $Data['file_pdf'] = $hsl;
        echo view($this->theme.'viewfile',$Data);
        
	}
	
	/**
	* ========================================================================================================================
	* PRIVAE FUNCTION 
	* ========================================================================================================================
	*/ 
	
	function getdtReport($type)
	{
		$rptType = setting()->get('Akungrup.FinReportAcc');
		
		$comp = $rptType[$type]['component'];
		//test_result($comp);
		
		$dtrpt = $this->getSaldoBB();
		$rdata = $dtrpt['rsdata'];
		$Res =[];
		foreach($rdata as $k =>$val)
		{
			if(in_array($val['gtype'],$comp)){
			//	$dt['kode_akun'] = $val['kode_akun'];
				$dt['nama_akun'] = $val['nama_akun'];
				$dt['norm_balance'] = $val['norm_balance'];
				$amount = ($dt['norm_balance']=='Db')?$val['debet']:$val['kredit'];
				$dt['amount'] = $amount;
				if($type == "balance"){
					$Res[$val['gtype']][$val['grup_akun']][$k]=$dt;
				}else{
					$Res[$val['gtype']][$k]=$dt;
				}		
			}
		}
		
		$result['periode']	= $dtrpt['periode'];
		$result['rsdata']	= $Res;
		$result['opsi']		= $rptType[$type];
		return $result;
	}
	
	private function getSaldoBB()
	{
		$gl = $this->getDataBB(FALSE);
		$rdata = $gl['rsdata'];
	//	test_result($gl);
		$Res=[]; $totDebet = 0; $totKredit = 0;
		foreach($rdata as $k =>$val)
		{
			unset($val['recSet']);$Debet="INVALID"; $Kredit ="INVALID";
			$Debet = ($val['norm_balance']=='Db' && $val['debet']>$val['kredit'])?$val['debet']-$val['kredit']:0;
			$Kredit = ($val['norm_balance']=='Kr' && $val['debet']<$val['kredit'])?$val['kredit']-$val['debet']:0;
			$val['debet'] = $Debet;
			$val['kredit'] = $Kredit;
			$Res[$k] = $val;
			$totDebet += $Debet;
			$totKredit += $Kredit;
		}	
		$result['periode']	= $gl['periode'];
		$result['rsdata']	= $Res;
		$result['total']	= ['debet'=>$totDebet, 'kredit'=>$totKredit];
		return $result;
	}
	
	private function getDataBB($ajp = true)
	{
		$acc = $this->AccPeriode();
		$tglAwal = $acc['awal'];
		$tglAkh  = (is_null($acc['akhir']))?date("Y-m-d"):$acc['akhir'];
		
	//	$gl = $this->model->where($parm)->findAll();
		$naModel = model('Modules\Account\Models\NawalModel');
		$Neraca_Awal = $naModel->getDropdown($tglAwal);
	 	
	 	
	 	$parm = ['tanggal >' => $tglAwal, 'tanggal <='=>$tglAkh, 'b.deskripsi <>'=>'Jurnal Penutup'];
	 	if($ajp){
	 		$parm = ['tanggal >' => $tglAwal, 'tanggal <='=>$tglAkh];
	 	}
		$detGl = $this->model->getDropdown($parm);
		//$AkunBB = $this->accModel->orderBy('kode_akun', 'ASC')->asArray()->findAll();
		$AkunBB = $this->accModel->getAkunBB();
		//test_result($AkunBB);
		//mengelompokkan data berdasarkan Kode Akun BB
		$Res = [];
		foreach($AkunBB as $PERK)
		{
			//ISI IDENTITAS
			$BB['gtype'] = $PERK['gtype'];
			$BB['grup_akun'] = $PERK['grup_akun'];
			$BB['nama_akun'] = $PERK['nama_akun'];
			$BB['kode_akun'] = $PERK['kode_akun'];
			$BB['norm_balance'] = $PERK['norm_balance'];
			
			//CEK SALDO AWAL
			$recSet = []; $DEBET = 0; $KREDIT = 0;
			if(array_key_exists($PERK['kode_akun'], $Neraca_Awal))
			{
				$rs = $Neraca_Awal[$PERK['kode_akun']];
				$DEBET += $rs['debet'];
				$KREDIT += $rs['kredit'];
				$rs['deskripsi'] = "Saldo Awal";
				$recSet[0]=$rs;
			}
			
			//Ambil data Jurnal
			if(array_key_exists($PERK['kode_akun'], $detGl))
			{
				$data = $detGl[$PERK['kode_akun']];
				if(count($data)>0)
				{
					foreach($data as $rec)
					{
						$rs['tanggal'] = getTgl($rec['tanggal']);
						$rs['deskripsi']= $rec['deskripsi'];
						$rs['debet']  = (float)$rec['debet'];
						$rs['kredit'] = (float)$rec['kredit'];
						$DEBET += $rs['debet'];
						$KREDIT += $rs['kredit'];
						$recSet[] = $rs;
					}
				}
			}
			
			if(count($recSet)>0)
			{
				$BB['recSet']   = $recSet;
				$BB['debet'] = $DEBET;
				$BB['kredit'] = $KREDIT;
				$Res[$PERK['kode_akun']]=$BB;
			}
		}
		$result['periode']['awal']=$tglAwal;
		$result['periode']['akhir']= $tglAkh;
		$result['rsdata']=$Res;
		//test_result($result);
		return $result;
	}
	
	private function getJurnal()
	{
		//ambil data jurnal
		$acc = $this->AccPeriode();
		$tglAwal = $acc['awal'];
		$tglAkh  = (is_null($acc['akhir']))?date("Y-m-d"):$acc['akhir'];
		
		$parm = ['tanggal >' => $tglAwal, 'tanggal <='=>$tglAkh];
	//	$gl = $this->model->where($parm)->findAll();
		
		$detGl = $this->model->getDetailGl($parm);
		
		//mengelompokkan data berdasarkan nomor bukti:
		$gl = []; $n = 0;
		foreach($detGl as $GL)
		{
			$gl[$GL['trx_id']]['tanggal'] = $GL['tanggal'];
			$gl[$GL['trx_id']]['no_bukti'] = $GL['no_bukti'];
			$gl[$GL['trx_id']]['deskripsi'] = $GL['deskripsi'];
			$debet = (float)$GL['debet'];
			$kredit = (float)$GL['kredit'];
			
			if($GL['debet']>0){
				$gl[$GL['trx_id']]['debet'][] = ['nama_akun'=>$GL['nama_akun'],'kode_akun'=>$GL['kode_akun'], 'debet'=>$debet, 'kredit'=>$kredit];
			}
			
			if($GL['kredit']>0){
				$gl[$GL['trx_id']]['kredit'][] = ['nama_akun'=>$GL['nama_akun'],'kode_akun'=>$GL['kode_akun'], 'debet'=>$debet, 'kredit'=>$kredit];
			}
		}
		
		$result['periode']['awal']=$tglAwal;
		$result['periode']['akhir']= $tglAkh;
		$result['rsdata']=$gl;
		//test_result($result);
		return $result;
	}
	
	private function AccPeriode()
	{
		$ppsModel = model('Modules\Account\Models\AccPeriodModel');
		$data = $ppsModel->orderBy('id', 'desc')->first()->toarray();
		return $data;
	}
	
	private function createQR($data)
	{
		$path = setting()->get('MyApp.qrPath_dir');
		$qrurl = setting()->get('MyApp.qrDirectory');
		
		$qrcode  = new QRCode;
		// set options after QRCode invocation
		$options = new QROptions;
		// $outputType can be one of: GDIMAGE_BMP, GDIMAGE_GIF, GDIMAGE_JPG, GDIMAGE_PNG, GDIMAGE_WEBP
		$options->outputType          = QROutputInterface::GDIMAGE_PNG;
		$options->quality             = 90;
		// the size of one qr module in pixels
		$options->scale               = 20;
		$options->bgColor             = [200, 150, 200];
		$options->imageTransparent    = true;
		// the color that will be set transparent
		// @see https://www.php.net/manual/en/function.imagecolortransparent
		$options->transparencyColor   = [200, 150, 200];
		$options->drawCircularModules = true;
		$options->drawLightModules    = true;
		$options->circleRadius        = 0.4;
		$options->keepAsSquare        = [
			QRMatrix::M_FINDER_DARK,
			QRMatrix::M_FINDER_DOT,
			QRMatrix::M_ALIGNMENT_DARK,
		];
	}
}
