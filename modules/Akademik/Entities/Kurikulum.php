<?php

namespace Modules\Akademik\Entities;

use CodeIgniter\Entity\Entity;

class Kurikulum extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    function setId($prodi)
    {
        $tgl = $this->attributes['issued'];
        $prodi = $this->attributes['id_prodi'];
        $akronim = $this->attributes['instance_rpt'];
        $tstgl = ind_to_unix($tgl);
		$yy = date("y",$tstgl);
        $rdnum = random_string('numeric',1);
		$idk = $akronim.sprintf("%02d",$prodi).$yy.$rdnum;
        //$idk = $akronim.$rdnum;
		
        $this->attributes["id"] = $idk ;
        return $this;
    } 
}