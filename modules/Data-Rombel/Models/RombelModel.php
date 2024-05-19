<?php
namespace Modules\Room\Models;;

use CodeIgniter\Model;
use App\Models\BaseModel;

class RombelModel extends Model
{
    protected $table      = 'rombel';
    protected $primaryKey = 'id';

    //protected $useAutoIncrement = true;
    //protected $returnType    =  'Modules\Room\Entities\Rombel'; // configure entity to use'array';
    protected $allowedFields = ['id','nama_rombel', 'getLevel', 'kode_ta', 'grade', 'curr_id','walikelas'];
    
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
    
    public function getAll($tp=array())
    {
    	$builder = $this->db->table('rombel a');
		$builder->select('a.*, b.nama as wali')->join('tbl_ptk b', 'b.nik = a.walikelas')->where($tp);
	    $query = $builder->get();
	//	$rs = $builder->getCompiledSelect();
	
	//	test_result($rs);
		$result = [];
		foreach($query->getResult() as $row){
			$rs = $row;
			$rs->id =encrypt($row->id);
			$result[]= $rs;
		}
        return $result;
    }
    
}