<?php

namespace Modules\Account\Entities;

use CodeIgniter\Entity\Entity;

class AccPeriod extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
