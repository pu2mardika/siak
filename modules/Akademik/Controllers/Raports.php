<?php

namespace Modules\Akademik\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use Config\Services;
use Config\MyApp;
use Modules\Akademik\Models\RatingModel;
use Modules\Akademik\Models\RaportsModel;
use Modules\Akademik\Models\KurikulumModel;

class Raports extends BaseController
{
    public  $keys='';
    protected $dconfig;
	protected $session;
	protected $theme;
	protected $model;
	//protected $curr_model ;
	protected $ratingModel ;

    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Akademik\Config\Raports::class);
        $this->session = \Config\Services::session();
		$this->model = new RaportsModel;	
		$this->RatingModel = new RatingModel;	
    //   $this->curr_model 	= new KurikulumModel;
		$this->data['site_title'] = 'Halaman Raports';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['key']		  = $this->dconfig->primarykey;
		$this->data['allowimport']= $this->dconfig->importallowed;
		helper(['cookie', 'form', 'util']);
    }
	
	public function showList($currID):string
	{ 
		$id=(is_array($currID))?$currID['currId']:$currID;
	
		$dtview['useAccordion'] = true;
		$dtview['strdelimeter'] =setting('Raports.arrDelimeter');
		$dtview['fields'] = $this->dconfig->fields;
		$dtview['id'] 	  = $id;
		$dtview['aksi']	  = ['main' =>['uri'=>'raports', 'title'=>'Komponen Raport'], 
							 'addOn'=>['uri'=>'raports','title'=>'Komponen Raport']];
		$dtview['isplainText'] = TRUE;
		$dtview['key']	  = setting('Raports.primarykey');
		$dtview['opsi']['comp_nilai']	= $this->RatingModel->getDropDown($id);
		$dtview['rtarget']= "#raports-content";
		$dtview['dtview'][0]['rsdata'] = $this->model->where('curr_id',$id)->findAll();
		$dtview['title']  = "Daftar Komponen Penilaian";
		$dtview['actions']= setting('Raports.actions');
		$dtview['addOnACt'] = setting('Raports.addOnACt');
		$dtview['section'] = "ass";
		//test_result($dtview);
		return view($this->theme.'cells/dlist',$dtview);
	}
	
	function addView($id=0)
	{
		//TANAPA ENKRIPSI
        $this->cekHakAkses('create_data');
		$data   = $this->data;
        $opt['comp_nilai']   = $this->RatingModel->getDropDown($id);
		$data['fields'] 	 = $this->dconfig->fields;
		$data['useCKeditor'] = false;
		$data['opsi'] 		 = $opt;
		$data['hidden']		 = ['curr_id'=>$id];
		$data['useCKeditor'] = false;
		$data['rtarget']	 = "#raports-content";
		$data['title']		 = "Tambah Komponen Raport";
		$data['error'] 		 = [];// validation_list_errors();
		$data['rsdata'] 	 = [];
		echo view($this->theme.'ajxform', $data);
	}
	
	function addAction($id=0): RedirectResponse
	{
		$rules = $this->dconfig->roles;	
		if ($this->validate($rules)) {
			$dataRaports  	   = $this->request->getPost();
			$dataRaports['id'] = $dataRaports['curr_id'];
			$RaportsModel 	   = new RaportsModel();
			
			$Raports = new \Modules\Akademik\Entities\Raports();
			$Raports->fill($dataRaports);
			$simpan  = $RaportsModel->insert($Raports,false);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			if($id == 0){
				return redirect()->to(base_url('raports'));
			}else{
				$idx =  encrypt($id);
				return redirect()->to(base_url('kurikulum/detail/'.$idx));
			}
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function updateView($ids)
	{
		$this->cekHakAkses('update_data');
		$idn = decrypt($ids); 
		
		$id = explode(setting('Raports.arrDelimeter'),$idn); //$id[0]= raports_id, $idx[1] = id_curr
		//test_result($id);
		$data   = $this->data;
		$data['title']	     = "Update Data Komponen Raport";
		$opt['comp_nilai']   = $this->RatingModel->getDropDown($id[1]);
		$data['useCKeditor'] = false;
		$data['opsi'] 		 = $opt;
		$data['hidden']		 = ['curr_id'=>$id[1]];
		$data['useCKeditor'] = false;
		$data['rtarget']	 = "#raports-content";
		$data['error']       = validation_list_errors();		 
		$data['rsdata']      =  $this->model->find($id[0])->toarray();      
		echo view($this->theme.'ajxform',$data); 
	}
	
	function updateAction($ids): RedirectResponse
	{
		$idn = decrypt($ids); 
		$id = explode(setting('Raports.arrDelimeter'),$idn); //$id[0]= raports_id, $idx[1]=$idx[3] = id_skl, $idx[2] = id_curr
		$roles = $rules = $this->dconfig->roles;
		if ($this->validate($roles)) {
			$data = $this->request->getPost();
			$model = new RaportsModel();

			$rsdata = new \Modules\Akademik\Entities\Raports();
			$rsdata->fill($data);
			$simpan = $model->update($id[0], $rsdata);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			if($id == 0){
				return redirect()->to(base_url('raports'));
			}else{
				$idx =  encrypt($id[1]);
				return redirect()->to(base_url('kurikulum/detail/'.$idx));
			}
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}

	public function delete($ids){
		$idn = decrypt($ids); 
		$id = explode(setting('Raports.arrDelimeter'),$idn); //$id[0]= raports id, $id[1] = id curr
		$Raportsmodel = new RaportsModel();
		$Raportsmodel->delete($id[0]);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		echo show_alert("Data Telah di Hapus","Sukses");
		if($id == 0){
			return redirect()->to(base_url('raports'));
		}else{
			$idx =  encrypt($id[1]);
			return redirect()->to(base_url('kurikulum/detail/'.$idx));
		}
	}
}
