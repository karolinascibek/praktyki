<?php namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;

use CodeIgniter\Model;
class EmployeeModel extends Model{

    
    protected $table      = 'employees';
    protected $primaryKey = 'id';

    //protected $returnType     = 'array';
    //protected $useSoftDeletes = true;

    protected $allowedFields = ['name','last_name' ,'eamil'];

    protected $useTimestamps = true;
    protected $createdField  = 'data_created';
    protected $updatedField  = 'data_updated';
    //protected $deletedField  = 'deleted_at';

    //protected $validationRules    = [];
    //protected $validationMessages = [];
    //protected $skipValidation     = false;

    public function getAll(){
        return $this->findAll();
    }
    public function getAllForEmployer($id_employer){
        $employees = $this->where(['id_employer' => $id_employer])->findAll();
        return $employees;
    }


 
}
?>
