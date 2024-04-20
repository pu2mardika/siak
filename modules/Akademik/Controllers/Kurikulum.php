<?php

namespace Modules\Akademik\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use Config\Services;
use Config\MyApp;
use Modules\Akademik\Models\KurikulumModel;
use Modules\Akademik\Models\ProdiModel;

class Kurikulum extends BaseController
{
    public  $keys='';
    protected $dconfig;
	protected $session;
	protected $theme;
	protected $model;
	protected $prodi_model ;

    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Akademik\Config\Kurikulum::class);
        $this->session = \Config\Services::session();
		$this->model = new KurikulumModel;	
        $this->prodi_model = new ProdiModel;
		$this->data['site_title'] = 'Halaman Kurikulum';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['key']		  = $this->dconfig->primarykey;
		$this->data['allowimport']		  = $this->dconfig->importallowed;
        $this->addStyle (base_url().'/css/personal.css');
		$this->addStyle ('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
		helper(['cookie', 'form']);
    }
	
	function index()
	{
	
		$kurikulum 	= $this->model->findAll();
		$data = $this->data;
		$data['title']		= "Manajemen Kurikulum";
		$data['rsdata']		= $kurikulum;
		$data['msg'] 		= "";
        $data['isplainText'] = TRUE;
		$data['opsi'] 		= $this->dconfig->opsi;
        $data['opsi']['id_prodi'] 	= $this->prodi_model->getDropdown();
		$data['actions']	= $this->dconfig->actions;
		$data['addOnACt']= $this->dconfig->addOnACt;
		echo view($this->theme.'datalist',$data);
    }
	
	
	function addView()
	{
		$this->cekHakAkses('create_data');
		
		$data	=$this->data;
		$data['title']	= "Tambah Data Kurikulum";
		$fields = $this->dconfig->fields;
		$data['error'] = [];// validation_list_errors();
		$data['fields'] = $fields;
		$data['opsi'] 	= $this->dconfig->opsi;
        $data['opsi']['id_prodi'] 	= $this->prodi_model->getDropdown();
		$data['rsdata'] = [];
        $data['useCKeditor'] = true;
		echo view($this->theme.'form',$data);
	}

	function addAction(): RedirectResponse
	{
		$rules = $this->dconfig->roles;	
		if ($this->validate($rules)) {
			$data = $this->request->getPost();
			$data['id']=$data['id_prodi'];
			$Kurikulummodel = new KurikulumModel();
			$Kurikulum= new \Modules\Akademik\Entities\Kurikulum();
			$Kurikulum->fill($data);
			$simpan = $Kurikulummodel->insert($Kurikulum,false);
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('kurikulum'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function updateView($ids)
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		 
		$data=$this->data;
		$data['title']	= "Update Data Kurikulum";
		$data['error'] = validation_list_errors();
		$data['fields'] = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
        $data['opsi']['id_prodi'] 	= $this->prodi_model->getDropdown();
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
			$model = new KurikulumModel();

			$rsdata = new \Modules\Akademik\Entities\Kurikulum();
			$rsdata->fill($data);
			$simpan = $model->update($id, $rsdata);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			
			return redirect()->to(base_url('kurikulum'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}

	function delete($ids){
		$id = decrypt($ids); 
		$Kurikulummodel = new KurikulumModel();
		$Kurikulummodel->delete($id);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('prodi'));
	}

	function detView($ids)
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		
		$data=$this->data;
		$data['title']	= "Detail Kurikulum";

		$rs =  $this->model->find($id)->toarray();

		$RESUME['descrip_field'] = $this->dconfig->resume_descrip_field;
		$RESUME['AddOnFields'] 	 = $this->dconfig->res_addON_fields;
		$RESUME['data'] 		 = $rs;
		$RESUME['subtitle']		 = $rs['curr_name'];
		
		$data['breadcrumb'][$rs['curr_name']] = "#";
		//TABS SECTION
		
		//Subject
		$TABS['subject'] = ['title'=>'Data Subject','active'=>1, 'vcell'=>"TEST SUBJECT"];
		
		//CEK Skl
		//$vcall = view_cell('\Modules\Akademik\Libraries\Akademik::show', ['theme'=>$this->theme, 'dtview'=>$dtview]); 
		$vcall = view_cell('\Modules\Akademik\Controllers\Skl::showList', ['currId'=>$id]); 
		
		$TABS['skl']     = ['title'=>'Data SKL','active'=>0, 'vcell'=>$vcall];
		
		$data['tabs']	 = $TABS;
		$data['resume']  = $RESUME;
		$data['opsi'] 	 = $this->dconfig->opsi;
        
		$data['rsdata'] = $rs;
		echo view($this->theme.'dataViewCell',$data);
	}
}
