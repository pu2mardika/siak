<?php

namespace Modules\Akademik\Entities;

use CodeIgniter\Entity\Entity;

class Raports extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    function setId($currID)
    {
        $currID = $this->attributes['curr_id'];
        $hal    = $this->attributes['hal'];
        $block  = $this->attributes['block'];
       // $rdnum = random_string('alpha',1);
		$idk = $currID.$hal.$block;
        $this->attributes["id"] = $idk ;
        return $this;
    } 
}
