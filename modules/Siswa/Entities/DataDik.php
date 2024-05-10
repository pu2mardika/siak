<?php

namespace Modules\Siswa\Entities;

use CodeIgniter\Entity\Entity;

class DataDik extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function getId(){
        // accessor which tgl value indonesian date-time format
        $config         = new \Config\Encryption();
		//$config->key    = 'aBigsecret_ofAtleast32Characters';
		//$config->driver = 'OpenSSL';

		$encrypter = \Config\Services::encrypter($config);
		$this->attributes['id']= bin2hex($encrypter->encrypt($this->attributes['nik']));
		return $this->attributes['id'];
	}
}
