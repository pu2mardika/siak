<?php

namespace Modules\Account\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\RedirectResponse;
use Modules\Account\Models\AccPeriodModel;
use Config\Services;
use Config\MyApp;

class AccPeriod extends BaseController
{
    protected $dconfig;
	protected $session;
	protected $theme;
	
    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Account\Config\AccPeriod::class);
        $this->session = \Config\Services::session();
		$this->model = new AccPeriodModel();	
		
		$this->data['site_title'] = 'PERIODE AKUNTASI';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['opsi'] 	  = $this->dconfig->opsi;
		$this->data['key']		  = $this->dconfig->primarykey;
	//	$this->theme = $this->data[]
		helper(['cookie', 'form','date']);
    }
	
	function index()
	{
	//	$this->cekHakAkses('read_data');
		$dtakunperiod = $this->model->findAll();
		$data = $this->data;
		$data['title']	= "Manajemen Data Periode Akuntansi";
		$data['rsdata']	= $dtakunperiod;
		$data['msg'] 	= "";
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['actions']= $this->dconfig->actions;
		$data['allowimport']= $this->dconfig->importallowed;
		 
		echo view($this->theme.'datalist',$data);
		
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
		//$data['addONJs'] = "akunperiod.init()";
		//test_result($data);
		echo view($this->theme.'form',$data);
	}
	
	public function addAction(): RedirectResponse
	{
		$rules = $this->dconfig->roles;
		if ($this->validate($rules)) {
			$data = $this->request->getPost();
			//$akunperiodmodel = new AccPeriod();
			//test_result($data);
			$akunperiod= new \Modules\Account\Entities\AccPeriod();
			$akunperiod->fill($data);
			$simpan = $this->model->insert($akunperiod,false);
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('akunperiod'));
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
	//	$data['addONJs'] = "akunperiod.init()";
		echo view($this->theme.'form',$data);
		
	}
	
	public function updateAction($ids)
	{
		$rules = $this->dconfig->roles;
		if ($this->validate($rules)) {
			$data = $this->request->getPost();
			$id = decrypt($ids); 
			$akunperiod= new \Modules\Account\Entities\AccPeriod();
			$akunperiod->fill($data);
			$simpan = $this->model->update($id, $akunperiod);
			 
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil diperbaharui');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('akunperiod'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function delete($ids){
		$id = decrypt($ids); 
		//$akunperiodmodel = new AccPeriod();
		$this->model->delete($id);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('akunperiod'));
	}
}
