<?php

namespace Modules\Akademik\Entities;

use CodeIgniter\Entity\Entity;

class Skl extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
    
    function setId($prodi)
    {
        $currId = $this->attributes['currId'];
        $grade = $this->attributes['grade'];
        $subgrade = $this->attributes['subgrade'];
        $rdnum = random_string('numeric',1);
		$idk = $currId.sprintf("%02d",$grade).$subgrade.$rdnum;
       
        $this->attributes["id"] = $idk ;
        return $this;
    } 
}
