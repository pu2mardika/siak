<?php

namespace Modules\Akademik\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use Config\Services;
use Config\MyApp;
use Modules\Akademik\Models\ProgramModel;

class Program extends BaseController
{
    public  $keys='';
    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Akademik\Config\Program::class);
        $this->session = \Config\Services::session();
		$this->model = new ProgramModel;	
		$this->data['site_title'] = 'Halaman Program';
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
		$data['title']		= "Manajemen Jenis Program Pendidikan";
		$data['rsdata']		= $program;
		$data['msg'] 		= "";
        $data['isplainText'] = TRUE;
		$data['opsi'] 		= $this->dconfig->opsi;
		$data['actions']	= $this->dconfig->actions;
		$data['allowimport']= $this->dconfig->importallowed;
		echo view($this->theme.'datalist',$data);
    }
	
	function dtlist()
	{
	 	$request = Services::request(); 
        $m_jur 		= new ProgramModel();
		$program 		= $m_jur->findAll();
		$total 			= $m_jur->total();
		
        foreach($program as $doc)
        {
        	$ndata[]=$doc;
        }	
        
		 $output = [
            'draw' => $request->getPost('draw'),
            'recordsTotal' => $total,
            'recordsFiltered' => 9, //$datatable->countFiltered(),
            'data' => $ndata
        ];
		
		dd($program);
		
        echo json_encode($output);
	}
	
	function addView()
	{
		$this->cekHakAkses('create_data');
		
		$data	=$this->data;
		$data['title']	= "Tambah Data Jenis Program";
		$fields = $this->dconfig->fields;
		$data['error'] = [];// validation_list_errors();
		$data['fields'] = $fields;
		$data['opsi'] 	= $this->dconfig->opsi;
        $data['useCKeditor'] = true;
		$data['rsdata'] = [];
		echo view($this->theme.'form',$data);
	}

	function addAction(): RedirectResponse
	{
		$rules = $this->dconfig->roles;	
		if ($this->validate($rules)) {
			$data = $this->request->getPost();
			$Programmodel = new ProgramModel();
			$Program= new \Modules\Akademik\Entities\Program();
			$Program->fill($data);
			$simpan = $Programmodel->insert($Program,false);
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('program'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function updateView($ids)
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		 
		$data=$this->data;
		$data['title']	= "Update Data Jenis Program";
		$data['error'] = validation_list_errors();
		$data['fields'] = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
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
			$model = new ProgramModel();

			$rsdata = new \Modules\Akademik\Entities\Program();
			$rsdata->fill($data);
			$simpan = $model->update($id, $rsdata);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			
			return redirect()->to(base_url('program'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}

	function delete($ids){
		$id = decrypt($ids); 
		$Programmodel = new ProgramModel();
		$Programmodel->delete($id);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('program'));
	}
	
}
