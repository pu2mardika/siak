<?php

namespace Modules\Akademik\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tapel extends Migration
{
    public function up()
    {
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci'];
        $this->db->disableForeignKeyChecks();

        //table tahun pelajaran (tbl_tp)
        $fields = [
		    'thid' => [
		        'type'           => 'INT',
		        'constraint'     => 5,
		        'auto_increment' => true,
		    ],
		    'deskripsi' => [
		        'type'       => 'varchar',
		        'constraint' => 100,
		    ],
		    'awal' => [
		        'type'       => 'int',
		        'constraint' => 11,
		        'null'    	 => true,
		    ],
		    'akhir' => [
		        'type'       => 'int',
		        'constraint' => 11,
		        'null'    	 => true,
		    ],
		];
         
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('thid');
        $this->forge->createTable('tbl_tp', true, $attributes);
    }

    public function down()
    {
        //HAPUS Tabel
        $this->forge->dropTable('tbl_tp', true);
    }
}
