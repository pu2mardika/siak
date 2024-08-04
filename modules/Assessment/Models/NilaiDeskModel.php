<?php

namespace Modules\Assessment\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\RawSql;

class NilaiDeskModel extends Model
{
    protected $table            = 'nilai_deskripsi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['member_id', 'subgrade', 'rating_id', 'idx', 'nilai'];

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
        $builder = $this->db->table($this->table);
        return $builder->insertBatch($data);
    }

    public function updateMasal($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->updateBatch($data,['member_id', 'subgrade', 'rating_id', 'idx']);
    }

    public function getsNilai($parm)
	{
		return $this->getData($parm)->getResultArray();
	}

    function reset($parm=[])
    {
        $RID['roomid'] = $parm['rommID'];
        $kond = ['subgrade'=>$parm['subgrade'], 'idx'=>$parm['pid']];
        $subQuery = $this->db->table('rombel_memb')->select('id')->where($RID);
//        $subQuery = $db->table('users_jobs')->select('job_id')->where('user_id', 3);

        $builder = $this->db->table($this->table)
            ->where($kond)
            ->whereIn('member_id', $subQuery);;
        return $builder->delete();
    }

    private function getData($param=[]){
        $builder = $this->db->table($this->table.' a');
		$builder->select('a.*')
				->join('rombel_memb b', 'a.member_id = b.id');
		$builder->where($param);
		$query = $builder->get();
		return $query;
    }
}
