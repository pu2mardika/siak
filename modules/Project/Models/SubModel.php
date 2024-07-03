<?php

namespace Modules\Project\Models;

use CodeIgniter\Model;

class SubModel extends Model
{
    protected $table            = 'subelemen_project';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Project\Entities\SubElemen::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['elemen_id','deskripsi','tujuan'];

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

    public function getAll($parm=[])
    {
      return $this->getsData($parm)->getResultArray();
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
			    $rdata['id']=$E->id;
          $rdata['deskripsi'] =$E->deskripsi;
          $rdata['tujuan'] =$E->tujuan;
          $Result[$E->dimensi_id][$E->elemen_id][]= (object) $rdata;
        }
        return $Result;
    }
  
    private function getsData($param)
    {
        //dimensi_project : 'id', 'curr_id', 'nama_dimensi'
        //elemen_project: id, 'dimensi_id', 'deskripsi'
        
        $builder = $this->db->table('subelemen_project a');
        $builder->select('a.id, a.elemen_id, a.deskripsi, a.tujuan, b.dimensi_id, b.deskripsi as elemen, c.nama_dimensi, c.curr_id')
            ->join('elemen_project b', 'a.elemen_id = b.id')
            ->join('dimensi_project c', 'b.dimensi_id = c.id');
    //    $builder->orderBy('b.no_urut', 'ASC');
        $builder->where($param);
        $query = $builder->get();
        return $query;
    }
}
