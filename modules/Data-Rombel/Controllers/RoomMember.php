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
			$ids= $_GET['ids'];
			$id = decrypt($ids);
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
		$currID = $room['curr_id'];
		$room['curr_id']=$KUR[$currID];
		$stated = $room['learn_metode'];
		$room['learn_metode']=$LM['learn_metode'][$stated];
		$roomID = decrypt($room['id']);
		
		//RESUME DATA
		$data['resume']['field'] = $this->dconfig->ResumeFields;
		$data['resume']['data'] = $room;
		$data['resume']['subtitle'] = "Manajemen Anggota Rombel ";//.$addTitle;

		//AMBIL DATA KURIKULUM MEMILIKI PROJEK ATAU TIDAK
		$KUR = $this->currModel->find($currID); 
		$msg = "NO PROJECT";
		$addOnAct = $this->dconfig->panelAct;
		if($KUR->has_project==1)
		{
			$msg = "HAS PROJECT";
			$data['resume']['field']['projek']=['label' => 'Data Projek', 'perataan'=>'left'];
			
			//ambil data projek
			$projekModel = model(\Modules\Project\SkenModel::class);
		//	$rsProjek = $projekModel->asarray()->where('room_id', $roomID)->findAll();
			$rsProjek = $projekModel->getsAll(['room_id'=>$roomID]);
			//menjadikan hasil rsproject sebagai string
			$data['resume']['data']['projek'] = view_cell('\Modules\Project\Controllers\SkenProject::getProject', ['id'=>$id]);
		}
	
	//	$data['addOnACt'] = $this->dconfig->detAddOnACt;
		$dtmember = $this->model->getAll(['a.roomid'=>$id]);
		$data['rsdata']	= $dtmember;
		$data['msg'] 	= "";
		$data['isplainText'] = false;
		$data['keys'] 	= $this->dconfig->primarykey;
		$data['opsi']   = setting()->get('Siswa.opsi');
		$data['detAction']= $this->dconfig->actions;
		$data['addOnActDet']= $this->dconfig->detAddOnACt;
		$data['condAddOnAct']= $this->dconfig->addOnPanelAct;
		$data['addOnACt']= $addOnAct;
		$data['dataStated']= ($stated==1)?1:2;
		echo view($this->theme.'frmdatalist',$data);	
    }

	function genTuton($ids = null)
	{
		if(is_null($ids))
		{
			$this->session->setFlashdata('warning','Data gagal dilanjutkan');
			return redirect()->to(base_url('rombel'));
		}

		//buat data daring disini
	}

	function cekTuton(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: POST");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

		// add this php file to your web server and enter the complete url in AutoResponder (e.g. https://www.example.com/api_autoresponder.php)

		// to allow only authorized requests, you need to configure your .htaccess file and set the credentials with the Basic Auth option in AutoResponder

		// access a custom header added in your AutoResponder rule
		// replace XXXXXX_XXXX with the name of the header in UPPERCASE (and with '-' replaced by '_')
		$myheader = $_SERVER['HTTP_XXXXXX_XXXX'];
		
		// get posted data
		$data = json_decode(file_get_contents("php://input"));
		
		// make sure json data is not incomplete
		if(
			!empty($data->query) &&
			!empty($data->appPackageName) &&
			!empty($data->messengerPackageName) &&
			!empty($data->query->sender) &&
			!empty($data->query->message)
		){
			
			// package name of AutoResponder to detect which AutoResponder the message comes from
			$appPackageName = $data->appPackageName;
			// package name of messenger to detect which messenger the message comes from
			$messengerPackageName = $data->messengerPackageName;
			// name/number of the message sender (like shown in the Android notification)
			$sender = $data->query->sender;
			// text of the incoming message
			$message = $data->query->message;
			// is the sender a group? true or false
			$isGroup = $data->query->isGroup;
			// name/number of the group participant who sent the message if it was sent in a group, otherwise empty
			$groupParticipant = $data->query->groupParticipant;
			// id of the AutoResponder rule which has sent the web server request
			$ruleId = $data->query->ruleId;
			// is this a test message from AutoResponder? true or false
			$isTestMessage = $data->query->isTestMessage;
			
			// process messages here
			// set response code - 200 success
			http_response_code(200);

			// send one or multiple replies to AutoResponder
			echo json_encode(array("replies" => array(
				array("message" => "Hey " . $sender . "!\nThanks for sending: " . $message),
				array("message" => "Success ✅")
			)));
			
			// or this instead for no reply:
			// echo json_encode(array("replies" => array()));
		}

		// tell the user json data is incomplete
		else{
			
			// set response code - 400 bad request
			http_response_code(400);
			
			// send error
			echo json_encode(array("replies" => array(
				array("message" => "Error ❌"),
				array("message" => "JSON data is incomplete. Was the request sent by AutoResponder?")
			)));
		}

	}
		
	function addView($ids = null)
	{
		$this->cekHakAkses('create_data');
		
		if(is_null($ids))
		{
			$this->session->setFlashdata('warning','Data gagal ditampilkan');
			return redirect()->to(base_url('nilai'));
		}
		$IDS = decrypt($ids);
		$ID = (is_hex($IDS))?decrypt($IDS):$IDS;
	//	test_result($ID);
		$data = $this->data;
		$data['title']	= "Tambah Data Rombel";
		$fields = $this->dconfig->Addfields;
		$data['error'] = [];
		$data['hidden']	= ['roomid'=>encrypt($ID)];
		$data['fields'] = $fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['rsdata'] = [];//['kode_ta'=>$ctp];
		$data['addONJs'] = "rombel.add();";
		$data['rtarget']	= "#skl-content";
		echo view($this->theme.'ajxform',$data);
	//	echo view($this->theme.'form',$data);
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
		$data['fields']  = $this->dconfig->srcFields;
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
	//	$currModel  = model(\Modules\Akademik\Models\KurikulumModel::class); 
	//	$prodiModel = model(\Modules\Akademik\Models\ProdiModel::class); 
		$data['title']	= "Mutasi Rombel";
		$data['error']  = [];
		$data['fields'] = $this->dconfig->Mutasaifields;
		$data['opsi']   = setting()->get('Siswa.opsi');
	
		$rs =  $this->model->find($id)->toarray();
		$rsdata = $this->model->get($rs['noinduk']);
		//show_result($rsdata);
		//AMBIL DATA ROMBEL YANG SETARA
		$room = $this->rombelModel->find($rsdata['roomid'])->toarray();
		$idx = encrypt($rs['roomid']);
		$rsdata['nama_rombel'] = $room['nama_rombel'];
		$data['rsdata'] = $rsdata;
		$parm = ['curr_id'=>$room['curr_id'],'grade'=>$room['grade'],'kode_ta'=>$room['kode_ta']];
		$roomDD = $this->rombelModel->Dropdown($parm);
		unset($roomDD[$rs['roomid']]);
		$data['opsi']['roomid']=$roomDD;
		$data['rtarget']	= "#dtHistory";
		echo view($this->theme.'ajxform',$data);
	}

	function editAction($ids): RedirectResponse
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		$roles = $rules = $this->dconfig->roleEdit;
		
		if ($this->validate($roles)) {
			
			//$this->model->update($id, $data);
			$data = $this->request->getPost();
			$model = new MemberModel();

			$rsdata = new \Modules\Room\Entities\Member();
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
		$MemberModel = new MemberModel();
		$MemberModel->delete($id);

		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('rombel'));
	}

	private function prevGrade($ids)
	{
		$ID    = decrypt($ids);
		$id = (is_hex($ID))?decrypt($ID):$ID;
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
		$ID    = decrypt($ids);
		$id = (is_hex($ID))?decrypt($ID):$ID;
	//	test_result($id);
		$DATA = $this->data;

		$room  = $this->rombelModel->find($id)->toarray();
		$curr = $this->currModel->find($room['curr_id'])->toarray();
		$IDPRODI = $curr['id_prodi'];
		//AMBIL DATA SISWA BARU YANG Id_prodi-nya = $IDPRODI dan belum terdaftar pada rombel di grade sekarang dan di ta sekarang
		$partisipan = $this->model->getParticipan($IDPRODI, $room['kode_ta'], $room['grade']);
		//menampilkan data siswa dalam cek box
		$data['resData'] = $partisipan;
		$data['keys'] 	 = 'noinduk';
	//	$data['fhead']   = $this->dconfig->srcFields;
		$data['fields']   = $this->dconfig->srcFields;
		$data['has_ref'] = [];
		$data['opsi']	 = [];
		$data['inputype'] = $DATA['inputype'];
		echo view($this->theme.'cells/tablecheck',$data);
	}
}