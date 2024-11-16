<?php

namespace Modules\Raport\Models;

use CodeIgniter\Model;

class CertModel extends Model
{
    protected $table            = 'stsb';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Raport\Entities\Cert::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'jenis', 'kode_ta', 'exam', 'issued', 'otorized_by'];

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
/*
    public function getAll($parm)
    {
      return $this->getsData($parm)->getResult();
    }

    public function gets($parm)
    {
        return $this->getsData($parm)->getRowArray();
    }
  
    private function getsData($param=[])
    {
        $builder = $this->db->table($this->table.' a');
        $builder->select('a.id, a.curr_id, a.exam, a.issued, a.otorized_by, 
            b.curr_name, b.curr_system, b.instance_rpt, b.has_project, b.action_class, c.deskripsi as tapel')
            ->join('curriculum b', 'a.curr_id = b.id')
            ->join('tbl_tp c', 'a.kode_ta = c.thid');
        $builder->where($param);
        $query = $builder->get();
        return $query;
    }
*/
    /**
     * menampilkan data rombel yang memiliki field RoomID, kode_ta, jns_lhb dan jml_member yang belum sert.
     * `walikelas`, `kode_ta`, `curr_id`, `grade`
     */
    public function getRombel($param = "")
    {
        $sql = "SELECT a.id, a.nama_rombel, a.walikelas, a.kode_ta, a.curr_id, a.grade, b.instance_rpt, b.action_class, c.jns_lhb, y.jml as member  
                FROM rombel a JOIN curriculum b ON a.curr_id=b.id 
                JOIN prodi c ON b.id_prodi = c.id_prodi 
                JOIN (SELECT roomid, COUNT(id) as jml FROM rombel_memb WHERE id NOT IN (SELECT memberId FROM cert_detail) GROUP BY roomid) y ON a.id = y.roomid 
                WHERE y.jml>0 ".$param.";";
        $query = $this->db->query($sql);
        return $query->getResult();
    }
}
