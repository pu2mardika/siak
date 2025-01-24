<?php

namespace Modules\Pricing\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\Forge;
use Modules\Pricing\Config\Pricing;
use CodeIgniter\Database\RawSql;

class Price extends Migration
{
    /**
     * Auth Table names
     */
    private $tables;

    private array $attributes;

    public function __construct(?Forge $forge = null)
    {
        /** @var Auth $authConfig */
        $authConfig = config('Pricing');
/*
        if ($authConfig->DBGroup !== null) {
            $this->DBGroup = $authConfig->DBGroup;
        }
*/
        parent::__construct($forge);

        $this->tables     = $authConfig->table;
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
             'id_prodi'    => [
                 'type'       => 'int',
                 'constraint' => 11,
             ],
             'komponen' => [
                 'type'       => 'int',
                 'constraint' => 1,
                 'null'       => false,
             ],
             'amount' => [
                 'type'       => 'double',
                 'default'    => 0,
             ],
             'jns_bayar' => [
                 'type'       => 'tinyint',
                 'constraint' => 1,
                 'null'       => false,
             ],
             'tmt' => [
                 'type'       => 'date',
                 'nill'       => false,
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
         $this->forge->addForeignKey('id_prodi', 'prodi', 'id_prodi','CASCADE', 'CASCADE', 'fk_pro_price');
         $this->createTable($this->tables);
    }

    public function down(): void
    {
        //
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable($this->tables, true);
        $this->db->enableForeignKeyChecks();

    }

    private function createTable(string $tableName): void
    {
        $this->forge->createTable($tableName, false, $this->attributes);
    }
}
