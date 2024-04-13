<?php

namespace Modules\Account\Database\Migrations;

use CodeIgniter\Database\Migration;

class NrAwal extends Migration
{
    public function up()
    {
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci'];
        $this->db->disableForeignKeyChecks();
        $fields = [
		    'id' => [
		        'type' 		 => 'int', 
		    	'constraint' => 5, 
		    	'unsigned'   => true, 
		    	'auto_increment' => true
		    ],
		    'tanggal' => [
		        'type'   => 'date',
		        'null' 	 => true,
		    ],
		    'kode_akun' => [
		        'type'       => 'varchar',
		        'constraint' => 16,
		    ],
		    'debet' => [
		        'type'       => 'float',
		        'constraint' => 11,
		        'default'    => 0,
		    ],
		    'kredit' => [
		        'type'       => 'float',
		        'constraint' => 11,
		        'default'    => 0,
		    ],
		];
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('kode_akun');
        $this->forge->createTable('neracaAwal', true, $attributes);
    }

    public function down()
    {
        // HAPUS TABEL
        $this->forge->dropTable('neracaAwal', true);
    }
}
