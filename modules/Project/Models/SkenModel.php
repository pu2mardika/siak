<?php

namespace Modules\Project\Models;

use CodeIgniter\Model;

class SkenModel extends Model
{
    protected $table            = 'skenproject';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['project_id', 'room_id'];

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

    function getsAll($param=[])
    {
        $builder = $this->db->table('skenproject a');
		$builder->select('a.*, b.nama_project, b.deskripsi')->join('dataproject b', 'a.project_id = b.id')->where($param);
	    return $builder->get()->getResultArray();
    }

    public function simpanMasal($data)
    {
        return $this->db->table($this->table)->insertBatch($data);
    }
}
