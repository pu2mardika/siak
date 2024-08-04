<?php

namespace Modules\Raport\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Raport extends Migration
{
    public function up()
    {
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci'];
		/**
         * tabel raport
         * CREATE TABLE `tbl_report` (
        `rpt_id` varchar(32) NOT NULL,
        `id_curriculum` varchar(20) NOT NULL,
        `kode_ta` varchar(10) NOT NULL,
        `subgrade` tinyint(1) NOT NULL,
        `issued` int(11) NOT NULL,
        `otorized_by` varchar(100) NOT NULL
        ) 
        */
        
        $fields = [
            'id'=> [
            	'type' => 'varchar', 
            	'constraint' => 32,  
                'unique'     => true,
            ],
            'curr_id'=> [
            	'type' => 'varchar', 
            	'constraint' => 20, 
            ],
            'kode_ta'=> [
            	'type'       => 'INT',
		        'constraint' => 5, 
            ],
            'subgrade' => [
            	'type' => 'tinyint', 
            	'constraint' => 1,
                'null'    	 => false,
            ],
            'issued' => [
		        'type'       => 'date',
		        'null'    	 => false,
		    ],
            'otorized_by' => [
            	'type' => 'varchar', 
            	'constraint' => 255,
                'null'    	 => false,
            ],
            'created_at' => [
		        'type'    => 'TIMESTAMP',
		        'default' => new RawSql('CURRENT_TIMESTAMP'),
		    ],
		    'updated_at' => [
		        'type'   => 'TIMESTAMP',
		        'null' 	 => true,
		    ],
		    'deleted_at' => [
		        'type'   => 'TIMESTAMP',
		        'null' 	 => true,
		    ],
        ];
        
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('curr_id');
        $this->forge->addForeignKey('curr_id', 'curriculum', 'id', 'CASCADE', 'CASCADE', 'fk_curr_report');
        $this->forge->addForeignKey('kode_ta', 'tbl_tp', 'thid', 'CASCADE', 'CASCADE', 'fk_tp_report');
        $this->forge->createTable('raport', true, $attributes);
    }

    public function down()
    {
        //
        $this->forge->dropTable('raport', true);
    }
}
