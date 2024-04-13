<?php

namespace Modules\Account\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Modules\Account\Models\NotifyModel;
use Config\Services;
use Config\MyApp;

class Notify extends BaseController
{
    protected $dconfig;
	protected $session;
	protected $theme;
	
    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Account\Config\Notify::class);
        $this->session = \Config\Services::session();
		$this->model = new NotifyModel;	
		
		$this->data['site_title'] = 'Notifikasi';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['opsi'] 	  = $this->dconfig->opsi;
		$this->data['key']		  = $this->dconfig->primarykey;
	//	$this->theme = $this->data[]
		helper(['cookie', 'form','date']);
    }
	
	function index()
	{
	//	$this->cekHakAkses('read_data');
		$rs = $this->model->findAll();
		$data = $this->data;
		//test_result($data);
		
		$rsdata=[];
		if(count($rs)>0){
			foreach($rs as $v)
			{
				$dt['id'] = $v->id;
				$dt['created_at'] = $v->created_at;
				$dt['deskripsi'] = $v->deskripsi;
				$parm = $v->param.date('Dz')."H".$v->id;
				
				$aksi = $v->aksi.'/'.encrypt($parm);
				
				$dt['aksi'] = "<a href='".base_url($aksi)."' title = 'Tindak Lanjut'>Tindal Lanjut</a>";
				$rsdata[] = (object) $dt;
			}
		}
		
		$data['title']	= "Manajemen Data Akungrup";
		$data['rsdata']	= $rsdata;
	//	$data['total']	= $total;
		$data['allowADD'] 	= FALSE;
		$data['allowACT'] 	= FALSE;
		$data['msg'] 	= "";
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['actions']= $this->dconfig->actions;
		$data['allowimport']= $this->dconfig->importallowed;
		 
		echo view($this->theme.'datalist',$data);
		
    }
}
