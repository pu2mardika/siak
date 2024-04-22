<?php

namespace Modules\Akademik\Models;

use CodeIgniter\Model;

class SubjectModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'subject';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Akademik\Entities\Subject::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['subjectid', 'grup_id', 'subject_name', 'item_order', 'tot_skk', 'form_nilai'];

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
    
    public function getSubject($currID){
    	/**
		* 
		* @var 	$this->db->select('a.*, b.id_curriculum, b.parent_grup');
		$this->db->from($this->tbl_subjects. " a");
		$this->db->join($this->tbl_grup_mapel. " b","a.grup_id=b.grup_id","LEFT");
		$this->db->order_by("a.grup_id", "ASC");
		$this->db->order_by("a.item_order", "ASC");
		* 
		*/
    	
    	$builder = $this->db->table('subjects a');
		$builder->select('a.*, b.curr_id, b.parent_grup, b.nm_grup')->join('grup_mapel b', 'a.grup_id = b.grup_id');
		$builder->orderBy('a.grup_id', 'ASC');
		$builder->orderBy('a.item_order', 'ASC');
		$builder->where('b.curr_id', $currID);
		$query = $builder->get()->getResultArray();
		$Result = [];
		if(count($query)>0){
    		foreach($query as $dt)
    		{
    			$rs=$dt; 
    			unset($rs['curr_id']);
    			unset($rs['parent_grup']);
    			unset($rs['nm_grup']);
    			unset($rs['grup_id']);
    			$R['gid']=$dt['grup_id'];
    			$R['title']=$dt['nm_grup'];
    			$R['rsdata']=$rs;
    			$Result[$dt['grup_id']]=$R;
    		}
    	}else{
    		$Result[0]['rsdata']=[];
    	}
		return $Result;
    }
}
