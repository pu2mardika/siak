<?php namespace Config;

use CodeIgniter\Config\BaseConfig;
class MyApp extends BaseConfig
{

	public $imagesPath = ROOTPATH . 'public/images/';
	 
	public $imagesURL = 'http://localhost/perpus/public/images/';
	
	public $checkRoleAction = ['enable_global' => true, 'field' =>'id_user_input'];
	
	public $csrf = [
	
		// Load csrf_helper.php
		'enable' => true,
		
		// Automatic insert token into cookie
		'auto_settoken' => true,
		
		// Auto compare cookie token and $_POST token and exit program when an error occured
		'auto_check' => false,
		
		// Form field, misal: <input type="hidden" name="csrf_app_token" value="..."/>
		'name' => 'csrf_app_token',
		
		// Cookie lifetime in seconds
		'expire' => 7200
	];
	
	public $siteName 	= 'Sistem Informasi Administrasi Akademik';
	public $appVerison  = '4.0.1';
	public $appName 	= 'SIAK';
	public $theme 	 	= 'sbadmin2';
	public $themeDir 	= 'themes/';
	
	public $inputtype = [
		'checkbox'	=>	'form_checkbox',
		'color'		=>	'form_input',
		'date'		=>	'form_input',
		'dropdown'	=>	'form_dropdown',
		'email'		=>	'form_input',
		'file'		=>	'form_input',
		'month'		=>	'form_input',
		'number'	=>	'form_input',
		'range'		=>	'form_input',
		'search'	=>	'form_input',
		'tel'		=>	'form_input',
		'text'		=>	'form_input',
		'textarea'	=>	'form_textarea',
		'time'		=>	'form_input',
		'url'		=>	'form_input',
		'week'		=>	'form_input',
		'hidden'	=>	'form_hidden',
	];
	
	public $tmpfile_dir = WRITEPATH . 'tmp/';
}
