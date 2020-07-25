<?php namespace App\Validation;
use App\Models\EmployeeModel;

class DateRules
{
    public function checkDate(string $str, string $fields,array $data)
    {
        $model = new EmployeeModel();
        $user = $model->where('email',$data['email'])
                      ->first();
        if( !$user){
            return false;
        }
        return password_verify($data['password'], $user['password']);
    }
}


?>