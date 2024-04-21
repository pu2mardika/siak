<?php

namespace Modules\Akademik\Models;

use CodeIgniter\Model;

class GmapelModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'grup_mapel';
    protected $primaryKey       = 'grup_id';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Akademik\Entities\Gmapel::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['curr_id', 'nm_grup', 'parent_grup'];

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
