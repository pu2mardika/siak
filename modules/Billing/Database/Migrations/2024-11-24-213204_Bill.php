<?php

namespace Modules\Billing\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\Forge;
use Modules\Billing\Config\Billing;
use CodeIgniter\Database\RawSql;

class Bill extends Migration
{
    private $tables;

    private array $attributes;

    public function __construct(?Forge $forge = null)
    {
        /** @var Auth $authConfig */
        $authConfig = config('Billing');

        parent::__construct($forge);

        $this->tables     = $authConfig->tables;
        $this->attributes = ($this->db->getPlatform() === 'MySQLi') ? ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']: [];
    }

    public function up():void
    {
        $fields = [
            'id' => [
                'type'       => 'varchar',
                'constraint' => 35,
                'unique'     => true,
            ],
            'nik'=> [
                'type'       => 'varchar',
                'constraint' => 16,
            ],
            'issued' => [
                'type'       => 'date',
                'null'       => false,
            ],
            'due_date' => [
                'type'       => 'date',
                'null'    => true,
            ],
            'amount' => [
                'type'       => 'double',
                'default'    => 0,
            ],
            'coupon' => [
                'type'       => 'varchar',
                'constraint' => 10,
                'null' 	     => true,
            ],
            'created_at' => [
                'type'       => 'TIMESTAMP',
                'default'    => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type'       => 'TIMESTAMP',
                'null' 	     => true,
            ],
            'deleted_at' => [
                'type'       => 'TIMESTAMP',
                'null' 	     => true,
            ],
        ];
         
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('nik', 'tbl_datadik', 'nik','CASCADE', 'CASCADE', 'fk_billed');
        $this->createTable($this->tables['bill']);

        /** TABEL PAYMENT */
        $fields = [
            'id' => [
                'type'       => 'varchar',
                'constraint' => 35,
                'unique'     => true,
            ],
            'bill_id'=> [
                'type'       => 'varchar',
                'constraint' => 35,
            ],
            'payment_date' => [
                'type'       => 'date',
                'null'       => false,
            ],
            'amount' => [
                'type'       => 'double',
                'default'    => 0,
            ],
            'discont' => [
                'type'       => 'float',
                'default'    => 0,
            ],
        ];
         
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('bill_id', $this->tables['bill'], 'id','CASCADE', 'CASCADE', 'fk_billfk_billPay');
        $this->createTable($this->tables['pay']);

        /** TABEL COUPON */
        $fields = [
            'id' => [
                'type' => 'int', 
            	'constraint' => 11, 
            	'unsigned' => true, 
            	'auto_increment' => true,
            ],
            'code' => [
                'type'       => 'varchar',
                'constraint' => 10,
                'unique'     => true,
            ],
            'deskripsi'=> [
                'type'       => 'varchar',
                'constraint' => 100,
            ],
            'issued' => [
                'type'       => 'date',
                'null'       => false,
            ],
            'due_date' => [
                'type'       => 'date',
                'null'    => true,
            ],
            'discont' => [
                'type'       => 'float',
                'default'    => 0,
            ],
            'disc_type' => [
                'type'       => 'ENUM',
                'constraint' => ['fx', 'fl'],
                'default'    => 'fx',
            ],
            'created_at' => [
                'type'       => 'TIMESTAMP',
                'default'    => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type'       => 'TIMESTAMP',
                'null' 	     => true,
            ],
            'deleted_at' => [
                'type'       => 'TIMESTAMP',
                'null' 	     => true,
            ],
            
        ];
         
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->createTable($this->tables['cupon']);

    }

    public function down(): void
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable($this->tables['bill'], true);
        $this->forge->dropTable($this->tables['pay'], true);
        $this->forge->dropTable($this->tables['cupon'], true);
        $this->db->enableForeignKeyChecks();
    }

    private function createTable(string $tableName): void
    {
        $this->forge->createTable($tableName, false, $this->attributes);
    }
}
