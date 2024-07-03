<?php

namespace Modules\Assessment\Database\Migrations;

use CodeIgniter\Database\Migration;

class Lognilai extends Migration
{
    public function up()
    {
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci'];
        $fields = [
		    'member_id'    => [
		        'type'       => 'varchar',
		        'constraint' => 40,
		    ],
		    'id_mengajar' => [
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
		        'constraint' => 5,
		        'null'    	 => false,
		    ],
		];
         
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey(['member_id', 'id_mengajar', 'rating_id', 'idx'], 'id');
        $this->forge->addForeignKey('member_id', 'rombel_memb', 'id','CASCADE', 'CASCADE', 'fk_member');
        $this->forge->addForeignKey('id_mengajar', 'ptm', 'id','CASCADE', 'CASCADE', 'fk_ajarnilai');
        $this->forge->addForeignKey('rating_id', 'rating', 'id','CASCADE', 'CASCADE', 'fk_ratenilai');
		$this->forge->createTable('leger_nilai', true, $attributes);

        $fields = [
            'id_mengajar' => [
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
		    'atp' => [
		        'type'       => 'varchar',
		        'constraint' => 50,
		        'null'    	 => false,
		    ],
		];         
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey(['id_mengajar', 'rating_id', 'idx'], 'id');
        $this->forge->addForeignKey('id_mengajar', 'ptm', 'id','CASCADE', 'CASCADE', 'fk_atpajar');
        $this->forge->addForeignKey('rating_id', 'rating', 'id','CASCADE', 'CASCADE', 'fk_atprate');
		$this->forge->createTable('tblatps', true, $attributes);
    }

    public function down()
    {
        //
        $this->forge->dropTable('tblatps', true);
        $this->forge->dropTable('leger_nilai', true);
    }
}
