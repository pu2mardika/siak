<?php

namespace Modules\Room\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Rombel extends Migration
{
    public function up()
    {
        //
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci'];
        $fields = [
		    'id' => [
		        'type'       => 'varchar',
		        'constraint' => 35,
				'unique'     => true,
		    ],
		    'nama_rombel'    => [
		        'type'       => 'varchar',
		        'constraint' => 100,
		    ],
		    'walikelas' => [
		        'type'       => 'varchar',
		        'constraint' => 15,
		        'null'    	 => true,
		    ],
		    'kode_ta' => [
		        'type'       => 'int',
		        'constraint' => 5,
		        'null'       => false,
		    ],
		    'curr_id'=> [
            	'type' => 'varchar', 
            	'constraint' => 20, 
            ],
		    'grade' => [
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
        $this->forge->addPrimaryKey('roomid');
        $this->forge->addKey('kode_ta');
        $this->forge->addKey('curr_id');
        $this->forge->addForeignKey('kode_ta', 'tbl_tp', 'thid','CASCADE', 'CASCADE', 'fk_tp_rombel');
        $this->forge->addForeignKey('curr_id', 'curriculum', 'id','CASCADE', 'CASCADE', 'fk_fk_curr_room');
		$this->forge->createTable('rombel', true, $attributes);
		
		$fields = [
		    'id' => [
		        'type'       => 'varchar',
		        'constraint' => 15,
		    ],
		    'roomid' => [
		        'type'       => 'varchar',
		        'constraint' => 35,
		    ],
		    'noinduk' => [
		        'type'       => 'varchar',
		        'constraint' => 15,
		    ],
		    'no_absen' => [
		        'type'       => 'int',
		        'constraint' => 11,
		    ],
		    'learn_metode' => [
		        'type'       => 'tinyint',
		        'constraint' => 2,
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
        $this->forge->addKey('roomid');
        $this->forge->addKey('noinduk');
		$this->forge->addForeignKey('roomid', 'rombel', 'id','CASCADE', 'CASCADE', 'fk_room_member');
		//$this->forge->addForeignKey('noinduk', 'siswa', 'noinduk','CASCADE', 'CASCADE', 'fk_room_siswa');
        $this->forge->createTable('rombel_memb', true, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('rombel_memb', true);
        $this->forge->dropTable('rombel', true);
    }
}
