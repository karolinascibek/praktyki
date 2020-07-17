<?php namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;

use CodeIgniter\Model;
class EmployeeModel extends Model{

    
    protected $table      = 'employees';
    protected $primaryKey = 'id_employee';

    //protected $returnType     = 'array';
    //protected $useSoftDeletes = true;

    protected $allowedFields = ['id_employee','name','last_name' ,'email' , 'password','number_free_days','id_employer', 'days_used'];

    protected $useTimestamps = true;
    protected $createdField  = 'employee_data_created';
    protected $updatedField  = 'employee_data_updated';

    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    //protected $deletedField  = 'deleted_at';

    //protected $validationRules    = [];
    //protected $validationMessages = [];
    //protected $skipValidation     = false;

    protected function passwordHash(array $data){
        //haszowanie hasła
        if(isset($data['data']['password'])){
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
    
    protected function beforeInsert(array $data){
        $data = $this->passwordHash($data);
        return $data;
    }
    protected function beforeUpdate(array $data){
        $data = $this->passwordHash($data);
        return $data;
    }





    public function getAll(){
        return $this->findAll();
    }

    public function findEmployeesAndTheirVacationDays($id_employer){
        $employees = $this->where(['id_employer' => $id_employer])->findAll();
        return $employees;
    }



 
}
?>
