<?php

namespace Modules\Akademik\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use Config\Services;
use Config\MyApp;
use Modules\Akademik\Models\SklModel;
use Modules\Akademik\Models\KurikulumModel;
use Modules\Akademik\Models\MapelModel;

class Skl extends BaseController
{
    public  $keys='';
    protected $dconfig;
	protected $session;
	protected $theme;
	protected $model;
	protected $skl_model ;

    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Akademik\Config\Skl::class);
        $this->session = \Config\Services::session();
		$this->model = new SklModel;	
        $this->curr_model = new KurikulumModel;
		$this->data['site_title'] = 'Halaman Skl';
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
		$data['title']		 = "Manajemen Skl";
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
		$data['strdelimeter'] =setting('Skl.arrDelimeter');
		$data['fields'] =setting('mapel.fieldCells');
		$data['id'] 	  = $id;
		$data['aksi']	  = ['main' =>['uri'=>'skl', 'title'=>'Capaian Pembelajaran'], 
							 'addOn'=>['uri'=>'mapel','title'=>'Distribusi MaPel']
							];
		$data['isplainText'] = TRUE;
		$data['key']	  = setting('Skl.primarykey');
		
		$data['opsi']	  = $this->curr_model->getLevel($id);
		$data['dtview'][0]['rsdata'] = $this->model->where('currId',$id)->findAll();
		$data['dtview'] = $this->_getMapel($id);
		$data['rtarget']= "#skl-content";
		$data['title']  = "Daftar Capaian Pembelajaran";
		$data['actions']= setting('mapel.actions');
		return view($this->theme.'cells/dlist',$data);
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
			$fields 			= $this->dconfig->fields2;
			$data['opsi'] 		= $this->curr_model->getLevel($id);
			$data['hidden']		= ['currId'=>$id];
			$form 				= $this->theme.'ajxform';
			$data['useCKeditor']= true;
			$data['rtarget']	= "#skl-content";
		}
		$data['title']	= "Tambah Data Skl";
		$data['error'] = [];// validation_list_errors();
		$data['fields'] = $fields;
		$data['rsdata'] = [];
		echo view($form, $data);
	}
	
	function addAction($id=0): RedirectResponse
	{
		$rules = $this->dconfig->roles;	
		if ($this->validate($rules)) {
			$dataSkl = $this->request->getPost();
			$dataSkl['id']=$dataSkl['currId'];
			//$data['id']=$data['id_skl'];
			//test_result($data);
			$SklModel = new SklModel();
			$Skl= new \Modules\Akademik\Entities\Skl();
			$Skl->fill($dataSkl);
			$simpan = $SklModel->insert($Skl,false);
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
		
		$id = explode(setting('Skl.arrDelimeter'),$idn); //$id[0]= id_skl, $id[1] = id curr
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
		
		$data['title']	= "Update Data Skl";
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
			
			//$this->model->update($id, $data);
			$data = $this->request->getPost();
			$model = new SklModel();

			$rsdata = new \Modules\Akademik\Entities\Skl();
			$rsdata->fill($data);
			$simpan = $model->update($id[0], $rsdata);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			
			if($id == 0){
				return redirect()->to(base_url('skl'));
			}else{
				$idx =  encrypt($id[1]);
				return redirect()->to(base_url('kurikulum/detail/'.$idx));
			}
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}

	function delete($ids){
		$idn = decrypt($ids); 
		$id = explode(setting('Subject.arrDelimeter'),$idn); //$id[0]= subject id, $id[1] = id curr 
		$Sklmodel = new SklModel();
		$Sklmodel->delete($id[0]);
		$this->session->setFlashdata('sukses','Data telah dihapus');
		echo show_alert("Data Telah di Hapus","Sukses");
		
		if($id == 0){
			return redirect()->to(base_url('skl'));
		}else{
			$idx =  encrypt($id[1]);
			return redirect()->to(base_url('kurikulum/detail/'.$idx));
		}
	}
	
	private function _getMapel($currId)
	{
		$MapelModel = new MapelModel;
		$skl = $this->model->where('currId', $currId)->findAll();
		$rsdata = $MapelModel->getMapel($currId,true);
		//test_result($rsdata);	    
		$Result = [];
		foreach($skl as $dt)
		{
			$Result[$dt->id]['title']=$dt->grade_name;
			$rdata = (array_key_exists($dt->id,$rsdata))?$rsdata[$dt->id]:[];
			$Result[$dt->id]['rsdata']=$rdata;
		}
		
		if(count($Result)==0)
		{
			$Result[0]['rsdata']=[];
		}
		return $Result;
	//	test_result($Result);
	}
	
}
