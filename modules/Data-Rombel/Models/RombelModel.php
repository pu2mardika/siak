<?php
namespace Modules\Room\Models;;

use CodeIgniter\Model;
use App\Models\BaseModel;

class RombelModel extends Model
{
    protected $table      = 'tbl_rombel';
    protected $primaryKey = 'roomid';

    //protected $useAutoIncrement = true;
    //protected $returnType    =  'Modules\Room\Entities\Rombel'; // configure entity to use'array';
    protected $allowedFields = ['nama_rombel', 'walikelas', 'kode_ta', 'grade'];
    
    protected $returnType    =  \Modules\Room\Entities\Rombel::class;
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
    public function total($tp=array())
    {
        $builder = $this->db->table($this->table);
        $query = $builder->where($tp);
        $query = $builder->get();
        return $query;
    }
    
    public function getAll($tp=array())
    {
    	$builder = $this->db->table('tbl_rombel a');
		$builder->select('a.*, b.nama as wali')->join('tbl_ptk b', 'b.nik = a.walikelas')->where($tp);
		$rs = $builder->get();
	
	//	test_result($rs);
		$result = [];
		foreach($rs as $row){
			$rs = $row;
			$rs['id']=encrypt($row->roomid);
			$result[]=$rs;
		}
		return $result;
    }
    
}