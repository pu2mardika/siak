<?php

namespace Modules\Akademik\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use Config\Services;
use Config\MyApp;
use Modules\Akademik\Models\SubjectModel;
use Modules\Akademik\Models\RatingModel;
use Modules\Akademik\Models\KurikulumModel;

class Rating extends BaseController
{
    public  $keys='';
    protected $dconfig;
	protected $session;
	protected $theme;
	protected $model;
	protected $curr_model ;
	protected $subjectModel ;

    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Akademik\Config\Rating::class);
        $this->session = \Config\Services::session();
		$this->model = new RatingModel;	
		$this->subjectModel = new SubjectModel;	
        $this->curr_model 	= new KurikulumModel;
		$this->data['site_title'] = 'Halaman Rating';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['key']		  = $this->dconfig->primarykey;
		$this->data['allowimport']= $this->dconfig->importallowed;
		helper(['cookie', 'form', 'util']);
    }
	
	public function showList($currID):string
	{ 
		$id=(is_array($currID))?$currID['currId']:$currID;
		//$GratingModel = new GratingModel;
		$opt			  = $this->dconfig->opsi;
		$dtview['useAccordion'] = true;
		$dtview['strdelimeter'] =setting('Rating.arrDelimeter');
		$dtview['fields'] = $this->dconfig->fields;
		$dtview['id'] 	  = $id;
		$dtview['aksi']	  = ['main' =>['uri'=>'rating', 'title'=>'Penilaian'], 
							 'addOn'=>['uri'=>'rating','title'=>'Penilaian']];
		$dtview['isplainText'] = TRUE;
		$dtview['key']	  = setting('Rating.primarykey');
		$dtview['opsi']	  = $opt;
		$dtview['rtarget']= "#rating-content";
		$dtview['dtview'][0]['rsdata'] = $this->model->where('curr_id',$id)->findAll();
		$dtview['title']  = "Daftar Komponen Penilaian";
		$dtview['actions']= setting('Rating.actions');
		$dtview['addOnACt'] = setting('Rating.addOnACt');
		$dtview['section'] = "ass";
		//test_result($dtview);
		return view($this->theme.'cells/dlist',$dtview);
	}
	
	function addView($id=0)
	{
		$this->cekHakAkses('create_data');
		//$idn = decrypt($ids); 
		//$id = explode(setting('rating.arrDelimeter'),$idn); //$id[0]= id raing, $id[1] = id curr
		$data   = $this->data;
		$data['fields'] 	 = $this->dconfig->fields;
		$data['useCKeditor'] = false;
		$data['opsi'] 		 = setting('rating.opsi');
		$data['hidden']		 = ['curr_id'=>$id];
		$data['useCKeditor'] = false;
		$data['rtarget']	 = "#rating-content";
		$data['title']		 = "Tambah Mata Pelajaran";
		$data['error'] 		 = [];// validation_list_errors();
		$data['rsdata'] 	 = [];
		echo view($this->theme.'ajxform', $data);
	}
	
	function addAction($ids=0): RedirectResponse
	{
		$rules = $this->dconfig->roles;	
		if ($this->validate($rules)) {
			$dataRating  	  = $this->request->getPost();
			$dataRating['id'] = $dataRating['curr_id'];
			$RatingModel 	  = new RatingModel();
			
			$Rating = new \Modules\Akademik\Entities\Rating();
			$Rating->fill($dataRating);
			$simpan = $RatingModel->insert($Rating,false);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			if($ids == 0){
				return redirect()->to(base_url('rating'));
			}else{
				$idx =  encrypt($ids);
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
		
		$id = explode(setting('Rating.arrDelimeter'),$idn); //$id[0]= rating_id, $idx[1] = id_curr
		//test_result($id);
		$data   = $this->data;
		$data['title']	= "Update Data Komponen Penilaian";
		$this->dconfig->fields;
		$data['useCKeditor'] = false;
		$data['opsi'] 		 = setting('rating.opsi');
		$data['hidden']		= ['curr_id'=>$id[1]];
		$data['useCKeditor']= false;
		$data['rtarget']	= "#rating-content";
		$data['error'] = validation_list_errors();		 
		//$rs =  $this->model->where($parm)->find();
		$data['rsdata'] =  $this->model->find($id[0])->toarray();      
		echo view($this->theme.'ajxform',$data); 
	}
	
	function updateAction($ids): RedirectResponse
	{
		$idn = decrypt($ids); 
		$id = explode(setting('Rating.arrDelimeter'),$idn); //$id[0]= rating_id, $idx[1]=$idx[3] = id_skl, $idx[2] = id_curr
		$roles = $rules = $this->dconfig->roles;
		if ($this->validate($roles)) {
			$data = $this->request->getPost();
			$model = new RatingModel();

			$rsdata = new \Modules\Akademik\Entities\Rating();
			$rsdata->fill($data);
			$simpan = $model->update($id[0], $rsdata);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			if($id == 0){
				return redirect()->to(base_url('rating'));
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
		$id = explode(setting('Rating.arrDelimeter'),$idn); //$id[0]= rating id, $id[1] = id curr
		$Ratingmodel = new RatingModel();
		$Ratingmodel->delete($id[0]);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		echo show_alert("Data Telah di Hapus","Sukses");
		if($id == 0){
			return redirect()->to(base_url('rating'));
		}else{
			$idx =  encrypt($id[1]);
			return redirect()->to(base_url('kurikulum/detail/'.$idx));
		}
	}
}
