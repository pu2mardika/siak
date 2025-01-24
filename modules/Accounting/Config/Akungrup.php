<?php

namespace Modules\Account\Config;

use CodeIgniter\Config\BaseConfig;

class Akungrup extends BaseConfig
{
     /**
	 * --------------------------------------------------------------------
	 * akun_grup : `grupId`, `grupName`, `gtype`
	 * --------------------------------------------------------------------
	 *
	 * @var array
	 */
	public $opsi = [
		'gtype' => [1=>'Acctiva/Assets', 2=>'Kewajiban / Liabilities', 3=>'Modal/Equity', 4=>'Pendapatan/Income',
				    5=>'Beban Operasional/Operating Expenses', 6=>'Beban Non Operasional/Non Operating Expenses', 
				    7=>'Laba-Rugi', 8=>'Other Income and Expenses', 9=>'Post Luar Biasa',
				    10=>'Pajak'],
	];
	
	public array $FinReportAcc = [
		'lra' => [
					'component'=> [4, 5, 6, 8, 9, 10],
					'oi'=> [
							'title' => "SHU Operasional",
							'data'	=> [
										4=> ["title"=>"Pendapatan", "koef"=>1, 'type'=>"pure"], 
										5=> ["title"=>"Beban/Expenses", "koef"=>-1, 'type'=>"pure"]
									   ]
						   ],
					'ebit'=> [
							 'title'=> "SHU Dibagi",
							 'data' => [
							 			6=> ["title"=>'Beban Non Operasional', "koef"=>-1, 'type'=>"pure"], 
							 			8=> ["title"=>'Other Income and Expenses', "koef"=>1, 'type'=>"mix"],
							 			9=> ["title"=>'Post Luar Biasa', "koef"=>1, 'type'=>"pure"]
							           ]
					 		 ],
					'np'=> [
							 'title'=> "R/L Sebelum Pajak",
							 'data' => [
							 			10=> ["title"=>'Pajak', "koef"=>1, 'type'=>"pure"]
							 		   ]
					 	   ]
				 ],
		'equity' => [
					
				 ],
		
		'balance' => [
					
				 ]
		
			
	];
	
	/**
	* ---------------------------------------------------------------------
	* FIELD NAME 
	* ---------------------------------------------------------------------
	* @var array
	* 
	*/
	public $fields = [
		'grupId'		=> ['label' => 'Kode Grup','width'=>15,'extra'=>['id' => 'nama','class' => '', 'required' => true],'type'=>'text', ],
		'grupName'		=> ['label' => 'Nama Grup','width'=>40,'extra'=>['id' => 'nama','class' => '', 'required' => true],'type'=>'text', ],
		'gtype'			=> ['label' => 'Jenis Akun','width'=>30,'extra'=>['id' => 'jk','class' => '', 'required' => true],'type'=>'dropdown'],
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
        'grupId'   		=> ['label' => 'Kode Grup', 'rules' =>'required'],
        'grupName'  	=> ['label' => 'Nama Grup', 'rules' =>'required'],
        'gtype'  		=> ['label' => 'Jenis', 'rules' =>'required'],
	];  
	
	public $roleEdit = [
		'grupId'   		=> ['label' => 'Kode Grup', 'rules' =>'required'],
        'grupName'  	=> ['label' => 'Nama Grup', 'rules' =>'required'],
        'gtype'  		=> ['label' => 'Jenis', 'rules' =>'required'],
	];  
	/**
	 * --------------------------------------------------------------------
	 * Layout for the views to extend
	 * --------------------------------------------------------------------
	 *
	 * @var string
	 */
	public $primarykey = 'id';
	
	
	/**
	* ---------------------------------------------------------------------
	* Export and Import data allowed
	* ---------------------------------------------------------------------
	* 
	* @var boelean
	*/
	public $importallowed = TRUE;
	
	/**
	* ---------------------------------------------------------------------
	* action boolean
	* ---------------------------------------------------------------------
	* 
	* @var array
	*/
	public $actions = [
		'edit' 		=> ['icon'=>'edit','src'=>'akungrup/edit/', 'label'=>'Detail', 'extra'=>''],
		'delete'	=> ['icon'=>'trash','src'=>'akungrup/hapus/', 'label'=>'Detail', 'extra'=>"onclick='confirmation(event)'"],
	];
}
