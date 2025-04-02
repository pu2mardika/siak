<?php

namespace Modules\Billing\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\Forge;
use Modules\Billing\Config\Billing;
use CodeIgniter\Database\RawSql;

class CorporateBill extends Migration
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
            'corporate_name'=> [
                'type'       => 'varchar',
                'constraint' => 15,
            ],
            'contact_person' => [
                'type'       => 'varchar',
                'constraint' => 250,
                'null'       => false,
            ],
            'alamat'=> [
                'type'       => 'varchar',
                'constraint' => 250,
            ],
            'nohp'=> [
                'type'       => 'varchar',
                'constraint' => 13,
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
        $this->forge->addPKey('billId');
        $this->createTable($this->tables['grup_bill']);
    }

    public function down()
    {
         $this->forge->dropTable($this->tables['grup_bill'], true);
    }

    private function createTable(string $tableName): void
    {
        $this->forge->createTable($tableName, false, $this->attributes);
    }
}
