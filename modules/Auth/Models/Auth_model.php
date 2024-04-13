<?php
  
namespace Modules\Auth\Models;
  
use CodeIgniter\Model;
  
class Auth_model extends Model{
  
    protected $table = "user";
    protected $primaryKey = "id";
    
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['email', 'username', 'password', 'avatar', 'remember_token', 'role', 'created_by', 'updated_by']; 
    
    
    protected $useTimestamps = true;
    
    protected $createdField  = 'created_date';
    protected $updatedField  = 'updated_date';
   
    protected $validationRules = [
        'email'         => 'required|valid_email|is_unique[users.email,id,{id}]',
        'username'      => 'required|alpha_numeric_punct|min_length[3]|is_unique[users.username,id,{id}]',
        'password' 		=> 'required',
    ];
  
    public function getLogin($username, $password)
    {
        return $this->db->table($this->table)->where(['username' => $username, 'password' => $password])->get()->getRowArray();
    }
    
    public function register($data)
    {
        $query = $this->db->table($this->table)->insert($data);
        return $query ? true : false;
    }

    public function cek_login($email)
    {
        $query = $this->table($this->table)
                ->where('email', $email)
                ->countAll();

        if($query >  0){
            $hasil = $this->table($this->table)
                    ->where('email', $email)
                    ->limit(1)
                    ->get()
                    ->getRowArray();
        } else {
            $hasil = array(); 
        }
        return $hasil;
    }
}