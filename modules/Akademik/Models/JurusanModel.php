<?php
namespace Modules\Akademik\Models;;

use CodeIgniter\Model;
use App\Models\BaseModel;

class JurusanModel extends Model
{
    protected $table      = 'tbl_jurusan';
    protected $primaryKey = 'id_jur';

    protected $useAutoIncrement = true;
    protected $returnType     = 'Modules\Akademik\Entities\Jurusan'; // configure entity to use'array';
    protected $allowedFields = ['nm_jurusan', 'desc', 'prasyarat', 'state'];
    
    // total
    public function total()
    {
        $builder = $this->db->table('tbl_jurusan');
        $query = $builder->get();
        return $query->getNumRows();
    }
	
}