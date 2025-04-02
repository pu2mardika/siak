<?php
declare(strict_types=1);
namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class UserModel extends ShieldUserModel
{
    protected function initialize(): void
    {
        parent::initialize();
        /*
        $this->allowedFields = [
            $this->allowedFields,
            'first_name', // Added
            'last_name',  // Added
        ];*/
        $allowedFields = $this->allowedFields;
        $allowedFields[] = 'mobile_number';
        $allowedFields[] = 'full_name';
        $this->allowedFields = $allowedFields;
    }
    
    public function getUser()
    {
        $table = setting()->get('Auth.tables');
        $builder = $this->db->table($table['users']." a");
        $builder->select('*')
                ->join($table['identities'].' b', 'a.id = b.user_id', 'left')
                ->join($table['groups_users'].' c', 'a.id = c.user_id', 'left');
        $builder->where('b.type !=', 'magic-link');
        $query = $builder->get();
        return $query->getResult();
    }
}