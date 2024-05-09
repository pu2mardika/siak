<?php

namespace Modules\Register\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;
use CodeIgniter\Files\File;
use Config\MyApp;
use Modules\Register\Models\EnrollModel;
//use Modules\Akademik\Models\ProdiModel;

use Dompdf\Dompdf;
use chillerlan\QRCode\{QRCode, QROptions};

class Enrollment extends BaseController
{
    public  $keys='';
	protected $dconfig; 
	protected $theme;
	
    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Register\Config\Register::class);
        $this->session = \Config\Services::session();
		$this->model = new EnrollModel;	
		$this->ProdiModel = model(\Modules\Akademik\Models\ProdiModel::class);
		$this->data['site_title'] = 'Manajemen Data Calon Peserta Didik';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['opsi'] 	  = $this->dconfig->opsi;
		$this->data['opsi']['id_prodi'] = $this->ProdiModel->getDropdown();
		$this->data['key']		  = $this->dconfig->primarykey;
	//	$this->theme = $this->data[]
		helper(['cookie', 'form']);
    }
	
	function index()
	{
		$this->cekHakAkses('read_data');
		$dtRegister = $this->model->findAll();
		$data=$this->data;	
		$data['title']	= "Data Calon Peserta Didik";
		$data['rsdata']	= $dtRegister;
		$data['actions']= $this->dconfig->actions;
		$data['allowimport']= $this->dconfig->importallowed;
		echo view($this->theme.'datalist',$data);
    }
	
	function addView()
	{
		$uri   = current_url(true);
		$prodi = $uri->setSilent()->getSegment(3, 0);
		
		$data=$this->data; //mengambil data
		$data['title']	= "Registrasi Calon Peserta Didik";
		$data['error']  = [];
		$fields = $this->dconfig->fields;
		$rsdata = [];
		if (isset($_GET['idx'])) 
		{
			$nik = $_GET['idx'];
			$rsdata = $this->model->find($nik);
			if(!$rsdata)
			{
				$rsdata['nik']=$nik;
			}
		}

		if($prodi <> 0){
			$fields['id_prodi']['type']='hidden';
			$rsdata['id_prodi']=$prodi;
		}
		$data['fields'] = $fields;
		//$data['opsi'] 	= $this->dconfig->opsi;
		$data['rsdata'] = $rsdata;
		$data['addOnJSFunc'] = $this->dconfig->addonJS;
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
			//test_result($rdata);
			$Registermodel = new EnrollModel();
			$Register= new \Modules\Register\Entities\Enroll();
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
		$opsi = $this->data['opsi'];
		$rsdata =  $this->model->find($id)->toarray();
		$dtQR = base_url('enroll/detail/'.$ids);
		$tgl_lahir= ucwords($rsdata['tempatlahir'].", ".format_tanggal($rsdata['tgllahir']));
		$rsdata['tgllahir'] = $tgl_lahir;
		$rsdata['qrcode'] = '<img src="'.(new QRCode)->render($dtQR).'" alt="QR Code" height="150" width="150" />';
		$image ='images/' . setting()->get('MyApp.logo');
		$rsdata['logo']	= base_url($image);
		$rsdata['judul'] = "PROGRAM PILIHAN: ".strtoupper($opsi['id_prodi'][$rsdata['id_prodi']]);
		$fdata['opsi'] = $opsi;
		$fdata['rsdata'] = $rsdata;
		$fdata['fields'] = $this->dconfig->printfield;		
		$data['rsdata'] = $fdata;
		//echo view('Modules\Register\Views\print_bukti',$data);
		
		#RANDER pdf
		$filename = date('ymdHis').$id.'-Bukti Daftar';

        // instantiate and use the dompdf class
       /*
        $dompdf = new Dompdf(array('enable_remote' => true));
        // load HTML content
        $dompdf->loadHtml(view('Modules\Register\Views\print_bukti',$data));
        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'potrait');
        // render html as PDF
        $dompdf->render();
        // output the generated pdf
        $dompdf->stream($filename);
		*/
		$html = view('Modules\Register\Views\print_bukti',$data);
		$pdf = new \App\Libraries\Pdfgenerator();
		$hsl = $pdf->generate($html, $filename, "A4", "landscape");
		
        //echo $hsl;
        $Data=$this->data;
        $Data['file_pdf'] = $hsl;
        echo view($this->theme.'viewfile',$Data);
	}
	
	function updateView($ids)
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		$data=$this->data;
		$data['title']	= "Update Data Calon Peserta Didik";
		$data['error'] = validation_list_errors();
		$data['fields'] = $this->dconfig->validasi_fields;
		$rs =  $this->model->find($id);
		$tglLahir = $rs->tgllahir;
		$rsdata = $rs->toarray();
		//$rsdata['tgllahir']=$tglLahir->toDateTimeString();
		//$rsdata['tgllahir']=$tglLahir->toDateString();
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
			$model = new EnrollModel();

			$rsdata = new \Modules\Register\Entities\Enroll();
			$rsdata->fill($data);
			$simpan = $model->update($id, $rsdata);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('enrollment'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function delete($ids){
		$id = decrypt($ids); 
		$Registermodel = new EnrollModel();
		$Registermodel->delete($id);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('enrollment'));
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
				return redirect()->to(base_url('enrollment/konfirm'));
	         }

	         $data = ['errors' => 'The file has already been moved.'];
			
		}else{
			$data = $this->data;
			$data['title']	= "Import Data Register";
			$data['error'] = validation_list_errors();
			$data['u_ri']  = base_url('enrollment/tempxls');
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
			$model = new EnrollModel();
			$simpan = $model->insertBatch($DATA['rsdata']);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('enrollment'));
		} 
		
		//$nilai $act = nol
		if($act === $DATA['actN']){
			//hapus data dari sesi
			unset($_SESSION['dtRegister']);
			$this->session->setFlashdata('warning','Data Dibatalkan oleh Pengguna');
			return redirect()->to(base_url('enrollment'));
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
