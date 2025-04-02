<?php

namespace Modules\Billing\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\Forge;
use Modules\Billing\Config\Billing;
use CodeIgniter\Database\RawSql;

class Payment extends Migration
{
    public function __construct(?Forge $forge = null)
    {
        /** @var Auth $authConfig */
        $authConfig = config('Billing');

        parent::__construct($forge);

        $this->tables     = $authConfig->tables;
        $this->attributes = ($this->db->getPlatform() === 'MySQLi') ? ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']: [];
    }

    public function up()
    {
        $fields = [
            'id' => [
                'type'       => 'varchar',
                'constraint' => 35,
                'unique'     => true,
            ],
            'billId' => [
                'type'       => 'varchar',
                'constraint' => 35,
            ],
            'payment_date' => [
		        'type'       => 'timestamp',
		        'null'    	 => true,
		    ],
            'pay_amount'=> [
                'type'       => 'decimal',
                'constraint' => 10,
            ],
            'trxId' => [
		        'type' => 'varchar',
		        'constraint' => 50,
		        'null'    	 => true,
		    ],
		    'opid' => [
		        'type'       => 'int',
		        'constraint' => 10,
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
        $this->forge->addForeignKey('billId', $this->tables['bill'], 'id', 'RESTRICT', 'CASCADE', 'fk_payment');
        $this->createTable($this->tables['pay']);
    }

    public function down()
    {
        $this->forge->dropTable($this->tables['pay'], true);
    }

    private function createTable(string $tableName): void
    {
        $this->forge->createTable($tableName, false, $this->attributes);
    }
}
