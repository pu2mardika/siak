<?php namespace Modules\Register\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\RedirectResponse;
use Modules\Register\Models\RegisterModel;
use Config\Services;
use CodeIgniter\Files\File;
use Config\MyApp;
//use Modules\Register\Config\Register;
use Dompdf\Dompdf;
use chillerlan\QRCode\{QRCode, QROptions};

class Register extends BaseController
{
	public  $keys='';
	protected $dconfig; 
	protected $theme;
	
    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Register\Config\Register::class);
        $this->session = \Config\Services::session();
		$this->model = new RegisterModel;	
		$this->data['site_title'] = 'Manajemen Data Register';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['opsi'] 	  = $this->dconfig->opsi;
		$this->data['key']		  = $this->dconfig->primarykey;
	//	$this->theme = $this->data[]
		helper(['cookie', 'form']);
    }
	
	function index()
	{
		$this->cekHakAkses('read_data');
		$dtRegister = $this->model->findAll();
		$total = $this->model->total();
		//echo $this->theme;die();
		$data=$this->data;	
	//	test_result($data);	
		/*
		* Model Ajax
		*/
		$Register_updated = [];
		$msg = [];
		if (!empty($_POST['submit'])) 
		{
			$Register_updated = $this->model->update();
			
			if ($Register_updated) {
				$msg['status'] = 'ok';
				$msg['content'] = 'Data berhasil diupdate';
			} else {
				$msg['status'] = 'warning';
				$msg['content'] = 'Tidak ada data yang diupdate';
			}
		}
		// End Submit
		$data['title']	= "Manajemen Data Register";
		$data['rsdata']	= $dtRegister;
		$data['total']	= $total;
		$data['msg'] 	= $msg;
		$data['actions']= $this->dconfig->actions;
		$data['allowimport']= $this->dconfig->importallowed;
		echo view($this->theme.'datalist',$data);
    }
	
	function detail($ids)
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		$data=$this->data;
		$data['title']	= "Update Data Register";
		$data['error'] = validation_list_errors();
		$data['fields'] = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$rs =  $this->model->find($id);
		$tglLahir = $rs->tgllahir;
		$rsdata = $rs->toarray();
		//$rsdata['tgllahir']=$tglLahir->toDateTimeString();
		$rsdata['tgllahir']=$tglLahir->toDateString();
		$data['rsdata'] = $rsdata;
	//	show_result($rsdata);
		echo view($this->theme.'vdetail',$data);
	}
	
	function addView()
	{
		$uri   = current_url(true);
		$prodi = $uri->setSilent()->getSegment(3, 0);
		$data=$this->data; //mengambil data
		$data['title']	= "Tambah Data Register";
		$data['error']  = validation_list_errors();
		$fields = $this->dconfig->fields;
		$rsdata = [];
		if($prodi > 0){
			$fields['id_prodi']['type']='hidden';
			$rsdata['id_prodi']=$prodi;
		}
		$data['fields'] = $fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['rsdata'] = $rsdata;
		//test_result($data);
		echo view($this->theme.'form',$data);
	}

	function addAction() : RedirectResponse
	{
		//$this->cekHakAkses('create_data');
		$rules = $this->dconfig->roles;
		
				
		if ($this->validate($rules)) {
			$rdata = $this->request->getPost();
			$rdata['idreg']=register(date("Y-m-d"));

			$Registermodel = new RegisterModel();
			$Register= new \Modules\Register\Entities\Register();
			$Register->fill($rdata);
			$simpan = $Registermodel->insert($Register,false);
			
			if($simpan){
				$ids=encrypt($rdata['nik']);
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
				return redirect()->to(base_url('enroll/ctkreg/'.$ids));
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
				return redirect()->to(base_url('enroll'));
			}
			
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	
	function ctkbukti($ids)
	{
		$id = decrypt($ids);
		#Ambil data 
		$rs =  $this->model->find($id);
		$tglLahir = $rs->tgllahir;
		$rsdata = $rs->toarray();
		//$rsdata['tgllahir']=$tglLahir->toDateTimeString();
		$rsdata['tgllahir']=$tglLahir->toDateString();

		$dtQR = base_url('daftar/detail/'.$ids);
		$tgl_lahir= $rsdata['tempatlahir'].", ".format_tanggal($rsdata['tgllahir']);
		$rsdata['tgllahir'] = $tgl_lahir;
		$rsdata['qrcode'] = '<img src="'.(new QRCode)->render($dtQR).'" alt="QR Code" height="150" width="150" />';;
		$fdata['rsdata'] = $rsdata;
		$fdata['fields'] = $this->dconfig->printfield;
		$fdata['opsi'] 	= $this->dconfig->opsi;				
		$data['rsdata'] = $fdata;
		
		#RANDER pdf
		$filename = date('ymdHis').$id.'-Bukti Daftar';

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        // load HTML content
        $dompdf->loadHtml(view('Modules\Register\Views\print_bukti',$data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'potrait');

        // render html as PDF
        $dompdf->render();
        // output the generated pdf
        $dompdf->stream($filename);
	}
	
	function updateView($ids)
	{
		$data=$this->data;
		$data['title']	= "Update Data Register";
		$data['error'] = validation_list_errors();
		$data['fields'] = $this->dconfig->validasi_fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$rs =  $this->model->find($id);
		$tglLahir = $rs->tgllahir;
		$rsdata = $rs->toarray();
		//$rsdata['tgllahir']=$tglLahir->toDateTimeString();
		$rsdata['tgllahir']=$tglLahir->toDateString();
		$data['rsdata'] = $rsdata;
	//	show_result($rsdata);
		echo view($this->theme.'form',$data);
	}

	function updateAction($ids): RedirectResponse
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		$roles = $this->dconfig->roleEdit;
		
		if ($this->validate($roles)) {
			//$this->model->update($id, $data);
			$data = $this->request->getPost();
			$model = new RegisterModel();

			$rsdata = new \Modules\Register\Entities\Register();
			$rsdata->fill($data);
			$simpan = $model->update($id, $rsdata);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('daftar'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function delete($ids){
		$id = decrypt($ids); 
		$Registermodel = new RegisterModel();
		$Registermodel->delete($id);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('daftar'));
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
				$this->session->setTempdata('dtRegister',$Data,120);
				return redirect()->to(base_url('Register/konfirm'));
	         }

	         $data = ['errors' => 'The file has already been moved.'];
			
		}else{
			$data = $this->data;
			$data['title']	= "Import Data Register";
			$data['error'] = validation_list_errors();
			$data['u_ri']  = base_url('Register/tempxls');
			echo view($this->theme.'frmImport',$data);
		}
	}
	
	public function simpanmasal($act = 0) {
		$DATA = $this->session->getTempdata('dtRegister');
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
			$model = new RegisterModel();
			$simpan = $model->insertBatch($DATA['rsdata']);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('daftar'));
		} 
		
		//$nilai $act = nol
		if($act === $DATA['actN']){
			//hapus data dari sesi
			unset($_SESSION['dtRegister']);
			$this->session->setFlashdata('warning','Data Dibatalkan oleh Pengguna');
			return redirect()->to(base_url('daftar'));
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
		$nama_file = 'temp_dataRegister';
		$fn = $excel->write_data($nama_file,$headf,$data);
				
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($fn);
	    $writer->save($dirf.$nama_file.'.xlsx');;
       // header("Content-Type: application/vnd.ms-excel");
        return $this->response->download($dirf.$nama_file.'.xlsx', null);
	}
}

/* End of file yoa.php */
/* Location: ./application/controllers/akademik/yoa.php */