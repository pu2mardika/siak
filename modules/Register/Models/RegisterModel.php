<?php
namespace Modules\Register\Models;;

use CodeIgniter\Model;
use App\Models\BaseModel;

class RegisterModel extends Model
{
    protected $table      = 'tbl_register';
    protected $primaryKey = 'nik';

    //protected $useAutoIncrement = true;
    //protected $returnType    =  'Modules\Register\Entities\Register'; // configure entity to use'array';
    protected $allowedFields = ['nik', 'idreg','nama', 'nisn', 'tempatlahir', 
                                'tgllahir', 'jk', 'alamat', 'nohp', 'nama_ayah', 
                                'nama_ibu', 'alamat_ortu', 'nohp_ayah', 'nohp_ibu', 'id_prodi'];
    
    protected $returnType    =  \Modules\Register\Entities\Register::class;
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
        $builder = $this->db->table('tbl_register');
        $query = $builder->get();
        return $query->getNumRows();
    }
    
}