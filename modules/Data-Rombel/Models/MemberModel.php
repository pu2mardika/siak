<?php

namespace Modules\Room\Models;

use CodeIgniter\Model;

class MemberModel extends Model
{
    protected $table            = 'rombel_memb';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Room\Entities\Member::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'roomid', 'noinduk', 'no_absen'];

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

    private function getData($parm)
    {
        $where = "a.deleted_at IS NULL";
        $builder = $this->db->table('rombel_memb a');
		$builder->select('a.id, a.roomid, a.noinduk, c.idreg, c.nama, c.nisn, c.jk, b.no_ijazah, a.no_absen, a.created_at')
                ->join('siswa b', 'a.noinduk = b.noinduk')
                ->join('tbl_datadik c', 'b.nik = c.nik');	
		$builder->orderBy('a.noinduk', 'ASC');
		$builder->where($where);
		$builder->where($parm);
		$query = $builder->get();
        return $query;
    }

    public function getAll($parm=[])
    {
    //    $parm[deleted_at]=null;
        return $this->getData($parm)->getResultArray();
    }

    public function get($id)
    {
        $parm['a.noinduk']=$id;
        return $this->getData($parm)->getRowArray();
    }

    /**
     * menampilkan data siswa sesuai dengan prodi dan belum
     * terdaftar pada ta dan grade bersangkutan.
     */
    public function getParticipan($prodi, $ta, $grade)
    {
        $sql = 'SELECT a.noinduk, a.nik, b.nama, a.prodi, b.idreg, b.jk
        FROM siswa a JOIN tbl_datadik b ON a.nik = b.nik
        WHERE a.prodi = '.$prodi.' AND NOT EXISTS
        ((SELECT y.nik, x.id, z.kode_ta, z.grade   
           FROM  rombel_memb x JOIN siswa y ON x.noinduk = y.noinduk  JOIN rombel z ON x.roomid = z.id
           WHERE z.kode_ta = '.$ta.' AND z.grade = '.$grade.' AND a.nik = y.nik));';
        
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function simpanMasal($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insertBatch($data);
    }
}
