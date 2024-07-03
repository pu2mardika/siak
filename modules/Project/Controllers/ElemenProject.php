<?php

namespace Modules\Project\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use Config\Services;
use Config\MyApp;
use Modules\Project\Models\DimensiModel;
use Modules\Project\Models\ElemenModel;
//use Modules\Akademik\Models\KurikulumModel;

class ElemenProject extends BaseController
{
    public  $keys='';
    protected $dconfig;
	protected $session;
	protected $theme;
	protected $model;
	protected $skl_model ;

    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Project\Config\Elemen::class);
        $this->session = \Config\Services::session();
		$this->model = new ElemenModel;	
        $this->DimensiModel = new DimensiModel;
		$this->data['site_title'] = 'Halaman Gmapel';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['key']		  = $this->dconfig->primarykey;
		$this->data['allowimport']= $this->dconfig->importallowed;
		helper(['cookie', 'form']);
    }
	
	function index()
	{
		$dimensi 	= $this->model->findAll();
		$data = $this->data;
		$data['title']		 = "Manajemen Elemen Project";
		$data['rsdata']		 = $dimensi;
		$data['msg'] 		 = "";
        $data['isplainText'] = TRUE;
	//	$data['opsi'] 		 = $this->dconfig->opsi;
        $data['opsi']['dimensi_id'] = $this->DimensiModel->getDropdown();
		$data['actions']	 = $this->dconfig->actions;
		$data['addOnACt']    = $this->dconfig->addOnACt;
    //    test_result($data);
		echo view($this->theme.'datalist',$data);
    }
	
	function addView($ids=0)
	{
		$this->cekHakAkses('create_data');
		$fields = $this->dconfig->fields;
		$form = $this->theme.'form';
		$data	=$this->data;
		$data['useCKeditor'] = false;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['dimensi_id'] = $this->DimensiModel->getDropdown();
		if($ids <> 0){
			$idn = decrypt($ids); 
			$id = explode(setting('Elemen.arrDelimeter'),$idn); //$id[0]= grup_id, $id[1] = id curr
		//	test_result($id);
			unset($fields['dimensi_id']);
			$data['hidden']		= ['dimensi_id'=>$id[0]];
			$form 				= $this->theme.'ajxform';
			$data['useCKeditor']= false;
			$data['rtarget']	= "#project-content";
		}
		$data['title']	= "Tambah Elemen Project";
		$data['error'] = [];// validation_list_errors();
		$data['fields'] = $fields;
		$data['rsdata'] = [];
		echo view($form, $data);
	}
	
	function addAction($id=0): RedirectResponse
	{
		$rules = $this->dconfig->roles;	
		if ($this->validate($rules)) {
			$rsData = $this->request->getPost();
			$Model = new ElemenModel();
			$Project = new \Modules\Project\Entities\Elemen();
			$Project->fill($rsData);
			$simpan = $Model->insert($Project,false);
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			if($id == 0){
				return redirect()->to(base_url('elemen'));
			}else{
				return redirect()->to(base_url('kurikulum/showList'));
			}
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function updateView($ids)
	{
		$this->cekHakAkses('update_data');
		$idn = decrypt($ids); 
		
		$id = explode(setting('Elemen.arrDelimeter'),$idn); //$id[0]= grup_id, $id[1] = id curr
		//test_result($id);
		$data   = $this->data;
		$form   = $this->theme.'form';
		$fields = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
        $data['opsi']['dimensi_id']     = $this->DimensiModel->getDropdown();
		if(count($id)>1){
			unset($fields['dimensi_id']);
			$data['hidden']		= ['dimensi_id'=>$id[1]];
			$form 				= $this->theme.'ajxform';
			$data['useCKeditor']= true;
			$data['rtarget']	= "#project-content";
		} 
		
		$data['title']	= "Update Data Elemen Project";
		$data['error'] = validation_list_errors();
		$data['fields'] = $fields;
		
		$rs =  $this->model->find($id[0])->toarray();
		$data['rsdata'] = $rs;
      //  $data['useCKeditor'] = false;
		echo view($form,$data);
	}
	
	function updateAction($ids): RedirectResponse
	{
		$id = decrypt($ids); 
		$roles = $rules = $this->dconfig->roles;
		
		if ($this->validate($roles)) {
			
			//$this->model->update($id, $data);
			$data = $this->request->getPost();
			
			$model = new ElemenModel();
			$rsdata = new \Modules\Project\Entities\Elemen();
			
			$rsdata->fill($data);
			$simpan = $model->update($id, $rsdata);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			
			return redirect()->to(base_url('elemen'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}

	function delete($ids){
		$idn = decrypt($ids); 
		$id = explode(setting('Elemen.arrDelimeter'),$idn); //$id[0]= elemen id, $id[1] = id curr  
		$Model = new ElemenModel();
		$Model->delete($id[0]);
		// masuk database
		//$this->session->setFlashdata('sukses','Data telah dihapus');
		//return redirect()->to(base_url('skl'));
		echo show_alert("Data Telah di Hapus","Sukses");
		if($id == 0){
			return redirect()->to(base_url('elemen'));
		}else{
			$idx =  encrypt($id[1]);
			return redirect()->to(base_url('kurikulum/detail/'.$idx));
		}
	}
}
