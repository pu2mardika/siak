<?php

namespace Modules\Project\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use Config\Services;
use Config\MyApp;
use Modules\Project\Models\SubModel;
use Modules\Project\Models\ElemenModel;

class SubElemen extends BaseController
{
    public  $keys='';
    protected $dconfig;
	protected $session;
	protected $theme;
	protected $model;
	protected $skl_model ;

    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Project\Config\SubElemen::class);
        $this->session = \Config\Services::session();
		$this->model = new SubModel;	
        $this->ElemenModel = new ElemenModel;
		$this->data['site_title'] = 'Halaman Gmapel';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['key']		  = $this->dconfig->primarykey;
		$this->data['allowimport']= $this->dconfig->importallowed;
		helper(['cookie', 'form']);
    }
	
	function index()
	{
		$dimensi 	= $this->model->getAllRow();
		$data = $this->data;
		$data['title']		 = "Manajemen Sub Elemen Project";
		$data['rsdata']		 = $dimensi;
		$data['msg'] 		 = "";
        $data['isplainText'] = TRUE;
	//	$data['opsi'] 		 = $this->dconfig->opsi;
        $data['opsi']['elemen_id'] = $this->ElemenModel->getDropdown();
		$data['actions']	 = $this->dconfig->actions;
		$data['addOnACt']    = $this->dconfig->addOnACt;
    //    test_result($data);
		echo view($this->theme.'datalist',$data);
    }

    public function showList($currID):string
	{ 
		$id=(is_array($currID))?$currID['currId']:$currID;
		$data['strdelimeter'] =setting('Elemen.arrDelimeter');
		$data['fields'] =setting('SubElemen.fieldCells');
		$data['id'] 	  = $id;
		$data['aksi']	  = ['main'  =>['uri'=>'dimensi', 'title'=>'Dimensi Project'], 
							 'subAct'=>['uri'=>'elemen','title'=>'Elemen Project'],
							 'addOn' =>['uri'=>'subelemen','title'=>'Sub Elemen Project']
							];
		$data['isplainText'] = TRUE;
		$data['key']	  = setting('SubElemen.primarykey');
		
		$data['opsi']	  = $this->dconfig->actions;
	//	$data['dtview'][0]['rsdata'] = $this->model->where('currId',$id)->findAll();
		$data['dtview'] = $this->_getElemen($id);
		$data['rtarget']= "#project-content";
		$data['title']  = "Daftar Elemen Projek";
		$data['actions']= setting('SubElemen.actions');
	//	test_result($data['dtview']);
		return view($this->theme.'cells/datalist2',$data);
	}
	
	function addView($id=0)
	{
		$this->cekHakAkses('create_data');
		$fields = $this->dconfig->fields;
		$form = $this->theme.'form';
		$data	=$this->data;
		$data['useCKeditor'] = false;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['elemen_id'] = $this->ElemenModel->getDropdown();
		if($id <> 0){
			unset($fields['elemen_id']);
			$idn = decrypt($id); 
			$id = explode(setting('Elemen.arrDelimeter'),$idn);
		//	test_result($id);
			$data['hidden']		= ['elemen_id'=>$id[0]];
			$form 				= $this->theme.'ajxform';
			$data['useCKeditor']= false;
			$data['rtarget']	= "#project-content";
		}
		$data['title']	= "Tambah Elemen Project";
		$data['error'] = [];// validation_list_errors();
		$data['fields'] = $fields;
		$data['rsdata'] = [];
		echo view($form, $data);
	}
	
	function addAction($id=0): RedirectResponse
	{
		$rules = $this->dconfig->roles;	
		if ($this->validate($rules)) {
			$rsData = $this->request->getPost();
			$Model = new SubModel();
			$Project = new \Modules\Project\Entities\SubElemen();
			$Project->fill($rsData);
			$simpan = $Model->insert($Project,false);
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			if($id == 0){
				return redirect()->to(base_url('subelemen'));
			}else{
				return redirect()->to(base_url('kurikulum/showList'));
			}
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function updateView($ids)
	{
		$this->cekHakAkses('update_data');
		$idn = decrypt($ids); 
		
		$id = explode(setting('SubElemen.arrDelimeter'),$idn); //$id[0]= grup_id, $id[1] = id curr
		//test_result($id);
		$data   = $this->data;
		$form   = $this->theme.'form';
		$fields = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
        $data['opsi']['elemen_id']     = $this->ElemenModel->getDropdown();
		if(count($id)>1){
			unset($fields['elemen_id']);
			$data['hidden']		= ['elemen_id'=>$id[1]];
			$form 				= $this->theme.'ajxform';
			$data['useCKeditor']= true;
			$data['rtarget']	= "#project-content";
		} 
		
		$data['title']	= "Update  Sub Elemen Project";
		$data['error'] = validation_list_errors();
		$data['fields'] = $fields;
		
		$rs =  $this->model->find($id[0])->toarray();
		$data['rsdata'] = $rs;
      //  $data['useCKeditor'] = false;
		echo view($form,$data);
	}
	
	function updateAction($ids): RedirectResponse
	{
		$id = decrypt($ids); 
		$roles = $rules = $this->dconfig->roles;
		
		if ($this->validate($roles)) {
			
			//$this->model->update($id, $data);
			$data = $this->request->getPost();
			
			$model = new SubModel();
			$rsdata = new \Modules\Project\Entities\SubElemen();
			
			$rsdata->fill($data);
			$simpan = $model->update($id, $rsdata);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			
			return redirect()->to(base_url('subelemen'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}

	function delete($ids){
		$idn = decrypt($ids); 
		$id = explode(setting('Elemen.arrDelimeter'),$idn); //$id[0]= elemen id, $id[1] = id curr  
		$Model = new SubModel();
		$Model->delete($id[0]);
		// masuk database
		//$this->session->setFlashdata('sukses','Data telah dihapus');
		//return redirect()->to(base_url('skl'));
		echo show_alert("Data Telah di Hapus","Sukses");
		if($id == 0){
			return redirect()->to(base_url('subelemen'));
		}else{
			$idx =  encrypt($id[1]);
			return redirect()->to(base_url('kurikulum/detail/'.$idx));
		}
	}

    private function _getElemen($currId)
	{
		$dModel = model(\Modules\Project\Models\DimensiModel::class); 
		$eModel = model(\Modules\Project\Models\ElemenModel::class);
		//$dimensi = $dModel->asarray()->where('curr_id', $currId)->findAll();
		$dimensi = $dModel->where('curr_id', $currId)->findAll();
		$elemen  = $eModel->getElemen(['c.curr_id'=>$currId]);
        $rsdata = $this->model->getElemen(['c.curr_id'=>$currId]);
	
		$result = [];
		foreach($dimensi as $dp)
		{
			$dpID = $dp->id;
			$result[$dpID]['title']=$dp->nama_dimensi;
			if(array_key_exists($dpID,$elemen))
			{
				$eProject = $elemen[$dpID];
				foreach($eProject as $ep)
				{
					$result[$dpID]['SubLevel'][$ep->id]['title']=$ep->deskripsi;
					if(array_key_exists($dpID, $rsdata))
					{
						$sdata = $rsdata[$dpID];
						if(array_key_exists($ep->id,$sdata))
						{
							$seProject = $sdata[$ep->id];
							$result[$dpID]['SubLevel'][$ep->id]['rsdata']= $sdata[$ep->id];
						}else{
							$result[$dpID]['SubLevel'][$ep->id]['rsdata']=[];
						}
					}else{
						$result[$dpID]['SubLevel'][$ep->id]['rsdata']=[];
					}
				}
			}else{
				$result[$dpID]['SubLevel']=[];
			}
		}
		if(count($result)==0)
		{
			$result[0]['rsdata']=[];
		}
		return $result;
	}
}
