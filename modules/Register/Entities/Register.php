<?php

namespace Modules\Register\Entities;

use CodeIgniter\Entity\Entity;

class Register extends Entity
{
     /**
     * Maps names used in sets and gets against unique
     * names within the class, allowing independence from
     * database column names.
     *
     * Example:
     *  $datamap = [
     *      'db_name' => 'class_name'
     *  ];
     */
    protected $datamap = [];
    /**
     * Define properties that are automatically converted to Time instances.
     */
    protected $dates   = ['tgllahir'];
    /**
     * Array of field names and the type of value to cast them as
     * when they are accessed.
     */
    protected $casts   =[
    	'status' 	=> 'boolean',
    ];
    /**
     * SET NOREGISTER
     */ 
    function setIdreg()
    {
        $this->attributes["idreg"] = register(date('Y-m-d'));
        return $this;
    } 
      
    public function getId(){
       // $config         = new \Config\Encryption();
	//	$config->key    = 'aBigsecret_ofAtleast32Characters';
	//	$config->driver = 'OpenSSL';
	//	$encrypter = \Config\Services::encrypter($config);
        $encrypter = \Config\Services::encrypter();
		$this->attributes['id']= bin2hex($encrypter->encrypt($this->attributes['nik']));
		return $this->attributes['id'];
	}
    
}
