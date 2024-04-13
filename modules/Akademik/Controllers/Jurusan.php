<?php namespace Modules\Akademik\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\RedirectResponse;
use Modules\Akademik\Models\JurusanModel;
use Config\Services;
use Config\MyApp;

class Jurusan extends BaseController
{
	public  $keys='';
    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Akademik\Config\Jurusan::class);
        $this->session = \Config\Services::session();
		$this->model = new JurusanModel;	
		$this->data['site_title'] = 'Halaman Program';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['key']		  = $this->dconfig->primarykey;
		helper(['cookie', 'form']);
    }
	
	function index()
	{
		$this->cekHakAkses('read_data');
		
		$m_jur 		= new JurusanModel();
		$jurusan 	= $m_jur->findAll();
		$total 		= $m_jur->total();
		
		$data = $this->data;
		$data['title']		= "Manajemen Jenis Program";
		$data['rsdata']		= $jurusan;
		$data['total']		= $total;
		$data['msg'] 		= "";
		$data['opsi'] 		= $this->dconfig->opsi;
		$data['actions']	= $this->dconfig->actions;
		$data['allowimport']= $this->dconfig->importallowed;
		echo view($this->theme.'datalist',$data);
    }
	
	function dtlist()
	{
	 	$request = Services::request(); 
        $m_jur 		= new JurusanModel();
		$jurusan 		= $m_jur->findAll();
		$total 			= $m_jur->total();
		
        foreach($jurusan as $doc)
        {
        	$ndata[]=$doc;
        }	
        
		 $output = [
            'draw' => $request->getPost('draw'),
            'recordsTotal' => $total,
            'recordsFiltered' => 9, //$datatable->countFiltered(),
            'data' => $ndata
        ];
		
		dd($jurusan);
		
        echo json_encode($output);
	}
	
	function detail($ids)
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		$data=$this->data;
		$data['title']	= "Update Data";
		$data['error'] = [];
		$data['fields'] = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$rs =  $this->model->find($id);
		$tglLahir = $rs->tgllahir;
		$rsdata = $rs->toarray();
		$data['rsdata'] = $rsdata;
	//	show_result($rsdata);
		echo view($this->theme.'vdetail',$data);
	}
	
	function addView()
	{
		$this->cekHakAkses('create_data');
		
		$data	=$this->data;
		$data['title']	= "Tambah Data Jenis Program";
		$fields = $this->dconfig->fields;
		$data['error'] = [];// validation_list_errors();
		$data['fields'] = $fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['rsdata'] = [];
		echo view($this->theme.'form',$data);
	}

	function addAction(): RedirectResponse
	{
		$rules = $this->dconfig->roles;	
		if ($this->validate($rules)) {
			$data = $this->request->getPost();
			$Jurusanmodel = new JurusanModel();
			$Jurusan= new \Modules\Akademik\Entities\Jurusan();
			$Jurusan->fill($data);
			$simpan = $Jurusanmodel->insert($Jurusan,false);
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('Jurusan'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function updateView($ids)
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		 
		$data=$this->data;
		$data['title']	= "Update Data Jenis Program";
		$data['error'] = validation_list_errors();
		$data['fields'] = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$rs =  $this->model->find($id)->toarray();
		$data['rsdata'] = $rs;
		echo view($this->theme.'form',$data);
	}
	
	function updateAction($ids): RedirectResponse
	{
		$id = decrypt($ids); 
		$roles = $rules = $this->dconfig->roleEdit;
		
		if ($this->validate($roles)) {
			
			//$this->model->update($id, $data);
			$data = $this->request->getPost();
			$model = new JurusanModel();

			$rsdata = new \Modules\Akademik\Entities\Jurusan();
			$rsdata->fill($data);
			$simpan = $model->update($id, $rsdata);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			
			return redirect()->to(base_url('Jurusan'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}

	function delete($ids){
		$id = decrypt($ids); 
		$Jurusanmodel = new JurusanModel();
		$Jurusanmodel->delete($id);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('Jurusan'));
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
				$this->session->setTempdata('dtJurusan',$Data,120);
				return redirect()->to(base_url('Jurusan/konfirm'));
	         }

	         $data = ['errors' => 'The file has already been moved.'];
			
		}else{
			$data = $this->data;
			$data['title']	= "Import Data Rombel";
			$data['error'] = validation_list_errors();
			$data['u_ri']  = base_url('program/tempxls');
			echo view($this->theme.'frmImport',$data);
		}
	}
	
	public function simpanmasal($act = 0) {
		$DATA = $this->session->getTempdata('dtJurusan');

		if($act === 0){
			//tampilkan ke browser
			$Data = $this->data;
			$data = array_merge($Data,$DATA);
			$data['title'] = "Konfirmasi Data!";
		//	test_result($data);
			echo view($this->theme.'list2konfirm',$data);
		}
		
		if($act === $DATA['actY']){
			$model = new JurusanModel();
			$simpan = $model->insertBatch($DATA['rsdata']);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('Jurusan'));
		} 
		
		//$nilai $act = nol
		if($act === $DATA['actN']){
			//hapus data dari sesi
			unset($_SESSION['dtJurusan']);
			$this->session->setFlashdata('warning','Data Dibatalkan oleh Pengguna');
			return redirect()->to(base_url('Jurusan'));
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
	
	function togle_sts($ids,$val){
		$id=$this->kriptograf->paramDecrypt($ids,$this->keys);
		$sts=$this->kriptograf->paramDecrypt($val,$this->keys);
		$this->mod_jurusan->togle_state($id,$sts);
		$this->fungsi->load_ajax('akademik/jurusan/list_jurusan','#panel_editing');
	}	
	
}

/* End of file yoa.php */
/* Location: ./application/controllers/akademik/yoa.php */