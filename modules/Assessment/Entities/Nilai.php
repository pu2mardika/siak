<?php

namespace Modules\Assessment\Entities;

use CodeIgniter\Entity\Entity;

class Nilai extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
