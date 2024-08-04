<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\BaseModel;
use App\Libraries\Auth;
use Config\App;
use Config\MyApp;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    //protected $session;
    
    /**
	* An array of data that used in each module.
	*/
    protected $data;
	protected $model;
	protected $actionUser;
	protected $moduleURL;
	protected $moduleRole;
	protected $theme;
	protected $layout;
	protected $config;
	protected $myconfig;
	protected $isLoggedIn;
	
	public $currentModule;
	
	private $controllerName;
	private $methodName;
	private $strdelimeter;
	
    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        date_default_timezone_set('Asia/Makassar');
        // Preload any models, libraries, etc, here.

       // $this->session = \Config\Services::session();
        #
    }
    
    public function __construct() {	
	//	date_default_timezone_set('Asia/Makassar');
		$this->session = \Config\Services::session();
	//	$this->request = \Config\Services::request();
	//	$this->language = \Config\Services::language();
		helper(['util','app','xhtml','html']);
		
		$this->config = new App;
		$this->myconfig = new MyApp;
		$this->auth = new Auth;
		$user = auth()->user();
		
		//test_result($this->auth);
		
		$this->model = new BaseModel;
		
		$config = config('App');
		$myconfig = config('MyApp');
		
		//$web = $this->session->get('web');
		//modifikasi dimulai dari sini
		$web = $this->session->get('redirect_url');
		
		$router = service('router');
		$controller  = $router->controllerName();
		$exp  = explode('\\', $controller);
		
		$nama_module =  'home';	
		foreach ($exp as $key => $val) {
			if(strtolower($val) == 'modules')unset($exp[$key + 1]);
			if (!$val || strtolower($val) == 'app' || strtolower($val) == 'controllers' || strtolower($val) == 'modules' || strtolower($val) == 'codeigniter' || strtolower($val) == 'shield')unset($exp[$key]);
				
		}
		//service('settings')->set('App.siteName', 'My Great Site');
		 
		// Dash tidak valid untuk nama class, sehingga jika ada dash di url maka otomatis akan diubah menjadi underscore, hal tersebut berpengaruh ke nama controller
		$nama_module = str_replace('_', '-', strtolower(join('/', $exp)));
		$module_url = $config->baseURL . $nama_module;
		
		$web= ['module_url' => $module_url, 'nama_module' => $nama_module, 'method_name' => $router->methodName()];
		$this->methodName = $web['method_name'];
		//Batas Modifikasi 
		//test_result($web);

		$nama_module = $web['nama_module'];
		$module = $this->model->getModule($nama_module);
		 
		if (!$module) {
			$this->data['status'] = 'error';
			$this->data['title'] = 'ERROR';
			$this->data['content'] = 'Module ' . $nama_module . ' tidak ditemukan';
			$this->viewError($this->data);
			exit();
		}
		$this->currentModule = $module;
		$this->moduleURL = $web['module_url'];
		
		//$this->model->checkRememberme();
		$this->isLoggedIn = auth()->loggedIn();
						
		$this->data['current_module'] = $this->currentModule;
	//	$this->data['config'] = $this->config;
//		$this->data['request'] = $this->request;
	//	$this->data['isloggedin'] = $this->isLoggedIn;
		$this->data['session'] = $this->session;
		
		
		$this->data['scripts'] = [];
		$this->data['styles'] = [];
		$this->data['module_url'] = $this->moduleURL;
		$this->data['inputype'] = $myconfig->inputtype;
		$this->data['strdelimeter']=setting('MyApp.arrDelimeter');
		/**
		* 
		* DIHAPUS
		* 
		
		if ($this->isLoggedIn) {
			$user_setting = $this->model->getUserSetting();
			if ($user_setting) {
				$this->data['app_layout'] = json_decode($user_setting->param, true);
				$this->theme=$myconfig->themeDir .$this->data['app_layout']['theme'];	
			}
		} else {
			$query = $this->model->getAppLayoutSetting();
			foreach ($query as $val) {
				$app_layout[$val['param']] = $val['value'];
			}
			$this->data['app_layout'] = $app_layout;
		}
		*/
		
		$this->data['site_title'] = setting('MyApp.siteName');
		$this->data['site_desc'] = setting('MyApp.siteDescription');
		 
		$this->data['settingApp'] = $this->model->getSettingApp();
		//test_result($this->data['settingApp']);
		
		$this->theme	=$myconfig->themeDir .setting()->get('MyApp.theme').'/';
		$this->layout   = $this->theme.'layout';
		
		$this->data['theme'] = $this->theme;
		$this->data['layout'] = $this->layout;
		
		// Login? Yes, No, Restrict
		if ($this->currentModule['login'] == 'Y' && $nama_module != 'login') {
			$this->loginRequired();
		} else if ($this->currentModule['login'] == 'R') {
			$this->loginRestricted();
		}
				
		//if ($this->isLoggedIn) {
		if (auth()->loggedIn()) {
			//$user=user(); 
			$user= auth()->user(); 
			$usrgrup = $user->getGroups();
			//ambil id role dari Database
			$userRole = $this->model->getUserRole($usrgrup[0]);
			$ID_role = $userRole['id_role'];
						 
			$this->user=['id'=>$user->id, 'fullname'=>$user->username, 'username'=>$user->username, 'role'=>$ID_role];
			$this->data['user'] = $this->user;
			
			$this->getModuleRole();
			$this->getListAction($ID_role);
			
			// Check Global Role Action
			$this->checkRoleAction();
			
			// List action assigned to role
			$this->data['action_user'] = $this->actionUser;
			$this->data['menu'] = $this->model->getMenu('all',false, $this->currentModule['nama_module'],$ID_role);
			
		//	test_result($this->data['menu']);
			
			$this->data['breadcrumb'] = ['Home' => $this->config->baseURL, $this->currentModule['judul_module'] => $this->moduleURL];
			$this->data['module_role'] = $this->model->getDefaultUserModule($ID_role);
						
			if ($nama_module == 'login') {
				$this->redirectOnLoggedIn();
			}
		}
	}
	
	private function getModuleRole()
	{
		$query = $this->model->getModuleRole($this->currentModule['id_module']);
		$this->moduleRole = [];
		foreach ($query as $val) {
			$this->moduleRole[$val['id_role']] = $val;
		}
	}
	
	private function getListAction($id_role) 
	{
		if ($this->isLoggedIn && $this->currentModule['nama_module'] != 'login') {
			
			if ($this->moduleRole) {
				if (key_exists($id_role, $this->moduleRole)) {
					
					$this->actionUser = $this->moduleRole[$id_role];
				}
				if ($this->currentModule['nama_module'] != 'login' ) {
					
					if (!key_exists($id_role, $this->moduleRole)) {
						$this->setCurrentModule('error');
						$this->data['msg']['status'] = 'error';
						$this->data['msg']['message'] = 'Anda tidak berhak mengakses halaman ini';
						$this->_render('error.php', $this->data);
						exit();
					}
				}
			} else {
				$this->setCurrentModule('error');
				$this->data['msg']['status'] = 'error';
				$this->data['msg']['message'] = 'Role untuk module ini belum diatur'; 
				$this->data['content']= 'Role untuk module ini belum diatur'; 
				echo view('app_error',$this->data);
				exit();
			}
		}
	}
	
	private function setCurrentModule($module) {
		$this->currentModule['nama_module'] = $module;
	}
	
	protected function getControllerName() {
		return $this->controllerName;
	}
	
	protected function getMethodName() {
		return $this->methodName;
	}
	
	protected function addStyle($file) {
		$this->data['styles'][] = $file;
	}
	
	protected function addJs($file, $print = false) {
		if ($print) {
			$this->data['scripts'][] = ['print' => true, 'script' => $file];
		} else {
			$this->data['scripts'][] = $file;
		}
	}
	
	protected function viewError($data) {
		echo view('app_error.php', $data);
	}
	/*
	protected function view($file, $data = false, $file_only = false) 
	{
		if (is_array($file)) {
			foreach ($file as $file_item) {
				echo view($file_item, $data);
			}
		} else { 
			echo view('main/header.php', $data);
			echo view('main/' . $file, $data);
			echo view('main/footer.php');
		}
	}
	
	protected function view(string $view, array $data = [], array $options = []): string
    {
        return View($view, $data, $options);
    }
	*/
	
	protected function _render(string $view, array $data = [], array $options = []): string
	{
		$view=$this->theme.$view;
		return view($view, $data, $options);
	}
	
	protected function loginRequired() 
	{
		if (!$this->isLoggedIn) {
			header('Location: ' . $this->config->baseURL . 'login');
			// redirect()->to($this->config->baseURL . 'login');
			exit();
		}
	}
	
	protected function loginRestricted() {
		if ($this->isLoggedIn) {
			if ($this->methodName !== 'logout') {
				header('Location: ' . $this->config->baseURL);
			}
		}
	}
	
	protected function redirectOnLoggedIn() {

		if ($this->isLoggedIn) {
			header('Location: ' . $this->config->baseURL . $this->data['module_role']->nama_module);
			// redirect($this->router->default_controller);
		}
	}
	
	protected function mustNotLoggedIn() {
		if ($this->isLoggedIn) {	
			if ($this->currentModule['nama_module'] == 'login') {
				header('Location: ' . $this->config->baseURL . $this->data['module_role']->nama_module);
				exit();
			}
		}
	}
	
	protected function mustLoggedIn() {
		if (!$this->isLoggedIn) {
			header('Location: ' . $this->config->baseURL . 'login');
			exit();
		}
	}
	
	private function checkRoleAction() 
	{
		if ($this->myconfig->checkRoleAction['enable_global']) 
		{
			$method = $this->methodName;
			$error = false;
			if ($method == 'tambah' || $method == 'add') {
				if ($this->actionUser['create_data'] == 'no') {
					$error = 'Role Anda tidak diperkenankan untuk menambah data';
				}
			} else if ($method == 'update' || $method == 'edit') {
				if ($this->actionUser['update_data'] == 'no') {
					$error = 'Role Anda tidak diperkenankan untuk mengubah data';
				}
			} else {
				if (!empty($_POST['delete'])) {
					if ($this->actionUser['delete_data'] == 'no') {
						$error = 'Role Anda tidak diperkenankan untuk menghapus data';
					}
				}
			}
			
			if ($error) {
				$this->data['msg'] = ['status' => 'error', 'message' => $error];
				$this->view('error.php', $this->data);
			}
		}
		
	}
	
	protected function cekHakAkses($action, $table_column = null, $column_check = null) {
		
		$action_title = ['read_data' => 'membuka data', 'create_data' => 'menambah data', 'update_data' => 'mengubah data', 'delete_data' => 'menghapus data'];
		$allowed = $this->actionUser[$action];
				
		if ($allowed == 'no') {
			$this->currentModule['nama_module'] = 'error';
			$this->data['msg'] = ['status' => 'error', 'message' => 'Role Anda tidak diperkenankan untuk ' . $action_title[$action]];
			$this->view('error.php', $this->data);
		} 
		else if ($allowed == 'own') 
		{
			// Read -> go to where_own()
			if ($action == 'read_data') 
				return true;
			
			// Update and delete
			$column = '';
			if ($table_column) {
				$exp = explode('|', $table_column);
				$table = $exp[0];
				$column = @$exp[1];
			} else {
				$table = $this->currentModule['nama_module'];
			}
			
			if (!$column) {
				$column = 'id_' . $table;
			}
			
			if (!$column_check) {
				$column_check = $this->myconfig->checkRoleAction['field'];
			}
		//	show_result($this->data['user'] );
		//	test_result($_SESSION);
		
		//	$result = $this->model->getDataById($table, $column, trim($_REQUEST['id']));
			$result = $this->model->getDataById($table, $column, trim($this->data['user']['username']));
					
			if ($result) {
				$data = $result[0];
				
				if ($data[$column_check] != $_SESSION['user']['id_user']) {
					$this->data['msg'] = ['status' => 'error', 'message' => 'Role Anda tidak diperkenankan untuk ' . $action_title[$action] . ' ini'];
					$this->view('/error.php', $this->data);
				}
			}
		}
	}
	
	public function whereOwn($column = null) 
	{	
		if (!$column)
			$column = $this->myconfig->checkRoleAction['field'];
			
		if ($this->actionUser['read_data'] == 'own') {
			return ' WHERE ' . $column . ' = ' . $this->user['id'];
		}
		return ' WHERE 1 = 1 ';
	}
	
	protected function printError($message) {
		$this->data['title'] = 'Error...';
		$this->data['msg'] = $message;
		$this->view('error.php', $this->data);
		exit();
	}
	
	/* Used for modules when edited data not found */
	protected function errorDataNotFound($addData = null) {
		$data = $this->data;
		$data['title'] = 'Error';
		$data['msg']['status'] = 'error';
		$data['msg']['content'] = 'Data tidak ditemukan';
		
		if ($addData) {
			$data = array_merge($data, $addData);
		}
		$this->view('error-data-notfound.php', $data);
		exit;
	}
    
}
