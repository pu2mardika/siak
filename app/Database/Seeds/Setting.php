<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Setting extends Seeder
{
	public function run()
	{
		$base_config=[
			[
				'param' => 'app_name',
				'value'	=> 'SIAP',
				'grup' 	=> 'BaseConfig'
			],
			[
				'param' => 'app_verison',
				'value'	=> '4.0',
				'grup' 	=> 'BaseConfig'
			],
			[
				'param' => 'date_version',
				'value'	=> 'April 2023',
				'grup' 	=> 'BaseConfig'
			],
			[
				'param' => 'app_title',
				'value'	=> 'Sistem Informasi Administrasi dan Keuangan Sekolah',
				'grup' 	=> 'BaseConfig'
			],
			[
				'param' => 'logo_app',
				'value'	=> 'logo_aplikasi.png',
				'grup' 	=> 'BaseConfig'
			],
			[
				'param' => 'favicon',
				'value'	=> 'favicon.png',
				'grup' 	=> 'BaseConfig'
			],
			[
				'param' => 'footer_app',
				'value'	=> '© {{YEAR}} <a href="https://mbc.or.id" target="_blank">MANDIRI BINA CIPTA</a>',
				'grup' 	=> 'BaseConfig'
			],
			[
				'param' => 'allow_registration',
				'value'	=> '1',
				'grup' 	=> 'AuthSecurity'
			],
			[
				'param' 	=> 'captcha_registration',
				'value'	=> '1',
				'grup' 	=> 'AuthSecurity'
			],
			[
				'param' 	=> 'email_activation',
				'value'	=> '1',
				'grup' 	=> 'AuthSecurity'
			],
			[
				'param' => 'email_activation_expire',
				'value'	=> '172800',
				'grup' 	=> 'AuthSecurity'
			],			
			[
				'param' => 'email_account_details',
				'value'	=> '1',
				'grup' 	=> 'AuthSecurity'
			],
			[
				'param' => 'use_username',
				'value'	=> '1',
				'grup' 	=> 'AuthSecurity'
			],
			[
				'param' => 'outh2',
				'value'	=> '1',
				'grup' 	=> 'authlogin'
			],
			[
				'param' => 'login_record_ip',
				'value'	=> '1',
				'grup' 	=> 'authlogin'
			],
			[
				'param' => 'login_record_time',
				'value'	=> '1',
				'grup' 	=> 'authlogin'
			],
			[
				'param' => 'login_count_attempts',
				'value'	=> '1',
				'grup' 	=> 'authlogin'
			],
			[
				'param' 	=> 'login_max_attempts',
				'value'	=> '5',
				'grup' 	=> 'authlogin'
			],
			[
				'param' => 'company_name',
				'value'	=> 'Change Company Name',
				'grup' 	=> 'profil'
			],
			[
				'param' 	=> 'address1',
				'value'	=> 'address1',
				'grup' 	=> 'profil'
			],
			[
				'param' => 'address2',
				'value'	=> 'address2',
				'grup' 	=> 'profil'
			],
			[
				'param' => 'phone',
				'value'	=> 'phone',
				'grup' 	=> 'profil'
			],
			[
				'param' => 'city',
				'value'	=> 'Karangasem',
				'grup' 	=> 'profil'
			],
			[
				'param' => 'postal_code',
				'value'	=> '80811',
				'grup' 	=> 'profil'
			],
			[
				'param' => 'primary_contact_email',
				'value'	=> 'example@siak.com',
				'grup' 	=> 'profil'
			],
			[
				'param'	=> 'website',
				'value'	=> 'https://',
				'grup' 	=> 'profil'
			],
			[
				'param' => 'color_scheme',
				'value'	=> 'red',
				'grup' 	=> 'layout'
			],
			[
				'param' => 'sidebar_color',
				'value'	=> 'dark',
				'grup' 	=> 'layout'
			],
			[
				'param' => 'logo_background_color',
				'value'	=> 'dark',
				'grup' 	=> 'layout'
			],
			[
				'param' => 'font_family',
				'value'	=> 'poppins',
				'grup' 	=> 'layout'
			],
			[
				'param' => 'font_size',
				'value'	=> '14',
				'grup' 	=> 'layout'
			],
			[
				'param' => 'theme',
				'value'	=> 'sbadmin2',
				'grup' 	=> 'layout'
			]
		];
		
		foreach($base_config as $data){
			// insert semua data ke tabel
			$this->db->table('app_settings')->insert($data);
		}
	}
}
