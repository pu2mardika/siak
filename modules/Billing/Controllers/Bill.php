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
		helper(['cookie', 'form']);
    }

    public function index()
    {
        $data= $this->data;
        $rs = $this->model->findAll();
        $rsData =[];
        foreach($rs as $r){
            $rsd=$r;
            $rsd->discont = ($r->disc_type=="fx")?"Rp. ".format_angka($r->discont):format_angka($r->discont)."%";
            $rsData[]=$rsd;
        }
        $data['title']	= "DAFTAR BILING";
		$data['rsdata']	= $rsData;//$this->model->findAll();
		$data['actions']= $this->dconfig->actions;
		$data['allowimport']= $this->dconfig->importallowed;
		echo view($this->theme.'datalist',$data);
    }

    function letView()
	{
		$this->cekHakAkses('create_data');	
		if($this->session->getFlashdata('rsData'))
		{
			$data			= $this->data;
			$rsdata 		= $this->session->getFlashdata('rsData');
			$data['title']	= "Membuat Billing";
			$data['error'] 	= [];
			$data['fields'] = $this->dconfig->fields;
			$data['opsi'] 	= $this->dconfig->opsi;
			$data['rsdata'] = $rsdata;
			$data['hidden'] = ['nik' => $rsdata['nik']];
			echo view($this->theme.'form',$data);
		}else{
			$this->session->setFlashdata('warning','Aksi atau tindakan yang dilakukan tidak sah!!!');
			return redirect()->to(base_url('bill'));
		}
	}

    public function AddNew()
    {
		$this->cekHakAkses('create_data');
        $this->addStyle(base_url().'vendors/easyautocomplate/easy-autocomplete.css');
		$this->addStyle(base_url().'vendors/easyautocomplate/easy-autocomplete.themes.css');
		$data=$this->data;
		$data['title']	= "Tambah Data Billing";
		$data['error']  = [];//validation_list_errors();
		$data['fields'] = $this->dconfig->fields;
		$data['rsdata'] = [];
		echo view($this->theme.'form',$data);
    }

    function addAction(): RedirectResponse
	{
		$rules = $this->dconfig->roles;
		
		if ($this->validate($rules)) {
			$data = $this->request->getPost();
			$data['code'] = strtoupper($data['code']);
			$MODEL = new BillModel();
			$rs= new \Modules\Billing\Entities\Bill();
			$rs->fill($data);
			$simpan = $MODEL->insert($rs,false); 
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('billing'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
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
			
			return redirect()->to(base_url('billing'));
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
		return redirect()->to(base_url('billing'));
	}
}