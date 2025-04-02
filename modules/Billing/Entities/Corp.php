<?php

namespace Modules\Billing\Entities;

use CodeIgniter\Entity\Entity;

class Corp extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function getBillId(){
        $encrypter = \Config\Services::encrypter();
        $attrib = $this->attributes;
        $this->attributes['billId']= (is_null($this->attributes['billId'])||strlen($this->attributes['billId'])<1)?"NOT SET":$this->attributes['billId'];
        return $this->attributes['billId'];
    }

    public function getNama(){
        $attrib = $this->attributes;
        $this->attributes['nama']=$this->attribute->corporate_name;
    }
}
