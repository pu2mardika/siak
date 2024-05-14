<?php namespace Modules\Siswa\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\RedirectResponse;
use Modules\Siswa\Models\SiswaModel;
use Config\Services;
use CodeIgniter\Files\File;
use Config\MyApp;
//use Modules\Siswa\Config\Siswa;

use chillerlan\QRCode\Output\QROutputInterface;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\{QRCode, QROptions};
use Picqer;

class Siswa extends BaseController
{
	public  $keys='';
	protected $dconfig;
//	protected $session;
	protected $theme;
	
    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Siswa\Config\Siswa::class);
        $this->session = \Config\Services::session();
		$this->model = new SiswaModel;	
		$this->prodiModel = model(\Modules\Akademik\Models\ProdiModel::class); 
		$this->data['site_title'] = 'Manajemen Data Siswa';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['opsi'] 	  = $this->dconfig->opsi;
		$this->data['key']		  = $this->dconfig->primarykey;
		
		helper(['cookie', 'form','date']);
	//	$this->addJs (base_url().'/js/jquery.easy-autocomplete.min.js?r=' . time());
		$this->addJs (base_url().'js/modules/siswa.js?r=' . time());
    }
	
	function index()
	{
		$this->cekHakAkses('read_data');
		//$prodiModel = model(\Modules\Akademik\Models\ProdiModel::class); 
		$data=$this->data;		
		/*
		* Model Ajax
		*/
		$siswa_updated = [];
		$msg = [];
		if (!empty($_POST['submit'])) 
		{
			$siswa_updated = $this->model->update();
			if ($siswa_updated) {
				$msg['status']  = 'ok';
				$msg['content'] = 'Data berhasil diupdate';
			} else {
				$msg['status']  = 'warning';
				$msg['content'] = 'Tidak ada data yang diupdate';
			}
		}
		
		if (isset($_GET['ps'])) 
		{
			$cps = $_GET['ps'];
			$ps  = $this->prodiModel->find($cps);
			$addTitle = $ps->nm_prodi;
			$parm = ['prodi'=>$cps];
		}else{
			$cps = "";
			$parm =[];
			$addTitle = "[Semua Prodi]";
		}
		
		$data['title']	  = "Data Siswa ".$addTitle;
		$data['rsdata']	  = $this->model->getAll($parm);
		$dtfilter		  = $this->dconfig->dtfilter;
		$dtfilter['cVal'] = $cps;
		$data['dtfilter'] = $dtfilter;
		$data['ps'] 	  = $this->prodiModel->getDropdown();
	//	$data['actions']  = $this->dconfig->actions;
		$data['condActDet']  = $this->dconfig->condActDet;
		$data['allowimport']= $this->dconfig->importallowed;
		$data['isplainText'] = TRUE;
		echo view($this->theme.'datalist',$data);	
    }
	
	function detail($ids)
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		$data=$this->data;
		$data['title']	= "Update Data Siswa";
		$data['error']  = [];
	//	$data['fields'] = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$rsdata = $this->model->get($id);
		$rsdata['tgllahir']=format_date($rsdata['tgllahir']);
		$data['rsdata'] = $rsdata;
		echo view($this->theme.'vdetail',$data);
	}
	
	function addView()
	{
		$this->cekHakAkses('create_data');
		$data=$this->data;
		$data['title']	= "Tambah Data Siswa";
		$data['error']  = [];
		$data['fields'] = $this->dconfig->addFields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['prodi'] 	= $this->prodiModel->getDropdown();
		$data['rsdata'] = [];
		$data['addONJs'] = "siswa.init()";
		echo view($this->theme.'form',$data);
	}

	function addAction(): RedirectResponse
	{
		$rules = $this->dconfig->roles;	
		if ($this->validate($rules)) {
			$data = $this->request->getPost();
			unset($data['noktp']);

			//MENYIAPKAN DATA PENDUKUNG
			$data = $this->_setNoInduk($data);
			$siswamodel = new SiswaModel();
			$siswa= new \Modules\Siswa\Entities\siswa();
			$siswa->fill($data);
			$simpan = $siswamodel->insert($siswa, false);
			if($simpan){
				$ids = encrypt($NOINDUK);
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
				return redirect()->to(base_url('siswa/ctkreg/'.$ids));
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
				return redirect()->to(base_url('siswa'));
			}	
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function konfirm()
	{
		$this->cekHakAkses('create_data');
		if (isset($_GET['idx'])) 
		{
			$id = decrypt($_GET['idx']);
		}else{
			return redirect()->to(base_url('enrollment'));
		}

		//ambil data registrasi
		$RegModel = model(\Modules\Register\Models\EnrollModel::class); 
		$regData = $RegModel->find($id)->toarray();
		$regData['prodi']=$regData['id_prodi'];
		
		//test_result($regData);
		$fields1 = setting()->get('Register.fields');
		unset($fields1['id_prodi']); //hapus id_prodi
		$fields2 = setting()->get('Siswa.addFields');
		$fields0 = setting()->get('Siswa.addOnFields');
		//$fields1['sumber_info']['extra']['disabled']=true;
		unset($fields2['noktp']);
		unset($fields2['nik']);

		$data = $this->data;
		$data['title']	= "Tambah Data Siswa";
		$data['error']  = [];
		$data['fields'] = array_merge($fields0, $fields1, $fields2);
		$data['opsi'] 	= setting()->get('Register.opsi');
		$data['opsi']['prodi'] 	= $this->prodiModel->getDropdown();
		$data['rsdata'] = $regData;
		$data['hidden'] = ['idreg' => $regData['idreg']];
	//	$data['addONJs'] = "siswa.init()";
		echo view($this->theme.'form',$data);
	}

	function konfirmAction(): RedirectResponse
	{
		$rules = $this->dconfig->roles;	
		if ($this->validate($rules)) {
			$data = $this->request->getPost();
			$dtdikf= ['nik', 'idreg', 'nama', 'nisn', 'tempatlahir', 'tgllahir', 'jk', 'alamat', 'nohp', 
					  'nama_ayah', 'nama_ibu', 'alamat_ortu', 'nohp_ayah', 'nohp_ibu', 'sumber_info'];
			//mengambil data field datadik
			//test_result($data);
			$datadik=[];
			foreach($dtdikf as $k)
			{
				$datadik[$k]=$data[$k];
			}
			
			$siswaf = [
				'noinduk', 'nik', 'prodi', 'no_ijazah', 'tgl_ijazah', 'tgl_diterima', 'tgl_reg', 'no_urt'
			];
			$data = $this->_setNoInduk($data);
			
			$dtreg=[];
			foreach($siswaf as $k)
			{
				$dtreg[$k]=$data[$k];
			}
			show_result($data);
			show_result($datadik);
			show_result($dtreg);
			
			//test_result($data);
			//MENYIMPAN DATA	
			$siswamodel = new SiswaModel();
			$simpan = $siswamodel->actSimpan($datadik, $dtreg);
			if($simpan){
				$ids = encrypt($data['noinduk']);
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
				return redirect()->to(base_url('siswa/ctkreg/'.$ids));
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
				return redirect()->to(base_url('siswa'));
			}	
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}

	function delete($ids){
		$id = decrypt($ids); 
		$siswamodel = new SiswaModel();
		$siswamodel->delete($id);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('siswa'));
	}

	function ctkbukti($ids)
	{
		$id = decrypt($ids);
		//$redColor = [255, 0, 0];
		$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
		#Ambil data 
		$user = $this->data['user'];
		//test_result($user);
		$opsi = $this->data['opsi'];
		$rsdata =  $this->model->get($id);
		$dtQR = base_url('siswa/detail/'.$ids);
		$tgl_lahir= ucwords($rsdata['tempatlahir'].", ".format_date($rsdata['tgllahir']));
		$rsdata['tgllahir'] = $tgl_lahir;
		$rsdata['qrcode'] = '';// '<img src="'.(new QRCode)->render($dtQR).'" alt="QR Code" height="150" width="150" />';
		$barcode   = $generator->getBarcode($rsdata['noinduk'], $generator::TYPE_CODE_128);
		$rsdata['barcode'] = '<img src="data:image/png;base64,'. base64_encode($barcode).'"/>';
		$image ='images/' . setting()->get('MyApp.logo');
		$fdata['logo']	= base_url($image);
		$fdata['instansi']	= setting()->get('MyApp.companyName');
		$fdata['opsi'] = $opsi;
		$fdata['rsdata'] = $rsdata;
		$fdata['fields'] = $this->dconfig->fields;		
		$fdata['rsdata'] = $rsdata;
		$fdata['user'] = $user['fullname'];
	//	test_result($rsdata);
	//	echo view('Modules\Siswa\Views\buktiReg',$fdata);
		#RANDER pdf
		$filename = date('ymdHis').$id.'-Bukti Daftar';

		$html = view('Modules\Siswa\Views\buktiReg',$fdata);
		$pdf = new \App\Libraries\Pdfgenerator();
	//	$pdf->createQR($dtQR);
		
		$hsl = $pdf->generate($html, $filename, "A4", "potrait",FALSE);
        $Data=$this->data;
        $Data['file_pdf'] = $hsl;
        echo view($this->theme.'viewfile',$Data);
		
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
				$this->session->setTempdata('dtsiswa',$Data,120);
				return redirect()->to(base_url('siswa/konfirm'));
	         }

	         $data = ['errors' => 'The file has already been moved.'];
			
		}else{
			$data = $this->data;
			$data['title']	= "Import Data Siswa";
			$data['error'] = validation_list_errors();
			$data['u_ri']  = base_url('siswa/tempxls');
			echo view($this->theme.'frmImport',$data);
		}
	}
	
	public function simpanmasal($act = 0) {
		$DATA = $this->session->getTempdata('dtsiswa');
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
			$model = new SiswaModel();
			$simpan = $model->insertBatch($DATA['rsdata']);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('siswa'));
		} 
		
		//$nilai $act = nol
		if($act === $DATA['actN']){
			//hapus data dari sesi
			unset($_SESSION['dtsiswa']);
			$this->session->setFlashdata('warning','Data Dibatalkan oleh Pengguna');
			return redirect()->to(base_url('siswa'));
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
		$nama_file = 'temp_dataSiswa';
		$fn = $excel->write_data($nama_file,$headf,$data);
				
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($fn);
	    $writer->save($dirf.$nama_file.'.xlsx');;
       // header("Content-Type: application/vnd.ms-excel");
        return $this->response->download($dirf.$nama_file.'.xlsx', null);
	}

	public function getprofil($key="")
	{
		$data = $this->model->getlike($key);
		echo json_encode($data);
		
	}

	private function _setNoInduk($data)
	{
		$thn= unix2Ind(strtotime($data['tgl_reg']),'Y');
		$ps = $this->prodiModel->find($data['prodi'])->toarray();
		
		$param['tgl_reg >']=strtotime("01-01-".$thn. "00:00:00");
		$param['prodi']=$data['prodi'];

		$no=$this->model->getOrder($param);
		$jur = $ps['jurusan'];
		$lv = $ps['jenjang'];
	//	test_result($no);
		$th = unix2Ind(strtotime($data['tgl_reg']),'y');
		$NOINDUK = $jur.$lv.$th.sprintf("%02d",$data['prodi']).sprintf("%03d",$no).random_string('numeric',1);
		$data['no_urt'] =$no;
		$data['noinduk']=$NOINDUK;
		$data['tgl_reg']= strtotime($data['tgl_reg']);
		return $data;	
	}
	
}

/* End of file yoa.php */
/* Location: ./application/controllers/akademik/yoa.php */