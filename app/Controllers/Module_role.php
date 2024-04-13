<?php
/**
*	App Name	: Admin Template Dashboard Codeigniter 4	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2020
*/

namespace App\Controllers;
use App\Models\ModuleRoleModel;

class Module_role extends \App\Controllers\BaseController
{
	protected $model;
	private $formValidation;
	
	public function __construct() {
		
		parent::__construct();
		$this->addJs ($this->config->baseURL . 'themes/modern/builtin/js/module-role.js');
		$this->addStyle($this->config->baseURL . 'vendors/wdi/wdi-loader.css');
		
		helper ('xhtml');
		
		$this->model = new ModuleRoleModel;	
		$this->data['site_title'] = 'Halaman Module Role';
		// echo '<pre>'; print_r($_SESSION);
		$this->data['module'] = $this->model->getAllModule();
		
		$roles = $this->model->getAllRole();
		foreach($roles as $row) {
			$this->data['role'][$row['id_role']] = $row;
		}

		$this->data['user_role'] = [];
		$module_role = $this->model->getAllModuleRole();
		// echo '<pre>'; print_r($user_role); die;
		foreach($module_role as $row) {
			$this->data['all_module_role'][$row['id_module']][] = $row['id_role'];
		}
	}
	
	public function index()
	{
		$this->cekHakAkses('read_data');
		
		$data = $this->data;
	//	test_result($data);
		// Delete
		if (!empty($_POST['delete'])) {
			$result = $this->model->deleteData();
			// $result = false;
			if ($result) {
				$data['msg'] = ['status' => 'ok', 'message' => 'Data module-role berhasil dihapus'];
			} else {
				$data['msg'] = ['status' => 'error', 'message' => 'Data module-role gagal dihapus'];
			}
		}
					
		$data['result'] = $this->model->getModuleStatus();
		echo view('main\module-role-data', $data);
	}
	
	public function delete() {
		if (isset($_POST['pair_id'])) 
		{
			$query = $this->model->deleteData();
			if ($query) {
				$message = ['status' => 'ok', 'message' => 'Data berhasil dihapus'];
			} else {
				$message = ['status' => 'error', 'message' => 'Data gagal dihapus'];
			}
			echo json_encode($message);
			exit;
		}
	}
	
	public function edit()
	{
		$this->cekHakAkses('update_data');
		$id = $_GET['id'];
		$breadcrumb['Edit'] = '';
		
		$data = $this->data;
		$data['title'] = 'Edit ' . $this->currentModule['judul_module'];
		$data['module'] = $this->model->getModule($id);
		$data['role'] = $this->model->getAllRole();
		$data['role_detail'] = $this->model->getRoleDetail();
		$data['module_role'] = $this->model->getModuleRoleById($id);
		// Submit data
		if (isset($_POST['submit'])) 
		{
			$error = $this->validateForm();
			
			if ($error) {
				$message['status'] = 'error';
				$message['content'] = $error;
			} else {
				
				$query = $this->model->saveData();
				
				if ($query) {
					$message = ['status' => 'ok', 'content' => 'Data berhasil disimpan'];
				} else {
					$message = ['status' => 'error', 'content' => 'Data gagal disimpan'];
				}
			}
			$data['msg'] = $message;
		}
		
		echo $this->view('main/module-role-form-add', $data);
	}
	
	public function detail() {
		$breadcrumb['Detail'] = '';
		
		$data = $this->data;
		$data['title'] = 'Edit ' . $this->currentModule['judul_module'];

		$data['module'] = $this->model->getModule($_GET['id']);
		$data['role'] = $this->model->getAllRole();
		$data['role_detail'] = $this->model->getRoleDetail();
		$data['module_role'] = $this->model->getModuleRoleById($_GET['id']);
		
		echo view('main/module-role-detail', $data);
	}
	
	private function validateForm() {
		
		/* $validation =  \Config\Services::validation();
		if ($this->request->getPost('id_role') == '') {
			$validation->setRule('nama_role', 'Nama Role', 'trim|required');
		}
		$validation->setRule('judul_role', 'Judul Role', 'trim|required');
		$validation->setRule('keterangan', 'keterangan', 'trim|required');
		$validation->withRequest($this->request)->run();
		$form_errors = $validation->getErrors();
		
		if (!$this->auth->validateFormToken('form_edit')) {
			$form_errors['token'] = 'Token tidak ditemukan, submit ulang form dengan mengklik tombol submit';
		}
		
		return $form_errors; */
	}
	
}