<?php

namespace Modules\Tendik\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tendik extends Migration
{
    public function up()
    {
        //MEMBUAT TABEL TENDIK
                
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci'];
        $this->db->disableForeignKeyChecks();
        $fields = [
		    'nik' => [
		        'type'       => 'varchar',
		        'constraint' => 16,
		        'unique'     => true,
		    ],
		    'noid' => [
		        'type'       => 'varchar',
		        'constraint' => 18,
		        'unique'     => true,
		    ],
		    'nama' => [
		        'type'       => 'varchar',
		        'constraint' => 100,
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
		    'status' => [
		        'type'       => 'ENUM',
		        'constraint' => ['0', '1', '2', '3'], //0 = Tidak Kawin, 1=Kawin, 2 = Cerai Hidup, 3 = Cerai Mati
		        'default'    => '0',
		    ],
		    'sts_kepeg' => [
		        'type'       => 'ENUM',
		        'constraint' => ['1', '2', '3', '4', '5'],  // 1 = PNS, 2 = PPPK, 3 = Kontrak Daerah, 4 = Kontrak Sekolah, 5 = Pengabdi
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
		    'npwp' => [
		        'type'       => 'varchar',
		        'constraint' => 15,
		        'null'    	 => true,
		    ],
			'email' => [
		        'type'       => 'varchar',
		        'constraint' => 30,
		        'null'    	 => true,
		    ],
		    'rekeningbank' => [
		        'type'       => 'varchar',
		        'constraint' => 100,
		        'null'    	 => true,
		    ],
		    'namabank' => [
		        'type'       => 'varchar',
		        'constraint' => 100,
		        'null'    	 => true,
		    ],
		    'holdname' => [
		        'type'       => 'varchar',
		        'constraint' => 50,
		        'null'    	 => true,
		    ],
		    'tmt' => [
		        'type'       => 'timestamp',
		        'null'    	 => true,
		    ],
		    'state' => [
		        'type'       => 'ENUM',
		        'constraint' => ['0', '1', '2'], //0 = pindah, 1 = aktif, 2 = pensiun
		        'default'    => '1',
		    ],
			'created_at' => [
		        'type'    => 'TIMESTAMP',
		        'null' => true,
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
        $this->forge->addPrimaryKey('nik');
        $this->forge->createTable('tbl_ptk', true, $attributes);
    }

    public function down()
    {
        //Menghapus Tabel
        $this->forge->dropTable('tbl_ptk', true);
    }
}
