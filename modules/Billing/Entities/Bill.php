<?php

namespace Modules\Billing\Entities;

use CodeIgniter\Entity\Entity;

class Bill extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function getId(){
         $encrypter = \Config\Services::encrypter();
         $attrib = $this->attributes;
         $this->attributes['id']= bin2hex($encrypter->encrypt($this->attributes['id']));
         return $this->attributes['id'];
     }
}
