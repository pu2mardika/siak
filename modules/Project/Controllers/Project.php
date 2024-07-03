<?php

namespace Modules\Project\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use Config\Services;
use Config\MyApp;
use Modules\Project\Models\DataProjectModel;
use Modules\Akademik\Models\KurikulumModel;

class Project extends BaseController
{
    public  $keys='';
    protected $dconfig;
	protected $session;
	protected $theme;
	protected $model;
	protected $curr_model ;

    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Project\Config\DataProject::class);
        $this->session = \Config\Services::session();
		$this->model = new DataProjectModel;	
        $this->curr_model = new KurikulumModel;
		$this->data['site_title'] = 'Halaman Projek';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['key']		  = $this->dconfig->primarykey;
		$this->data['allowimport']= $this->dconfig->importallowed;
		helper(['cookie', 'form']);
    }
	
	function index()
	{
		$rsData 	= $this->model->findAll();
		$data = $this->data;
		$data['title']		 = "Manajemen Dimensi Project";
		$data['rsdata']		 = $rsData;
		$data['msg'] 		 = "";
        $data['isplainText'] = TRUE;
		$data['opsi'] 		 = $this->dconfig->opsi;
        $data['opsi']['curr_id'] 	= $this->curr_model->getDropdown();
		$data['actions']	 = $this->dconfig->actions;
		$data['addOnACt']    = $this->dconfig->addOnACt;
		$data['ajxAction']   = $this->dconfig->ajxAction;
		echo view($this->theme.'datalist',$data);
    }
	
		
	function addView()
	{
		$this->cekHakAkses('create_data');
		$fields = $this->dconfig->fields;
		$form = $this->theme.'form';
		$data	=$this->data;
		$data['useCKeditor'] = false;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['curr_id'] = $this->curr_model->getDropdown();
		$data['title']	= "Tambah Dimensi Project";
		$data['error'] = [];// validation_list_errors();
		$data['fields'] = $fields;
		$data['rsdata'] = [];
		echo view($form, $data);
	}
	
	function addAction(): RedirectResponse
	{
		$rules = $this->dconfig->roles;	
		if ($this->validate($rules)) {
			$rsData = $this->request->getPost();
			$Model = new DataProjectModel();
			$dEntity = new \Modules\Project\Entities\DataProject();
			$dEntity->fill($rsData);
			$simpan = $Model->insert($dEntity,false);
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('project'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function updateView($ids)
	{
		$this->cekHakAkses('update_data');
		$idn = decrypt($ids); 
		
		$id = explode(setting('Gmapel.arrDelimeter'),$idn); //$id[0]= grup_id, $id[1] = id curr
		
		$data   = $this->data;
		$form   = $this->theme.'form';
		$fields = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
        $data['opsi']['curr_id']     = $this->curr_model->getDropdown();
		if(count($id)>1){
			unset($fields['curr_id']);
			$data['hidden']		= ['curr_id'=>$id[1]];
			$form 				= $this->theme.'ajxform';
			$data['useCKeditor']= true;
			$data['rtarget']	= "#mapel-content";
		} 
		
		$data['title']	= "Update Data Grup Mata Pelajaran";
		$data['error'] = validation_list_errors();
		$data['fields'] = $fields;
		
		$rs =  $this->model->find($id[0])->toarray();
		$data['rsdata'] = $rs;
        $data['useCKeditor'] = true;
		echo view($form,$data);
	}
	
	function updateAction($ids): RedirectResponse
	{
		$id = decrypt($ids); 
		$roles = $rules = $this->dconfig->roles;
		
		if ($this->validate($roles)) {
			
			//$this->model->update($id, $data);
			$data = $this->request->getPost();
			
			$Model = new DataProjectModel();
			$rsdata = new \Modules\Project\Entities\DataProject();
			$rsdata->fill($data);
			$simpan = $Model->update($id, $rsdata);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			
			return redirect()->to(base_url('project'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}

	function delete($ids){
		$idn = decrypt($ids); 
		$id = explode(setting('Subject.arrDelimeter'),$idn); //$id[0]= subject id, $id[1] = id curr  
		$Model = new DataProjectModel();
		$Model->delete($id[0]);
		// masuk database
		//$this->session->setFlashdata('sukses','Data telah dihapus');
		//return redirect()->to(base_url('skl'));
		echo show_alert("Data Telah di Hapus","Sukses");
		if($id == 0){
			return redirect()->to(base_url('project'));
		}else{
			$idx =  encrypt($id[1]);
			return redirect()->to(base_url('kurikulum/detail/'.$idx));
		}
	}
}
