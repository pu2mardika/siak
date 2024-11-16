<?php

namespace Modules\Raport\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Stsb extends Migration
{
    public function up()
    {
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci'];
		        
        $fields = [
            'id'=> [
            	'type' => 'varchar', 
            	'constraint' => 32,  
                'unique'     => true,
            ],
            'kode_ta'=> [
            	'type'       => 'INT',
		        'constraint' => 5, 
            ],
            'jenis'=> [
            	'type'       => 'tinyint',
		        'constraint' => 5, 
            ],
            'exam' => [
		        'type'       => 'date',
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
        $this->forge->addForeignKey('kode_ta', 'tbl_tp', 'thid', 'CASCADE', 'CASCADE', 'fk_tp_stsb');
        $this->forge->createTable('stsb', true, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('stsb', true);
    }
}
