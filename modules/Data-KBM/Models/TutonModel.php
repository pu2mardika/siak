<?php

namespace Modules\Kbm\Models;

use CodeIgniter\Model;

class TutonModel extends Model
{
    protected $table            = 'rombel_memb';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

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

    public function getParticipan($parm)
    {
        $query = $this->getData($parm);
        return $query->getResultArray();
    }

    private function getData($parm)
    {
        $builder = $this->db->table('rombel_memb a');
		$builder->select('a.id, a.roomid, a.noinduk, a.learn_metode, c.idreg, c.nama, c.nisn, c.email, d.kode_ta')
                ->join('siswa b', 'a.noinduk = b.noinduk')
                ->join('tbl_datadik c', 'b.nik = c.nik')
                ->join('rombel d', 'a.roomid = d.id');	
		$builder->orderBy('a.noinduk', 'ASC');
		$builder->where($parm);
		$query = $builder->get();
        return $query;
    }
    
    public function getMapel()
    {
        $where = "a.deleted_at IS NULL";
        $builder = $this->db->table('ptm a');
		$builder->select('a.id, a.roomid, a.id_mapel, c.skk, a.kkm, e.subject_name, a.ptk_id, b.nama, b.noid, b.email, d.kode_ta, a.subgrade, d.curr_id')
                ->join('tbl_ptk b', 'a.ptk_id = b.nik')
                ->join('mapel c', 'a.id_mapel = c.id')
                ->join('rombel d', 'a.roomid = d.id')
                ->join('subjects e', 'c.id_subject = e.id');	
		$builder->orderBy('a.id_mapel', 'ASC');
		$builder->where($where);
		$builder->where($parm);
		$query = $builder->get();
        return $query->getResultArray();
    }
}
