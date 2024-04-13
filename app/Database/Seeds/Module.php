<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Module extends Seeder
{
	public function run()
	{
		//MEMBUAT DATA Module 
		
		$data_module_sts=[
			[
				'nama_status'	=> 'Aktif',
				'keterangan'	=> ''
			],
			[
				'nama_status'	=> 'Dalam Perbaikan',
				'keterangan'	=> 'Hanya role developer yang dapat mengakses module dengan status ini'
			],
			[
				'nama_status'	=> 'Non Aktif',
				'keterangan'	=> ''
			],
			
		];
		
		foreach($data_module_sts as $data){
			// insert semua data ke tabel
			$this->db->table('module_status')->insert($data);
		}
		
		/**
		* 'module' ('id_module', 'nama_module', 'judul_module', 'id_module_status', 'login', 'deskripsi')
		*/
		$data_module=[
			[
				'id_module'			=> 1,
				'nama_module'		=> 'menu',
				'judul_module'		=> 'Menu Manager',
				'id_module_status'	=> 1,
				'login'				=> 'Y',
				'deskripsi'			=> 'Administrasi Menu'
			],
			[
				'id_module'			=> 2,
				'nama_module'		=> 'module',
				'judul_module'		=> 'Module Manager',
				'id_module_status'	=>  1,
				'login'				=> 'Y',
				'deskripsi'			=> 'Administrasi Module'
			],
			[
				'id_module'			=> 3,
				'nama_module'		=> 'module-role',
				'judul_module'		=> 'Assign Role ke Module',
				'id_module_status'	=>  1,
				'login'				=> 'Y',
				'deskripsi'			=> 'Pengaturan Role ke Module'
			],
			[
				'id_module'			=> 4,
				'nama_module'		=> 'role',
				'judul_module'		=> 'Role Manager',
				'id_module_status'	=>  1,
				'login'				=> 'Y',
				'deskripsi'			=> 'Pengaturan Role'
			],
			[
				'id_module'			=> 5,
				'nama_module'		=> 'user',
				'judul_module'		=> 'User Manager',
				'id_module_status'	=>  1,
				'login'				=> 'Y',
				'deskripsi'			=> 'Pengaturan User'
			],
			[
				'id_module'			=> 6,
				'nama_module'		=> 'user-role',
				'judul_module'		=> 'Assign Role ke User',
				'id_module_status'	=>  1,
				'login'				=> 'Y',
				'deskripsi'			=> 'Pengaturan Role ke User'
			],
			[
				'id_module'			=> 7,
				'nama_module'		=> 'menu-role',
				'judul_module'		=> 'Assign Role ke Menu',
				'id_module_status'	=>  1,
				'login'				=> 'Y',
				'deskripsi'			=> 'Pengaturan Role ke menu'
			],
			[
				'id_module'			=> 8,
				'nama_module'		=> 'logincontroller',
				'judul_module'		=> 'Login',
				'id_module_status'	=>  1,
				'login'				=> 'R',
				'deskripsi'			=> 'Login'
			],
			[
				'id_module'			=> 9,
				'nama_module'		=> 'setting',
				'judul_module'		=> 'Setting',
				'id_module_status'	=>  1,
				'login'				=> 'R',
				'deskripsi'			=> 'Pengaturan Aplikasi'
			],
			[
				'id_module'			=> 10,
				'nama_module'		=> 'setting-web',
				'judul_module'		=> 'Setting Web',
				'id_module_status'	=>  1,
				'login'				=> 'Y',
				'deskripsi'			=> 'Pengaturan Web, seperti logo dll'
			],
			[
				'id_module'			=> 11,
				'nama_module'		=> 'home',
				'judul_module'		=> 'Home',
				'id_module_status'	=>  1,
				'login'				=> 'Y',
				'deskripsi'			=> 'Home'
			],
			[
				'id_module'			=> 12,
				'nama_module'		=> 'lragrup',
				'judul_module'		=> 'Grup Perkiraan LRA',
				'id_module_status'	=>  1,
				'login'				=> 'Y',
				'deskripsi'			=> 'Grup Perkiraan LRA'
			],
			[
				'id_module'			=> 13,
				'nama_module'		=> 'lradet',
				'judul_module'		=> 'Data Perkiraan LRA',
				'id_module_status'	=>  1,
				'login'				=> 'Y',
				'deskripsi'			=> 'Manajemen Perkiraan LRA'
			],
			[
				'id_module'			=> 14,
				'nama_module'		=> 'accsys',
				'judul_module'		=> 'Sistem Account',
				'id_module_status'	=>  1,
				'login'				=> 'Y',
				'deskripsi'			=> 'Manajemen Sistem Account'
			],
			[
				'id_module'			=> 21,
				'nama_module'		=> 'jurusan',
				'judul_module'		=> 'Jurusan',
				'id_module_status'	=>  1,
				'login'				=> 'Y',
				'deskripsi'			=> 'Manajemen Jurusan'
			],
			[
				'id_module'			=> 22,
				'nama_module'		=> 'tp',
				'judul_module'		=> 'Tahun Pelajaran',
				'id_module_status'	=>  1,
				'login'				=> 'Y',
				'deskripsi'			=> 'Manajemen Jurusan'
			],
			[
				'id_module'			=> 23,
				'nama_module'		=> 'siswa',
				'judul_module'		=> 'Peserta Didik',
				'id_module_status'	=>  1,
				'login'				=> 'Y',
				'deskripsi'			=> 'Manajemen Peserta Didik'
			],
			[
				'id_module'			=> 24,
				'nama_module'		=> 'tendik',
				'judul_module'		=> 'Tenaga Pendidik dan Kependidikan',
				'id_module_status'	=>  1,
				'login'				=> 'Y',
				'deskripsi'			=> 'Manajemen Tendik'
			],
			[
				'id_module'			=> 25,
				'nama_module'		=> 'rombel',
				'judul_module'		=> 'Rombongan Belajar',
				'id_module_status'	=>  1,
				'login'				=> 'Y',
				'deskripsi'			=> 'Manajemen ROMBEL'
			],
				
		];
		
		foreach($data_module as $data){
			// insert semua data ke tabel
			$this->db->table('module')->insert($data);
		}
		
		/**
		* role
		* INSERT INTO 'role' ('id_role', 'nama_role', 'judul_role', 'keterangan', 'id_module') VALUES
			(1, 'admin', 'Administrator', 'Administrator', 5),
			(2, 'user', 'User', 'Pengguna umum', 5),
			(3, 'webdev', 'Web Developer', 'Pengembang aplikasi', 5);
		*/
		
		$role = [
			[
				'id_role'		=> 1,
				'nama_role'		=> 'superadmin', 
				'judul_role' 	=> 'Super Admin' , 
				'keterangan'	=> 'Full Control System', 
				'id_module' 	=> 5
			],
			[
				'id_role'		=> 2,
				'nama_role'		=> 'Admin', 
				'judul_role' 	=> 'Admin System' , 
				'keterangan'	=> 'Administrator System', 
				'id_module' 	=> 5
			],
			[
				'id_role'		=> 3,
				'nama_role'		=> 'developer', 
				'judul_role' 	=> 'Developer' , 
				'keterangan'	=> 'Pengembang Aplikasi', 
				'id_module' 	=> 5
			],
			[
				'id_role'		=> 4,
				'nama_role'		=> 'user', 
				'judul_role' 	=> 'User' , 
				'keterangan'	=> 'Pengguna Umum', 
				'id_module' 	=> 5
			],
		];
		
		foreach($role as $data){
			// insert semua data ke tabel
			$this->db->table('role')->insert($data);
		}
		
		/**
		* role
		* INSERT INTO `role_detail` (`id_role_detail`, `nama_role_detail`, `judul_role_detail`) VALUES
			(1, 'all', 'Boleh Akses Semua Data'),
			(2, 'no', 'Tidak Boleh Akses Semua Data'),
			(3, 'own', 'Hanya Data Miliknya Sendiri');
		*/
		
		$roledet = [
			[
				'id_role_detail'		=> 1,
				'nama_role_detail'		=> 'all', 
				'judul_role_detail' 	=> 'Boleh Akses Semua Data'
			],
			[
				'id_role_detail'		=> 2,
				'nama_role_detail'		=> 'no', 
				'judul_role_detail' 	=> 'Tidak Boleh Akses Semua Data'
			],
			[
				'id_role_detail'		=> 3,
				'nama_role_detail'		=> 'own', 
				'judul_role_detail' 	=> 'Hanya Data Miliknya Sendiri'
			],
			
		];
		
		foreach($roledet as $data){
			// insert semua data ke tabel
			$this->db->table('role_detail')->insert($data);
		}
		
		/**
		* 	module_role
		* INSERT INTO 'module_role' ('id', 'id_module', 'id_role', 'read_data', 'create_data', 'update_data', 'delete_data') VALUES
		*  (1, 3, 1, 'all', 'yes', 'all', 'all'),
		*/
		$module_role=[
			[
				'id' 			=> 1, 
				'id_module' 	=> 11, 
				'id_role' 		=> 1, 
				'read_data' 	=> 'all', 
				'create_data' 	=> 'yes', 
				'update_data' 	=> 'all', 
				'delete_data' 	=> 'all'
			],
			[
				'id' 			=> 2, 
				'id_module' 	=> 11, 
				'id_role' 		=> 2, 
				'read_data' 	=> 'all', 
				'create_data' 	=> 'yes', 
				'update_data' 	=> 'all', 
				'delete_data' 	=> 'all'
			],
			[
				'id' 			=> 3, 
				'id_module' 	=> 11, 
				'id_role' 		=> 3, 
				'read_data' 	=> 'all', 
				'create_data' 	=> 'yes', 
				'update_data' 	=> 'all', 
				'delete_data' 	=> 'all'
			],
			[
				'id' 			=> 4, 
				'id_module' 	=> 11, 
				'id_role' 		=> 4, 
				'read_data' 	=> 'all', 
				'create_data' 	=> 'yes', 
				'update_data' 	=> 'all', 
				'delete_data' 	=> 'all'
			],
			[
				'id' 			=> 5, 
				'id_module' 	=> 1, 
				'id_role' 		=> 1, 
				'read_data' 	=> 'all', 
				'create_data' 	=> 'yes', 
				'update_data' 	=> 'all', 
				'delete_data' 	=> 'all'
			],
			[
				'id' 			=> 6, 
				'id_module' 	=> 2, 
				'id_role' 		=> 1, 
				'read_data' 	=> 'all', 
				'create_data' 	=> 'yes', 
				'update_data' 	=> 'all', 
				'delete_data' 	=> 'all'
			],
			[
				'id' 			=> 7, 
				'id_module' 	=> 3, 
				'id_role' 		=> 1, 
				'read_data' 	=> 'all', 
				'create_data' 	=> 'yes', 
				'update_data' 	=> 'all', 
				'delete_data' 	=> 'all'
			],
			[
				'id' 			=> 8, 
				'id_module' 	=> 4, 
				'id_role' 		=> 1, 
				'read_data' 	=> 'all', 
				'create_data' 	=> 'yes', 
				'update_data' 	=> 'all', 
				'delete_data' 	=> 'all'
			],
			[
				'id' 			=> 9, 
				'id_module' 	=> 5, 
				'id_role' 		=> 1, 
				'read_data' 	=> 'all', 
				'create_data' 	=> 'yes', 
				'update_data' 	=> 'all', 
				'delete_data' 	=> 'all'
			],
			[
				'id' 			=> 10, 
				'id_module' 	=> 5, 
				'id_role' 		=> 2, 
				'read_data' 	=> 'own', 
				'create_data' 	=> 'no', 
				'update_data' 	=> 'own', 
				'delete_data' 	=> 'no'
			],
			[
				'id' 			=> 11, 
				'id_module' 	=> 6, 
				'id_role' 		=> 1, 
				'read_data' 	=> 'all', 
				'create_data' 	=> 'yes', 
				'update_data' 	=> 'all', 
				'delete_data' 	=> 'all'
			],
			[
				'id' 			=> 12, 
				'id_module' 	=> 7, 
				'id_role' 		=> 1, 
				'read_data' 	=> 'all', 
				'create_data' 	=> 'yes', 
				'update_data' 	=> 'all', 
				'delete_data' 	=> 'all'
			],
			[
				'id' 			=> 13, 
				'id_module' 	=> 9, 
				'id_role' 		=> 1, 
				'read_data' 	=> 'all', 
				'create_data' 	=> 'yes', 
				'update_data' 	=> 'all', 
				'delete_data' 	=> 'all'
			],
			[
				'id' 			=> 14, 
				'id_module' 	=> 10, 
				'id_role' 		=> 1, 
				'read_data' 	=> 'all', 
				'create_data' 	=> 'yes', 
				'update_data' 	=> 'all', 
				'delete_data' 	=> 'all'
			],
			[
				'id' 			=> 15, 
				'id_module' 	=> 10, 
				'id_role' 		=> 2, 
				'read_data' 	=> 'all', 
				'create_data' 	=> 'yes', 
				'update_data' 	=> 'all', 
				'delete_data' 	=> 'all'
			],
			[
				'id' 			=> 16, 
				'id_module' 	=> 10, 
				'id_role' 		=> 3, 
				'read_data' 	=> 'all', 
				'create_data' 	=> 'yes', 
				'update_data' 	=> 'all', 
				'delete_data' 	=> 'all'
			],
			[
				'id' 			=> 17, 
				'id_module' 	=> 12, 
				'id_role' 		=> 1, 
				'read_data' 	=> 'all', 
				'create_data' 	=> 'yes', 
				'update_data' 	=> 'all', 
				'delete_data' 	=> 'all'
			],
			[
				'id' 			=> 18, 
				'id_module' 	=> 12, 
				'id_role' 		=> 2, 
				'read_data' 	=> 'all', 
				'create_data' 	=> 'yes', 
				'update_data' 	=> 'all', 
				'delete_data' 	=> 'all'
			],
			[
				'id' 			=> 19, 
				'id_module' 	=> 13, 
				'id_role' 		=> 1, 
				'read_data' 	=> 'all', 
				'create_data' 	=> 'yes', 
				'update_data' 	=> 'all', 
				'delete_data' 	=> 'all'
			],
			[
				'id' 			=> 20, 
				'id_module' 	=> 13, 
				'id_role' 		=> 2, 
				'read_data' 	=> 'all', 
				'create_data' 	=> 'yes', 
				'update_data' 	=> 'all', 
				'delete_data' 	=> 'all'
			],
			[
				'id' 			=> 21, 
				'id_module' 	=> 14, 
				'id_role' 		=> 1, 
				'read_data' 	=> 'all', 
				'create_data' 	=> 'yes', 
				'update_data' 	=> 'all', 
				'delete_data' 	=> 'all'
			],
			[
				'id' 			=> 22, 
				'id_module' 	=> 21, 
				'id_role' 		=> 1, 
				'read_data' 	=> 'all', 
				'create_data' 	=> 'yes', 
				'update_data' 	=> 'all', 
				'delete_data' 	=> 'all'
			],
			[
				'id' 			=> 23, 
				'id_module' 	=> 21, 
				'id_role' 		=> 2, 
				'read_data' 	=> 'all', 
				'create_data' 	=> 'yes', 
				'update_data' 	=> 'all', 
				'delete_data' 	=> 'all'
			],
			
		];
		
		foreach($module_role as $data){
			// insert semua data ke tabel
			$this->db->table('module_role')->insert($data);
		}
	}
}
