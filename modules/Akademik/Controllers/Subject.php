<?php

namespace Modules\Akademik\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use Config\Services;
use Config\MyApp;
use Modules\Akademik\Models\SubjectModel;
use Modules\Akademik\Models\KurikulumModel;

class Subject extends BaseController
{
    public  $keys='';
    protected $dconfig;
	protected $session;
	protected $theme;
	protected $model;
	protected $skl_model ;

    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Akademik\Config\Subject::class);
        $this->session = \Config\Services::session();
		$this->model = new SubjectModel;	
        $this->curr_model = new KurikulumModel;
		$this->data['site_title'] = 'Halaman Subject';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['key']		  = $this->dconfig->primarykey;
		$this->data['allowimport']		  = $this->dconfig->importallowed;
       // $this->addStyle (base_url().'/css/personal.css');
		//$this->addStyle ('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
		helper(['cookie', 'form']);
    }
	
	function index()
	{
	
		$kurikulum 	= $this->model->findAll();
		$data = $this->data;
		$data['title']		 = "Manajemen Mata Pelajaran";
		$data['rsdata']		 = $kurikulum;
		$data['msg'] 		 = "";
        $data['isplainText'] = TRUE;
		$data['opsi'] 		 = $this->dconfig->opsi;
        $data['opsi']['currId'] 	= $this->curr_model->getDropdown();
		$data['actions']	 = $this->dconfig->actions;
		$data['addOnACt']    = $this->dconfig->addOnACt;
		echo view($this->theme.'datalist',$data);
    }
	
	/**
	* Diakses dari controller yang lain sebagai viewcell sehingga return nya adalah string.
	* @param $currID
	* 
	* @return
	*/
	public function showList($currID):string
	{ 
		$id=(is_array($currID))?$currID['currId']:$currID;
		$dtview['strdelimeter'] =setting('Subject.arrDelimeter');
		$dtview['fields'] = $this->dconfig->fields;
		$dtview['id'] 	  = $id;
		$dtview['aksi']	  = ['main'=>'gmapel', 'addOn'=>'subject'];
		$dtview['isplainText'] = TRUE;
		$dtview['key']	  = setting('Subject.primarykey');
		$dtview['opsi']	  = $this->curr_model->getLevel($id);
		$dtview['dtview'] = $this->model->getSubject($id);
		$dtview['title']  = "Daftar Mata Pelajaran";
		$dtview['actions']= setting('Subject.actions');
		$dtview['addOnACt'] = setting('Subject.addOnACt');
		return view($this->theme.'cells/dlist',$dtview);
	}
	
	function addView($id=0)
	{
		$this->cekHakAkses('create_data');
		$fields = $this->dconfig->fields;
		$form = $this->theme.'form';
		$data	=$this->data;
		$data['useCKeditor'] = true;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['currId'] = $this->curr_model->getDropdown();
		if($id <> 0){
			$fields 			= $this->dconfig->fields;
			$data['opsi'] 		= $this->curr_model->getLevel($id);
			$data['hidden']		= ['currId'=>$id];
			$form 				= $this->theme.'ajxform';
			$data['useCKeditor']= true;
			$data['rtarget']	= "#skl-content";
		}
		$data['title']	= "Tambah Data Subject";
		$data['error'] = [];// validation_list_errors();
		$data['fields'] = $fields;
		$data['rsdata'] = [];
		echo view($form, $data);
	}
	
	function addAction($id=0): RedirectResponse
	{
		$rules = $this->dconfig->roles;	
		if ($this->validate($rules)) {
			$dataSubject = $this->request->getPost();
			$dataSubject['id']=$dataSubject['currId'];
			//$data['id']=$data['id_skl'];
			//test_result($data);
			$SubjectModel = new SubjectModel();
			$Subject= new \Modules\Akademik\Entities\Subject();
			$Subject->fill($dataSubject);
			$simpan = $SubjectModel->insert($Subject,false);
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			if($id == 0){
				return redirect()->to(base_url('skl'));
			}else{
				return redirect()->to(base_url('skl/showList'));
			}
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function updateView($ids)
	{
		$this->cekHakAkses('update_data');
		$idn = decrypt($ids); 
		
		$id = explode(setting('Subject.arrDelimeter'),$idn); //$id[0]= id_skl, $id[1] = id curr
		//test_result($id);
		$data   = $this->data;
		$form   = $this->theme.'form';
		$fields = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
        $data['opsi']['currId'] 	= $this->curr_model->getDropdown();
        
		if(count($id)>1){
			$fields 			= $this->dconfig->fields2;
			$data['opsi'] 		= $this->curr_model->getLevel($id[1]);
			$data['hidden']		= ['currId'=>$id[1]];
			$form 				= $this->theme.'ajxform';
			$data['useCKeditor']= true;
			$data['rtarget']	= "#skl-content";
		} 
		
		$data['title']	= "Update Data Subject";
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
			$model = new SubjectModel();

			$rsdata = new \Modules\Akademik\Entities\Subject();
			$rsdata->fill($data);
			$simpan = $model->update($id, $rsdata);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			
			return redirect()->to(base_url('skl'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}

	function delete($ids){
		$id = decrypt($ids); 
		$Subjectmodel = new SubjectModel();
		$Subjectmodel->delete($id);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('skl'));
	}
}
