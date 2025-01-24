<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use Acme\Themes\Traits\Themeable;
use CodeIgniter\Shield\Controllers\LoginController;

class MyLoginController extends LoginController
{
    use Themeable;

    protected function view(string $view, array $data = [], array $options = []): string
    {
        return $this->themedView($view, $data, $options);
    }
}
