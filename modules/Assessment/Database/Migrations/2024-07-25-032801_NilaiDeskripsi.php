<?php

namespace Modules\Assessment\Database\Migrations;

use CodeIgniter\Database\Migration;

class NilaiDeskripsi extends Migration
{
    public function up()
    {
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci'];
        $fields = [
		    'member_id'    => [
		        'type'       => 'varchar',
		        'constraint' => 40,
		    ],
		    'subgrade' => [
		        'type'       => 'varchar',
		        'constraint' => 40,
		    ],
            'rating_id' => [
		        'type'       => 'varchar',
		        'constraint' => 32,
		    ],
		    'idx' => [
		        'type'       => 'int',
		        'constraint' => 5,
		        'default'    => 0,
		    ],
		    'nilai' => [
		        'type'       => 'varchar',
		        'constraint' => 1000,
		        'null'    	 => false,
		    ],
		];
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey(['member_id', 'subgrade', 'rating_id', 'idx'], 'id');
    //    $this->forge->addForeignKey('member_id', 'rombel_memb', 'id','CASCADE', 'CASCADE', 'fk_member');
    //    $this->forge->addForeignKey('rating_id', 'rating', 'id','CASCADE', 'CASCADE', 'fk_ratenilai');
		$this->forge->createTable('nilai_deskripsi', true, $attributes);
    }

    public function down()
    {
        //Hapus Tabel
        $this->forge->dropTable('nilai_deskripsi', true);
    }
}
