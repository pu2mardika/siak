<?php

namespace Modules\Room\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use Modules\Room\Models\MemberModel;
use Modules\Room\Models\RombelModel;
use Modules\Akademik\Models\KurikulumModel;
use Modules\Akademik\Models\ProdiModel;
use Config\Services;
use CodeIgniter\Files\File;
use Config\MyApp;

class RoomMember extends BaseController
{
    public  $keys='';
	protected $dconfig;
	protected $tendikModel;
	protected $TpModel;
	protected $form;

    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Room\Config\RoomMember::class);
        $this->session = \Config\Services::session();
		$this->model = new MemberModel;	
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
		$this->addJs (base_url().'/js/modules/rombel.js?r=' . time());
    }
	
	function index()
	{
		$this->cekHakAkses('read_data');
		$data=$this->data;		
		if (isset($_GET['ids'])) 
		{
			$id = decrypt($_GET['ids']);
		}else{
			$this->session->setFlashdata('warning','Data gagal ditampilkan');
			return redirect()->to(base_url('rombel'));
		}
		//AMbil detail Rombel
		$KUR = $this->currModel->getDropdown();
		$LM = setting()->get('Rombel.opsi');
		$R = $this->rombelModel->getAll(['id'=>$id]);
		$room = (array) $R[0];
		$addTitle = $room['nama_rombel'];
		
		$room['curr_id']=$KUR[$room['curr_id']];
		$room['learn_metode']=$LM['learn_metode'][$room['learn_metode']];
		
		//RESUME DATA
		$data['resume']['field'] = $this->dconfig->ResumeFields;
		$data['resume']['data'] = $room;
		$data['resume']['subtitle'] = "Manajemen Anggota Rombel ";//.$addTitle;
		$data['addOnACt'] = $this->dconfig->detAddOnACt;
		$dtmember = $this->model->getAll(['a.roomid'=>$id]);
		//$data['title']	= "Manajemen Anggota Rombel ".$addTitle;
		$data['rsdata']	= $dtmember;
		$data['msg'] 	= "";
		$data['isplainText'] = false;
		$data['keys'] 	= $this->dconfig->primarykey;
		$data['opsi']   = setting()->get('Siswa.opsi');
		$data['detAction']= $this->dconfig->actions;
	//	test_result($dtmember);
		echo view($this->theme.'frmdatalist',$data);	
    }
		
	function addView($ids = null)
	{
		$this->cekHakAkses('create_data');
		
		if(is_null($ids))
		{
			$this->session->setFlashdata('warning','Data gagal ditampilkan');
			return redirect()->to(base_url('rombel'));
		}
		
		$data = $this->data;
		$data['title']	= "Tambah Data Rombel";
		$fields = $this->dconfig->Addfields;
		$data['error'] = [];
		$data['hidden']	= ['roomid'=>$ids];
		$data['fields'] = $fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['rsdata'] = [];//['kode_ta'=>$ctp];
		$data['addONJs'] = "rombel.add();";
		$data['rtarget']	= "#skl-content";
		echo view($this->theme.'ajxform',$data);
		//echo view($this->theme.'form',$data);
	}

	public function doAction()
	{
		$act = $_GET['act'];
		$ids = $_GET['ids'];

		$opt = $this->dconfig->tofunc;
		$func = $opt[$act];
		$this->$func($ids);
	}
	
	function getDataMember()
	{
		$ids = $_GET['ids'];
		$id = decrypt($ids);
		
		$partisipan = $this->model->getAll(['a.roomid'=>$id]);
		//menampilkan data siswa dalam cek box
		$data['resData'] = $partisipan;
		$data['keys'] 	 = 'noinduk';
		$data['fhead']   = $this->dconfig->srcFields;
		$data['has_ref'] = [];
		$data['opsi']	 = [];
		echo view($this->theme.'cells/tablecheck',$data);
	}
	
	function addAction() //: RedirectResponse
	{
		$this->cekHakAkses('create_data');
		$rules = $this->dconfig->roles;
		if ($this->validate($rules)) {
			$data = $this->request->getPost();
			$dt['roomid']=decrypt($data['roomid']);
			
			//menyiapkan data member dari pd yang terpilih:
			$induk = $data['pd'];
			$rowD=[]; $no=1;
			foreach($induk as $key =>$val){
				$dt['id']	=$dt['roomid'].sprintf("%02d",$no).random_string('numeric',1);
				$dt['noinduk']=$val;
				$dt['no_absen']=$no;
				$rowD[]=$dt;
				$no++;
			}

			$memberModel = new MemberModel();
						
			$simpan = $memberModel->simpanMasal($rowD);
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
	
	function editView($ids)
	{
		$id = decrypt($ids); 
		$data=$this->data;
		$currModel  = model(\Modules\Akademik\Models\KurikulumModel::class); 
		$prodiModel = model(\Modules\Akademik\Models\ProdiModel::class); 
		$data['title']	= "Update Data Rombel";
		$data['error']  = [];
		$data['fields'] = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$rs =  $this->model->find($id)->toarray();
		$rs['wali']     = $rs['walikelas'];
		$data['rsdata'] = $rs;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['kode_ta'] = $this->TpModel->getDropdown();
		$data['opsi']['prodi']   = $prodiModel->getDropdown();
		$data['opsi']['curr_id'] = $currModel->getDropdown();
		$data['addONJs'] = "rombel.init()";
		//test_result($rs);
		echo view($this->theme.'form',$data);
	}

	function editAction($ids): RedirectResponse
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		$roles = $rules = $this->dconfig->roleEdit;
		
		if ($this->validate($roles)) {
			
			//$this->model->update($id, $data);
			$data = $this->request->getPost();
			unset($data['prodi']); //hapus field prodi karena tidak maskuk ekda tabse
			unset($data['wali']); //hapus field wali  karena yang dipakai adalah field wii
			$model = new RombelModel();

			$rsdata = new \Modules\Room\Entities\rombel();
			$rsdata->fill($data);
			$simpan = $model->update($id, $rsdata);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			
			return redirect()->to(base_url('rombel'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function delete($ids){
		$id = decrypt($ids); 
		$rombelmodel = new RombelModel();
		$rombelmodel->delete($id);

		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('rombel'));
	}

	private function prevGrade($ids)
	{
		$id = decrypt($ids);
		$room = $this->rombelModel->find($id)->toarray();
		//ambil type input dari config
		$data = $this->dconfig->suportFields['room'];
		$data['field']= 'roomid';
		$data['inputype']= $this->data['inputype'];
		
		//tampilkan data rombel sebelumnya pada kurikulum yang sama di TP sebelumnya
		$parm['kode_ta'] = $room['kode_ta']-1;
		$parm['curr_id'] = $room['curr_id'];
		$parm['grade']   = $room['grade']-1;
		
		$data['rdata'] = $this->rombelModel->getDropdown($parm);
		echo view($this->theme.'cells/inputform',$data);
		//test_result($data);
	}

	private function newPartisipan($ids)
	{
		//ambil data berdasarkan prodi yang dipilih
		$id    = decrypt($ids);
		$room  = $this->rombelModel->find($id)->toarray();
		$curr = $this->currModel->find($room['curr_id'])->toarray();
		$IDPRODI = $curr['id_prodi'];
		//AMBIL DATA SISWA BARU YANG Id_prodi-nya = $IDPRODI dan belum terdaftar pada rombel di grade sekarang dan di ta sekarang
		$partisipan = $this->model->getParticipan($IDPRODI, $room['kode_ta'], $room['grade']);
		//menampilkan data siswa dalam cek box
		$data['resData'] = $partisipan;
		$data['keys'] 	 = 'noinduk';
		$data['fhead']   = $this->dconfig->srcFields;
		$data['has_ref'] = [];
		$data['opsi']	 = [];
		echo view($this->theme.'cells/tablecheck',$data);
	}
}