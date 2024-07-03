<?php

namespace Modules\Project\Models;

use CodeIgniter\Model;

class DimensiModel extends Model
{
    protected $table            = 'dimensi_project';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Project\Entities\Dimensi::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['curr_id', 'nama_dimensi'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

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

    public function getDropdown($curr_id = 0)
    {
    	$data = ($curr_id == 0)?$this->findAll():$this->where('curr_id', $curr_id)->findAll();
    	
        $dd=[];
    	foreach($data as $val)
    	{
    		$dd[$val->id]=$val->nama_dimensi;
    	}
    	return $dd;
    }
}
