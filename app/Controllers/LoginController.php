<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Config\MyApp;

//use Acme\Themes\Traits\Themeable;
use CodeIgniter\Shield\Controllers\LoginController as ShieldLoginControl;

class LoginController extends ShieldLoginControl
{
    //use Themeable;
    
    protected function view(string $view, array $data = [], array $options = []): string
    {
        $myconfig = config('MyApp');
        $theme = $myconfig->themeDir.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.setting()->get('MyApp.theme').DIRECTORY_SEPARATOR;
        $view = $theme.$view;
        return view($view, $data, $options);
    }
}
