<?php

namespace Modules\Room\Entities;

use CodeIgniter\Entity\Entity;

class Rombel extends Entity
{
     /**
     * Maps names used in sets and gets against unique
     * names within the class, allowing independence from
     * database column names.
     *
     * Example:
     *  $datamap = [
     *      'db_name' => 'class_name'
     *  ];
     */
    protected $datamap = [];
    /**
     * Define properties that are automatically converted to Time instances.
     */
    protected $dates   = [];
    /**
     * Array of field names and the type of value to cast them as
     * when they are accessed.
     */
    protected $casts   =[
   // 	'status' 	=> 'boolean',
    ];
   
    function setId(string $prodi)
    {
        $TA = $this->attributes['kode_ta'];
        $currID = $this->attributes['curr_id'];
        $rdnum = strtoupper(random_string('alpha',2));
        $idx = substr($currID,0,3).sprintf("%02d",$TA).sprintf("%02d",$prodi).$rdnum.rand(1,9);
        $this->attributes["id"] = $idx;
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
