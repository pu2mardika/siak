<?php

namespace Modules\Account\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\RedirectResponse;
use Modules\Account\Models\AccountModel;
use Modules\Account\Models\AkungrupModel;
use Config\Services;
use CodeIgniter\Files\File;
use Config\MyApp;

class Account extends BaseController
{
    public  $keys='';
	protected $dconfig;
	protected $session;
	protected $theme;
	protected $model;
	protected $grupModel ;
	
    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Account\Config\Account::class);
        $this->session = \Config\Services::session();
		$this->model = new AccountModel;	
		$this->grupModel = model('Modules\Account\Models\AkungrupModel');
		$this->data['site_title'] = 'Manajemen Data Account';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['opsi'] 	  = $this->dconfig->opsi;
		$this->data['key']		  = $this->dconfig->primarykey;
	//	$this->theme = $this->data[]
		helper(['cookie', 'form','date']);
	//	$this->addJs (base_url().'/js/modules/account.js?r=' . time());
		$this->addJs (base_url().'/js/jquery.easy-autocomplete.min.js?r=' . time());
	//	$this->addJs (base_url().'/js/modules/account.js?r=' . time());
    }
	
	function index()
	{
	//	$this->cekHakAkses('read_data');
		$dtaccount = $this->model->orderBy('kode_akun', 'ASC')->findAll();
	//	test_result($dtaccount);
	//	$dtaccount = $this->model->getall($parm);
		$data = $this->data;
		$data['title']	= "Manajemen Data Account";
		$data['rsdata']	= $dtaccount;
		$data['msg'] 	= "";
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['grup_akun'] 	= $this->grupModel->getDropdown();
		$data['actions']= $this->dconfig->actions;
		$data['allowimport']= $this->dconfig->importallowed;
		echo view($this->theme.'datalist',$data);
    }
	
	function detail($ids)
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		$data=$this->data;
		$data['title']	= "Update Data Account";
		$data['error'] = validation_list_errors();
		$data['fields'] = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['grup_akun'] 	= $this->grupModel->getDropdown();
		$rs =  $this->model->find($id);
		$tglLahir = $rs->tgllahir;
		$rsdata = $rs->toarray();
		//$rsdata['tgllahir']=$tglLahir->toDateTimeString();
		$rsdata['tgllahir']=$tglLahir->toDateString();
		$data['rsdata'] = $rsdata;
	//	show_result($rsdata);
		echo view($this->theme.'vdetail',$data);
	}
	
	
	function addView()
	{
		$this->cekHakAkses('create_data');	
		$data	=$this->data;
		
		$data['title']	= "Tambah Data Account";
		$fields = $this->dconfig->fields;
		$data['error'] = [];
		$data['fields'] = $fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['grup_akun'] 	= $this->grupModel->getDropdown();
		$data['rsdata'] = [];
		//$data['addONJs'] = "account.init()";
		//test_result($data);
		echo view($this->theme.'form',$data);
	}
	
	public function addAction(): RedirectResponse
	{
		$rules = $this->dconfig->roles;
		if ($this->validate($rules)) {
			$data = $this->request->getPost();
			$accountmodel = new AccountModel();
			//test_result($data);
			$account= new \Modules\Account\Entities\account();
			$account->fill($data);
			$simpan = $accountmodel->insert($account,false);
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('akun'));
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
		$data['title']	= "Update Data Account";
		$data['error'] = [];
		$data['fields'] = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['grup_akun'] 	= $this->grupModel->getDropdown();
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
			$accountmodel = new AccountModel();
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
	
	function delete($ids){
		$id = decrypt($ids); 
		$accountmodel = new AccountModel();
		$accountmodel->delete($id);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('akun'));
	}
	
	function importView()
	{
		$data = $this->data;
		$data['title']	= "Import Data Account";
		$data['error'] = validation_list_errors();
		$data['u_ri']  = base_url('akun/tempxls');
		echo view($this->theme.'frmImport',$data);
	}
	
	function fromxlsx(){
		$this->cekHakAkses('create_data');
		$validationRule  =[
			'userfile' => ['uploaded[userfile]'],
		];
		
		if ($this->validate($validationRule)) {
			
			 $xlsx = $this->request->getFile('userfile');
			 if ($xlsx->isValid() && ! $xlsx->hasMoved()) {
	             // Get random file name
				$newName = $xlsx->getRandomName();
				// Store file in public/csvfile/ folder
				
				
				$myconfig = new MyApp;
				$dirf = $myconfig ->tmpfile_dir;
				$filepath = $this->myconfig->tmpfile_dir;
				
				//echo $type; 
				$xlsx->move($filepath, $newName);
				
				$inputFileName = $filepath.$newName;
				$excel = new \App\Libraries\Exc_lib();
				$rsdata = $excel->read_data_xlsx($inputFileName);
				helper('text');
				$Data['actY'] = random_string('md5',32);
				$Data['actN'] = random_string('alnum',12);
				$Data['rsdata'] = $rsdata;
				//Konfirmasi data
				$this->session->setTempdata('dtaccount',$Data,120);
				return redirect()->to(base_url('akun/konfirm'));
	         }

	         $data = ['errors' => 'The file has already been moved.'];
			
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	public function simpanmasal($act = 0) {
		$DATA = $this->session->getTempdata('dtaccount');
		//test_result($Data);
		//$nilai $act = nol
		if($act === 0){
			//tampilkan ke browser
			$Data = $this->data;
			$data = array_merge($Data,$DATA);
			$data['title'] = "Konfirmasi Data!";
		//	test_result($data);
			echo view($this->theme.'list2konfirm',$data);
		}
		
		if($act === $DATA['actY']){
			$model = new AccountModel();
			$simpan = $model->insertBatch($DATA['rsdata']);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('akun'));
		} 
		
		//$nilai $act = nol
		if($act === $DATA['actN']){
			//hapus data dari sesi
			unset($_SESSION['dtaccount']);
			$this->session->setFlashdata('warning','Data Dibatalkan oleh Pengguna');
			return redirect()->to(base_url('akun'));
		}
	}
	
	function tmpobyek()
	{
		$excel = new \App\Libraries\Exc_lib();
		$myconfig = new MyApp;
		$dirf = $myconfig ->tmpfile_dir;
		
		$filepath = $this->myconfig->tmpfile_dir;
		$headf = [];
		$fields= $this->dconfig->fields;
		foreach ($fields as $k => $v){
			$headf[]=$k;
			$rowdata[$k]=$v['label'];
		}
		$data[] = $rowdata;
		$nama_file = 'temp_dataAccount';
		$fn = $excel->write_data($nama_file,$headf,$data);
				
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($fn);
	    $writer->save($dirf.$nama_file.'.xlsx');;
       // header("Content-Type: application/vnd.ms-excel");
        return $this->response->download($dirf.$nama_file.'.xlsx', null);
	}
}
