<?php

namespace Modules\Account\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\RedirectResponse;
use Modules\Account\Models\NawalModel;
use Config\Services;
use CodeIgniter\Files\File;
use Config\MyApp;

class NeracaAwl extends BaseController
{
     public  $keys='';
	protected $dconfig;
	protected $session;
	protected $theme;
	protected $model;
	protected $grupModel ;
	
    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Account\Config\Journal::class);
        $this->session = \Config\Services::session();
		$this->model = new AccountModel;	
		$this->data['site_title'] = 'Manajemen Data Neraca Awal';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['opsi'] 	  = $this->dconfig->opsi;
		$this->data['key']		  = $this->dconfig->primarykey;
	//	$this->theme = $this->data[]
		helper(['cookie', 'form','date']);
	//	$this->addJs (base_url().'/js/modules/account.js?r=' . time());
		$this->addJs (base_url().'/js/jquery.easy-autocomplete.min.js?r=' . time());
	//	$this->addJs (base_url().'/js/modules/account.js?r=' . time());
    }
    
    public function index()
    {
        //
    }
}
