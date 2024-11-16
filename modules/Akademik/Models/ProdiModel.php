<?php

namespace Modules\Akademik\Models;

use CodeIgniter\Model;

class ProdiModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'prodi';
    protected $primaryKey       = 'id_prodi';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Akademik\Entities\Prodi::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nm_prodi', 'skl', 'jurusan', 'jenjang','jns_lhb'];

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

    public function getDropdown()
    {
    	$data = $this->findAll();
    	$dd=[];
    	foreach($data as $val)
    	{
    		$dd[$val->id_prodi]=$val->nm_prodi;
    	}
    	return $dd;
    }

    function gets($param)
    {
        $builder = $this->db->table($this->table.' a');
		$builder->select('a.nm_prodi, a.jenjang, a.jurusan, a.skl, b.nm_program, b.unit_kerja')
				->join('jurusan b', 'a.jurusan = b.id');
		$builder->where($param);
		return $builder->get()->getResultArray();
    }
}