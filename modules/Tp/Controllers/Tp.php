<?php namespace Modules\Tp\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use Config\Services;
use Modules\Tp\Models\TpModel;
use CodeIgniter\Files\File;
use Config\MyApp;
//use Modules\Tp\Config\Tp;

class Tp extends BaseController
{
	public  $keys='';
	protected $dconfig;
//	protected $session;
	protected $theme;
	
    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Tp\Config\Tp::class);
        $this->session = \Config\Services::session();
		$this->model = new TpModel;	
		$this->data['site_title'] = 'Manajemen Data Tahun Pelajaran';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['opsi'] 	  = $this->dconfig->opsi;
		$this->data['key']		  = $this->dconfig->primarykey;
	//	$this->theme = $this->data[]
		helper(['cookie', 'form']);
    }
	
	function index()
	{
		$this->cekHakAkses('read_data');
		$dttp = $this->model->findAll();
		$total = $this->model->total();
		//echo $this->theme;die();
		$data=$this->data;		
		/*
		* Model Ajax
		*/
		$tp_updated = [];
		$msg = [];
		if (!empty($_POST['submit'])) 
		{
			$tp_updated = $this->model->update();
			
			if ($tp_updated) {
				$msg['status'] = 'ok';
				$msg['content'] = 'Data berhasil diupdate';
			} else {
				$msg['status'] = 'warning';
				$msg['content'] = 'Tidak ada data yang diupdate';
			}
		}
		// End Submit

		$data['title']	= "Manajemen Data Tp";
		$data['rsdata']	= $dttp;
		$data['total']	= $total;
		$data['msg'] 	= $msg;
		$data['actions']= $this->dconfig->actions;
		$data['allowimport']= $this->dconfig->importallowed;
		echo view($this->theme.'datalist',$data);
		
    }
	
	function dtlist()
	{
	 	$request = Services::request(); 
        $m_jur 		= new TpModel();
		$tp 			= $m_jur->findAll();
		$total 			= $m_jur->total();
		
        foreach($tp as $doc)
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
		
		dd($tp);
        echo json_encode($output);
	}
		
	function detail($ids)
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		$data=$this->data;
		$data['title']	= "Update Data Tp";
		$data['error'] = validation_list_errors();
		$data['fields'] = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$rs =  $this->model->find($id);
		$awal = $rs->awal;
		$akhir = $rs->akhir;
		$rsdata = $rs->toarray();
		$rsdata['awal'] 	= $awal->toDateString();
		$rsdata['akhir']	= $akhir->toDateString();
		$data['rsdata'] = $rsdata;
	//	show_result($rsdata);
		echo view($this->theme.'vdetail',$data);
	}
	
	function addView()
	{
		$this->cekHakAkses('create_data');
		$data=$this->data;
		$data['title']	= "Tambah Data Tp";
		$data['error']  = [];//validation_list_errors();
		$data['fields'] = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['rsdata'] = [];
		echo view($this->theme.'form',$data);
	}
	
	function addAction(): RedirectResponse
	{
		$rules = $this->dconfig->roles;
		
		if ($this->validate($rules)) {
			$data = $this->request->getPost();
			$tpmodel = new TpModel();

			$tp= new \Modules\Tp\Entities\Tp();
			$tp->fill($data);
			$simpan = $tpmodel->insert($tp);
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('tp'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function updateView($ids)
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		$roles = $rules = $this->dconfig->roleEdit;
		$data=$this->data;
		$data['title']	= "Update Data Tp";
		$data['error'] = validation_list_errors();
		$data['fields'] = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$rs =  $this->model->find($id);
		$awal = $rs->awal;
		$akhir = $rs->akhir;
		$rsdata = $rs->toarray();
		$rsdata['awal'] 	= $awal->toDateString();
		$rsdata['akhir']	= $akhir->toDateString();
		$data['rsdata'] 	= $rsdata;
	//	show_result($rsdata);
		echo view($this->theme.'form',$data);
	}
	
	function updateAction($ids): RedirectResponse
	{
		$id = decrypt($ids); 
		$roles = $rules = $this->dconfig->roles;
		if ($this->validate($roles)) {
			$data = $this->request->getPost();
			$model = new TpModel();

			$rsdata = new \Modules\Tp\Entities\Tp();
			$rsdata->fill($data);
			$simpan = $model->update($id, $rsdata);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('tp'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function delete($ids){
		$id = decrypt($ids); 
		$tpmodel = new TpModel();
		$tpmodel->delete($id);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('tp'));
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
				return redirect()->to(base_url('tp/konfirm'));
	         }

	         $data = ['errors' => 'The file has already been moved.'];
			
		}else{
			$data = $this->data;
			$data['title']	= "Import Data Tp";
			$data['error'] = validation_list_errors();
			$data['u_ri']  = base_url('tp/tempxls');
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
			$model = new TpModel();
			$simpan = $model->insertBatch($DATA['rsdata']);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('tp'));
		} 
		
		//$nilai $act = nol
		if($act === $DATA['actN']){
			//hapus data dari sesi
			unset($_SESSION['dttp']);
			$this->session->setFlashdata('warning','Data Dibatalkan oleh Pengguna');
			return redirect()->to(base_url('tp'));
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
		$nama_file = 'temp_dataTp';
		$fn = $excel->write_data($nama_file,$headf,$data);
				
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($fn);
	    $writer->save($dirf.$nama_file.'.xlsx');;
        return $this->response->download($dirf.$nama_file.'.xlsx', null);
	}
}

/* End of file yoa.php */
/* Location: ./application/controllers/akademik/yoa.php */