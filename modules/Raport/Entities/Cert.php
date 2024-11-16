<?php

namespace Modules\Raport\Entities;

use CodeIgniter\Entity\Entity;

class Cert extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    function setId(string $no)
    {
        $ta   = sprintf("%02d",$this->attributes['kode_ta']);
        $tgl  = $this->attributes['issued'];
        $type = $this->attributes['jenis'];
        $tstgl= ind_to_unix($tgl);
		$yy = date("ym",$tstgl);
        $rdnum = random_string('numeric',2);
		$idk = $ta.$yy.$rdnum.$type;
        $this->attributes["id"] = $idk;
        return $this;
    } 

}
