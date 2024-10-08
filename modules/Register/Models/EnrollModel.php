<?php

namespace Modules\Register\Models;

use CodeIgniter\Model;

class EnrollModel extends Model
{
    protected $table            = 'tbl_register';
    protected $primaryKey       = 'nik';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Register\Entities\Enroll::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nik', 'idreg','nama', 'nisn', 'tempatlahir', 'tgllahir', 'jk', 
                                   'alamat', 'nohp', 'nama_ayah', 'nama_ibu', 'alamat_ortu', 
                                   'nohp_ayah', 'nohp_ibu', 'id_prodi'
                                  ];

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
}
