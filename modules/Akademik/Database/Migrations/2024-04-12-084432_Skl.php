<?php

namespace Modules\Akademik\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Skl extends Migration
{
    public function up()
    {
        //
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci'];
		/**
         * tabel skl --> TblSKL
         * CREATE TABLE `tbl_skl` (
		  `id_skl` varchar(12) NOT NULL,
		  `grade` tinyint(1) NOT NULL,
		  `subgrade` tinyint(1) NOT NULL,
		  `skl` text NOT NULL,
		  `state` int(3) NOT NULL,
		  `id_curriculum` varchar(20) NOT NULL,
		  `grade_name` varchar(35) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

		--
		-- Indexes for dumped tables
		--

		--
		-- Indexes for table `tbl_skl`
		--
		ALTER TABLE `tbl_skl`
		  ADD PRIMARY KEY (`id_skl`),
		  ADD KEY `id_curriculum` (`id_curriculum`);
         * 
        */
        
        $fields = [
            'id'=> [
            	'type' => 'int', 
            	'constraint' => 11,  
            	'auto_increment' => true,
            ],
            'grade' => [
            	'type' => 'tinyint', 
            	'constraint' => 1,
            ],
            'subgrade' => [
            	'type' => 'tinyint', 
            	'constraint' => 1,
            ],
            'grade_name' => [
            	'type' => 'varchar', 
            	'constraint' => 35,
            ],
            'deskripsi' => [
            	'type' => 'varchar', 
            	'constraint' => 255,
            ],
            'currId'=> [
            	'type' => 'varchar', 
            	'constraint' => 20, 
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
        $this->forge->createTable('tblSkl', true, $attributes);
    }

    public function down()
    {
        //HAPUS  TABEL
        $this->forge->dropTable('tblSkl', true);
    }
}
