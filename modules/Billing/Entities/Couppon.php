<?php

namespace Modules\Billing\Entities;

use CodeIgniter\Entity\Entity;

class Couppon extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function getId(){
        // accessor which tgl value indonesian date-time format
        $config         = new \Config\Encryption();
		
		$encrypter = \Config\Services::encrypter($config);
		$this->attributes['id']= bin2hex($encrypter->encrypt($this->attributes['id']));
		return $this->attributes['id'];
	}
}
