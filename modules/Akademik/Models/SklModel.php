<?php

namespace Modules\Akademik\Models;

use CodeIgniter\Model;

class SklModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tblSkl';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Akademik\Entities\Skl::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','grade', 'subgrade', 'grade_name', 'deskripsi', 'currId'];

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
    
    public function getSKL($parms)
    {
    	$builder = $this->db->table($this->table);
		$builder->select('*');
		$builder->where("currId = '{$parms}'");
		$query = $builder->get()->getResultArray();
		return $query;
    }
}
