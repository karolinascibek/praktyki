<?php namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
class CustomModel{

    protected $db;

    public function __construct(ConnectionInterface &$db){
        $this->db =&$db;
    }

    function all(){
        return $this->db->table('employees')->get()->getResult();
    }

    function  findEmployees($id_employer){
            $bulider = $this->db->table('employees')
                              ->where('id_employer',$id_employer)
                                ->join('users','employees.id_user = users.id')
                                ->select('id_user ,name , last_name, number_free_days, days_used')
                                ->get()->getResult();

            return $bulider;
    }
    function findEmployeesVacation($id_employer){
        $bulider = $this->db->table('employees')
                        ->where('id_employer',$id_employer)
                        ->join('holiday', 'holiday.id_employee = employees.id_user')
                        ->select('id_user ,data ')
                        ->get()->getResult();
        return $bulider;
    }

}
?>