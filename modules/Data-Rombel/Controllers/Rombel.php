<?php namespace Modules\Room\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use Modules\Room\Models\RombelModel;
use Modules\Tendik\Models\TendikModel;
use Modules\Tp\Models\TpModel;
use Modules\Akademik\Models\KurikulumModel;
use Modules\Akademik\Models\ProdiModel;
use Config\Services;
use CodeIgniter\Files\File;
use Config\MyApp;
//use Modules\Room\Config\Rombel;

class Rombel extends BaseController
{
	public  $keys='';
	protected $dconfig;
//	protected $session;
	protected $theme;
	protected $tendikModel;
	protected $TpModel;
	protected $form;

    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Room\Config\Rombel::class);
        $this->session = \Config\Services::session();
		$this->model = new RombelModel;	
		$this->tendikModel = new TendikModel;	
		$this->TpModel = new TpModel;
		$this->currModel  = model(\Modules\Akademik\Models\KurikulumModel::class); 	
		$this->data['site_title'] = 'Manajemen Data Rombel';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['opsi'] 	  = $this->dconfig->opsi;
		$this->data['key']		  = $this->dconfig->primarykey;
		
		//$this->form 			  = $this->theme.($this->request->isAJAX())?"ajxform":"form";
		helper(['cookie', 'form','date']);
		$this->addJs (base_url().'/js/modules/rombel.js?r=' . time());
		$this->addJs (base_url().'/js/jquery.easy-autocomplete.min.js?r=' . time());
		$this->addJs (base_url().'/js/modules/rombel.js?r=' . time());
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
			$desc = $tp->deskripsi;
		}else{
			$tp = $this->TpModel->getcurTP();
		    if(isset($tp->thid)){
		        $ctp  = $tp->thid;
		        $desc = $tp->deskripsi;
		    }else{
		        $ctp  = "";
		        $desc = "[Belum Ada Data]";
		    }
		}
		$addTitle = "Tahun ".$desc;
		$parm=['kode_ta'=>$ctp];
		//$dtrombel = $this->model->where('kode_ta', $ctp)->findAll();
		$dtrombel = $this->model->getAll(['kode_ta'=>$ctp]);
		$data['title']	= "Manajemen Data Rombel ".$addTitle;
		$data['rsdata']	= $dtrombel;
		$data['msg'] 	= "";
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['walikelas'] 	= $this->tendikModel->getDropdown();
		$dtfilter	= $this->dconfig->dtfilter;
		$tp = $this->TpModel->getcurTP();
		$dtfilter['cVal'] = $ctp;
		$data['TaPel'] 	= $this->TpModel->getDropdown();
		$data['dtfilter'] 	= $dtfilter;
		$data['actions']= $this->dconfig->actions;
		$data['allowimport']= $this->dconfig->importallowed;
	//	test_result($data['opsi']);
		echo view($this->theme.'datalist',$data);	
    }
		
	function addView()
	{
		$this->cekHakAkses('create_data');
		$data	=$this->data;
		$tp = $this->TpModel->getcurTP();
			//test_result($tp);
		$ctp = $tp->thid;
		$currModel  = model(\Modules\Akademik\Models\KurikulumModel::class); 
		$prodiModel = model(\Modules\Akademik\Models\ProdiModel::class); 
		$data['title']	= "Tambah Data Rombel";
		$fields = $this->dconfig->fields;
		$data['error'] = [];
		$data['fields'] = $fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['kode_ta'] = $this->TpModel->getDropdown();
		$data['opsi']['prodi'] = $prodiModel->getDropdown();
		$data['opsi']['curr_id'] = [];
		$data['rsdata'] = ['kode_ta'=>$ctp];
		$data['addONJs'] = "rombel.init()";
		echo view($this->theme.'form',$data);
	}
	
	function addAction(): RedirectResponse
	{
		$this->cekHakAkses('create_data');
		$rules = $this->dconfig->roles;
		if ($this->validate($rules)) {
			$data = $this->request->getPost();
			$rombelmodel = new RombelModel();
			$data['id']=$data['prodi'];
			unset($data['prodi']); //hapus field prodi karena tidak maskuk ekda tabse
			unset($data['wali']); //hapus field wali  karena yang dipakai adalah field wii
		//	test_result($data);
			$rombel= new \Modules\Room\Entities\Rombel();
			$rombel->fill($data);
			$simpan = $rombelmodel->insert($rombel,false);
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
	
	function editView($ids)
	{
		$id = decrypt($ids); 
		$data=$this->data;
		$currModel  = model(\Modules\Akademik\Models\KurikulumModel::class); 
		$prodiModel = model(\Modules\Akademik\Models\ProdiModel::class); 
		$tendik = $this->tendikModel->getDropdown();
		$data['title']	= "Update Data Rombel";
		$data['error']  = [];
		$data['fields'] = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$rs =  $this->model->find($id)->toarray();
		$rs['wali']     = $tendik[$rs['walikelas']];
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

			$rsdata = new \Modules\Room\Entities\Rombel();
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
		test_result($id);
		$rombelmodel = new RombelModel();
		$rombelmodel->delete($id);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('rombel'));
	}
	
	function fromxlsx(){
		$this->cekHakAkses('create_data');
		$validationRule  =[
			'userfile' => ['uploaded[userfile]'],
		];
		
		if ($this->validate($validationRule)) {
			
			 $xlsx = $this->request->getFile('userfile');
			 if ($xlsx->isValid() && ! $xlsx->hasMoved()) {
	             // Get random file name
				$newName = $xlsx->getRandomName();
				// Store file in public/csvfile/ folder
				
				
				$myconfig = new MyApp;
				$dirf = $myconfig ->tmpfile_dir;
				$filepath = $this->myconfig->tmpfile_dir;
				
				//echo $type; 
				$xlsx->move($filepath, $newName);
				
				$inputFileName = $filepath.$newName;
				$excel = new \App\Libraries\Exc_lib();
				$rsdata = $excel->read_data_xlsx($inputFileName);
				helper('text');
				$Data['actY'] = random_string('md5',32);
				$Data['actN'] = random_string('alnum',12);
				$Data['rsdata'] = $rsdata;
				//Konfirmasi data
				$this->session->setTempdata('dtrombel',$Data,120);
				return redirect()->to(base_url('rombel/konfirm'));
	         }

	         $data = ['errors' => 'The file has already been moved.'];
			
		}else{
			$data = $this->data;
			$data['title']	= "Import Data Rombel";
			$data['error'] = validation_list_errors();
			$data['u_ri']  = base_url('rombel/tempxls');
			echo view($this->theme.'frmImport',$data);
		}
	}
	
	public function simpanmasal($act = 0) {
		$DATA = $this->session->getTempdata('dtrombel');
		//test_result($Data);
		//$nilai $act = nol
		if($act === 0){
			//tampilkan ke browser
			$Data = $this->data;
			$data = array_merge($Data,$DATA);
			$data['title'] = "Konfirmasi Data!";
		//	test_result($data);
			echo view($this->theme.'list2konfirm',$data);
		}
		
		if($act === $DATA['actY']){
			$model = new RombelModel();
			$simpan = $model->insertBatch($DATA['rsdata']);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('rombel'));
		} 
		
		//$nilai $act = nol
		if($act === $DATA['actN']){
			//hapus data dari sesi
			unset($_SESSION['dtrombel']);
			$this->session->setFlashdata('warning','Data Dibatalkan oleh Pengguna');
			return redirect()->to(base_url('rombel'));
		}
	}
	
	function tmpobyek()
	{
		$excel = new \App\Libraries\Exc_lib();
		$myconfig = new MyApp;
		$dirf = $myconfig ->tmpfile_dir;
		
		$filepath = $this->myconfig->tmpfile_dir;
		$headf = [];
		$fields= $this->dconfig->fields;
		foreach ($fields as $k => $v){
			$headf[]=$k;
			$rowdata[$k]=$v['label'];
		}
		$data[] = $rowdata;
		$nama_file = 'temp_dataRombel';
		$fn = $excel->write_data($nama_file,$headf,$data);
				
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($fn);
	    $writer->save($dirf.$nama_file.'.xlsx');;
       // header("Content-Type: application/vnd.ms-excel");
        return $this->response->download($dirf.$nama_file.'.xlsx', null);
	}
	
	public function getwali($key="")
	{
		$modtendik = new TendikModel;
		$data = $modtendik->getlike($key);
		//test_result($this->currentModule);
		echo json_encode($data);
		
	}
	
	public function getcurr($id)
	{
	  $room = $this->currModel->getDropdown($id);
	  //test_result($room);
	  $htm='<option value="">[--PILIH KURIKULUM--]</option>';
	  if(count($room)>0)
	  {
		  unset($room['-']);
		  foreach($room as $k => $v)
		  {
			  //$ky=$this->kriptograf->paramEncrypt($k,$this->key);
			  $htm .='<option value="'.$k.'">'.$v.'</option>';
		  }
	  }
	  return $htm;
  }

  function getGrade($id)
  	{
		$grade=$this->currModel->getLevel($id);
		$r = $grade['grade'];
		$htm='<option value="">[--PILIH--]</option>';
		if(count($r)>0)
		{
			foreach($r as $k =>$val)
			{
				$htm .='<option value="'.$k.'">'.$val.'</option>';
			}
		}
		return $htm;
	}

}

/* End of file yoa.php */
/* Location: ./application/controllers/akademik/yoa.php */