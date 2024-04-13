<?php namespace Modules\Akademik\Models;

use CodeIgniter\Model;

class JurusanModel extends Model
{
    protected $table      = 'tbl_jurusan';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $allowedFields = ['id_jur', 'nm_jurusan', 'desc', 'prasyarat', 'state'];
}