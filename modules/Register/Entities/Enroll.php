<?php

namespace Modules\Register\Entities;

use CodeIgniter\Entity\Entity;

class Enroll extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
   
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
