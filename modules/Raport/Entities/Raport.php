<?php

namespace Modules\Raport\Entities;

use CodeIgniter\Entity\Entity;

class Raport extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    function setId(string $subgrid)
    {
        $currID = $this->attributes['curr_id'];
        $idx = $currID.sprintf("%02d",$subgrid);
        $this->attributes["id"] = md5($idx);
        return $this;
    } 
}
