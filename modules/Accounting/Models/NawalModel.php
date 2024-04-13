<?php

namespace Modules\Account\Models;

use CodeIgniter\Model;

class NawalModel extends Model
{
    protected $table            = 'neracaAwal';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Account\Entities\Nawal::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['tanggal', 'kode_akun', 'debet', 'kredit'];

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
    
    public function getDropdown($tglAwal)
    {
    	$data = $this->where('tanggal >=', $tglAwal)->asArray()->findAll();
    	$dd=[];
    	foreach($data as $val)
    	{
    		$dd[$val['kode_akun']]=[
    			"tanggal" 	=>$val['tanggal'], 
    			"deskripsi"	=>"SALDO AWAL", 
    			"debet"		=>(float)$val['debet'], 
    			'kredit'	=>(float)$val['kredit']
    		];
    	}
    	return $dd;
    }
    
    public function getData($where)
    {
    	$builder = $this->db->table('neracaAwal a');
		$builder->select('a.*, b.nama_akun') 
				->join('akun_bb b', 'a.kode_akun = b.kode_akun');
		$builder->where($where);
		$builder->orderBy('a.kode_akun', 'ASC');
		$query = $builder->get()->getResult();
		return $query;
    }
}
