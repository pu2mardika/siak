<?php

namespace Modules\Account\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Account extends Migration
{
    public function up()
    {
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci'];
        $this->db->disableForeignKeyChecks();
        $fields = [
		    'grupId' => [
		        'type'       => 'varchar',
		        'constraint' => 16,
		        'unique'     => true,
		    ],
		    'grupName' => [
		        'type'       => 'varchar',
		        'constraint' => 200, 
		    ],
		    'gtype' => [
		        'type'       => 'int',
		        'constraint' => 5,
		    ],
		];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('grupId');
		$this->forge->addKey('gtype');
        $this->forge->createTable('akun_grups', true, $attributes);
        
        //TABEL KE-2
        $fields = [
		    'kode_akun' => [
		        'type'       => 'varchar',
		        'constraint' => 16,
		        'unique'     => true,
		    ],
		    'nama_akun' => [
		        'type'       => 'varchar',
		        'constraint' => 200, 
		    ],
		    'grup_akun' => [
		        'type'       => 'varchar',
		        'constraint' => 16,
		    ],
		    'norm_balance' => [
		        'type'       => 'ENUM',
		        'constraint' => ['Db', 'Kr'],
		        'default'    => 'Db',
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
        $this->forge->addPrimaryKey('kode_akun');
		$this->forge->addKey('grup_akun');
		$this->forge->addForeignKey('grup_akun', 'akun_grups', 'grupId', 'CASCADE', 'CASCADE', 'fk_grup_akun');
        $this->forge->createTable('akun_bb', true, $attributes);
        
        //TABEL KE-3
        $fields = [
		    'key_item' => [
		        'type'       => 'varchar',
		        'constraint' => 50,
		        'unique'     => true,
		    ],
		    'deskripsi' => [
		        'type'       => 'varchar',
		        'constraint' => 200, 
		    ],
		    'kode_akun' => [
		        'type'       => 'varchar',
		        'constraint' => 16,
		    ],
		    'is_mpn' => [
		        'type'       => 'ENUM',
		        'constraint' => ['0', '1'],
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
        $this->forge->addPrimaryKey('key_item');
		$this->forge->addKey('kode_akun');
        $this->forge->createTable('akun_system', true, $attributes);
        
         //TABEL KE-4
        $fields = [
		    'trx_id' => [
		        'type'       => 'varchar',
		        'constraint' => 16,
		        'unique'     => true,
		    ],
		    'tanggal' => [
		        'type'   => 'TIMESTAMP',
		        'null' 	 => true,
		    ],
		    'deskripsi' => [
		        'type'       => 'text',
		    ],
		    'no_bukti' => [
		        'type'       => 'varchar',
		        'constraint' => 16,
		        'unique'     => true,
		    ],
		    'amount' => [
		        'type'       => 'int',
		        'constraint' => 11,
		        'default'    => 0,
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
        $this->forge->addPrimaryKey('trx_id');
        $this->forge->createTable('jurnal', true, $attributes);
        
         //TABEL KE-5
        $fields = [
		    'trx_id' => [
		        'type'       => 'varchar',
		        'constraint' => 16,
		        'unique'     => true,
		    ],
		   'kode_akun' => [
		        'type'       => 'varchar',
		        'constraint' => 16,
		    ],
		    'debet' => [
		        'type'       => 'int',
		        'constraint' => 11,
		        'default'    => 0,
		    ],
		    'kredit' => [
		        'type'       => 'int',
		        'constraint' => 11,
		        'default'    => 0,
		    ],
			'indek' => [
		        'type'       => 'int',
		        'constraint' => 1,
		        'default'    => 0,
		    ],
		];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey(['trx_id','kode_akun'],'idx');
		$this->forge->addForeignKey('trx_id', 'jurnal', 'trx_id', 'CASCADE', 'CASCADE', 'fk_det_trx');
		$this->forge->addForeignKey('kode_akun', 'akun_bb', 'kode_akun', 'CASCADE', 'CASCADE', 'fk_det_akun');
        $this->forge->createTable('jurnal_detail', true, $attributes);
    }

    public function down()
    {
        //
        $this->forge->dropTable('jurnal_detail', true);
        $this->forge->dropTable('jurnal', true);
        $this->forge->dropTable('akun_system', true);
        $this->forge->dropTable('akun_bb', true);
        $this->forge->dropTable('akun_grups', true);
    }
}
