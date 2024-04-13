<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AppSetting extends Migration
{
	public function up()
	{
		$attributes = ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci'];
		// Membuat kolom/field untuk tabel app_settings
		$this->forge->addField([
			'param' => ['type' => 'VARCHAR', 'constraint' => 255],
			'value' => ['type' => 'tinytext', 'default' => 'NULL'],
			'grup'  => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'BaseConfig'],
		]);

		// Membuat primary key
		$this->forge->addKey('param', TRUE);

		// Membuat tabel news
		$this->forge->createTable('app_settings', TRUE, $attributes);
		
		/**
		* `setting_app_user` 
		*/
		$this->forge->addField([
			'id_user' => ['type' => 'int', 'constraint' => 11],
			'param'   => ['type' => 'VARCHAR', 'constraint' => 255],
		]);

		// Membuat primary key
		$this->forge->addKey('id_user', TRUE);

		// Membuat tabel news
		$this->forge->createTable('setting_app_user', TRUE, $attributes);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//drop Table
		$this->forge->dropTable('app_settings', true);
		$this->forge->dropTable('setting_app_user', true);
	}
}
