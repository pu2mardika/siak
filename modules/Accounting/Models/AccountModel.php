<?php

namespace Modules\Account\Models;

use CodeIgniter\Model;

class AccountModel extends Model
{
    protected $table            = 'akun_bb';
    protected $primaryKey       = 'kode_akun';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Account\Entities\Account::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kode_akun', 'nama_akun', 'grup_akun', 'norm_balance'];

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
    		$dd[$val->kode_akun]=$val->kode_akun ."-".$val->nama_akun;
    	}
    	return $dd;
    }
    
    public function getAkunBB()
    {
    	$builder = $this->db->table('akun_bb a');
		$builder->select('a.*, b.grupName, b.gtype')->join('akun_grups b', 'b.grupId = a.grup_akun');
		$builder->orderBy('a.grup_akun', 'ASC');
		$builder->orderBy('a.kode_akun', 'ASC');
		$query = $builder->get()->getResultArray();
		return $query;
    }
}
