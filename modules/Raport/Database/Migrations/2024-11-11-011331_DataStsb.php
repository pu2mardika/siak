<?php

namespace Modules\Raport\Database\Migrations;

use CodeIgniter\Database\Migration;

class DataStsb extends Migration
{
    public function up()
    {
        //
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci'];
		        
        $fields = [
            'id'=> [
            	'type' => 'varchar', 
            	'constraint' => 32,  
                'unique'     => true,
            ],
           
            'certId'=> [
            	'type' => 'varchar', 
            	'constraint' => 32,  
            ],

            'memberId'=> [
            	'type'       => 'varchar',
		        'constraint' => 40, 
            ],
            
            'no_urut' => [
            	'type'       => 'INT',
		        'constraint' => 5, 
            ],
        ];
        
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('certId');
        $this->forge->addForeignKey('certId', 'stsb', 'id', 'CASCADE', 'CASCADE', 'fk_memb_stsb');
    //    $this->forge->addForeignKey('memberId', 'rombel_memb', 'id', 'CASCADE', 'CASCADE', 'fk_memb_stsb');
        $this->forge->createTable('cert_detail', true, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('cert_detail', true);
    }
}
