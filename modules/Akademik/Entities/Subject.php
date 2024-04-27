<?php

namespace Modules\Akademik\Entities;

use CodeIgniter\Entity\Entity;

class Subject extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
    
     function setId($currID)
    {
        $akr	= $this->attributes['akronim'];
        $grup 	= $this->attributes['grup_id'];
        $rdnum 	= random_string('numeric',1);
		$idk 	= substr($currID,0,3).sprintf("%03d",$grup).$akr.$rdnum;
        $this->attributes["id"] = strtoupper($idk) ;
        return $this;
    } 
}
