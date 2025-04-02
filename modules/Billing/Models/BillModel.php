<?php

namespace Modules\Billing\Models;

use CodeIgniter\Model;
use Modules\Billing\Config\Billing;

class BillModel extends Model
{
    protected $table            = '';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Billing\Entities\Bill::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'nipd', 'issued', 'deskripsi', 'due_date', 'amount', 'diskon','biltype','unit', 'status'];

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

    public function __construct(?Forge $forge = null)
    {
        /** @var Auth $authConfig */
        $authConfig = config('Billing');
        parent::__construct($forge);
        $this->tables= $authConfig->tables;
        $this->table = $this->tables['bill'];
    }

    public function is_exist($parm=[])
    {
        $res = $this->where($parm)->findAll();
        return (is_null($res) || count($res)<1)?false:true;
    }

    public function getAll($parm=[])
    {
        return $this->getData($parm)->getResult($this->returnType);
    }

    public function getsRow($parm)
    {
        return $this->getData($parm)->getRow(0, $this->returnType);
    }

    public function getArray($id)
    {
        $parm['id'] = $id;
        return $this->getData($parm)->getRowArray();
    }

    public function getCorpBill($id)
    {
        $parm['a.id'] = $id;
        $where = "a.deleted_at IS NULL";
        $parm['a.biltype']="c";
        $builder = $this->db->table($this->table.' a');
		$builder->select('a.*, b.corporate_name as nama, b.alamat')
                ->join($this->tables['grup_bill'].' b', 'a.nipd = b.id');
		$builder->where($where);
		$builder->where($parm);
		$query = $builder->get();
        return $query->getRowArray();
    }

    private function getData($parm)
    {
        $where = "a.deleted_at IS NULL";
        $parm['a.biltype']="p";
        $builder = $this->db->table($this->table.' a');
		$builder->select('a.*, b.nik, b.nama, b.nisn, b.tempatlahir, b.tgllahir, b.jk, b.alamat, b.nohp, b.nama_ayah, b.nama_ibu, b.alamat_ortu, b.nohp_ayah, b.nohp_ibu, c.prodi')
                ->join('siswa c', 'a.nipd = c.noinduk')
                ->join('tbl_datadik b', 'b.nik = c.nik');
		$builder->where($where);
		$builder->where($parm);
		$query = $builder->get();
        return $query;
    }

    public function getsData($parm=[])
    {
        $where = "a.deleted_at IS NULL";
        $builder = $this->db->table($this->table.' a');
		$builder->select('a.*, b.nik, b.nama, b.nisn, b.alamat, b.nohp, c.prodi')
                ->join('siswa c', 'a.nipd = c.noinduk')
                ->join('tbl_datadik b', 'b.nik = c.nik');
		$builder->where($where);
		$builder->where($parm);
		$query = $builder->get();
        return $query->getResult();
    }
}
