<?php

namespace Modules\Docregister\Entities;

use CodeIgniter\Entity\Entity;

class Document extends Entity
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
    protected $casts   = [
    	'state'	=> 'boolean',
    ];
    /**
    function setPassword(string $password)
    {
        $this->attributes["password"] = password_hash($password, PASSWORD_BCRYPT);
        return $this;
    } 
    */
    
    public function setTgl(){
        // convert date-time into unix time stamp
        helper(['app']);
        return ind_to_unix($this->attributes['tgl'],"00:00:00");
    }
    
    public function setRegId()
    {
    	$this->attributes['regId'] = sprintf('%1$03d',$this->attributes['no_kendali']).sprintf('%1$02d',$this->attributes['no_order']);
    	//$this->attributes['opid']=1;
    	return $this;
    }
    
    public function getTgl(){
        // accessor which tgl value indonesian date-time format
        helper(['app']);
        return unix2Ind($this->attributes['tgl']);
    }
    
    public function setNomorSurat()
    {
    	helper(['app']);
    	return formN0Surat($this->attributes['no_kendali'], 
    					   $this->attributes['no_order'],
    					   $this->attributes['clascode'],
    					   $this->attributes['tgl']);
    }

    
}
