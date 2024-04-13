<?php namespace Modules\Docregister\Controllers;

use App\Controllers\BaseController;
use Modules\Docregister\Models\DocregisterModel;
use Modules\Docregister\Entities\Document;
use Config\Services;

class Docregister extends BaseController
{
	protected $model;
	public $output = [
        'sukses'    => false,
        'pesan'     => '',
        'data'      => []
    ];
    
	public function __construct() {
		
		parent::__construct();
		// $this->mustLoggedIn();
		$this->addJs ( $this->config->baseURL. 'js/modules/docregister.js?r=' . time());
		$this->data['site_title'] = 'MANAJEMEN SURAT KELUAR';
		helper(['cookie', 'form', 'app', 'bootbox']);
		$this->model = new DocregisterModel();
	}
	
	public function index()
	{
		$this->cekHakAkses('read_data');
		
		$data = $this->data;
		
		/*
		$menu_updated = [];
		$msg = [];
		if (!empty($_POST['submit'])) 
		{
			$menu_updated = $this->model->updateData();
			
			if ($menu_updated) {
				$msg['status'] = 'ok';
				$msg['content'] = 'Menu berhasil diupdate';
			} else {
				$msg['status'] = 'warning';
				$msg['content'] = 'Tidak ada menu yang diupdate';
			}
		}
		// End Submit
		*/

		// helper('builtin/admin_menu');
		//$result = $this->model->getMenu('all',true, $this->currentModule['nama_module']);
		//$list_menu = menu_list($result);
		//$docs = new Document;
		
                   	
		//$data['list_data'] 	= $this->lstdata();
		$data['ur']		='suratkeluar/listdoc';
	//	$data['role']	= $this->model->getAllRole();
	//	$data['msg'] 	= $msg;
		$fhead=array('tgl'=>10, 'clascode'=>5, 'no_order'=>5, 'no_surat'=>15, 'tujuan'=>25, 'prihal'=>25);
		$data['fhead']=$fhead;
		echo view('Modules\Docregister\Views\index', $data);
	}
	
	public function listdoc()
	{
		//$docs = new Document;
		$request = Services::request();
		//$model = model(DocregisterModel::class);
		$model = $this->model;
		$nokendali=1;
		$docs= $model->where('no_kendali', $nokendali)
                     ->findAll();
        $data=array();$n=0;
        
        
        foreach($docs as $doc)
        {
        	$no++;
            $row    = array();
            $row[]  = $no;
        	$row[]=$doc->tgl;
        	$row[]=$doc->NomorSurat;
        	$row[]=$doc->prihal;
        	$row[]=$doc->tujuan;
        	$data[]=$row;
        }	
        
        $ndata=$model->where('no_kendali', $nokendali)->countAllResults();
        
        $output = [
            'draw' => $request->getPost('draw'),
            'recordsTotal' => $n,
            'recordsFiltered' => $ndata, //$datatable->countFiltered(),
            'data' => $docs
        ];

        echo json_encode($output);
        //echo json_encode($documents);
                   
	}
	
	public function create()
    {
        if ($this->model->insert($this->request->getPost())) {
            return $this->respondCreated();
        }

        return $this->fail($this->model->errors());
    }
    
	public function tambah()
    {
        $model = model(DocregisterModel::class);
        $user=$this->user;
        if ($this->request->isAJAX()) {
           $data = ['tgl'	=>$this->request->getVar('tgl'),
	            'no_kendali'=> $this->request->getVar('no_kendali'),
	            'clascode'  => $this->request->getVar('clascode'),
	            'nosurat'   => $this->request->getVar('nosurat'),
	            'no_order'  => $this->request->getVar('no_order'),
	            'tujuan'   	=> $this->request->getVar('tujuan'),
	            'prihal'   	=> $this->request->getVar('prihal'),
	            'idtransact'=> $this->request->getVar('idtransact'),
	            'doctype'   => $this->request->getVar('doctype'),
	            'opid'   	=> $user->id,
	            'state'   	=> 1,
            ];
			test_result($data);
           /* $simpan = $model->save($data);
            */
            if ($model->save($data)) {
                $this->output['sukses'] = true;
                $this->output['pesan']  = 'Data ditemukan';
            }

            echo json_encode($this->output);
        }
    }

    public function edit()
    {
        $user_model = $this->user_model;
        if ($this->request->isAJAX()) {
            $id_user = $this->request->getVar('id_user');
            $result = $user_model->edit($id_user);
            if ($result) {
                $this->output['sukses'] = true;
                $this->output['pesan']  = 'Data ditemukan';
                $this->output['data']   = $result;
            }

            echo json_encode($this->output);
        }
    }

    public function update()
    {
        $user_model = $this->user_model;
        if ($this->request->isAJAX()) {
            $data = [
                'nama_user' => $this->request->getVar('nama_user'),
                'alamat'    => $this->request->getVar('alamat')
            ];
            $id_user = $this->request->getVar('id_user');
            $simpan = $user_model->ubah($data, $id_user);
            if ($simpan) {
                $this->output['sukses'] = true;
                $this->output['pesan']  = 'Data diupdate';
            }

            echo json_encode($this->output);
        }
    }

    public function hapus()
    {
        $user_model = $this->user_model;
        if ($this->request->isAJAX()) {
            $id_user = $this->request->getVar('id_user');
            $hapus = $user_model->hapus($id_user);
            if ($hapus) {
                $this->output['sukses'] = true;
                $this->output['pesan']  = 'Data telah dihapus';
            }

            echo json_encode($this->output);
        }
    }
}
