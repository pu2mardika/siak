<?php

namespace Modules\Akademik\Models;

use CodeIgniter\Model;

class SubjectModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'subjects';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Akademik\Entities\Subject::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'grup_id', 'subject_name', 'akronim', 'item_order', 'tot_skk', 'form_nilai'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = '';	//'created_at';
    protected $updatedField  = '';	//'updated_at';
    protected $deletedField  = '';	//'deleted_at';

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
    
    public function getSubject($currID, $obj=FALSE){
    	    	
    	$builder = $this->db->table('subjects a');
		$builder->select('a.*, b.curr_id')->join('grup_mapel b', 'a.grup_id = b.grup_id');
		$builder->orderBy('a.grup_id', 'ASC');
		$builder->orderBy('a.item_order', 'ASC');
		$builder->where('b.curr_id', $currID);
		$query = $builder->get()->getResult();
		$Result = [];
		if(count($query)>0){
    		foreach($query as $dt)
    		{
    			//$rs = ($obj)?(object)$dt:$dt;
    			//$Result[$dt['grup_id']][]=$rs;
    			$Result[$dt->grup_id][]=$dt;
    		}
    	}
		return $Result;
    }
    
    public function nextOrder($currID)
    {
    	$builder = $this->db->table('subjects a');
		$builder->selectMax('a.item_order', 'order')->join('grup_mapel b', 'a.grup_id = b.grup_id');
		$builder->where('b.curr_id', $currID);
		$Q = $builder->get()->getRowArray();
		$R = 0;
		if(isset($Q)){
    		$R = $Q['order']; 
    	}
    	//test_result($Q);
		return $R + 1;
    }
}
