<?php namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;

use CodeIgniter\Model;
class EmployeeModel extends Model{

    
    protected $table      = 'employees';
    protected $primaryKey = 'id_employee';

    //protected $returnType     = 'array';
    //protected $useSoftDeletes = true;

    protected $allowedFields = ['id_employee','name','last_name' ,'email' , 'password','number_free_days','id_employer'];

    protected $useTimestamps = true;
    protected $createdField  = 'employee_data_created';
    protected $updatedField  = 'employee_data_updated';
    //protected $deletedField  = 'deleted_at';

    //protected $validationRules    = [];
    //protected $validationMessages = [];
    //protected $skipValidation     = false;

    public function getAll(){
        return $this->findAll();
    }

    public function findEmployeesAndTheirVacationDays($id_employer){
        $employees = $this->where(['id_employer' => $id_employer])->findAll();
        return $employees;
    }



 
}
?>
