<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Akademik extends Migration
{
	public function up()
	{
		$attributes = ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci'];
		/**
         * tabel jurusan --> program
         * 
         */
        $fields = [
            'id'=> [
            	'type' => 'int', 
            	'constraint' => 11, 
            	'unsigned' => true, 
            	'auto_increment' => true,
            ],
            'nm_program' => [
            	'type' => 'varchar', 
            	'constraint' => 50,
            ],
            'desc' => [
            	'type' => 'varchar', 
            	'constraint' => 255,
            ],
			'unit_kerja' => [
            	'type' => 'varchar', 
            	'constraint' => 15,
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
        $this->forge->createTable('jurusan', true, $attributes);

		/**
		 * Tabel Program Studi
		 * 
		 */

		$fieldx = [
            'id_prodi'=> [
            	'type' => 'int', 
            	'constraint' => 11, 
            	'unsigned' => true,   
            	'auto_increment' => true,
            ],
            'nm_prodi' => [
            	'type' => 'varchar', 
            	'constraint' => 50,
            ],
            'skl' => [
            	'type' => 'varchar', 
            	'constraint' => 255,
            ],
            'jurusan'  => [
            	'type' => 'int', 
            	'constraint' => 11,
				'unsigned' => true,
            ],
			'jenjang'  => [
            	'type' => 'varchar', 
            	'constraint' => 3,
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

		$this->forge->addField($fieldx);
        $this->forge->addPrimaryKey('id_prodi');
		$this->forge->addKey('jurusan');
        $this->forge->addForeignKey('jurusan', 'jurusan', 'id','', 'CASCADE');
        $this->forge->createTable('prodi', true, $attributes);
		
		/**TABEL KURIKULUM
		 * CREATE TABLE `tbl_curriculum` (
			`id_curriculum` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
			`id_prodi` int(3) NOT NULL,
			`curr_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
			`issued` int(11) NOT NULL,
			`curr_desc` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
			`l_duration` int(3) NOT NULL,
			`curr_system` varchar(1) NOT NULL,
			`instance_rpt` varchar(20) NOT NULL,
			`ch_level` tinyint(2) NOT NULL,
			`state` int(1) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
		 * 
		 * ALTER TABLE `tbl_curriculum`
			ADD PRIMARY KEY (`id_curriculum`),
			ADD UNIQUE KEY `idcurr` (`id_curriculum`),
			ADD KEY `id_prodi` (`id_prodi`);
		 * 
		 * ALTER TABLE `tbl_curriculum`
  			ADD CONSTRAINT `kurikulum_prodi` FOREIGN KEY (`id_prodi`) REFERENCES `tbl_prodi` (`id_prodi`) ON DELETE CASCADE ON UPDATE CASCADE;
		 */
		$fields=[
            'id'=> [
            	'type' => 'varchar', 
            	'constraint' => 20, 
            	'unique'     => true,
            ],
			'id_prodi '=> [
            	'type' => 'int', 
            	'constraint' => 11, 
            ],
            'curr_name' => [
            	'type' => 'varchar', 
            	'constraint' => 50,
            ],
            'curr_desc' => [
            	'type' => 'varchar', 
            	'constraint' => 255,
            ],
            'issued'  => [
            	'type' => 'int', 
            	'constraint' => 11,
            ],
			'l_duration'  => [
            	'type' => 'int', 
            	'constraint' => 3,
            ],
			'curr_system'  => [
            	'type' => 'varchar', 
            	'constraint' => 3,
            ],
			'instance_rpt'  => [
            	'type' => 'varchar', 
            	'constraint' => 20,
            ],
            'ch_level'    => [
            	'type' => 'smallint', 
            	'constraint' => 2,
            ],
			'state'   	 => [
            	'type' => 'smallint', 
            	'constraint' => 1,
            	'default' => 1,
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
		$this->forge->addKey('id_prodi');
		$this->forge->addForeignKey('id_prodi', 'prodi', 'id_prodi','', 'CASCADE');
        $this->forge->createTable('curriculum', true, $attributes);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//drop Table
		$this->forge->dropTable('curriculum', true);
		$this->forge->dropTable('prodi', true);
		$this->forge->dropTable('jurusan', true);
	}
}