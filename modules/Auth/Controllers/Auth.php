<?php 
declare(strict_types=1);
namespace Modules\Auth\Controllers;

//use App\Controllers\BaseController;
use Modules\Auth\Models\Auth_model;
use CodeIgniter\API\ResponseTrait;
use \Jwt\JWT;
use CodeIgniter\RESTful\ResourceController;
 
class Auth extends ResourceController
//class Auth extends BaseController
{
	protected $auth ;
	public function __construct() {
       # $auth = new \Modules\Auth\Models\Auth_model();
        $this->auth  = model('Modules\Auth\Models\Auth_model');
        $this->validation = \Config\Services::validation();
		$this->session = session();
        
    }
 
    public function index()
    {
        helper(['form']);
        $data['login_by_username']=TRUE;
        $data['login_by_email']=TRUE;
        $data['use_recaptcha']=TRUE;
        return view('Modules\Auth\Views\f_login',$data);
    }
    
    public function privateKey()
    {
        $privateKey = <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQC8kGa1pSjbSYZVebtTRBLxBz5H4i2p/llLCrEeQhta5kaQu/Rn
vuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t0tyazyZ8JXw+KgXTxldMPEL9
5+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4ehde/zUxo6UvS7UrBQIDAQAB
AoGAb/MXV46XxCFRxNuB8LyAtmLDgi/xRnTAlMHjSACddwkyKem8//8eZtw9fzxz
bWZ/1/doQOuHBGYZU8aDzzj59FZ78dyzNFoF91hbvZKkg+6wGyd/LrGVEB+Xre0J
Nil0GReM2AHDNZUYRv+HYJPIOrB0CRczLQsgFJ8K6aAD6F0CQQDzbpjYdx10qgK1
cP59UHiHjPZYC0loEsk7s+hUmT3QHerAQJMZWC11Qrn2N+ybwwNblDKv+s5qgMQ5
5tNoQ9IfAkEAxkyffU6ythpg/H0Ixe1I2rd0GbF05biIzO/i77Det3n4YsJVlDck
ZkcvY3SK2iRIL4c9yY6hlIhs+K9wXTtGWwJBAO9Dskl48mO7woPR9uD22jDpNSwe
k90OMepTjzSvlhjbfuPN1IdhqvSJTDychRwn1kIJ7LQZgQ8fVz9OCFZ/6qMCQGOb
qaGwHmUK6xzpUbbacnYrIM6nLSkXgOAwv7XXCojvY614ILTK3iXiLBOxPu5Eu13k
eUz9sHyD6vkgZzjtxXECQAkp4Xerf5TGfQXGXhxIX52yH+N2LtujCdkQZjXAsGdm
B2zNzvrlgRmgBrklMTrMYgm1NPcW+bRLGcwgW2PTvNM=
-----END RSA PRIVATE KEY-----
EOD;
        return $privateKey;
    }
    
    public function register()
	{
		$fullname 	= $this->request->getPost('fullname');
		$username 	= $this->request->getPost('username');
		$email 		= $this->request->getPost('email');
		$password 	= $this->request->getPost('password');

		$password_hash = password_hash($password, PASSWORD_BCRYPT);

		$data = json_decode(file_get_contents("php://input"));

		$dataRegister = [
			'fullname' => $fullname,
			'username' => $username,
			'email' => $email,
			'password' => $password_hash
		];

		$register = $this->auth->register($dataRegister);

		if($register == true){
			$output = [
				'status' => 200,
				'message' => 'Berhasil register'
			];
    		return $this->respond($output, 200);
		} else {
			$output = [
				'status' => 400,
				'message' => 'Gagal register'
			];
    		return $this->respond($output, 400);
		}
	}
	 
    public function prosess()
    {
        $username = htmlspecialchars($this->request->getPost('username'));
        $password = htmlspecialchars($this->request->getPost('password'));
 		$cek_login = $this->auth->getLogin($username,$password);
 		
        if(!empty($cek_login)){
 
            session()->set("id", $cek_login['id']);
            session()->set("username", $cek_login['username']);
            session()->set("password", $cek_login['password']);
 
            return redirect()->to('/home');
 
        } else {
 
            return redirect()->to('/login');
         
        }
         
    }
    
    public function proses()
	{
		$email 		= $this->request->getPost('email');
		$password 	= $this->request->getPost('password');

		$cek_login = $this->auth->cek_login($email);
		
		print_r($cek_login); die();

		// var_dump($cek_login['password']);

		if(password_verify($password, $cek_login['password']))
		{
			$secret_key = $this->privateKey();
			$issuer_claim = "THE_CLAIM"; // this can be the servername. Example: https://domain.com
			$audience_claim = "THE_AUDIENCE";
			$issuedat_claim = time(); // issued at
			$notbefore_claim = $issuedat_claim + 10; //not before in seconds
			$expire_claim = $issuedat_claim + 3600; // expire time in seconds
			$token = array(
				"iss" => $issuer_claim,
				"aud" => $audience_claim,
				"iat" => $issuedat_claim,
				"nbf" => $notbefore_claim,
				"exp" => $expire_claim,
				"data" => array(
					"id" => $cek_login['id'],
					"firstname" => $cek_login['first_name'],
					"lastname" => $cek_login['last_name'],
					"email" => $cek_login['email']
				)
			);

			$token = JWT::encode($token, $secret_key);

			$output = [
				'status' => 200,
				'message' => 'Berhasil login',
				"token" => $token,
                "email" => $email,
                "expireAt" => $expire_claim
			];
			return $this->respond($output, 200);
		} else {
			$output = [
				'status' => 401,
				'message' => 'Login failed',
				"password" => $password
			];
			return $this->respond($output, 401);
		}
	}
	
    public function logout()
    {
       echo "LOGOUT BERHASIL";
        //session()->destroy();
        //return redirect()->to('/login');
    }
    
    public function test()
    {
       echo "TEST BERHASIL";
        //session()->destroy();
        //return redirect()->to('/login');
    }
}
