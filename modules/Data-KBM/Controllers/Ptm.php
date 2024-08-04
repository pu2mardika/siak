<?php

namespace Modules\Kbm\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use Modules\Tp\Models\TpModel;
use Modules\Kbm\Models\PtmModel;
use Modules\Room\Models\RombelModel;
use Modules\Akademik\Models\KurikulumModel;
use Modules\Akademik\Models\ProdiModel;
use Config\Services;
use CodeIgniter\Files\File;
use Config\MyApp;

class Ptm extends BaseController
{
    public  $keys='';
	protected $dconfig;
	protected $tendikModel;
	protected $TpModel;
	protected $form;

    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Kbm\Config\Ptm::class);
        $this->session = \Config\Services::session();
		$this->model = new PtmModel;	
        $this->TpModel  = model(\Modules\Tp\Models\TpModel::class); 	
		$this->rombelModel = model(\Modules\Room\Models\RombelModel::class); 	
		$this->currModel  = model(\Modules\Akademik\Models\KurikulumModel::class); 	
		$this->data['site_title'] = 'Manajemen Data Rombel';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['opsi'] 	  = $this->dconfig->opsi;
		$this->data['key']		  = $this->dconfig->primarykey;
		
		//$this->form 			  = $this->theme.($this->request->isAJAX())?"ajxform":"form";
		helper(['cookie', 'form','date']);
		$this->addStyle (base_url().'css/table-data.css?r=' . time());
		$this->addJs (base_url().'/js/jquery.easy-autocomplete.min.js?r=' . time());
	//	$this->addJs (base_url().'/js/modules/ptm.js?r=' . time());
    }
	
	function index()
	{
		$this->cekHakAkses('read_data');
		
		//echo $this->theme;die();
		$data=$this->data;		
		if (isset($_GET['tp'])) 
		{
			$ctp = $_GET['tp'];
			$tp = $this->TpModel->find($ctp);
		}else{
			$tp = $this->TpModel->getcurTP();
			//test_result($tp);
			$ctp = $tp->thid;
		}
		$addTitle = "Tahun ".$tp->deskripsi;
		$data['title']	= "Pembagian Tugas Mengajar ".$addTitle;
		$rsptm = $this->model->getAll(['d.kode_ta'=>$ctp]);
		//mengelompokkan rsptm berdasarkan data guru pengajar
		$rsdata=[];
		foreach($rsptm as $v)
		{
			$id = $v['ptk_id'];
			$sg = $v['subgrade'];
			$rsdata[$sg][$id]['gtitle']=$v['nama'].' NIK: '.$id;
			$detail = ['nama_rombel'=>$v['nama_rombel'], 'subject_name'=>$v['subject_name'], 'id_mapel'=>$v['id_mapel']];
			$detail['skk'] = (int)$v['skk'];
			$detail['kkm'] = (float)$v['kkm'];
			$rsdata[$sg][$id]['detail'][]=$detail;
		}
			
	//	test_result($rsdata);
		$data['rsdata']	= $rsdata;
		$data['msg'] 	= "";
		$data['subtitle'] = "Sub Grade-";
		$dtfilter	= $this->dconfig->dtfilter;
		$tp = $this->TpModel->getcurTP();
		$dtfilter['cVal'] = $ctp;
		$TaPel = $this->TpModel->getDropdown();
		unset($TaPel['']);
		unset($TaPel[$ctp]);
		$data['TaPel'] 	= $TaPel;
		$data['dtfilter'] 	= $dtfilter;
		$data['panelAct']= $this->dconfig->panelAct;
		$data['actions']= $this->dconfig->actions;
		$data['allowimport']= $this->dconfig->importallowed;
	//	test_result($data['opsi']);
		echo view($this->theme.'acordiontable',$data);		
    }
		
	function addView()
	{
		$this->cekHakAkses('create_data');
		$data = $this->data;
		$data['title']	= "Tambah Data Raport";
		$fields = $this->dconfig->Addfields;
		$data['error'] = [];
		$data['fields'] = $fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['TaPel'] 	= $this->TpModel->getDropdown();
		$data['opsi']['rombel'] = [];
		$data['rsdata'] = [];//['kode_ta'=>$ctp];
		$data['addONJs'] = $this->dconfig->addonJS;
		$data['rtarget']	= "#skl-content";
		//echo view($this->theme.'ajxform',$data);
		echo view($this->theme.'form',$data);
	}
	
	function getRoom($id)
	{
		$html= '<option value="" selected="selected">[--PILIH ROMBEL--]</option>';
		//ambil data rombel berdasarkan ID TP
		$room = $this->rombelModel->getDropdown(['kode_ta'=>$id]);
		unset($room['']);
		foreach($room as $k =>$v)
		{
			$html .='<option value="'.$k.'">'.$v.'</option>';
		}
		echo $html;
	}

	function getSubGrade()
	{
		if(isset($_GET['ids']))
		{
			$ids = $_GET['ids'];
			$id = decrypt($ids);
			//tampilkan data rombel
			$room = $this->rombelModel->find($id);
		//	test_result($room->curr_id);
			$level = $this->currModel->getLevel($room->curr_id);
			$html= '<option value="" selected="selected">[--PILIH SUB GRADE--]</option>';
			$subgrade = $level['subgrade'];
			foreach($subgrade as $k =>$v)
			{
				$html .='<option value="'.$k.'">'.$v.'</option>';
			}
			echo $html;
		}	
	}

	function getDataPtm()
	{
	//	test_result($_GET);
		if(isset($_GET['ids']) && isset($_GET['sgr']))
		{
			$ids = $_GET['ids'];
			$id = decrypt($ids);
			$sg = $_GET['sgr'];
			//tampilkan data rombel
			$room = $this->rombelModel->find($id);
			//test_result($room);
			//tetapkan parameter pengambilan data mapel berdasarkan currID, grade dan sub grade
			$parm['c.currId']=$room->curr_id;
			$parm['c.grade'] = $room->grade;
			$parm['c.subgrade'] = $sg;
			$mapelModel  = model(\Modules\Akademik\Models\MapelModel::class); 
			$ptkModel  = model(\Modules\Tendik\Models\TendikModel::class); 
			$mapel = $mapelModel->getsMapel($parm);
		//	test_result($mapel);
			$data['inputype'] = $this->data['inputype'];
			//menampilkan data siswa dalam cek box
			$data['resData'] = $mapel;
		//	$data['keys'] 	 = 'noinduk';
			$data['fields']   = $this->dconfig->srcFields;
			$data['opsi']['ptk']=$ptkModel->getDropDown();
			echo view($this->theme.'cells/tebleinput',$data);
		}
	}
	
	function addAction() //: RedirectResponse
	{
		$this->cekHakAkses('create_data');
		$rules = $this->dconfig->roles;
		if ($this->validate($rules)) {
			$data = $this->request->getPost();
			$roomid = decrypt($data['rombel']);
			show_result($data);
			//menyiapkan data member dari pd yang terpilih:
			$dt['roomid']=$roomid;
			$dt['subgrade']=$data['subgrade'];
			$mapel = $data['id_mapel'];
			$ptk = $data['ptk'];
			$kkm = $data['kkm'];
			
			//pastikan jumlah ptk, mapel dan kkm sama
			if(count($mapel)<>count($ptk)||count($mapel)<>count($kkm))
			{
				$this->session->setFlashdata('warning','Data gagal disimpan');
				return redirect()->to(base_url('ptm'));
			}

			$rowD=[]; 
			foreach($mapel as $key =>$val){
				$dt['id']	=$dt['roomid'].$dt['subgrade'].sprintf("%02d",$key + 1);
				$dt['id_mapel']=$val;
				$dt['ptk_id']=$ptk[$key];
				$dt['kkm']=$kkm[$key];
				$rowD[]=$dt;
			}

			$ptmModel = new PtmModel();
			//memasitkan sudah ada data yang sama atau belum
			$exist = $this->model->where(['roomid'=>$roomid, 'subgrade'=>$dt['subgrade']])->find();
			if($exist){
				$simpan = $ptmModel->updateMasal($rowD);	
			}else{		
				$simpan = $ptmModel->simpanMasal($rowD);
			}

			if($simpan){
				$this->session->setFlashdata('sukses', $simpan.' Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('ptm'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
}
