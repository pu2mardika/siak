<?php
namespace Modules\Tp\Models;;

use CodeIgniter\Model;
use App\Models\BaseModel;

class TpModel extends Model
{
    protected $table      = 'tbl_tp';
    protected $primaryKey = 'thid';

    protected $useAutoIncrement = true;
    protected $allowedFields = ['deskripsi', 'awal', 'akhir'];
    
    protected $returnType    =  \Modules\Tp\Entities\Tp::class;
    protected $useSoftDeletes = false;
    // Dates
    protected $useTimestamps = true;
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
    
    // total
    public function total()
    {
        $builder = $this->db->table($this->table);
        $query = $builder->get();
        return $query->getNumRows();
    }
    
    public function getcurTP()
    {
    	$param = ['awal <=' => date('Y-m-d H:i:s'), 'akhir >=' => date('Y-m-d H:i:s')];
    	$builder = $this->db->table($this->table);
    	//$builder->where('akhir <=', now());
    	//$builder->where('awal >=', now());
    	$builder->where($param);
        $builder->orderBy('thid', 'DESC');
    	//echo $builder->getCompiledSelect();//->getRow();	
    	return $builder->get()->getRow();
    }
    
    public function getDropdown()
    {
    	$data = $this->findAll();
    	$dd=[];
    	foreach($data as $val)
    	{
    		$dd[$val->thid]=$val->deskripsi;
    	}
    	return $dd;
    }
    
}