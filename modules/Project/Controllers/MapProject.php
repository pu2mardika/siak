<?php

namespace Modules\Project\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use Config\Services;
use Config\MyApp;
use Modules\Project\Models\MappingModel;

class MapProject extends BaseController
{
    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Project\Config\mapConfig::class);
        $this->session = \Config\Services::session();
		$this->model   = new MappingModel;	
        $this->eModel  = model(\Modules\Project\Models\SubModel::class); 
        $this->ProjekModel  = model(\Modules\Project\Models\DataProjectModel::class); 
		$this->data['site_title'] = 'Mapping Penilaian Projek';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['key']		  = $this->dconfig->primarykey;
		$this->data['allowimport']= $this->dconfig->importallowed;
		helper(['cookie', 'form']);
    }
    
    public function index()
    {
        if(isset($_GET['ids']))
        {
            $id = decrypt($_GET['ids']);
        }else{
            return redirect()->to(base_url('project')); 
        }

        $projek 	= $this->ProjekModel->find($id);
    //    test_result($projek->toarray());
        $data = $this->data;
		$data['title']	= "Maping Penilaian Project-".$projek->nama_project;
		$vcell = view_cell('\Modules\Project\Controllers\MapProject::getElemen', ['id'=>$id]); 
		$data['error']  = [];
		$data['hidden']	= ['project_id'=>$id];
		$data['fields'] = [];
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['rsdata'] = [];;
		$data['vcell']  = $vcell;
		$data['rtarget']= "#skl-content";
		echo view($this->theme.'ajxform',$data);
		//echo view($this->theme.'form',$data);
    }

    function getElemen($ID):string
    {
        $id=(is_array($ID))?$ID['id']:$ID;
     //   $sElemen    = $this->eModel->asarray()->findAll();
        $sElemen    = $this->eModel->findAll();
        $mapData     = $this->model->asarray()->where('project_id',$id)->findAll();

        //jadikan $mapData sebagai multidimensi array
        $MapData=[];
        foreach($mapData as $mp)
        {
            $MapData[$mp['subelemen_id']]= $mp;
        }
    //    show_result($mapData);
     //   test_result($MapData);
        //set $sElemen sebagai recordset
        $rsData = [];
        foreach($sElemen as $rs)
        {
            $rset['id']=$rs->id;
            $rset['elemen_id']=$rs->elemen_id;
            $rset['deskripsi']=$rs->deskripsi;
            if(array_key_exists($rs->id,$MapData))
            {
                $rset['check']='checked';
            }
            $rsData[]=$rset;
        }
    //    show_result($sElemen);
    //    show_result($MapData);
    //    test_result($rsData);
        $data['resData'] = $rsData;
		$data['keys'] 	 = 'id';
	//	$data['fhead']   = $this->dconfig->srcFields;
		$data['fields']   = $this->dconfig->srcFields;
		$data['has_ref'] = [];
		$data['opsi']	 = [];
        $data['inputype'] = $this->data['inputype'];
    //  test_result($data);
        return view($this->theme.'cells/tablecheck',$data);
    }

    function saveAction(): RedirectResponse
	{
		$this->cekHakAkses('update_data');
		
		$roles = $rules = $this->dconfig->roles;
		
		if ($this->validate($roles)) {
			
			//$this->model->update($id, $data);
			$data = $this->request->getPost();
            $pid = $data['project_id'];
            $dt['project_id']= $pid;
            $arryData = $data['subelemen_id'];
            $rsdata=[]; 

            foreach($arryData as $val){
                $dt['id']="MP".sprintf("%03d",$pid).sprintf("%03d",$val);
                $dt['subelemen_id']= $val;
                $rsdata[]=$dt;
            }
       
            if($this->model->countData(['project_id'=>$dt['project_id']])>0)
            {
                //hapus data sebelumnya (untuk replace)
               $this->model->where('project_id',$pid)->delete();
            }
            $simpan = $this->model->simpanMasal($rsdata);
			if($simpan){
				$this->session->setFlashdata('sukses', $simpan.' Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('rombel'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
}
