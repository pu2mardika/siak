<?php

namespace Modules\Account\Database\Migrations;

use CodeIgniter\Database\Migration;

class TmpJurnal extends Migration
{
    public function up()
    {
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci'];
        $this->db->disableForeignKeyChecks();
        $fields = [
		    'id' => [
		        'type' 		 => 'varchar', 
		    	'constraint' => 32, 
		    ],
		     'uid' => [
		        'type' 		 => 'varchar', 
		    	'constraint' => 32, 
		    ],
		    'tanggal' => [
		        'type'   => 'date',
		        'null' 	 => true,
		    ],
		    'deskripsi' => [
		        'type'       => 'text',
		    ],
		    'no_bukti' => [
		        'type'       => 'varchar',
		        'constraint' => 16,
		    ],
		    'jnstrx' => [
		        'type'       => 'varchar',
		        'constraint' => 10,
		    ],
		    'accId' => [
		        'type'       => 'varchar',
		        'constraint' => 16,
		    ],
		    'amount' => [
		         'type'       => 'int',
		        'constraint' => 11,
		        'default'    => 0,
		    ],
		     'activity' => [
		        'type'       => 'varchar',
		        'constraint' => 50,
		    ],
		];
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('uid');
        $this->forge->createTable('tmpJurnal', true, $attributes);
    }

    public function down()
    {
        //HAPUS TABEL
        $this->forge->dropTable('tmpJurnal', true);
    }
}
