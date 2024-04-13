<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Instaldata extends Seeder
{
    public function run()
    {
        $this->call('Module');
        $this->call('Setting');
        $this->call('Module');
        $this->call('Menu');
       // $this->call('Userlevel');
    }
}
