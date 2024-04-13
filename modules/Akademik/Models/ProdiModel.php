<?php
namespace Modules\Akademik\Models;;

use CodeIgniter\Model;
use App\Models\BaseModel;
use CodeIgniter\HTTP\RequestInterface;

class ProdiModel extends Model
{
    protected $table      = 'tbl_prodi'; //'id_prodi', 'nm_prodi', 'desc', 'id_jur', 'jenjang', 'state'
    protected $primaryKey = 'id_prodi';

    //protected $useAutoIncrement = true;

    protected $returnType     = 'Modules\Akademik\Entities\Prodi'; // configure entity to use'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nm_prodi', 'desc', 'id_jur', 'jenjang', 'state'];
    
    public function listing()
    {
        
    }
	
}