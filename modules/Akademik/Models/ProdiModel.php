<?php

namespace Modules\Akademik\Models;

use CodeIgniter\Model;

class ProdiModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'prodi';
    protected $primaryKey       = 'id_prodi';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Akademik\Entities\Prodi::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nm_prodi', 'skl', 'jurusan', 'jenjang'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getDropdown()
    {
    	$data = $this->findAll();
    	$dd=[];
    	foreach($data as $val)
    	{
    		$dd[$val->id_prodi]=$val->nm_prodi;
    	}
    	return $dd;
    }
}