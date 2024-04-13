<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Moodule extends Migration
{
	public function up()
	{
		$attributes = ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci'];
		/**
         * module_status table.
         */
        $this->forge->addField([
            'id_module_status'  => ['type' => 'tinyint', 'constraint' => 1, 'unsigned' => true, 'auto_increment' => true],
            'nama_status'     	=> ['type' => 'varchar', 'constraint' => 50],
            'keterangan'   		=> ['type' => 'varchar', 'constraint' => 255],
        ]);

        $this->forge->addPrimaryKey('id_module_status');
        $this->forge->createTable('module_status', true, $attributes);
		
		
		/**
		* table : module
		*/
		$this->forge->addField([
            'id_module'  		=> ['type' => 'smallint', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'nama_module'  		=> ['type' => 'varchar', 'constraint' => 50],
            'judul_module' 		=> ['type' => 'varchar', 'constraint' => 50],
            'id_module_status' 	=> ['type' => 'tinyint', 'constraint' => 1, 'null'=>true,'default' => NULL ],
            'login'  			=> ['type' => 'ENUM', 'constraint' => ['Y', 'N', 'R'], 'default'=> 'Y'],
            'deskripsi'  		=> ['type' => 'varchar', 'constraint' => 50],
        ]);
        
        $this->forge->addPrimaryKey('id_module');
        $this->forge->addUniqueKey('nama_module'); // gives UNIQUE KEY `blog_id_uri` (`blog_id`, `uri`)
        $this->forge->addKey('id_module_status'); 
		//$this->forge->addForeignKey('id_module_status', 'module_status', 'id_module_status', 'CASCADE', 'SET NULL');
        $this->forge->createTable('module', true, $attributes);
		
		/**
		* table : role
		*/
		$this->forge->addField([
            'id_role'  		=> ['type' => 'smallint', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'nama_role'  	=> ['type' => 'varchar', 'constraint' => 50, 'null'=> false],
            'judul_role'  	=> ['type' => 'varchar', 'constraint' => 50, 'null'=> false],
            'keterangan'  	=> ['type' => 'varchar', 'constraint' => 50, 'null'=> false],
            'id_module'   	=> ['type' => 'smallint', 'constraint' => 5, 'unsigned' => true, 'null'=> false, 'default'=>0],
        ]);

        $this->forge->addKey('id_role', true);
        $this->forge->addKey('nama_role',false,true);
        $this->forge->addKey('id_module');
        $this->forge->addForeignKey('id_module', 'module', 'id_module', 'CASCADE', 'CASCADE');
        $this->forge->createTable('role', true, $attributes);
		
		/**
		* Table : role_detail
		*/
		$this->forge->addField([
            'id_role_detail'	=> ['type' => 'tinyint', 'constraint' => 3, 'unsigned' => true, 'auto_increment' => true],
            'nama_role_detail'  => ['type' => 'varchar', 'constraint' => 255, 'null'=> true],
            'judul_role_detail' => ['type' => 'varchar', 'constraint' => 255, 'null'=> true],
        ]);

        $this->forge->addKey('id_role_detail', true);
        $this->forge->createTable('role_detail', true, $attributes);
        
		/**
		*  table module_role
		* COMMENT='Tabel hak akses module aplikasi, module aplikasi boleh diakses oleh user yang mempunyai role apa saja';
		*/
		
		$this->forge->addField([
            'id'  			=> ['type' => 'smallint', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'id_module'  	=> ['type' => 'smallint', 'constraint' => 5, 'unsigned' => true, 'default' => 0],
            'id_role'   	=> ['type' => 'smallint', 'constraint' => 5, 'unsigned' => true, 'default' => 0],
            'read_data'   	=> ['type' => 'varchar', 'constraint' => 255, 'default'=>''],
            'create_data'   => ['type' => 'varchar', 'constraint' => 255, 'default'=>''],
            'update_data'   => ['type' => 'varchar', 'constraint' => 255, 'default'=>''],
            'delete_data'   => ['type' => 'varchar', 'constraint' => 255, 'default'=>''],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('id_module');
        $this->forge->addKey('id_role');
        $this->forge->addForeignKey('id_module', 'module', 'id_module', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_role', 'role', 'id_role', 'CASCADE', 'CASCADE');
        $this->forge->createTable('module_role', true, $attributes);		
        
        
        //TABEL MENU
        /**
		* TABEL MENU
		*/
		$this->forge->addField([
            'id_menu'  	=> ['type' => 'smallint', 'constraint' => 5, 'null' => false, 'unsigned' => true, 'auto_increment' => true],
            'nama_menu' => ['type' => 'varchar', 'constraint' => 50],
            'class'  	=> ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'url'  		=> ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'id_module' => ['type' => 'smallint', 'constraint' => 5, 'unsigned' => true,'default' => NULL],
            'id_parent' => ['type' => 'smallint', 'constraint' => 5, 'unsigned' => true, 'default' => NULL],
            'aktif'   	=> ['type' => 'tinyint', 'constraint' => 1, 'default' => 1],
            'new'   	=> ['type' => 'tinyint', 'constraint' => 1, 'default' => 0],
            'urut'   	=> ['type' => 'tinyint', 'constraint' => 1, 'default' => 0],
        ]);

        $this->forge->addKey('id_menu', true);
        $this->forge->addKey('id_module');
        $this->forge->addKey('id_parent');
      //  $this->forge->addForeignKey('id_menu', 'menu', 'id_parent', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('id_module', 'module', 'id_module', 'CASCADE', "SET NULL");
        $this->forge->createTable('menu', true, $attributes); 
        
        /**
		* table menu_role
		*/
		$this->forge->addField([
            'id'  		=> ['type' => 'smallint', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'id_menu'  	=> ['type' => 'smallint', 'constraint' => 5, 'unsigned' => true],
            'id_role'  	=> ['type' => 'smallint', 'constraint' => 5, 'unsigned' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('id_menu');
        $this->forge->addKey('id_role');
        $this->forge->addForeignKey('id_menu', 'menu', 'id_menu', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_role', 'role', 'id_role', 'CASCADE', 'CASCADE');
        $this->forge->createTable('menu_role', true, $attributes); 
		
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//drop Table
		$this->forge->dropTable('menu_role', true);
		$this->forge->dropTable('menu', true);
		$this->forge->dropTable('module_role', true);
		$this->forge->dropTable('role_detail', true);
		$this->forge->dropTable('role', true);
		$this->forge->dropTable('module', true);
		$this->forge->dropTable('module_status', true);
	}
}
