<?php

namespace Modules\Kbm\Entities;

use CodeIgniter\Entity\Entity;

class Ptm extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
