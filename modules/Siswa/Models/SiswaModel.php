<?php
namespace Modules\Siswa\Models;;

use CodeIgniter\Model;
use App\Models\BaseModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class SiswaModel extends Model
{
    protected $table      = 'siswa';
    protected $primaryKey = 'noinduk';

    //protected $useAutoIncrement = true;
    //protected $returnType  =  'Modules\Siswa\Entities\Siswa'; // configure entity to use'array';
    protected $allowedFields = ['noinduk', 'nik', 'prodi', 'tgl_reg', 'no_ijazah', 'tgl_ijazah', 'tgl_diterima'];
    
    protected $returnType    =  \Modules\Siswa\Entities\Siswa::class;
    protected $useSoftDeletes = true;
    // Dates
    protected $useTimestamps = true;
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
    
    // total
    public function total()
    {
        $builder = $this->db->table('siswa');
        $query = $builder->get();
        return $query->getNumRows();
    }
    
    private function getData($parm)
    {
       //`b.idreg, b.nama, b.nisn, b.tempatlahir, b.tgllahir, b.jk, b.alamat, b.nohp, b.nama_ayah, b.nama_ibu, b.alamat_ortu, b.nohp_ayah, b.nohp_ibu`
        $where = "a.deleted_at IS NULL";
        $subquery = $this->db->table('rombel_memb t1')->selectCount('t1.noinduk')->where('t1.noinduk', 'a.noinduk');
        $builder = $this->db->table('siswa a');
		$builder->select('a.*, b.idreg, b.nama, b.nisn, b.tempatlahir, b.tgllahir, b.jk, b.alamat, b.nohp, b.nama_ayah, b.nama_ibu, b.alamat_ortu, b.nohp_ayah, b.nohp_ibu, c.nm_prodi')
				->selectSubquery($subquery, 'state')
                ->join('tbl_datadik b', 'a.nik = b.nik')
				->join('prodi c', 'a.prodi = c.id_prodi');
		$builder->orderBy('c.id_prodi', 'ASC');
		$builder->orderBy('a.noinduk', 'ASC');
		$builder->where($where);
		$builder->where($parm);
		$query = $builder->get();
        return $query;
    }

    public function getAll($parm=[], $asObj=TRUE)
    {
        $query = $this->getData($parm);
        return ($asObj)?$query->getResult():$query->getResultArray();
    }

    public function get($id)
    {
        $parm['noinduk']=$id;
        return $this->getData($parm)->getRowArray();
    }

    public function getlike($key)
    {
    	$sql = "SELECT nik, nama FROM tbl_datadik
    	WHERE `nik` LIKE '%{$key}%' ESCAPE '!' OR  `nama` LIKE '%{$key}%' ESCAPE '!'  OR  `idreg` LIKE '%{$key}%' ESCAPE '!'";	
    	$result = $this->db->query($sql)->getResultArray();
		return $result;
    }

    public function getPDlike($key)
    {
    	$sql = "SELECT a.noinduk, a.nik, b.nama, a.prodi, c.nm_prodi, d.nm_program, d.unit_kerja as uker FROM siswa a 
                JOIN tbl_datadik b ON a.nik=b.nik JOIN prodi c ON a.prodi=c.id_prodi JOIN jurusan d ON c.jurusan=d.id
    	        WHERE a.nik LIKE '%{$key}%' ESCAPE '!' 
                OR  b.nama LIKE '%{$key}%' ESCAPE '!'  
                OR  b.idreg LIKE '%{$key}%' ESCAPE '!'";	
    	$result = $this->db->query($sql)->getResultArray();
		return $result;
    }

    public function getOrder($parm=[])
    {
        $no = 0;
        $builder = $this->db->table($this->table);
        $builder->selectMax('no_urt', 'order');
        $builder->where($parm);
        $query = $builder->get();
        foreach ($query->getResult() as $row) {
            $no = $row->order;
        }
        return $no + 1;
    }

    //menyimpan data dengan transaction
    function actSimpan($datadik, $dtreg)
    {
        $this->db->transStart();
        //sisipkan data ke tabel datadik
        $builder = $this->db->table('tbl_datadik');
        $builder->insert($datadik);

        //sisipkan data ke table siswa
        $builder = $this->db->table($this->table);
        $builder->insert($dtreg);

        //hapus tabel registrasi:
        $builder = $this->db->table('tbl_register');
        $builder->delete(['nik' => $datadik['nik']]);
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            // generate an error... or use the log_message() function to log your error
            return false;
        }
        return true;
    }

    function batchSaving($data)
    {
        try {
    //        $this->db->transException(true)->transStart();
            //sisipkan data ke tabel datadik
            $datadik = $this->db->table('tbl_datadik');
            $dtreg = $this->db->table($this->table);
            foreach($data as $rs)
            {
                $datadik->insert($rs['datadik']);
                //sisipkan data ke table siswa
                $dtreg->insert($rs['dtreg']);
            }
            $this->db->transComplete();
        }catch (DatabaseException $e) {
            // Automatically rolled back already.
        }
       // if ($this->db->transStatus() === false) {
            // generate an error... or use the log_message() function to log your error
            
        //    return false;
       // }
        return $this->db->transStatus();
    }

    function getSpecial($parm=[],$reg)
    {
        $subQuery = $this->db->table('price')->select('MAX(tmt)', false)->where('tmt <=', $reg);
        $where = "a.deleted_at IS NULL";
        $builder = $this->db->table($this->table." a");
        $builder->select('a.prodi, c.nm_prodi, e.nm_program, count(a.noinduk) as qty, d.amount as harga, e.unit_kerja as unit, d.jns_bayar')
                ->join('tbl_datadik b', 'a.nik = b.nik')
				->join('prodi c', 'a.prodi = c.id_prodi')
				->join('price d', 'c.id_prodi = d.id_prodi')
				->join('jurusan e', 'd.id_prodi = e.id');
		$builder->orderBy('c.id_prodi', 'ASC');
		$builder->orderBy('a.noinduk', 'ASC');
		$builder->where($where);
		$builder->where($parm);
		$builder->where('d.tmt', $subQuery);
        $builder->groupBy('a.prodi');
        $builder->groupBy('d.komponen');
		$query = $builder->get();
        return $query->getResultArray();
    }
}