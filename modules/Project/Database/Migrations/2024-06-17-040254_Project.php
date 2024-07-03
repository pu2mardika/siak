<?php

namespace Modules\Project\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Project extends Migration
{
    public function up()
    {
        //
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci'];
		/**
         * tabel dimensi project ->dimensi_project 
        */
        
        $fields = [
            'id'=> [
            	'type' => 'int', 
            	'constraint' => 11,  
            	'auto_increment' => true,
            ],
            'curr_id'=> [
            	'type' => 'varchar', 
            	'constraint' => 20, 
            ],
            'nama_dimensi' => [
            	'type' => 'varchar', 
            	'constraint' => 255,
            ],
        ];
        
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('curr_id');
        $this->forge->addForeignKey('curr_id', 'curriculum', 'id', 'CASCADE', 'CASCADE', 'fk_dimensi_project');
        $this->forge->createTable('dimensi_project', true, $attributes);

        //TABEL ELEMENT PROJECT
        $fields = [
            'id'=> [
            	'type' => 'int', 
            	'constraint' => 11,  
            	'auto_increment' => true,
            ],
            'dimensi_id'=> [
            	'type' => 'int', 
            	'constraint' => 11, 
            ],
            'deskripsi' => [
            	'type' => 'varchar', 
            	'constraint' => 255,
            ],
        ];
        
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('dimensi_id');
        $this->forge->addForeignKey('dimensi_id', 'dimensi_project', 'id', 'CASCADE', 'CASCADE', 'fk_elemen_project');
        $this->forge->createTable('elemen_project', true, $attributes);

        //TABEL SUB ELEMEN
        $fields = [
            'id'=> [
            	'type' => 'int', 
            	'constraint' => 11,  
            	'auto_increment' => true,
            ],
            'elemen_id'=> [
            	'type' => 'int', 
            	'constraint' => 11, 
            ],
            'deskripsi' => [
            	'type' => 'text',
            ],
            'tujuan' => [
            	'type' => 'varchar', 
            	'constraint' => 255,
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
        $this->forge->addKey('elemen_id');
        $this->forge->addForeignKey('elemen_id', 'elemen_project', 'id', 'CASCADE', 'CASCADE', 'fk_subelemen_project');
        $this->forge->createTable('subelemen_project', true, $attributes);
    }

    public function down()
    {
        //HAPUS TABEL
        $this->forge->dropTable('subelemen_project', true);
        $this->forge->dropTable('elemen_project', true);
        $this->forge->dropTable('dimensi_project', true);
    }
}
