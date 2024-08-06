<?php

namespace Modules\Siswa\Database\Migrations;

use CodeIgniter\Database\Migration;

class Dtsiswa extends Migration
{
    public function up()
    {
          
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci'];
        $this->db->disableForeignKeyChecks();
		
        $fields = [
		    'nik' => [
		        'type'       => 'varchar',
		        'constraint' => 16,
		        'unique'     => true,
		    ],
		    'idreg' => [
		        'type'       => 'varchar',
		        'constraint' => 15, 
		    ],
		    'nama' => [
		        'type'       => 'varchar',
		        'constraint' => 100,
		    ],
		    'nisn' => [
		        'type'       => 'varchar',
		        'constraint' => 15,
		        'null'    	 => true,
		    ],
		    'tempatlahir' => [
		        'type'       => 'varchar',
		        'constraint' => 50,
		        'null'    	 => true,
		    ],
		    'tgllahir' => [
		        'type'       => 'timestamp',
		        'null'    	 => true,
		    ],
		    'jk' => [
		        'type'       => 'ENUM',
		        'constraint' => ['L', 'P'],
		        'default'    => 'L',
		    ],
		    'alamat' => [
		        'type' => 'TEXT',
		        'null' => true,
		    ],
		    'nohp' => [
		        'type'       => 'varchar',
		        'constraint' => 12,
		        'null'    	 => true,
		    ],
		    'nama_ayah' => [
		        'type'       => 'varchar',
		        'constraint' => 100,
		        'null'    	 => true,
		    ],
		    'nama_ibu' => [
		        'type'       => 'varchar',
		        'constraint' => 100,
		        'null'    	 => true,
		    ],
		    'alamat_ortu' => [
		        'type'       => 'varchar',
		        'constraint' => 100,
		        'null'    	 => true,
		    ],
		    'nohp_ayah' => [
		        'type'       => 'varchar',
		        'constraint' => 12,
		        'null'    	 => true,
		    ],
		    'nohp_ibu' => [
		        'type'       => 'varchar',
		        'constraint' => 12,
		        'null'    	 => true,
		    ],
			'sumber_info' => [
		        'type'       => 'varchar',
		        'constraint' => 50,
		        'null'    	 => true,
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
		    'status' => [
		        'type'       => 'ENUM',
		        'constraint' => ['0', '1', '2'], //0 = pindah, 1 = aktif, 2 = tamat
		        'default'    => '1',
		    ],
		];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('nik');
		$this->forge->addKey('idreg');
        $this->forge->createTable('tbl_datadik', true, $attributes);
        
		/**
		 * Tabel Data Siswa (tbl_siswa) Merupakan turunan tabel master data siswa 
		 * yang teregister dengan program studi
		 */

		 $fields = [
		    'noinduk' => [
		        'type'       => 'varchar',
		        'constraint' => 15,
		        'unique'     => true,
		    ],
		    'nik' => [
		        'type'       => 'varchar',
		        'constraint' => 16,
		    ],
			'prodi' => [
		        'type'       => 'int',
		        'constraint' => 11,
		    ],
			'no_ijazah' => [
		        'type'       => 'varchar',
		        'constraint' => 50,
		        'null'    	 => true,
		    ],
			'tgl_ijazah' => [
		        'type'       => 'date',
		        'null'    	 => true,
		    ],
			'tgl_diterima' => [
		        'type'       => 'date',
		        'null'    	 => true,
		    ],
			'tgl_reg' => [
		        'type'       => 'int',
		        'constraint' => 11,
		        'null'    	 => true,
		    ],
			'no_urt' => [
		        'type'       => 'int',
		        'constraint' => 11,
		        'null'    	 => true,
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
        $this->forge->addPrimaryKey('noinduk');
		$this->forge->addUniqueKey(['nik', 'prodi'], 'program');
        $this->forge->addForeignKey('nik', 'tbl_datadik', 'nik','CASCADE', 'CASCADE');
        $this->forge->createTable('siswa', true, $attributes);
    }

    public function down()
    {
        //
    }
}
