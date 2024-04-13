<?php

namespace Modules\Account\Entities;

use CodeIgniter\Entity\Entity;

class Account extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
     /**
     * SET NOREGISTER
     */ 
    function setIdreg()
    {
        $this->attributes["idreg"] = register(date('Y-m-d'));
        return $this;
    } 
      
    public function getId(){
        $encrypter = \Config\Services::encrypter();
		$this->attributes['id']= bin2hex($encrypter->encrypt($this->attributes['kode_akun']));
		return $this->attributes['id'];
	}
}
