<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Menu extends Seeder
{
    public function run()
    {/**
	 * 
	 * @var SELECT `id_menu`, `nama_menu`, `class`, `url`, `id_module`, `id_parent`, `aktif`, `new`, `urut` FROM `menu`
	 *
	 */
        //membuat data menu
        
        
		$data_menu=[
			[
				'id_menu'	=> 1,
				'nama_menu'	=> 'Manage Aplikasi',
				'class'	=> 'fas fa-cog',
				'url'	=> '#',
				'id_module'	=> 11,
				'id_parent'	=> 'NULL',
				'aktif'	=> 1,
				'new'	=> 0,
				'urut'	=> 1
			],
			[
				'id_menu'	=> 2,
				'nama_menu'	=> 'Layout Setting',
				'class'	=> 'fas fa-brush',
				'url'	=> 'setting',
				'id_module'	=> 9,
				'id_parent'	=> 1,
				'aktif'	=> 1,
				'new'	=> 0,
				'urut'	=> 1
			],
			[
				'id_menu'	=> 3,
				'nama_menu'	=> 'Menu',
				'class'	=> 'fas fa-clone',
				'url'	=> 'module',
				'id_module'	=> 1,
				'id_parent'	=> 1,
				'aktif'	=> 1,
				'new'	=> 0,
				'urut'	=> 1
			],
			[
				'id_menu'	=> 4,
				'nama_menu'	=> 'Modul',
				'class'	=> 'fas fa-network-wired',
				'url'	=> 'module',
				'id_module'	=> 2,
				'id_parent'	=> 1,
				'aktif'	=> 1,
				'new'	=> 0,
				'urut'	=> 1
			],
			[
				'id_menu'	=> 5,
				'nama_menu'	=> 'Role',
				'class'	=> 'fas fa-briefcase',
				'url'	=> 'user',
				'id_module'	=> 4,
				'id_parent'	=> 1,
				'aktif'	=> 1,
				'new'	=> 0,
				'urut'	=> 2
			],
			[
				'id_menu'	=> 6,
				'nama_menu'	=> 'Pengguna',
				'class'	=> 'fas fa-users',
				'url'	=> 'user',
				'id_module'	=> 5,
				'id_parent'	=> 1,
				'aktif'	=> 1,
				'new'	=> 0,
				'urut'	=> 2
			],	
			[
				'id_menu'	=> 7,
				'nama_menu'	=> 'Assign Role',
				'class'	=> 'fas fa-link',
				'url'	=> '#',
				'id_module'	=> 11,
				'id_parent'	=> '1',
				'aktif'	=> 1,
				'new'	=> 0,
				'urut'	=> 1
			],
			[
				'id_menu'	=> 8,
				'nama_menu'	=> 'User Role',
				'class'	=> 'fas fa-user-tag',
				'url'	=> 'user-role',
				'id_module'	=> 6,
				'id_parent'	=> 7,
				'aktif'	=> 1,
				'new'	=> 0,
				'urut'	=> 2
			],			
			[
				'id_menu'	=> 9,
				'nama_menu'	=> 'Module Role',
				'class'	=> 'fas fa-desktop',
				'url'	=> 'module-role',
				'id_module'	=> 3,
				'id_parent'	=> 7,
				'aktif'	=> 1,
				'new'	=> 0,
				'urut'	=> 2
			],	
			[
				'id_menu'	=> 10,
				'nama_menu'	=> 'Menu Role',
				'class'	=> 'fas fa-folder-minus',
				'url'	=> 'menu-role',
				'id_module'	=> 7,
				'id_parent'	=> 7,
				'aktif'	=> 1,
				'new'	=> 0,
				'urut'	=> 2
			],
			[
				'id_menu'	=> 11,
				'nama_menu'	=> 'Tools',
				'class'	=> 'fas fa-link',
				'url'	=> '#',
				'id_module'	=> 11,
				'id_parent'	=> '1',
				'aktif'	=> 1,
				'new'	=> 0,
				'urut'	=> 1
			],						
			[
				'id_menu'	=> 12,
				'nama_menu'	=> 'Manage Program',
				'class'	=> 'fas fa-folder-minus',
				'url'	=> '#',
				'id_module'	=> 1,
				'id_parent'	=> 'NULL',
				'aktif'	=> 1,
				'new'	=> 0,
				'urut'	=> 1
			],
			[
				'id_menu'	=> 13,
				'nama_menu'	=> 'Manage Pembelajaran',
				'class'	=> 'fas fa-folder-minus',
				'url'	=> '#',
				'id_module'	=> 1,
				'id_parent'	=> 'NULL',
				'aktif'	=> 1,
				'new'	=> 0,
				'urut'	=> 1
			],
			[
				'id_menu'	=> 14,
				'nama_menu'	=> 'Manage Data Siswa',
				'class'	=> 'fas fa-user-plus',
				'url'	=> '#',
				'id_module'	=> 1,
				'id_parent'	=> 'NULL',
				'aktif'	=> 1,
				'new'	=> 0,
				'urut'	=> 1
			],
			[
				'id_menu'	=> 15,
				'nama_menu'	=> 'Evaluasi Pembelajaran',
				'class'	=> 'fas fa-user-plus',
				'url'	=> '#',
				'id_module'	=> 1,
				'id_parent'	=> 'NULL',
				'aktif'	=> 1,
				'new'	=> 0,
				'urut'	=> 1
			],
			[
				'id_menu'	=> 16,
				'nama_menu'	=> 'Jurusan',
				'class'	=> 'fas fa-users',
				'url'	=> 'jurusan',
				'id_module'	=> 19,
				'id_parent'	=> 12,
				'aktif'	=> 1,
				'new'	=> 0,
				'urut'	=> 1
			],
			/*	[
				'id_menu'	=> 16,
				'nama_menu'	=> 'Surat Keluar',
				'class'	=> 'fas fa-users',
				'url'	=> 'docregister',
				'id_module'	=> 19,
				'id_parent'	=> 11,
				'aktif'	=> 1,
				'new'	=> 0,
				'urut'	=> 1
			],*/
		];
		
		foreach($data_menu as $data){
			// insert semua data ke tabel
			$this->db->table('menu')->insert($data);
		}
    }
}
