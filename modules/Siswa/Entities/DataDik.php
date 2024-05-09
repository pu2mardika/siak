<?php

namespace Modules\Siswa\Entities;

use CodeIgniter\Entity\Entity;

class DataDik extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
