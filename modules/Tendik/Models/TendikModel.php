<?php
namespace Modules\Tendik\Models;;

use CodeIgniter\Model;
use App\Models\BaseModel;

class TendikModel extends Model
{
    protected $table      = 'tbl_ptk';
    protected $primaryKey = 'nik';

    //protected $useAutoIncrement = true;
    //protected $returnType    =  'Modules\Tendik\Entities\Tendik'; // configure entity to use'array';
    protected $allowedFields = ['nik', 'noid', 'nama', 'tempatlahir', 'tgllahir', 'jk', 'status', 'sts_kepeg', 'alamat', 'nohp', 'email', 'npwp', 'rekeningbank', 'namabank', 'holdname', 'tmt', 'state'];
    
    protected $returnType    =  \Modules\Tendik\Entities\Tendik::class;
    protected $useSoftDeletes = true;
    // Dates
    protected $useTimestamps = true;
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
    
    // total
    public function total()
    {
        $builder = $this->db->table($this->table);
        $query = $builder->get();
        return $query->getNumRows();
    }
    
    public function getDropdown()
    {
    	$data = $this->findAll();
    	$dd=[];
    	foreach($data as $val)
    	{
    		$dd[$val->nik]=$val->nama;
    	}
    	return $dd;
    }
    
    public function getlike($key)
    {
    	/*
    	$wali = $this->db->table($this->table)
    			->like('nik',$key)
    			->orLike('nama',$key)
    			->orLike('noid', $key);
    	*/
    	$sql = "SELECT nik, nama FROM ".$this->table." 
    	WHERE `nik` LIKE '%{$key}%' ESCAPE '!' OR  `nama` LIKE '%{$key}%' ESCAPE '!'  OR  `noid` LIKE '%{$key}%' ESCAPE '!'";	
    	$result = $this->db->query($sql)->getResultArray();
		return $result;
    }
    
    public function getlikes($key)
    {
    	$wali = $this->db->table($this->table)
    			->like('nik',$key)
    			->orLike('nama',$key)
    			->orLike('noid', $key);
		return $wali;
    }
}