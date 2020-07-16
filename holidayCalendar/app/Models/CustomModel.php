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
                                //->join('users','employees.id_employer = users.id')
                                ->select('id_employee ,name , last_name, number_free_days, days_used')
                                ->get()->getResult();
            return $bulider;
    }
    function findEmployeesVacation($id_employer){
        $bulider = $this->db->table('employees')
                        ->where('id_employer',$id_employer)
                        ->join('holiday', 'holiday.id_employee = employees.id_employee')
                        ->select('employees.id_employee ,data ')
                        ->get()->getResult();
        return $bulider;
    }
    function findEmployessForCalendar($id_calendar){
        $bulider = $this ->db->table('calendar_employee')
                        ->where('id_calendar',$id_calendar)
                        ->join('employees','employees.id_employee = calendar_employee.id_employee')
                        ->select('employees.id_employee ,name , last_name, number_free_days, days_used')
                        ->get()->getResult();
        return $bulider;
    }
    function findHolidaysEmployees($id_calendar){
        $bulider = $this ->db->table('holiday')
                        ->where('id_calendar',$id_calendar)
                        ->select('holiday.id_employee ,data ')
                        ->get()->getResult();
        return $bulider;
    }

}
?>