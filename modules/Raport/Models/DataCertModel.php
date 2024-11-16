<?php

namespace Modules\Raport\Models;

use CodeIgniter\Model;

class DataCertModel extends Model
{
    protected $table            = 'cert_detail';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'certId', 'memberId', 'no_urut'];

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

    public function getAll($parm)
    {
        return $this->getsData($parm)->getResult();
    }

    public function getAllArr($parm)
    {
        return $this->getsData($parm)->getResultArray();
    }

    public function gets($parm)
    {
        return $this->getsData($parm)->getRowArray();
    }
  
    private function getsData($param=[])
    {
        $builder = $this->db->table($this->table.' a');
        $builder->select('a.id, a.certId, b.roomid, a.memberId, b.noinduk, 
                          e.nama, e.tempatlahir, e.tgllahir, e.idreg, e.nik, e.nisn,
                          x. curr_id, x.grade, y.id_prodi, z.nm_prodi,
                          y.curr_name, y.instance_rpt, y.action_class')
            ->join('rombel_memb b', 'a.memberId = b.id')
            ->join('siswa d', 'b.noinduk = d.noinduk')
            ->join('tbl_datadik e','d.nik = e.nik')
            ->join('rombel x', 'b.roomid = x.id')
            ->join('curriculum y', 'x.curr_id = y.id')
            ->join('prodi z', 'y.id_prodi = z.id_prodi');
        $builder->where($param);
        $query = $builder->get();
        return $query;
    }

    function getDataMember($roomID)
    {
        $sql = "SELECT a.id as memberId, a.roomid, a.noinduk, a.learn_metode, c.idreg, c.nama, c.nisn, c.jk  
        FROM rombel_memb a JOIN siswa b ON a.noinduk = b.noinduk  
        JOIN tbl_datadik c ON b.nik = c.nik 
        WHERE id NOT IN (SELECT memberId FROM cert_detail) AND a.roomid = '".$roomID."'";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function maxNum($certID)
    {
        $builder = $this->db->table($this->table);
        $builder->selectMax('age');
        $builder->where('certId', $certID);
        $query = $builder->get();
        return $query->getResult();
    }

    public function simpanMasal($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insertBatch($data);
    }
}
