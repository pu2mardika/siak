<?php

namespace Modules\Account\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Accperiod extends Migration
{
    public function up()
    {
        //MEMBUAT TABEL
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci'];
        $this->db->disableForeignKeyChecks();
        $fields = [
		    'id' => [
		        'type' 		 => 'int', 
		    	'constraint' => 5, 
		    	'unsigned'   => true, 
		    	'auto_increment' => true
		    ],
		    'awal' => [
		        'type'       => 'date',
		    ],
		    'akhir' => [
		        'type'       => 'date',
		        'null' 	 => true,
		    ],
		    'pps' => [
		        'type'       => 'int',
		        'constraint' => 11,
		        'null' 	 => true,
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
        $this->forge->createTable('accperiod', true, $attributes);
    }

    public function down()
    {
        //HAPUS TABEL
         $this->forge->dropTable('accperiod', true);
    }
}
