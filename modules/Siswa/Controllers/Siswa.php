<?php namespace Modules\Siswa\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\RedirectResponse;
use Modules\Siswa\Models\SiswaModel;
use Config\Services;
use CodeIgniter\Files\File;
use Config\MyApp;
//use Modules\Siswa\Config\Siswa;

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
		$this->data['site_title'] = 'Manajemen Data Siswa';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['opsi'] 	  = $this->dconfig->opsi;
		$this->data['key']		  = $this->dconfig->primarykey;
	//	$this->theme = $this->data[]
		helper(['cookie', 'form']);
    }
	
	function index()
	{
		$this->cekHakAkses('read_data');
		$dtsiswa = $this->model->findAll();
		$total = $this->model->total();
		//echo $this->theme;die();
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
				$msg['status'] = 'ok';
				$msg['content'] = 'Data berhasil diupdate';
			} else {
				$msg['status'] = 'warning';
				$msg['content'] = 'Tidak ada data yang diupdate';
			}
		}
		// End Submit

		$data['title']	= "Manajemen Data Siswa";
		$data['rsdata']	= $dtsiswa;
		$data['total']	= $total;
		$data['msg'] 	= $msg;
		$data['actions']= $this->dconfig->actions;
		$data['allowimport']= $this->dconfig->importallowed;
		echo view($this->theme.'datalist',$data);
		
    }
	
	function dtlist()
	{
	 	$request = Services::request(); 
        $m_jur 		= new SiswaModel();
		$siswa 			= $m_jur->findAll();
		$total 			= $m_jur->total();
		
        foreach($siswa as $doc)
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
		
		dd($siswa);
        echo json_encode($output);
	}
	
	function v_trash()
	{
		$offset = $this->uri->segment(4,0);
		$banyak_ya=$this->mod_jurusan->get_num();		
		$perpage=$this->config->item('perpage');
		$data2=$this->fungsi->getAjaxPagination($banyak_ya,
				$perpage,'akademik/jurusan/v_trash/',4,'#panel_editing');
		$data['paging'] = $data2['paging'];
		$data['banyak']=$banyak_ya;
		$data['jurusan'] = $this->mod_jurusan->view_trash($perpage,$offset);
		$this->load->view('akademik/jurusan/trash_panel',$data);
	}
	
	function detail($ids)
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		$data=$this->data;
		$data['title']	= "Update Data Siswa";
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
	
	function tambah()
	{
		$this->cekHakAkses('create_data');
		$rules = $this->dconfig->roles;
		//$this->simplival->hak('master',1);
		
		if ($this->validate($rules)) {
			$this->_simpandata();
		}else{
			$data=$this->data;
			$data['title']	= "Tambah Data Siswa";
			$data['error'] = validation_list_errors();
			$data['fields'] = $this->dconfig->fields;
			$data['opsi'] 	= $this->dconfig->opsi;
			$data['rsdata'] = [];
			//test_result($data);
			echo view($this->theme.'form',$data);
		}
	}
	
	
	private function _simpandata()
	{
		$data = $this->request->getPost();
		$siswamodel = new SiswaModel();

		$siswa= new \Modules\Siswa\Entities\siswa();
		$siswa->fill($data);
		$simpan = $siswamodel->insert($siswa);
		if($simpan){
			$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
		}else{
			$this->session->setFlashdata('warning','Data gagal disimpan');
		}
		return redirect()->to(base_url('siswa'));
	}
	
	function update($ids)
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		$roles = $rules = $this->dconfig->roleEdit;
		
		if ($this->validate($roles)) {
			
			//$this->model->update($id, $data);
			$data = $this->request->getPost();
			$model = new SiswaModel();

			$rsdata = new \Modules\Siswa\Entities\siswa();
			$rsdata->fill($data);
			$simpan = $model->update($id, $rsdata);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			
			return redirect()->to(base_url('siswa'));
		}else{
			$data=$this->data;
			$data['title']	= "Update Data Siswa";
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
			echo view($this->theme.'form',$data);
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
}

/* End of file yoa.php */
/* Location: ./application/controllers/akademik/yoa.php */