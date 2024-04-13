<?php

namespace Modules\Akademik\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use Config\Services;
use Config\MyApp;
use Modules\Akademik\Models\ProdiModel;
use Modules\Akademik\Models\ProgramModel;

class Prodi extends BaseController
{
    public  $keys='';
    protected $dconfig;
	protected $session;
	protected $theme;
	protected $model;
	protected $progam_model ;

    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Akademik\Config\Prodi::class);
        $this->session = \Config\Services::session();
		$this->model = new ProdiModel;	
        $this->progam_model = new ProgramModel;
		$this->data['site_title'] = 'Halaman Prodi';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['key']		  = $this->dconfig->primarykey;
        $this->addStyle (base_url().'/css/personal.css');
		helper(['cookie', 'form']);
    }
	
	function index()
	{
		$this->cekHakAkses('read_data');
		
		$program 	= $this->model->findAll();
		$data = $this->data;
		$data['title']		= "Manajemen Program Pendidikan";
		$data['rsdata']		= $program;
		$data['msg'] 		= "";
        $data['isplainText'] = TRUE;
		$data['opsi'] 		= $this->dconfig->opsi;
        $data['opsi']['jurusan'] 	= $this->progam_model->getDropdown();
		$data['actions']	= $this->dconfig->actions;
		$data['allowimport']= $this->dconfig->importallowed;
		echo view($this->theme.'datalist',$data);
    }
	
	
	function addView()
	{
		$this->cekHakAkses('create_data');
		
		$data	=$this->data;
		$data['title']	= "Tambah Data Jenis Prodi";
		$fields = $this->dconfig->fields;
		$data['error'] = [];// validation_list_errors();
		$data['fields'] = $fields;
		$data['opsi'] 	= $this->dconfig->opsi;
        $data['opsi']['jurusan'] 	= $this->progam_model->getDropdown();
		$data['rsdata'] = [];
        $data['useCKeditor'] = true;
		echo view($this->theme.'form',$data);
	}

	function addAction(): RedirectResponse
	{
		$rules = $this->dconfig->roles;	
		if ($this->validate($rules)) {
			$data = $this->request->getPost();
			$Prodimodel = new ProdiModel();
			$Prodi= new \Modules\Akademik\Entities\Prodi();
			$Prodi->fill($data);
			$simpan = $Prodimodel->insert($Prodi,false);
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('prodi'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function updateView($ids)
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		 
		$data=$this->data;
		$data['title']	= "Update Data Jenis Prodi";
		$data['error'] = validation_list_errors();
		$data['fields'] = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
        $data['opsi']['jurusan'] 	= $this->progam_model->getDropdown();
		$rs =  $this->model->find($id)->toarray();
		$data['rsdata'] = $rs;
        $data['useCKeditor'] = true;
		echo view($this->theme.'form',$data);
	}
	
	function updateAction($ids): RedirectResponse
	{
		$id = decrypt($ids); 
		$roles = $rules = $this->dconfig->roles;
		
		if ($this->validate($roles)) {
			
			//$this->model->update($id, $data);
			$data = $this->request->getPost();
			$model = new ProdiModel();

			$rsdata = new \Modules\Akademik\Entities\Prodi();
			$rsdata->fill($data);
			$simpan = $model->update($id, $rsdata);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			
			return redirect()->to(base_url('prodi'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}

	function delete($ids){
		$id = decrypt($ids); 
		$Prodimodel = new ProdiModel();
		$Prodimodel->delete($id);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('prodi'));
	}
}
