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
	public $theme 	 	= 'adminLTE';
	public $themeDir 	= 'ThemeViews';
	public $logo 		= 'logofinal.png';
	public $footer 		= '© {{YEAR}} <a href="https://mbc.or.id" target="_blank">MANDIRI BINA CIPTA</a>';
	
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
		'display'	=>  "form_display"
	];
	
	public $tmpfile_dir = WRITEPATH . 'tmp/';	
	public $qrPath_dir = ROOTPATH.'public/images/tmp/';
	public $qrDirectory = 'images/tmp/';
	
	public $pdfPath_Dir = ROOTPATH.'public/tmp/pdf/';
	public $pdftmpDir = 'tmp/pdf/';

	public string $arrDelimeter = '++VHV++';

	public string $noIjin_LKP = '05/DPMPTSP/2023';
	public string $tglIjin_LKP = '23 Maret 2023';

	public string $noIjin_PKBM = '02/DPMPTSP/2023';
	public string $tglIjin_PKBM = '23 Maret 2023';

	public function pdftmp_dir():string
	{
		return base_url('tmp/pdf/');
	}
	
	public function qrtmp_dir():string
	{
		return base_url('images/tmp/');
	}
	
	public function base64Logo():string
	{
		$logo = $this->imagesURL . $this->logo;
		//$path = $_SERVER['DOCUMENT_ROOT']."/".$logo; 
		$path = base_url($logo);// 'images/your_img.png' Modify this part (your_img.png  
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
		//return $type;
		return $base64;
	}

	public function legality($unit):array
	{
		$unit = strtoupper($unit);
		$legal['nomor'] = setting('MyApp.noIjin_'.$unit);
		$legal['tgl'] = setting('MyApp.tglIjin_'.$unit);
		return $legal;
	}
}
