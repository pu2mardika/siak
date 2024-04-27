<?php

namespace Modules\Akademik\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use Config\Services;
use Config\MyApp;
use Modules\Akademik\Models\GmapelModel;
use Modules\Akademik\Models\KurikulumModel;
class Gmapel extends BaseController
{
    public  $keys='';
    protected $dconfig;
	protected $session;
	protected $theme;
	protected $model;
	protected $skl_model ;

    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Akademik\Config\Gmapel::class);
        $this->session = \Config\Services::session();
		$this->model = new GmapelModel;	
        $this->curr_model = new KurikulumModel;
		$this->data['site_title'] = 'Halaman Gmapel';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['key']		  = $this->dconfig->primarykey;
		$this->data['allowimport']		  = $this->dconfig->importallowed;
		helper(['cookie', 'form']);
    }
	
	function index()
	{
	
		$kurikulum 	= $this->model->findAll();
		$data = $this->data;
		$data['title']		 = "Manajemen Grup Mata Pelajaran";
		$data['rsdata']		 = $kurikulum;
		$data['msg'] 		 = "";
        $data['isplainText'] = TRUE;
		$data['opsi'] 		 = $this->dconfig->opsi;
        $data['opsi']['curr_id'] 	= $this->curr_model->getDropdown();
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
		$id=(is_array($currID))?$currID['curr_id']:$currID;
		$dtview['strdelimeter'] =setting('Gmapel.arrDelimeter');
		$dtview['fields'] =setting('Gmapel.fields');
		$dtview['id'] 	  = $id;
		$dtview['act'] 	  = 'skl';
		$dtview['isplainText'] = TRUE;
		$dtview['key']	  = setting('Gmapel.primarykey');
		$dtview['opsi']['parent_grup'] = $this->model->getDropdown($id);
		$dtview['rsdata'] = $this->model->where('currId',$id)->findAll();
		$dtview['title']  = "Daftar Capaian Pembelajaran";
		$dtview['actions']= setting('Gmapel.actions');
		$dtview['addOnACt'] = setting('Gmapel.addOnACt');
		return view($this->theme.'cells/dlist',$dtview);
	}
	
	function addView($id=0)
	{
		$this->cekHakAkses('create_data');
		$fields = $this->dconfig->fields;
		$form = $this->theme.'form';
		$data	=$this->data;
		$data['useCKeditor'] = false;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['curr_id']     = $this->curr_model->getDropdown();
		$data['opsi']['parent_grup'] = $this->model->getDropdown($id);
		if($id <> 0){
			unset($fields['curr_id']);
			$data['hidden']		= ['curr_id'=>$id];
			$form 				= $this->theme.'ajxform';
			$data['useCKeditor']= true;
			$data['rtarget']	= "#mapel-content";
		}
		$data['title']	= "Tambah Grup Mata Pelajaran";
		$data['error'] = [];// validation_list_errors();
		$data['fields'] = $fields;
		$data['rsdata'] = [];
		echo view($form, $data);
	}
	
	function addAction($id=0): RedirectResponse
	{
		$rules = $this->dconfig->roles;	
		if ($this->validate($rules)) {
			$dataGmapel = $this->request->getPost();
			//$dataGmapel['id']=$dataGmapel['currId'];
			//$data['id']=$data['id_skl'];
			//test_result($data);
			$GmapelModel = new GmapelModel();
			$Gmapel= new \Modules\Akademik\Entities\Gmapel();
			$Gmapel->fill($dataGmapel);
			$simpan = $GmapelModel->insert($Gmapel,false);
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			if($id == 0){
				return redirect()->to(base_url('gmapel'));
			}else{
				return redirect()->to(base_url('subject/showList'));
			}
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function updateView($ids)
	{
		$this->cekHakAkses('update_data');
		$idn = decrypt($ids); 
		
		$id = explode(setting('Gmapel.arrDelimeter'),$idn); //$id[0]= grup_id, $id[1] = id curr
		//test_result($id);
		$data   = $this->data;
		$form   = $this->theme.'form';
		$fields = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
        $data['opsi']['curr_id']     = $this->curr_model->getDropdown();
        $data['opsi']['parent_grup'] = $this->model->getDropdown($id[1]);
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
			$model = new GmapelModel();

			$rsdata = new \Modules\Akademik\Entities\Gmapel();
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
		$idn = decrypt($ids); 
		$id = explode(setting('Subject.arrDelimeter'),$idn); //$id[0]= subject id, $id[1] = id curr  
		$Gmapelmodel = new GmapelModel();
		$Gmapelmodel->delete($id[0]);
		// masuk database
		//$this->session->setFlashdata('sukses','Data telah dihapus');
		//return redirect()->to(base_url('skl'));
		echo show_alert("Data Telah di Hapus","Sukses");
		if($id == 0){
			return redirect()->to(base_url('gmapel'));
		}else{
			$idx =  encrypt($id[1]);
			return redirect()->to(base_url('kurikulum/detail/'.$idx));
		}
	}
}
