<?php

namespace Modules\Akademik\Models;

use CodeIgniter\Model;

class KurikulumModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'curriculum';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Akademik\Entities\Kurikulum::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'id_prodi', 'curr_name', 'curr_desc', 'issued', 'l_duration', 
                                   'curr_system', 'instance_rpt', 'ch_level', 'has_project', 'action_class','state'];

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
    
    public function getDropdown($prodi = 0)
    {
    	$data = ($prodi == 0)?$this->findAll():$this->where('id_prodi', $prodi)->findAll();
    	
        $dd=[];
    	foreach($data as $val)
    	{
    		$dd[$val->id]=$val->curr_name;
    	}
    	return $dd;
    }
    
    public function getLevel($currId)
	{
		$level=['grade'=>[],'subgrade'=>[]];
		$curr = $this->find($currId)->toarray();
    	if(count($curr)>0){
    		$grade = $curr['l_duration'];
    		$subgrade = $curr['curr_system'];
    		
    		//grade
    		for($x=1; $x<=$grade; $x++){
    			$G[$x] = 'Level/Grade-'.$x;
    		}
    		$level['grade'] = $G;
    		$x=1;
    		for($x=1; $x<=$subgrade; $x++){
    			$S[$x] = 'Sub Level/Grade-'.$x;
    		}
    		$level['subgrade'] = $S;
    	}
		return $level;
	}

    //AMBIL DATA KURIKULUM YANG MENGGUNAKAN RAPORT
    public function DropDown($param)
    {
        $builder = $this->db->table($this->table.' a');
        $builder->select('a.id, a.curr_name, b.jns_lhb')
            ->join('prodi b', 'a.id_prodi = b.id_prodi');
        $builder->where($param);
        $query = $builder->get();
        $dd=[];
        foreach ($query->getResultArray() as $row) {
            $dd[$row['id']]=$row['curr_name'];
        }
        return $dd;
    }
}
