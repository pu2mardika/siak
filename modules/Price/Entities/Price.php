<?php

namespace Modules\Pricing\Entities;

use CodeIgniter\Entity\Entity;

class Price extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    function setId(string $no)
    {
        $tgl  = $this->attributes['tmt'];
        $type = $this->attributes['komponen'];
        $tstgl= ind_to_unix($tgl);
		$yy = date("ym",$tstgl);
        $rdnum = strtoupper(random_string('alpha',2));
		$idk = $yy.$rdnum.$type.random_string('numeric',2);
        $this->attributes["id"] = $idk;
        return $this;
    } 

    public function getId(){
        // accessor which tgl value indonesian date-time format
        $config         = new \Config\Encryption();
		//$config->key    = 'aBigsecret_ofAtleast32Characters';
		//$config->driver = 'OpenSSL';

		$encrypter = \Config\Services::encrypter($config);
		$this->attributes['id']= bin2hex($encrypter->encrypt($this->attributes['id']));
		return $this->attributes['id'];
	}
}
