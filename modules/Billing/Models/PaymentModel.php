<?php

namespace Modules\Billing\Models;

use CodeIgniter\Model;
use Modules\Billing\Config\Billing;

class PaymentModel extends Model
{
    protected $table            = '';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Billing\Entities\Payment::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

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
        $this->table = $this->tables['pay'];
    }

    public function getsData($parm=[])
    {
        $builder = $this->db->table($this->table.' a');
		$builder->select('a.*, b.nik, b.nama, b.nisn, b.alamat, b.nohp, c.prodi')
                ->join('siswa c', 'a.nipd = c.noinduk')
                ->join('tbl_datadik b', 'b.nik = c.nik');
		$builder->where($where);
		$builder->where($parm);
		$query = $builder->get();
        return $query->getResult();
    }

    function getData($parm=[])
    {
        $where = "a.deleted_at IS NULL";
        $subquery = $this->db->table($this->tables['pay'].' t1')
                ->selectSum('t1.pay_amount')
                ->where('t1.billId', 'a.id');

        $builder = $this->db->table($this->tables['bill'].' a');
		$builder->select('a.*, b.nik, b.nama, b.nisn, b.alamat, b.nohp, c.prodi')
				->selectSubquery($subquery, 'pay')
                ->join('siswa c', 'a.nipd = c.noinduk')
                ->join('tbl_datadik b', 'b.nik = c.nik');
		$builder->where($where);
		$builder->where($parm);
		$query = $builder->get();
        return $query->getResultArray();
    }
}
