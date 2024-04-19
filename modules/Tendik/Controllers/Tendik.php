<?php namespace Modules\Tendik\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use Config\Services;
use Modules\Tendik\Models\TendikModel;
use CodeIgniter\Files\File;
use Config\MyApp;
//use Modules\Tendik\Config\Tendik;

class Tendik extends BaseController
{
	public  $keys='';
	protected $dconfig;
//	protected $session;
	protected $theme;
	
    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Tendik\Config\Tendik::class);
        $this->session = \Config\Services::session();
		$this->model = new TendikModel;	
		$this->data['site_title'] = 'Manajemen Data Tendik';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['opsi'] 	  = $this->dconfig->opsi;
		$this->data['key']		  = $this->dconfig->primarykey;
	//	$this->theme = $this->data[]
		helper(['cookie', 'form']);
    }
	
	function index()
	{
		$this->cekHakAkses('read_data');
		$dttendik = $this->model->findAll();
		$total = $this->model->total();
		//echo $this->theme;die();
		$data=$this->data;		
		/*
		* Model Ajax
		*/
		$tendik_updated = [];
		$msg = [];
		if (!empty($_POST['submit'])) 
		{
			$tendik_updated = $this->model->update();
			
			if ($tendik_updated) {
				$msg['status'] = 'ok';
				$msg['content'] = 'Data berhasil diupdate';
			} else {
				$msg['status'] = 'warning';
				$msg['content'] = 'Tidak ada data yang diupdate';
			}
		}
		// End Submit

		$data['title']	= "Manajemen Data Tendik";
		$data['rsdata']	= $dttendik;
		$data['total']	= $total;
		$data['msg'] 	= $msg;
		$data['actions']= $this->dconfig->actions;
		$data['allowimport']= $this->dconfig->importallowed;
		echo view($this->theme.'datalist',$data);
		
    }
	
	function dtlist()
	{
	 	$request = Services::request(); 
        $m_jur 		= new TendikModel();
		$tendik 			= $m_jur->findAll();
		$total 			= $m_jur->total();
		
        foreach($tendik as $doc)
        {
        	//$no++;
        	$doc['aksi']="<a href='#' class='btn-warning btn-sm'>Ubah</a>&nbsp; <a href='#' class='btn-danger btn-sm'>Hapus</a>";
        	$ndata[]=$doc;
        }	
        
		 $output = [
            'draw' => $request->getPost('draw'),
            'recordsTotal' => $total,
            'recordsFiltered' => 9, //$datatable->countFiltered(),
            'data' => $ndata
        ];
		
		dd($tendik);
        echo json_encode($output);
	}
		
	function detail($ids)
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		$data=$this->data;
		$data['title']	= "Update Data Tendik";
		$data['error'] = validation_list_errors();
		$data['fields'] = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$rs =  $this->model->find($id);
		$tglLahir = $rs->tgllahir;
		$tmt = $rs->tmt;
		$rsdata = $rs->toarray();
		//$rsdata['tgllahir']=$tglLahir->toDateTimeString();
		$rsdata['tgllahir'] = $tglLahir->toDateString();
		$rsdata['tmt']		= $tmt->toDateString();
		$data['rsdata'] = $rsdata;
	//	show_result($rsdata);
		echo view($this->theme.'vdetail',$data);
	}
	
	function addView()
	{
		$this->cekHakAkses('create_data');
		$data=$this->data;
		$data['title']	= "Tambah Data Tendik";
		$data['error']  = [];
		$data['fields'] = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['rsdata'] = [];
		//test_result($data);
		echo view($this->theme.'form',$data);
	}
	
	function addAction(): RedirectResponse
	{
		$rules = $this->dconfig->roles;
		if ($this->validate($rules)) {
			$data = $this->request->getPost();
			$tendikmodel = new TendikModel();

			$tendik= new \Modules\Tendik\Entities\tendik();
			$tendik->fill($data);
			$simpan = $tendikmodel->insert($tendik);
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('tendik'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function update($ids)
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		$data=$this->data;
		$data['title']	= "Update Data Tendik";
		$data['error'] = validation_list_errors();
		$data['fields'] = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$rs =  $this->model->find($id);
		$tglLahir = $rs->tgllahir;
		$tmt = $rs->tmt;
		$rsdata = $rs->toarray();
		//$rsdata['tgllahir']=$tglLahir->toDateTimeString();
		$rsdata['tgllahir'] = $tglLahir->toDateString();
		$rsdata['tmt']		= $tmt->toDateString();
		$data['rsdata'] 	= $rsdata;
	//	show_result($rsdata);
		echo view($this->theme.'form',$data);
	}
	
	function updateAction($ids): RedirectResponse
	{
		$id = decrypt($ids); 
		$roles = $rules = $this->dconfig->roles;
		$roles = $rules = $this->dconfig->roleEdit;
		
		if ($this->validate($roles)) {
			$data = $this->request->getPost();
			$model = new TendikModel();

			$rsdata = new \Modules\Tendik\Entities\tendik();
			$rsdata->fill($data);
			$simpan = $model->update($id, $rsdata);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			
			return redirect()->to(base_url('tendik'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}		
	}
	
	function delete($ids){
		$id = decrypt($ids); 
		$tendikmodel = new TendikModel();
		$tendikmodel->delete($id);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('tendik'));
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
				$this->session->setTempdata('dtptk',$Data,120);
				return redirect()->to(base_url('tendik/konfirm'));
	         }

	         $data = ['errors' => 'The file has already been moved.'];
			
		}else{
			$data = $this->data;
			$data['title']	= "Import Data Tendik";
			$data['error'] = validation_list_errors();
			$data['u_ri']  = base_url('tendik/tempxls');
			echo view($this->theme.'frmImport',$data);
		}
	}
	
	public function simpanmasal($act = 0) {
		$DATA = $this->session->getTempdata('dtptk');
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
			$model = new TendikModel();
			$simpan = $model->insertBatch($DATA['rsdata']);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('tendik'));
		} 
		
		//$nilai $act = nol
		if($act === $DATA['actN']){
			//hapus data dari sesi
			unset($_SESSION['dttendik']);
			$this->session->setFlashdata('warning','Data Dibatalkan oleh Pengguna');
			return redirect()->to(base_url('tendik'));
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
		$nama_file = 'temp_dataTendik';
		$fn = $excel->write_data($nama_file,$headf,$data);
				
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($fn);
	    $writer->save($dirf.$nama_file.'.xlsx');;
       // header("Content-Type: application/vnd.ms-excel");
        return $this->response->download($dirf.$nama_file.'.xlsx', null);
	}
}

/* End of file yoa.php */
/* Location: ./application/controllers/akademik/yoa.php */