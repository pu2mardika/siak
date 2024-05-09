<?php

namespace Modules\Register\Controllers;

use Modules\Register\Controllers\Enrollment;
use CodeIgniter\HTTP\ResponseInterface;

class Enroll extends Enrollment
{
    function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $this->addNew();
    }
}
