<?php

namespace Modules\Project\Models;

use CodeIgniter\Model;

class MappingModel extends Model
{
    protected $table            = 'mapproject';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Project\Entities\Mapping::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','project_id', 'subelemen_id'];

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

    public function simpanMasal($data)
    {
        return $this->db->table($this->table)->insertBatch($data);
    }

    public function updateMasal($data)
    {
        return $this->db->table($this->table)->updateBatch($data, ['id']);
    }

    public function countData($param=[])
    {
        return $this->db->table($this->table)->where($param)->countAllResults();
    }

    public function getsAll($parm=[])
    {
        return $this->getsData($parm)->getResultArray();
    }

    private function getsData($param)
    {
        //dimensi_project : 'id', 'curr_id', 'nama_dimensi'
        //elemen_project: id, 'dimensi_id', 'deskripsi'
        
        $builder = $this->db->table('mapproject a');
        $builder->select('a.*, b.deskripsi, b.tujuan, b.elemen_id, c.deskripsi as elemen,c.dimensi_id, d.nama_dimensi, d.curr_id')
            ->join('subelemen_project b', 'a.subelemen_id = b.id')
            ->join('elemen_project c', 'b.elemen_id = c.id')
            ->join('dimensi_project d', 'c.dimensi_id = d.id');
        $builder->where($param);
        $query = $builder->get();
        return $query;
    }
}
