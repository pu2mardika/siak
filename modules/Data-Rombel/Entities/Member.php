<?php

namespace Modules\Room\Entities;

use CodeIgniter\Entity\Entity;

class Member extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
