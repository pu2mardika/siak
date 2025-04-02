<?php

namespace Modules\Billing\Config;

use CodeIgniter\Config\BaseConfig;

class Corp extends BaseConfig
{
	public $opsi = [];
    
    /**FIELDS: 'id', 'billid', 'corporate_name', 'contact_person', 'alamat', 'nohp' */
    public $fields = [
		'id'		    => ['label' => 'CID','width'=>8,'extra'=>['id'=>'txtawal','class' => '', 'required' => true],'type'=>'hidden'], 
		'billId'	    => ['label' => 'Kode Billing','width'=>8,'extra'=>['id'=>'txtawal','class' => '', 'required' => true],'type'=>'text'], 
		'corporate_name'=> ['label' => 'Corporate Name','width'=>15,'extra'=>['id'=>'txtawal','class' => '', 'required' => true],'type'=>'text'], 
		'contact_person'=> ['label' => 'PIC','width'=>20,'extra'=>['id'=>'txtdesc','class' => '', 'required' => true, 'rows'=>4, 'maxlength'=>250, 'title'=>'Maks 250 character'],'type'=>'textarea'], 
		'alamat'	    => ['label' => 'Alamat','width'=>25,'extra'=>['id'=>'txtawal','class' => '', 'required' => true],'type'=>'text'],  
		'nohp'	    	=> ['label' => 'Telepon','width'=>10,'extra'=>['id'=>'txtawal','class' => '', 'required' => true],'type'=>'date'],  
	];

	public $editfields = [
		'id'		    => ['label' => 'CID','width'=>10,'extra'=>['id'=>'txtawal','class' => '', 'required' => true, 'disabled'=>true],'type'=>'text'], 
		'billId'	    => ['label' => 'Kode Billing','width'=>10,'extra'=>['id'=>'txtawal','class' => '', 'required' => true,'disabled'=>true],'type'=>'text'], 
		'corporate_name'=> ['label' => 'Corporate Name','width'=>20,'extra'=>['id'=>'txtawal','class' => '', 'required' => true],'type'=>'text'], 
		'contact_person'=> ['label' => 'PIC','width'=>25,'extra'=>['id'=>'txtdesc','class' => '', 'required' => true],'type'=>'text'], 
		'alamat'		=> ['label' => 'Alamat','width'=>25,'extra'=>['id'=>'txtdesc','class' => '', 'required' => true, 'rows'=>4, 'maxlength'=>250, 'title'=>'Maks 250 character'],'type'=>'textarea'], 
		'nohp'	    	=> ['label' => 'Telepon','width'=>10,'extra'=>['id'=>'txtawal','class' => '', 'required' => true],'type'=>'tel'], 
	];

	public $ResumeFields = [
		'id'			=> ['label' => 'NCID', 'perataan'=>'left'], 
		'billId'	 	=> ['label' => 'Kode Billing', 'perataan'=>'left'],
		'corporate_name'=> ['label' => 'Nama Corporate', 'perataan'=>'left'],
		'contact_person'=> ['label' => 'Contact Person', 'perataan'=>'left'],  
		'alamat' 		=> ['label' => 'Alamat', 'perataan'=>'left'],  
		'nohp' 			=> ['label' => 'No. HP', 'perataan'=>'left'],  
		'amount' 		=> ['label' => 'Jumlah Tagihan', 'perataan'=>'left'],
		'issued' 		=> ['label' => 'Tanggal Invoice', 'perataan'=>'left'],
	];
	/**
	* ---------------------------------------------------------------------
	* ROLE DATA
	* ---------------------------------------------------------------------
	* 
	* @var 
	* 
	*/
	public $roles = [
		'corporate_name' => ['label' => 'Corporate Name', 'rules' => "required"],
        'contact_person' => ['label' => 'PIC', 'rules' =>'required'],
        'alamat' 		 => ['label' => 'Alamat', 'rules' =>'required'],
        'nohp' 		 	 => ['label' => 'Alamat', 'rules' =>'required'],
	]; 

     /* --------------------------------------------------------------------
	 * Layout for the views to extend
	 * --------------------------------------------------------------------
	 *
	 * @var string
	 */
	public $primarykey = 'id';
	public $BillKeys = 'billId';
	
	/**
	* ---------------------------------------------------------------------
	* Add New data allowed
	* ---------------------------------------------------------------------
	* 
	* @var boelean
	*/
	public $addAllowed = false;

	/**
	* ---------------------------------------------------------------------
	* Export and Import data allowed
	* ---------------------------------------------------------------------
	* 
	* @var boelean
	*/
	public $importallowed = false;
	
	/**
	* ---------------------------------------------------------------------
	* action boolean
	* ---------------------------------------------------------------------
	* 
	* @var array
	*/
	public $actions = [];
	

    public $condActDet = [
        0 => [
            'detail' 	=> ['icon'=>'list-alt','src'=>'bill/corpdet?ids=', 'label'=>'Detail', 'attr'=>'', 'extra'=>''],
		    'edit' 		=> ['icon'=>'edit','src'=>'bill/update/', 'label'=>'Edit', 'attr'=>'', 'extra'=>''],
        ],
        1 => [
            'detail' 	=> ['icon'=>'list-alt','src'=>'bill/corpdet?ids=', 'label'=>'Detail', 'attr'=>'', 'extra'=>''],
            'cetak' 	=> ['icon'=>'print','src'=>'bill/print2?ids=', 'label'=>'Cetak Billing', 'attr'=>'', 'extra'=>''],
        ],
    ];

	public $panelAct = [
		0 => ['aksi' 	=> ['icon'=>'list-alt','src'=>'bill/mkcorpbil?ids=', 'label'=>'Buat Bill', 'attr'=>'', 'extra'=>''],],
		1 => ['aksi' 	=> ['icon'=>'print','src'=>'bill/print?ids=', 'label'=>'Cetak Bill', 'attr'=>'', 'extra'=>''],]
	];
	/**
	* --------------------------------------------------------------------
	* index colom/field  untuk mengurutkan data
	* --------------------------------------------------------------------
	* 
	* @var 
	* 
	*/
	public $sortby = 3; 
}
