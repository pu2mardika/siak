<?php

namespace Modules\Account\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\RedirectResponse;
use Modules\Account\Models\AkungrupModel;
use Config\Services;
use CodeIgniter\Files\File;
use Config\MyApp;

class GrupAcc extends BaseController
{
    protected $dconfig;
	protected $session;
	protected $theme;
	
    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Account\Config\Akungrup::class);
        $this->session = \Config\Services::session();
		$this->model = new AkungrupModel;	
		
		$this->data['site_title'] = 'Manajemen Data Akungrup';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['opsi'] 	  = $this->dconfig->opsi;
		$this->data['key']		  = $this->dconfig->primarykey;
	//	$this->theme = $this->data[]
		helper(['cookie', 'form','date']);
    }
	
	function index()
	{
	//	$this->cekHakAkses('read_data');
		$dtakungrup = $this->model->findAll();
	//	$dtakungrup = $this->model->getall($parm);
	//	$total = $this->model->total();
		$data = $this->data;
		$data['title']	= "Manajemen Data Akungrup";
		$data['rsdata']	= $dtakungrup;
	//	$data['total']	= $total;
		$data['msg'] 	= "";
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['actions']= $this->dconfig->actions;
		$data['allowimport']= $this->dconfig->importallowed;
		 
		echo view($this->theme.'datalist',$data);
		
    }
	
	function detail($ids)
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		$data=$this->data;
		$data['title']	= "Update Data Akungrup";
		$data['error'] = validation_list_errors();
		$data['fields'] = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
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
		$data['title']	= "Tambah Data Grup Akun";
		$fields = $this->dconfig->fields;
		$data['error'] = [];
		$data['fields'] = $fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['rsdata'] = [];
		//$data['addONJs'] = "akungrup.init()";
		//test_result($data);
		echo view($this->theme.'form',$data);
	}
	
	public function addAction(): RedirectResponse
	{
		$rules = $this->dconfig->roles;
		if ($this->validate($rules)) {
			$data = $this->request->getPost();
			$akungrupmodel = new AkungrupModel();
			//test_result($data);
			$akungrup= new \Modules\Account\Entities\akungrup();
			$akungrup->fill($data);
			$simpan = $akungrupmodel->insert($akungrup,false);
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('akungrup'));
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
		$data['title']	= "Update Data Grup Akun";
		$data['error'] = [];
		$data['fields'] = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$rs =  $this->model->find($id)->toarray();
		$data['rsdata'] = $rs;
	//	$data['addONJs'] = "akungrup.init()";
		echo view($this->theme.'form',$data);
		
	}
	
	public function updateAction($ids)
	{
		$rules = $this->dconfig->roles;
		if ($this->validate($rules)) {
			$data = $this->request->getPost();
			$akungrupmodel = new AkungrupModel();
			$id = decrypt($ids); 
			$akungrup= new \Modules\Account\Entities\akungrup();
			$akungrup->fill($data);
			$simpan = $akungrupmodel->update($id, $akungrup);
			 
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil diperbaharui');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('akungrup'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function delete($ids){
		$id = decrypt($ids); 
		$akungrupmodel = new AkungrupModel();
		$akungrupmodel->delete($id);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('akungrup'));
	}
	
	function importView()
	{
		$data = $this->data;
		$data['title']	= "Import Data Grup Akun";
		$data['error'] = validation_list_errors();
		$data['u_ri']  = base_url('akungrup/tempxls');
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
				$this->session->setTempdata('dtakungrup',$Data,120);
				return redirect()->to(base_url('akungrup/konfirm'));
	         }

	         $data = ['errors' => 'The file has already been moved.'];
			
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	public function simpanmasal($act = 0) {
		$DATA = $this->session->getTempdata('dtakungrup');
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
			$model = new AkungrupModel();
			$simpan = $model->insertBatch($DATA['rsdata']);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('akungrup'));
		} 
		
		//$nilai $act = nol
		if($act === $DATA['actN']){
			//hapus data dari sesi
			unset($_SESSION['dtakungrup']);
			$this->session->setFlashdata('warning','Data Dibatalkan oleh Pengguna');
			return redirect()->to(base_url('akungrup'));
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
		$nama_file = 'temp_dataAkungrup';
		$fn = $excel->write_data($nama_file,$headf,$data);
				
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($fn);
	    $writer->save($dirf.$nama_file.'.xlsx');;
       // header("Content-Type: application/vnd.ms-excel");
        return $this->response->download($dirf.$nama_file.'.xlsx', null);
	}
	
	/*
	function dtlist()
	{
	 	$request = Services::request(); 
        $m_jur 		= new AkungrupModel();
		$akungrup 			= $m_jur->findAll();
		$total 			= $m_jur->total();
		
        foreach($akungrup as $doc)
        {
        	//$no++;
        	$doc['aksi']="<a href='#' class='btn-warning btn-sm'>Ubah</a>&nbsp; <a href='#' class='btn-danger btn-sm'>Hapus</a>";
        	$ndata[]=$doc;
        }	
        
		 $output = [
            'draw' => $request->getPost('draw'),
            'recordsTotal' => $total,
            'recordsFiltered' => 9, //$datatable->countFiltered(),
            'data' => $ndata
        ];
		
		dd($akungrup);
        echo json_encode($output);
	}
	*/
}
