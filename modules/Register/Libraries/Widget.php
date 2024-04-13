<?php namespace Modules\Register\Libraries;

class Widget
{

    public function buktidaftar(array $params): string
    {
        return view('Modules\Register\Views\bukti_daftar', $params);
    }

}