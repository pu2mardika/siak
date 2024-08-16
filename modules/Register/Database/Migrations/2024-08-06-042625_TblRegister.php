<?php

namespace Modules\Register\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class TblRegister extends Migration
{
    public function up()
    {
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci'];
        $this->db->disableForeignKeyChecks();
		/**
         * module_status table.
         */
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
		        'type'       => 'date',
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
			'id_prodi'	=> [
            	'type' 		=> 'int', 
            	'constraint'=> 11, 
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
		        'constraint' => ['0', '1', '2'], //0 = pindah, 1 = aproved, 2 = rejected
		        'default'    => '1',
		    ],
		];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('nik');
		$this->forge->addKey('idreg');
        $this->forge->createTable('tbl_register', true, $attributes);
    }

    public function down()
    {
        //
        $this->forge->dropTable('tbl_register', true);
    }
}
