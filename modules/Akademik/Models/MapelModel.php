<?php

namespace Modules\Akademik\Models;

use CodeIgniter\Model;

class MapelModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'mapel';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Akademik\Entities\Mapel::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','id_subject', 'id_skl', 'skk'];

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
    
	private function getsData($param=[])
	{
		$builder = $this->db->table('mapel a');
		$builder->select('a.id, a.id as id_mapel, a.id_subject, a.id_skl, a.skk, b.subject_name,  b.grup_id, b.akronim, c.grade, c.subgrade')
				->join('subjects b', 'a.id_subject = b.id')
				->join('tblskl c', 'a.id_skl = c.id');
		$builder->orderBy('a.id_skl', 'ASC');
		$builder->orderBy('b.item_order', 'ASC');
		$builder->where($param);
		$query = $builder->get();
		return $query;
	}

	public function getsMapel($parm)
	{
		return $this->getsData($parm)->getResultArray();
	}

    public function getMapel($currID){    	
    	/*'subject_name', 'akronim', 'item_order'
    	$builder = $this->db->table('mapel a');
		$builder->select('a.*, b.subject_name, b.akronim, c.grade, c.subgrade')
				->join('subjects b', 'a.id_mapel = b.id')
				->join('tblskl c', 'a.id_skl = c.id');
		$builder->orderBy('a.id_skl', 'ASC');
		$builder->orderBy('b.item_order', 'ASC');
		$builder->where('c.currId', $currID);
		$query = $builder->get()->getResult();
		*/
		$param['c.currId']=$currID;
		$builder = $this->getsData($param);
		$query = $builder->getResult();
		$Result = [];
		foreach($query as $dt)
		{
			$akrn = $dt->akronim.sprintf("%02d",$dt->grade).$dt->subgrade;
			$skk = $dt->skk;
			$dt->akronim = $akrn;
			$dt->skk = (int)$skk;
			//$dt->id = encrypt($dt->id_mapel.setting('Mapel.arrDelimeter').$dt->id_skl);
			//$dt->id = $dt->id_subject.setting('Mapel.arrDelimeter').$dt->id_skl;
			$Result[$dt->id_skl][]=$dt;
		}
		return $Result;
    }
	    
    public function detMapel(array $parm)
    {
    	$RS=[];
    	$R=$this->where($parm)->find();
    	foreach($R as $V)
    	{
    		$RS['id']=$V->id;
    		$RS['id_subject']=$V->id_subject;
    		$RS['id_skl']=$V->id_skl;
    		$RS['skk']=$V->skk;
    	}
    	return $RS;
    }
    /**
	* 
	* @param $currID
	* @param $sklID
	* 
	* @return
	*/
    public function getDropdown($currID, $sklID)
    {
    	//'id', 'grup_id', 'subject_name', 'akronim', 'item_order', 'tot_skk', 'form_nilai' from subjects
    	$sql="SELECT `a`.`id`, `a`.`subject_name`  FROM `subjects` `a` LEFT JOIN `grup_mapel` `b` 
			  ON `a`.`grup_id`=`b`.`grup_id` WHERE `b`.`curr_id` = '$currID' 
			  AND `a`.`id` NOT IN (SELECT id_subject FROM mapel WHERE id_skl = '$sklID') 
			  ORDER BY `a`.`grup_id` ASC, `a`.`item_order` ASC";
		$result = $this->db->query($sql)->getResult();
		
    	$dd[0]='[PILIH MAPEL]';
    	foreach($result as $val)
    	{
    		$dd[$val->id]=$val->subject_name;
    	}
    	return $dd;
    }
}