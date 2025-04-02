<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
class AuthController extends BaseController
{
    use ResponseTrait;
    public function userLogin()
    {
        $credentials = [
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password')
        ];

        if(auth()->logedIn())
        {
            auth()->logout();
        }

        $loginAttempt = auth()->attempt($credentials);
        if(!$loginAttempt->isOk())
        {
            return $this->fail("Invalid Login", 400);
        }else{
            $token = auth()->user()->generateAccessToken(service('request')->getVar('thismytoken'));
            return json_encode(['token' => $token->raw_token]);
        }
    }
}
