<?php

namespace Modules\Billing\Entities;

use CodeIgniter\Entity\Entity;

class Bill extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}