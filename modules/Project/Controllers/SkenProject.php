<?php

namespace Modules\Project\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use Config\Services;
use Config\MyApp;
use Modules\Project\Models\SkenModel;

class SkenProject extends BaseController
{
    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Project\Config\DistribConf::class);
        $this->session = \Config\Services::session();
		$this->model   = new SkenModel;	
		$this->data['site_title'] = 'Skenario Projek';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['key']		  = $this->dconfig->primarykey;
		$this->data['allowimport']= $this->dconfig->importallowed;
		helper(['cookie', 'form']);
    }

    function getProject($ID):string
    {
        $id=(is_array($ID))?$ID['id']:$ID;   
      
        $rsProjek = $this->model->getsAll(['room_id'=>$id]);
      //  test_result($rsProjek);
        //menjadikan hasil rsproject sebagai string
        $data['fields'] = $this->dconfig->fields;
        $data['rsData'] = $rsProjek;
        $data['idx']    = $id;
        $data['strdelimeter'] = setting('DistribConf.arrDelimeter');
        $data['key']    = $this->dconfig->primarykey;
        $data['addAct'] = $this->dconfig->addOnACt;
        $data['actions']= $this->dconfig->actions;
        return view($this->theme.'cells/listgrup',$data);
    }

    function addView()
    {
        if(isset($_GET['idr']))
        {
            $id = decrypt($_GET['idr']);
        }else{
            return redirect()->to(base_url('rombel')); 
        }

        $roomModel = model(\Modules\Room\Models\RombelModel::class);
        $rombel    = $roomModel->find($id);
        
        $data = $this->data;
		$data['title']	= "Maping Project-".$rombel->nama_rombel;
		$vcell = view_cell('\Modules\Project\Controllers\SkenProject::setProject', ['id'=>$id, 'currID'=>$rombel->curr_id]); 
		$data['error']  = [];
		$data['hidden']	= ['room_id'=>$id];
		$data['fields'] = [];
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['rsdata'] = [];;
		$data['vcell']  = $vcell;
		$data['rtarget']= "#skl-content";
		echo view($this->theme.'ajxform',$data);
    }

    function setProject($ID):string
    {
        $id=(is_array($ID))?$ID['id']:$ID;
        $cid=(is_array($ID))?$ID['id']:$ID;
         
        $projectModel = model(\Modules\Project\Models\DataProjectModel::class);
        $dproject    = $projectModel->findAll();
        $mapData     = $this->model->asarray()->where('room_id',$id)->findAll();

        //jadikan $mapData sebagai multidimensi array
        $MapData=[];
        foreach($mapData as $mp)
        {
            $MapData[$mp['project_id']]= $mp;
        }
    //    show_result($mapData);
       // test_result($dproject);
        //set $sElemen sebagai recordset
        $rsData = [];
        foreach($dproject as $rs)
        {
            $rset['id']=$rs->id;
            $rset['project_id']=$rs->id;
            $rset['deskripsi']=$rs->nama_project;
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

    function addAction()//: RedirectResponse
	{
		$this->cekHakAkses('update_data');
		
		$roles = $rules = $this->dconfig->roles;
		//test_result($this->request->getPost());
		if ($this->validate($roles)) {
			
			//$this->model->update($id, $data);
			$data = $this->request->getPost();
            $dt['room_id']= $data['room_id'];;
            $arryData = $data['project_id'];
            $rsdata=[]; 

            foreach($arryData as $val){
            //  $dt['id']="MP".sprintf("%03d",$pid).sprintf("%03d",$val);
                $dt['project_id']= $val;
                $rsdata[]=$dt;
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

    function remove($ids){
		$idn = decrypt($ids); 
		$id = explode(setting('DistribConf.arrDelimeter'),$idn); //$id[0]= elemen id, $id[1] = id rombel  
		$this->model->delete($id[0]);
		echo show_alert("Data Telah di Hapus","Sukses");
		if($id == 0){
			return redirect()->to(base_url('rombel'));
		}else{
			$idx =  encrypt($id[1]);
			return redirect()->to(base_url('rombel/detail?ids='.$idx));
		}
	}
};
