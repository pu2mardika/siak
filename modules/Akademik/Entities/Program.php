<?php

namespace Modules\Akademik\Entities;

use CodeIgniter\Entity\Entity;

class Program extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
