<?php
namespace Modules\Siswa\Models;;

use CodeIgniter\Model;
use App\Models\BaseModel;

class SiswaModel extends Model
{
    protected $table      = 'tbl_datadik';
    protected $primaryKey = 'nik';

    //protected $useAutoIncrement = true;
    //protected $returnType    =  'Modules\Siswa\Entities\Siswa'; // configure entity to use'array';
    protected $allowedFields = ['nik', 'idreg', 'nama', 'nisn', 'tempatlahir', 'tgllahir', 'jk', 'alamat', 'nohp', 'nama_ayah', 'nama_ibu', 'alamat_ortu', 'nohp_ayah', 'nohp_ibu'];
    
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
        $builder = $this->db->table('tbl_siswa');
        $query = $builder->get();
        return $query->getNumRows();
    }
    
}