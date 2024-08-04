<?php

namespace Modules\Assessment\Models;

use CodeIgniter\Model;

class NilaiModel extends Model
{
    protected $table            = 'leger_nilai';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Assessment\Entities\Nilai::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['member_id', 'id_mengajar', 'rating_id', 'idx', 'nilai'];

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

    //'member_id', 'id_mengajar', 'rating_id', 'idx', 'nilai'
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

    private function getData($param=[]){
        $builder = $this->db->table($this->table.' a');
		$builder->select('a.*, b.id_mapel')
				->join('ptm b', 'a.id_mengajar = b.id');
		$builder->where($param);
		$query = $builder->get();
		return $query;
    }

    public function getsNilai($parm)
	{
		return $this->getData($parm)->getResultArray();
	}
}
