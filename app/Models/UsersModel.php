<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table            = 'admin_usuario';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user','password',
    'name','email','active','activation_token',
    'reset_token','reset_token_expires_at'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


    public function validateUser($user,$password){
        $user = $this->where(['user'=> $user,'active'=>1])->first();
        if ($user && password_verify($password,$user['password'])){
            return $user;
        }
        return null;
    }


}
