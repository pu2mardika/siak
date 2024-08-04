<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Satker extends BaseConfig
{
    //
    public array $unit = [
        'lkp' => [
            'nm_satker' =>"LKP Mandiri Bina Cipta []",
            'jbt_pimpinan' => 'Direktur',
            'id_uo' => "K5654191",
            'akreditasi'=>'A'
        ],
        'pkbm' => [
            'nm_satker' =>"PKBM Mandiri Bina Cipta",
            'jbt_pimpinan' => 'Kepala',
            'id_uo' => "P9970471",
            'akreditasi'=>'A',
        ]
    ];
}
