<?php

namespace Modules\Akademik\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use Config\Services;
use Config\MyApp;
use Modules\Akademik\Models\SubjectModel;
use Modules\Akademik\Models\MapelModel;
use Modules\Akademik\Models\KurikulumModel;

class Mapel extends BaseController
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
        $this->dconfig = config(\Modules\Akademik\Config\Mapel::class);
        $this->session = \Config\Services::session();
		$this->model = new MapelModel;	
		$this->subjectModel = new SubjectModel;	
        $this->curr_model = new KurikulumModel;
		$this->data['site_title'] = 'Halaman Mapel';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['key']		  = $this->dconfig->primarykey;
		$this->data['allowimport']		  = $this->dconfig->importallowed;
		helper(['cookie', 'form', 'util']);
    }
	
	function addView($ids=0)
	{
		$this->cekHakAkses('create_data');
		$idn = decrypt($ids); 
		$id = explode(setting('mapel.arrDelimeter'),$idn); //$id[0]= grup_id, $id[1] = id curr
		$data   = $this->data;
		$data['fields'] = $this->dconfig->fields;
		$data['useCKeditor'] = false;
		$data['opsi']['id_subject'] = $this->model->getDropdown($id[1],$id[0]);
		$data['hidden']		 = ['id_skl'=>$id[0], 'currID'=>$id[1]];
		$data['useCKeditor'] = false;
		$data['rtarget']	 = "#skl-content";
		$data['title']	= "Tambah Mata Pelajaran";
		$data['error'] 	= [];// validation_list_errors();
		$data['rsdata'] = [];
		echo view($this->theme.'ajxform', $data);
		//echo view($this->theme.'form', $data);
	}
	
	function addAction($ids=0): RedirectResponse
	{
		$idn = decrypt($ids); 
		$id = explode(setting('mapel.arrDelimeter'),$idn); //$id[0]= grup_id, $id[1] = id curr
		$rules = $this->dconfig->roles;	
		if ($this->validate($rules)) {
			$dataMapel = $this->request->getPost();
			//ambil grade dan sub grade dari skl
			$sklModel = model(\Modules\Akademik\Models\SklModel::class);
			$skl = $sklModel->find($dataMapel['id_skl']);
			$id = $dataMapel['id_subject'].$skl->grade.$skl->subgrade;
			unset($dataMapel['currID']);
			$dataMapel['id']=$id;
			$MapelModel = new MapelModel();
			$Mapel= new \Modules\Akademik\Entities\Mapel();
			$Mapel->fill($dataMapel);
			$simpan = $MapelModel->insert($Mapel,false);
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			if($ids == 0){
				return redirect()->to(base_url('mapel'));
			}else{
				$idx =  encrypt($id[2]);
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
		
		$id = explode(setting('Mapel.arrDelimeter'),$idn); //$id[0]= mapel_id, $idx[1] = id_curr, $idx[2] = id_skl
	//	test_result($id);
		$parm =['id_subject'=>$id[0], 'id_skl'=>$id[2]];
		$data   = $this->data;
		$data['title']	= "Update Data Mapel";
		$this->dconfig->fields;
		$data['useCKeditor'] = false;
		$data['opsi']['id_subject'] = $this->model->getDropdown($id[1],$id[1]);
		$data['hidden']		= ['id_skl'=>$id[2]];
		$data['useCKeditor']= false;
		$data['rtarget']	= "#skl-content";
		$data['error'] = validation_list_errors();		 
		$data['rsdata'] =  $this->model->find($id[0])->toarray();//$this->model->detMapel($parm);      
		echo view($this->theme.'ajxform',$data); 
	}
	
	function updateAction($ids): RedirectResponse
	{
		$idn = decrypt($ids); 
		$id = explode(setting('Mapel.arrDelimeter'),$idn); //$id[0]= mapel_id, $idx[1] = id_curr, $idx[2] = id_skl
		$roles = $rules = $this->dconfig->roles;
		$parm =['id'=>$id[0]];
		
		if ($this->validate($roles)) {
			$data = $this->request->getPost();
			$model = new MapelModel();

			$rsdata = new \Modules\Akademik\Entities\Mapel();
			$rsdata->fill($data);
			//Menyimpan data dengan pendekatan builder karena membutuhkan lebih dari 1 key
			$RC['id_mapel']=$rsdata->id_mapel;
			$RC['id_skl']=$rsdata->id_skl;
			$RC['skk']=$rsdata->skk;
			
			$simpan = $model->where($parm)->set($RC)->update();
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			if($id == 0){
				return redirect()->to(base_url('mapel'));
			}else{
				$idx =  encrypt($id[2]);
				return redirect()->to(base_url('kurikulum/detail/'.$idx));
			}
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}

	public function delete($ids){
		$idn = decrypt($ids); 
		$id = explode(setting('Mapel.arrDelimeter'),$idn); //$id[0]= mapel id, $id[1] = id curr
		$parm =['id_mapel'=>$id[0], 'id_skl'=>$id[1]];
		//$idx = ['id_mapel'=>$id[0], 'id']
		$Mapelmodel = new MapelModel();
		$Mapelmodel->where($parm)->delete();
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		echo show_alert("Data Telah di Hapus","Sukses");
		if($id == 0){
			return redirect()->to(base_url('mapel'));
		}else{
			$idx =  encrypt($id[2]);
			return redirect()->to(base_url('kurikulum/detail/'.$idx));
		}
	}
}
