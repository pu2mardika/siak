<?php

namespace Modules\Account\Models;

use CodeIgniter\Model;

class TmpGlModel extends Model
{
    protected $table            = 'tmpjurnal'; //'id', 'uid', 'tanggal', 'deskripsi', 'no_bukti', 'jnstrx', 'accId', 'amount' FROM 'tmpjurnal'
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Account\Entities\TmpGl::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'uid', 'tanggal', 'deskripsi', 'no_bukti', 'jnstrx', 'accId', 'amount', 'activity'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $deletedField  = '';

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
    
    public function getData($uid){
    	$builder = $this->db->table('tmpjurnal a');
		$builder->select('a.*, b.nama_akun ')->join('akun_bb b', 'b.kode_akun = a.accId');
		$builder->where('a.uid', $uid);
		$query = $builder->get()->getResultArray();
		return $query;
    }
    
    public function getTotal($uid)
    {
    	$builder = $this->db->table($this->table);
    	$builder->selectSum('amount', 'total');
        $builder->where('uid', $uid);
        $query = $builder->get()->getRowArray();
        return ($query)?$query['total']:0;
    }
}
