<?php

namespace Modules\Kbm\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class TugasMengajar extends Migration
{
    public function up()
    {
        //
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci'];
        $fields = [
		    'id' => [
		        'type'       => 'varchar',
		        'constraint' => 40,
				'unique'     => true,
		    ],
		    'id_mapel'    => [
		        'type'       => 'varchar',
		        'constraint' => 11,
		    ],
		    'roomid' => [
		        'type'       => 'varchar',
		        'constraint' => 35,
		        'null'    	 => true,
		    ],
		    'subgrade' => [
		        'type'       => 'int',
		        'constraint' => 5,
		        'null'       => false,
		    ],
		    'ptk_id'=> [
            	'type' => 'varchar', 
            	'constraint' => 16, 
            ],
		    'kkm' => [
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
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('ptk_id');
        $this->forge->addKey('id_mapel');
        $this->forge->addKey('roomid');
        $this->forge->addUniqueKey(['id_mapel', 'roomid', 'subgrade'], 'mengajar_id');
        $this->forge->addForeignKey('ptk_id', 'tbl_ptk', 'nik','CASCADE', 'CASCADE', 'fk_pengajar');
        $this->forge->addForeignKey('id_mapel', 'mapel', 'id_mapel','CASCADE', 'CASCADE', 'fk_diajarkan');
        $this->forge->addForeignKey('roomid', 'rombel', 'id','CASCADE', 'CASCADE', 'fk_dikelas');
		$this->forge->createTable('ptm', true, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('ptm', true);
    }
}
