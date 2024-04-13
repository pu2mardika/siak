<?php

namespace Modules\Account\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Notify extends Migration
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
		    'deskripsi' => [
		        'type'       => 'text',
		    ],
		    'aksi' => [
		        'type'       => 'varchar',
		        'constraint' => 200,
		    ],
		    'param' => [
		        'type'       => 'varchar',
		        'constraint' => 32,
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
        $this->forge->createTable('notify', true, $attributes);
    }

    public function down()
    {
        //HAPUS TABEL
         $this->forge->dropTable('notify', true);
    }
}
