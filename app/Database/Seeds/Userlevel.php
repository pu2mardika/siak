<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserLevel extends Seeder
{
	public function run()
	{
		//MEMBUAT DATA
		$base_config=[
			[
				'level_id'	=> 1,
				'level_name'	=> 'Root'
			],
			[
				'level_id'	=> 2,
				'level_name'	=> 'Administrator'
			],
		];
		
		foreach($base_config as $data){
			// insert semua data ke tabel
			$this->db->table('user_level')->insert($data);
		}
	}
}
