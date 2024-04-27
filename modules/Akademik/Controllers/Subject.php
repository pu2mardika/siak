<?php

namespace Modules\Akademik\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use Config\Services;
use Config\MyApp;
use Modules\Akademik\Models\SubjectModel;
use Modules\Akademik\Models\GmapelModel;
use Modules\Akademik\Models\KurikulumModel;

class Subject extends BaseController
{
    public  $keys='';
    protected $dconfig;
	protected $session;
	protected $theme;
	protected $model;
	protected $curr_model ;
	protected $gmapelmodel ;

    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Akademik\Config\Subject::class);
        $this->session = \Config\Services::session();
		$this->model = new SubjectModel;	
		$this->gmapelmodel = new GmapelModel;	
        $this->curr_model = new KurikulumModel;
		$this->data['site_title'] = 'Halaman Subject';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['key']		  = $this->dconfig->primarykey;
		$this->data['allowimport']		  = $this->dconfig->importallowed;
       // $this->addStyle (base_url().'/css/personal.css');
		//$this->addStyle ('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
		helper(['cookie', 'form', 'util']);
    }
	
	function index()
	{
	
		$dtview	 = $this->model->getSubject('IKMB23004235');
		test_result($dtview);
		$data = $this->data;
		$data['title']		 = "Manajemen Mata Pelajaran";
		$data['rsdata']		 = $dtview;
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
		$GmapelModel = new GmapelModel;
		$opt			  = $this->dconfig->opsi;
		$opt['grup_id']		= $GmapelModel->getDropdown($id);
		$dtview['useAccordion'] = true;
		$dtview['strdelimeter'] =setting('Subject.arrDelimeter');
		$dtview['fields'] = $this->dconfig->fields;
		$dtview['id'] 	  = $id;
		$dtview['aksi']	  = ['main' =>['uri'=>'grupmp', 'title'=>'Grup Mapel'], 
							 'addOn'=>['uri'=>'subject','title'=>'Mapel']];
		$dtview['isplainText'] = TRUE;
		$dtview['key']	  = setting('Subject.primarykey');
		$dtview['opsi']	  = $opt;
		$dtview['rtarget']= "#mapel-content";
		$dtview['dtview'] = $this->_getSubjects($id);
		$dtview['title']  = "Daftar Mata Pelajaran";
		$dtview['actions']= setting('Subject.actions');
		$dtview['addOnACt'] = setting('Subject.addOnACt');
		$dtview['section'] = "mapel";
		//test_result($dtview);
		return view($this->theme.'cells/dlist',$dtview);
	}
	
	function addView($ids=0)
	{
		$this->cekHakAkses('create_data');
		$fields = $this->dconfig->fields;
		$form = $this->theme.'form';
		$data	=$this->data;
		$data['useCKeditor'] = true;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['grup_id'] = $this->gmapelmodel->getDropdown();
		$rsdata = [];
		if($ids <> 0){
			$idn = decrypt($ids); 
			$id = explode(setting('Subject.arrDelimeter'),$idn); //$id[0]= grup_id, $id[1] = id curr
			unset($fields['grup_id']);
			$data['hidden']		= ['grup_id'=>$id[0], 'currID'=>$id[1]];
			$form 				= $this->theme.'ajxform';
			$data['useCKeditor']= false;
			$data['rtarget']	= "#mapel-content";
			$rsdata['item_order'] = $this->model->nextOrder($id[1]);
		}
		$data['title']	= "Tambah Mata Pelajaran";
		$data['error'] = [];// validation_list_errors();
		$data['fields'] = $fields;
		$data['rsdata'] = $rsdata;
		echo view($form, $data);
	}
	
	function addAction($id=0): RedirectResponse
	{
		$rules = $this->dconfig->roles;	
		if ($this->validate($rules)) {
			$dataSubject = $this->request->getPost();
			$dataSubject['id']= $dataSubject['currID'];
			unset($dataSubject['currID']);
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
				return redirect()->to(base_url('subject'));
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
		
		$id = explode(setting('Subject.arrDelimeter'),$idn); //$id[0]= subject id, $id[1] = id curr
		//test_result($id);
		$data   = $this->data;
		$form   = $this->theme.'form';
		$fields = $this->dconfig->fields;
		//$data	=$this->data;
		$data['useCKeditor'] = true;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['grup_id'] = $this->gmapelmodel->getDropdown();
        
		if(count($id)>1){
			$idn = decrypt($ids); 
			$id = explode(setting('Subject.arrDelimeter'),$idn); //$id[0]= grup_id, $id[1] = id curr
			unset($fields['grup_id']);
			//$data['hidden']		= ['grup_id'=>$id[0], 'currID'=>$id[1]];
			$form 				= $this->theme.'ajxform';
			$data['useCKeditor']= false;
			$data['rtarget']	= "#mapel-content";
		} 
		
		$data['title']	= "Update Data Mapel";
		$data['error'] = validation_list_errors();
		$data['fields'] = $fields;
		
		$rs =  $this->model->find($id[0])->toarray();
		$data['rsdata'] = $rs;
        $data['useCKeditor'] = true;
		echo view($form,$data);
	}
	
	function updateAction($ids): RedirectResponse
	{
		$idn = decrypt($ids); 
		$id = explode(setting('Subject.arrDelimeter'),$idn); //$id[0]= subject id, $id[1] = id curr
		$roles = $rules = $this->dconfig->roles;
		
		if ($this->validate($roles)) {
			$data = $this->request->getPost();
			$model = new SubjectModel();

			$rsdata = new \Modules\Akademik\Entities\Subject();
			$rsdata->fill($data);
			$simpan = $model->update($id[0], $rsdata);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			if($id == 0){
				return redirect()->to(base_url('subject'));
			}else{
				return redirect()->to(base_url('subject/showList'));
			}
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}

	public function delete($ids){
		$idn = decrypt($ids); 
		$id = explode(setting('Subject.arrDelimeter'),$idn); //$id[0]= subject id, $id[1] = id curr
		
		$Subjectmodel = new SubjectModel();
		$Subjectmodel->delete($id[0]);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		echo show_alert("Data Telah di Hapus","Sukses");
		if($id == 0){
			return redirect()->to(base_url('subject'));
		}else{
			$idx =  encrypt($id[1]);
			return redirect()->to(base_url('kurikulum/detail/'.$idx));
		}
	}
	
	private function _getSubjects($currId)
	{
		$GmapelModel = new GmapelModel;
		$grup = $GmapelModel->where('curr_id', $currId)->findAll();
		$rsdata = $this->model->getSubject($currId,true);
	//	test_result($rsdata);
		$Result = [];
		foreach($grup as $dt)
		{
			$Result[$dt->grup_id]['title']=$dt->nm_grup;
			$rdata = (array_key_exists($dt->grup_id,$rsdata))?$rsdata[$dt->grup_id]:[];
			$Result[$dt->grup_id]['rsdata']=$rdata;
		}
		
		if(count($Result)==0)
		{
			$Result[0]['rsdata']=[];
		}
		return $Result;
	//	test_result($Result);
	}
}
