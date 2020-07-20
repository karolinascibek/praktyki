<?php namespace App\Validation;
use App\Models\UserModel;

class UserRules 
{
    public function validateUser(string $str, string $fields,array $data)
    {
        $model = new UserModel();
        $user = $model->where('email',$data['email'])
                      ->first();
        if( !$user){
            return false;
        }
        return password_verify($data['password'], $user['password']);
    }
    public function checkUserPassword(string $str, string $fields,array $data)
    {
        $model = new UserModel();
        $user = $model->where(['id'=>$data['id']])
                      ->first();
        if( !$user){
            return false;
        }
        return  password_verify($data['old_password'], $user['password']);
    }
}


?>