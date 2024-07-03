<?php

namespace Modules\Akademik\Database\Migrations;

use CodeIgniter\Database\Migration;

class Subject extends Migration
{
    public function up()
    {
       $attributes = ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci'];
       //$attributes = ['ENGINE' => 'InnoDB'];
		/**
         * tabel skl --> TblSKL
         * CREATE TABLE `tbl_grup_mapel` (
        */
        
        $fields = [
            'grup_id'=> [
            	'type' => 'int', 
            	'constraint' => 11,  
            	'auto_increment' => true,
            ],
            'curr_id'=> [
            	'type' => 'varchar', 
            	'constraint' => 20, 
            ],
            'nm_grup' => [
            	'type' => 'varchar', 
            	'constraint' => 100,
            ],
            'parent_grup' => [
            	'type' => 'varchar', 
            	'constraint' => 35,
            ],
        ];
        
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('grup_id');
        $this->forge->addKey('curr_id');
        $this->forge->addForeignKey('curr_id', 'curriculum', 'id', 'CASCADE', 'CASCADE', 'fk_grup_mapel');
        $this->forge->createTable('grup_mapel', true, $attributes);
        
        /**
		* 
		* CREATE TABLE `tbl_subjects` (
		*/
        
         $fields = [
            'id'=> [
            	'type' => 'varchar', 
            	'constraint' => 11,  
            	'index' => true,
            ],
            'grup_id' => [
            	'type' => 'int', 
            	'constraint' => 11,
            ],
            'subject_name' => [
            	'type' => 'varchar', 
            	'constraint' => 100,
            ],
            'akronim' => [
            	'type' => 'varchar', 
            	'constraint' => 5,
            ],
            'item_order' => [
            	'type' => 'varchar', 
            	'constraint' => 35,
            ],
            'tot_skk' => [
            	'type' => 'int', 
            	'constraint' => 11,
            ],
            'form_nilai'=> [
            	'type' => 'varchar', 
            	'constraint' => 20, 
            ],
        ];
        
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('grup_id');
        $this->forge->addForeignKey('grup_id', 'grup_mapel', 'grup_id', 'CASCADE', 'CASCADE', 'fk_gmapel');
        $this->forge->createTable('subjects', true, $attributes);
        
        /**
		* CREATE TABLE `tbl_mapel` (
		*/
		
		 $fields = [
            'id'=> [
            	'type' => 'varchar', 
            	'constraint' => 16,  
            ],
            'id_subject'=> [
            	'type' => 'varchar', 
            	'constraint' => 11,  
            ],
            'id_skl' => [
            	'type' => 'varchar', 
            	'constraint' => 22,
            ],
            'skk' => [
            	'type' => 'int', 
            	'constraint' => 3,
            ],
        ];
        
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('id_subject');
        $this->forge->addKey('id_skl');
		$this->forge->addForeignKey('id_subject', 'subjects', 'id', 'CASCADE', 'CASCADE', 'fk_subject');
		$this->forge->addForeignKey('id_skl', 'tblSkl', 'id', 'CASCADE', 'CASCADE', 'fk_dtSKL');
        $this->forge->createTable('mapel', true, $attributes);
    }

    public function down()
    {
        ////HAPUS  TABEL
        $this->forge->dropTable('mapel', true);
        $this->forge->dropTable('subjects', true);
        $this->forge->dropTable('grup_mapel', true);
    }
}
