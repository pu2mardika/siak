<?php

namespace Modules\Kbm\Models;

use CodeIgniter\Model;

class PtmModel extends Model
{
    protected $table            = 'ptm';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Kbm\Entities\Ptm::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'id_mapel', 'roomid', 'subgrade', 'ptk_id', 'kkm'];

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

    private function getData($parm)
    {
       //`id`, `id_mapel`, `roomid`, `subgrade`, `ptk_id`, `kkm`, 
        $where = "a.deleted_at IS NULL";
        $builder = $this->db->table('ptm a');
		$builder->select('a.id, a.roomid, a.id_mapel, c.skk, a.kkm, e.subject_name, a.ptk_id, b.nama, b.noid, d.nama_rombel, d.kode_ta, a.subgrade')
                ->join('tbl_ptk b', 'a.ptk_id = b.nik')
                ->join('mapel c', 'a.id_mapel = c.id_mapel')
                ->join('rombel d', 'a.roomid = d.id')
                ->join('subjects e', 'c.id_mapel = e.id');	
		$builder->orderBy('a.id_mapel', 'ASC');
		$builder->where($where);
		$builder->where($parm);
		$query = $builder->get();
        return $query;
    }

    public function getAll($parm=[])
    {
        return $this->getData($parm)->getResultArray();
    }

    public function simpanMasal($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insertBatch($data);
    }

    public function updateMasal($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->updateBatch($data,['id_mapel', 'roomid', 'subgrade']);
    }
}
