<?php

namespace Modules\Account\Entities;

use CodeIgniter\Entity\Entity;

class TmpGl extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
    
    public function setId($text){
		//$text = $this->attributes["id"];
		$this->attributes["id"] = md5($text) ;
        return $this;
	}
}
