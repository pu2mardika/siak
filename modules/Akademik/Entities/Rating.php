<?php

namespace Modules\Akademik\Entities;

use CodeIgniter\Entity\Entity;

class Rating extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
    
    function setId($currID)
    {
        $no = $this->attributes['no_urut'];
       // $rdnum = random_string('alpha',1);
		$idk = $currID.sprintf("%02d",$no);
        $this->attributes["id"] = $idk ;
        return $this;
    } 
}
