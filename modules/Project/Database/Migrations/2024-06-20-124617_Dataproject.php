<?php

namespace Modules\Project\Database\Migrations;

use CodeIgniter\Database\Migration;

class Dataproject extends Migration
{
    public function up()
    {
        //
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci'];
		/**
         * tabel dimensi project ->dataproject 
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
            'nama_project'=> [
            	'type' => 'varchar', 
            	'constraint' => 100, 
            ],
            'deskripsi' => [
            	'type' => 'varchar', 
            	'constraint' => 255,
            ],
        ];
        
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('curr_id');
        $this->forge->addForeignKey('curr_id', 'curriculum', 'id', 'CASCADE', 'CASCADE', 'fk_data_project');
        $this->forge->createTable('dataproject', true, $attributes);

        /**
         * tabel skenproject ->Peta Penilaian Project 
        */
        
        $fields = [
            'id'=> [
            	'type' => 'varchar', 
            	'constraint' => 11,  
            ],
            'project_id'=> [
            	'type' => 'int', 
            	'constraint' => 11, 
            ],
            'subelemen_id' => [
            	'type' => 'int', 
            	'constraint' => 11,
            ],
        ];
        
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('project_id');
        $this->forge->addKey('subelemen_id');
        $this->forge->addForeignKey('project_id', 'dataproject', 'id', 'CASCADE', 'CASCADE', 'fk_sken_project');
        $this->forge->addForeignKey('subelemen_id', 'subelemen_project', 'id', 'CASCADE', 'CASCADE', 'fk_subelm_project');
        $this->forge->createTable('mapproject', true, $attributes);

         /**
         * tabel mapproject ->Peta Project ke rombel
        */
        
        $fields = [
            'id'=> [
            	'type' => 'int', 
            	'constraint' => 11,  
            	'auto_increment' => true,
            ],
            'project_id'=> [
            	'type' => 'int', 
            	'constraint' => 11, 
            ],
            'room_id' => [
            	'type' => 'varchar', 
            	'constraint' => 35,
            ],
        ];
        
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('project_id');
        $this->forge->addKey('room_id');
        $this->forge->addForeignKey('project_id', 'dataproject', 'id', 'CASCADE', 'CASCADE', 'fk_map_project');
        $this->forge->addForeignKey('room_id', 'rombel', 'id', 'CASCADE', 'CASCADE', 'fk_room_project');
        $this->forge->createTable('skenproject', true, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('skenproject', true);
        $this->forge->dropTable('mapproject', true);
        $this->forge->dropTable('dataproject', true);
    }
}
