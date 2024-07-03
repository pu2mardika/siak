<?php

namespace Modules\Project\Models;

use CodeIgniter\Model;

class ElemenModel extends Model
{
    protected $table            = 'elemen_project';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Project\Entities\Elemen::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['dimensi_id', 'deskripsi'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

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

    public function getDropdown($dimensi = 0)
    {
    	$data = ($dimensi == 0)?$this->findAll():$this->where('dimensi_id', $dimensi)->findAll();
    	
        $dd=[];
    	foreach($data as $val)
    	{
    		$dd[$val->id]=$val->deskripsi;
    	}
    	return $dd;
    }

    public function getAllRow($parm=[])
    {
      return $this->getsData($parm)->getResult();
    }

    public function getElemen($parm=[])
    {
        $el = $this->getsData($parm)->getResult();
        $Result=[];
        foreach($el as $E)
        {
			$Result[$E->dimensi_id][]=$E;
        }
        return $Result;
    }
  
    private function getsData($param)
    {
        //dimensi_project : 'id', 'curr_id', 'nama_dimensi'
        //elemen_project: id, 'dimensi_id', 'deskripsi'
        
        $builder = $this->db->table('elemen_project a');
        $builder->select('a.*, c.nama_dimensi, c.curr_id')
            ->join('dimensi_project c', 'a.dimensi_id = c.id');
        $builder->where($param);
        $query = $builder->get();
        return $query;
    }
}
