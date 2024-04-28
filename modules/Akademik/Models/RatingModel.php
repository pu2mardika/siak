<?php

namespace Modules\Akademik\Models;

use CodeIgniter\Model;

class RatingModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'rating';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Akademik\Entities\Rating::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'curr_id', 'nm_komponen', 'no_urut', 'jns_nilai', 'type_nilai', 'is_mapel', 'tbl_stored_name', 'has_descript'];

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

    public function getDropdown($currID)
    {
        $data = $this->where('curr_id', $currID)->findAll();
    	$dd=[];
    	foreach($data as $val)
    	{
    		$dd[$val->id]=$val->nm_komponen;
    	}
    	return $dd;
    }
}
