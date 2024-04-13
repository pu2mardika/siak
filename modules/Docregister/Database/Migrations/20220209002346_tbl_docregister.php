<?php namespace Modules\Docregister\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblDocregister extends Migration
{
	public function up()
	{
		//BUAT TABEL docregister
		$attributes = ['ENGINE' => 'InnoDB', 'CHARSET'=>'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci'];
		/**
         * tbl_docregister.
         * CREATE TABLE `tbl_docregister` (
		  `id` varchar(25) NOT NULL,
		  `tgl` int(11) NOT NULL,
		  `no_kendali` int(3) NOT NULL,
		  `clascode` varchar(10) NOT NULL,
		  `no_order` int(3) NOT NULL,
		  `tujuan` varchar(200) DEFAULT NULL,
		  `prihal` varchar(200) NOT NULL,
		  `idtransact` varchar(50) NOT NULL,
		  `doctype` varchar(10) DEFAULT NULL,
		  `opid` varchar(20) NOT NULL,
		  `state` tinyint(1) NOT NULL DEFAULT 1
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;
         */
        $this->forge->addField([
            'regId'  		=> ['type' => 'varchar', 'constraint' => 25, 'null' => FALSE],
            'tgl' 			=> ['type' => 'int', 'constraint' => 11, 'null'=>FALSE],
            'no_kendali' 	=> ['type' => 'int', 'constraint' => 3, 'null'=>FALSE],
            'clascode'   	=> ['type' => 'varchar', 'constraint' => 10, 'null'=>FALSE],
            'nosurat'   	=> ['type' => 'varchar', 'constraint' => 200, 'null'=>FALSE],
            'no_order'   	=> ['type' => 'int', 'constraint' => 3, 'null'=>FALSE],
            'tujuan'   		=> ['type' => 'varchar', 'constraint' => 200, 'null'=>FALSE],
            'prihal'   		=> ['type' => 'varchar', 'constraint' => 200, 'null'=>FALSE],
            'idtransact'  	=> ['type' => 'varchar', 'constraint' => 50, 'null'=>FALSE],
            'doctype'   	=> ['type' => 'varchar', 'constraint' => 10, 'null'=>FALSE],
            'opid'   		=> ['type' => 'varchar', 'constraint' => 20, 'null'=>FALSE],
            'state'   		=> ['type' => 'tinyint', 'constraint' => 1, 'null'=>FALSE],
        ]);

        $this->forge->addPrimaryKey('regId');
        $this->forge->createTable('tbl_docregister', true, $attributes);
        
        /**
		* CREATE TABLE `tbl_doctype` (
		  `kode` varchar(7) NOT NULL,
		  `doc_descrip` varchar(250) NOT NULL,
		  `register` tinyint(1) NOT NULL DEFAULT 1,
		  `doc_clascode` varchar(10) NOT NULL DEFAULT '027'
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		* 
		* @return
		*/
		$this->forge->addField([
            'kode'  		=> ['type' => 'varchar', 'constraint' => 7, 'null' => FALSE],
            'doc_descrip'  	=> ['type' => 'varchar', 'constraint' => 250, 'null'=>FALSE],
            'register'   	=> ['type' => 'tinyint', 'constraint' => 1, 'null'=>FALSE],
            'doc_clascode'  => ['type' => 'varchar', 'constraint' => 10, 'null'=>FALSE],
        ]);

        $this->forge->addPrimaryKey('kode');
        $this->forge->createTable('tbl_doctype', true, $attributes);
        
        /**
		* CREATE TABLE `tbl_class_arch` (
		  `id_class` varchar(10) NOT NULL,
		  `deskripsi` varchar(100) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		* 
		* @return
		*/
		
		$this->forge->addField([
            'id_class'  => ['type' => 'varchar', 'constraint' => 10, 'null' => FALSE],
            'deskripsi'	=> ['type' => 'varchar', 'constraint' => 100, 'null'=>FALSE],
        ]);

        $this->forge->addPrimaryKey('kode');
        $this->forge->createTable('tbl_doctype', true, $attributes);
		
	}
	

	//--------------------------------------------------------------------

	public function down()
	{
		//
		$this->forge->dropTable('tbl_docregister', true);
		$this->forge->dropTable('tbl_doctype', true);
		$this->forge->dropTable('tbl_class_arch', true);
	}
}
