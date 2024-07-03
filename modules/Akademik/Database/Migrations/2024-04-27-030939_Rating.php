<?php

namespace Modules\Akademik\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rating extends Migration
{
    public function up()
    {
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci'];
		/**
         *
        */
        
        $fields = [
            'id'=> [
            	'type' => 'varchar', 
            	'constraint' => 32,  
            ],
            'curr_id'=> [
            	'type' => 'varchar', 
            	'constraint' => 20, 
            ],
            'nm_komponen' => [
            	'type' => 'varchar', 
            	'constraint' => 100,
            ],
            'no_urut' => [
            	'type' => 'int', 
            	'constraint' => 3,
            ],
            'jns_nilai' => [
            	'type' => 'varchar', 
            	'constraint' => 1,
            ],
            'type_nilai' => [
            	'type' => 'varchar', 
            	'constraint' => 5,
            	'default'    => 'NR',
            ],
            'is_mapel' => [
            	'type' => 'tinyint', 
            	'constraint' => 1,
            	'default'    => 0,
            ],
             'tbl_stored_name' => [
            	'type' => 'varchar', 
            	'constraint' => 200,
            ],
            'has_descript' => [
            	'type' => 'tinyint', 
            	'constraint' => 1,
            	'default'    => 0,
            ],
            'bobot' => [
            	'type' => 'tinyint', 
            	'constraint' => 1,
            	'default'    => 0,
            ],
            'akronim' => [
            	'type' => 'varchar', 
            	'constraint' => 3,
            	'null'    	 => false,
            ],
        ];
        
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('curr_id');
        $this->forge->addKey('akronim');
        $this->forge->addForeignKey('curr_id', 'curriculum', 'id', 'CASCADE', 'CASCADE', 'fk_curr_rating');
        $this->forge->createTable('rating', true, $attributes);
        
        /**
		* 
		* CREATE TABLE `rpt_section` (
		*/
        
         $fields = [
            'id'=> [
            	'type' => 'varchar', 
            	'constraint' => 32,  
            	'index' => true,
            ],
            'curr_id'=> [
            	'type' => 'varchar', 
            	'constraint' => 20, 
            ],
            'hal' => [
            	'type' => 'tinyint', 
            	'constraint' => 2,
            ],
            'block' => [
            	'type' => 'tinyint', 
            	'constraint' => 2,
            ],
            'comp_nilai' => [
            	'type' => 'varchar', 
            	'constraint' => 32,
            ],
            'judul' => [
            	'type' => 'varchar', 
            	'constraint' => 255,
            ],
        ];
        
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('curr_id');
        $this->forge->addKey('comp_nilai');
        $this->forge->addForeignKey('curr_id', 'curriculum', 'id', 'CASCADE', 'CASCADE', 'fk_curr_craport');
        $this->forge->addForeignKey('comp_nilai', 'rating', 'id', 'CASCADE', 'CASCADE', 'fk_rate_rpt');
        $this->forge->createTable('comp_rpt', true, $attributes);

        
    }

    public function down()
    {
        $this->forge->dropTable('comp_rpt', true);
        $this->forge->dropTable('rating', true);
    }
}
