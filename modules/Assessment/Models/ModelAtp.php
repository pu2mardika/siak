<?php

namespace Modules\Assessment\Models;

use CodeIgniter\Model;

class ModelAtp extends Model
{
    protected $table            = 'tblatps';
    protected $primaryKey       = 'id_mengajar';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Assessment\Entities\Atps::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_mengajar', 'rating_id', 'idx', 'atp', 'aspek'];

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

    public function getIdx($parms=[])
    {
        $builder = $this->db->table($this->table);
        $builder->selectMax('idx');
        $builder->where($parms);
        $query = $builder->get()->getRow();
        return ($query)?$query->idx + 1: 1;
    }

    public function update($data=[], $parm=[]):bool
    {
        $builder = $this->db->table($this->table);
        return $builder->where($parm)
                      ->update($data);
    }

    public function remove($parm=[]):bool
    {
        if(count($parm)<1)
        {
          return false;
        }

        $builder = $this->db->table($this->table);
        return $builder->where($parm)
                      ->delete();
    }

    public function simpanMasal($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insertBatch($data);
    }

    public function updateMasal($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->updateBatch($data,['id_mengajar', 'rating_id', 'idx']);
    }

    public function getAll($parm)
    {
      return $this->getsData($parm)->getResultArray();
    }
    
    public function getAtp($param=[])
    {
        $builder = $this->db->table('tblatps a');
        $builder->select('a.*, b.id_mapel')
            ->join('ptm b', 'a.id_mengajar = b.id');
        $builder->where($param);
        $query = $builder->get();
        return $query->getResultArray();
    }

    private function getsData($param=[])
    {
        $builder = $this->db->table('tblatps a');
        $builder->select('a.*, b.nm_komponen, b.akronim, b.no_urut')
            ->join('rating b', 'a.rating_id = b.id');
        $builder->orderBy('b.no_urut', 'ASC');
        $builder->where($param);
        $query = $builder->get();
        return $query;
    }
}
