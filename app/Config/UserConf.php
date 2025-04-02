<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class UserConf extends BaseConfig
{
    //
    public $fields = [
		'username'	    => ['label' => 'User Name','width'=>15, 'extra'=>['id'=>'usrId','class' => '', 'required' => true],'type'=>'text'],
        'full_name'	    => ['label' => 'Nama Lengkap','width'=>35, 'extra'=>['id'=>'usrName','class' => '', 'required' => true],'type'=>'text'],
        'email'	        => ['label' => 'Alamat Email','width'=>0, 'extra'=>['id'=>'dtemail','class' => '', 'required' => true],'type'=>'text'],
        'mobile_number' => ['label' => 'No Handphone','width'=>0, 'extra'=>['id'=>'dtemail','class' => '', 'required' => true],'type'=>'text'],
        'password'	    => ['label' => 'Kata Sandi','width'=>0, 'extra'=>['id'=>'pass','class' => '', 'required' => true],'type'=>'password'],
        'pass_confirm'	=> ['label' => 'Re-Kata Sandi','width'=>0, 'extra'=>['id'=>'repass','class' => '', 'required' => true],'type'=>'password'],
        'group'	        => ['label' => 'Grup Pengguna','width'=>15, 'extra'=>['id'=>'dgroup','class' => '', 'required' => true],'type'=>'dropdown'],
        'last_active'	=> ['label' => 'Akses Terakhir','width'=>15, 'extra'=>['id'=>'akses','class' => '', 'required' => true],'type'=>'date']
	];
	
	public $profil_fields = [
		'username'	    => ['label' => 'User Name','width'=>15, 'extra'=>['id'=>'usrId','class' => '', 'required' => true],'type'=>'text'],
        'full_name'	    => ['label' => 'Nama Lengkap','width'=>35, 'extra'=>['id'=>'usrName','class' => '', 'required' => true],'type'=>'text'],
        'email'	        => ['label' => 'Alamat Email','width'=>0, 'extra'=>['id'=>'dtemail','class' => '', 'required' => true],'type'=>'text'],
        'mobile_number' => ['label' => 'No Handphone','width'=>0, 'extra'=>['id'=>'dtemail','class' => '', 'required' => true],'type'=>'text'],
        'group'	        => ['label' => 'Grup Pengguna','width'=>15, 'extra'=>['id'=>'dgroup','class' => '', 'required' => true],'type'=>'dropdown'],
        'last_active'	=> ['label' => 'Akses Terakhir','width'=>15, 'extra'=>['id'=>'akses','class' => '', 'required' => true],'type'=>'date']
	];
	
	public $editfields = [
		'username'	    => ['label' => 'User Name','width'=>15, 'extra'=>['id'=>'usrId','class' => '', 'required' => true, 'disabled'=>""],'type'=>'text'],
        'full_name'	    => ['label' => 'Nama Lengkap','width'=>35, 'extra'=>['id'=>'usrName','class' => '', 'required' => true],'type'=>'text'],
        'email'	        => ['label' => 'Alamat Email','width'=>0, 'extra'=>['id'=>'dtemail','class' => '', 'required' => true, 'disabled'=>""],'type'=>'text'],
        'mobile_number' => ['label' => 'No. Handphone','width'=>0, 'extra'=>['id'=>'phone','class' => '', 'required' => true],'type'=>'tel'],
	];
	
	public $chPassfields = [
		'password'	    => ['label' => 'Kata Sandi','width'=>0, 'extra'=>['id'=>'pass','class' => '', 'required' => true],'type'=>'password'],
        'pass_confirm'	=> ['label' => 'Re-Kata Sandi','width'=>0, 'extra'=>['id'=>'repass','class' => '', 'required' => true],'type'=>'password'],
	];
	
	public $roles = [
        'full_name'     => ['label' => 'Nama', 'rules'         => 'required'],
        'username'      => ['label' => 'Username', 'rules'      => 'required|max_length[30]|min_length[3]|regex_match[/\A[a-zA-Z0-9\.]+\z/]|is_unique[users.username,id,{id}]'],
        'password'      => ['label' => 'Password', 'rules'      => 'required|min_length[8]'],
        'pass_confirm'  => ['label' => 'Password', 'rules'      => 'required_with[password]|max_length[255]|matches[password]'],
        'email'         => ['label' => 'Email Address', 'rules' => 'required|valid_email|is_unique[auth_identities.secret,id,{id}]'],
        'group'         => ['label' => 'Group', 'rules'         => 'required'],
	]; 
	
	public $editRoles = [
	    'full_name'          => ['label' => 'Nama', 'rules'     => 'required'],
        'mobile_number'      => ['label' => 'No Handphone', 'rules' => 'required|max_length[20]|min_length[10]|regex_match[/\A[0-9]+\z/]'],
	];
	
	public $chPassRoles = [
	    'password'      => ['label' => 'Password', 'rules'      => 'required|min_length[8]'],
        'pass_confirm'  => ['label' => 'Password', 'rules'      => 'required_with[password]|max_length[255]|matches[password]'],
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
	public $importallowed = FALSE;
	

	public $addAllowed = TRUE;
	/**
	* ---------------------------------------------------------------------
	* action boolean
	* ---------------------------------------------------------------------
	* 
	* @var array
	*/
	public $actions = [
		'chpass' 	=> ['icon'=>'key','src'=>'user/chpass/', 'label'=>'Ganti Password', 'extra'=>''],
		'edit' 		=> ['icon'=>'edit','src'=>'user/edit/', 'label'=>'Edit Profil', 'extra'=>''],
	];
}
