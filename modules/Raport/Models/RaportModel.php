<?php

namespace Modules\Raport\Models;

use CodeIgniter\Model;

class RaportModel extends Model
{
    protected $table            = 'raport';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Raport\Entities\Raport::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'curr_id', 'kode_ta', 'subgrade', 'issued', 'otorized_by' ];

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

    //protected $table

    public function getAll($parm)
    {
      return $this->getsData($parm)->getResultArray();
    }

    public function gets($parm)
    {
        return $this->getsData($parm)->getRowArray();
    }
  
    private function getsData($param=[])
    {
        $builder = $this->db->table($this->table.' a');
        $builder->select('a.id, a.curr_id, a.subgrade, a.issued, a.otorized_by, 
            b.curr_name, b.curr_system, b.instance_rpt, b.has_project, b.action_class, c.deskripsi as tapel')
            ->join('curriculum b', 'a.curr_id = b.id')
            ->join('tbl_tp c', 'a.kode_ta = c.thid');
        $builder->orderBy('a.subgrade', 'ASC');
        $builder->where($param);
        $query = $builder->get();
        return $query;
    }
}
