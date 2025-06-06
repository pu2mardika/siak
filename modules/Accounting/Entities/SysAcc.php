<?php

namespace Modules\Account\Entities;

use CodeIgniter\Entity\Entity;

class SysAcc extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function getId(){
        $encrypter = \Config\Services::encrypter();
		$this->attributes['id']= bin2hex($encrypter->encrypt($this->attributes['key_item']));
		return $this->attributes['id'];
	}
}
