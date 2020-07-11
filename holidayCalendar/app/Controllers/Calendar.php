<?php namespace App\Controllers;
use App\Models\CustomModel;
use App\Models\EmployeeModel;
use App\Models\UserModel;


class Calendar extends BaseController
{
	public function index()
	{

        $id = 2;
        $data = [
            'title'=>'Kalendarz',
            'styles' =>'calendar'
        ];
        //dane uzytkownika
        $user = $this->getUser($id);

        $data['name'] =$user['name'];
        $data['last_name'] = $user['last_name'];

        // pobranie osób do kalendarza
        $employees =  $this->findEmployees($id);
        $employersHolidays = $this->findEmployeesHolidays($id);
        var_dump($employees);
        //var_dump($employersHolidays);
        //--------------------------------

        $array=$this->createArrayDatesHolidays($employersHolidays, $employees);
        //--------------------------------

        var_dump($array);
        if(is_array($employees)){

            $array=$this->createArrayDatesHolidays($employersHolidays, $employees);
            $data['holidays']=$array['holidays'];
            $data['employees']=$array['employees'];
    
        }
        echo view('templates/header', $data);

        // gdy nie ma jeszcze dodanego zadnego pracownika do kalendarza
        if( is_array($employees) && count($employees) == 0){

            echo view('createCalendar', $data);
        }
        else{
            //var_dump($data);
            echo view('calendar', $data);
        }
        echo view('templates/footer', $data);
    }
    

    //---------------------------------------------------------------- do bazy danych
    private function getAllEmployees(){
        $e = new EmployeeModel();
        $t = $e->getAllForEmployer(2);

		return $t;
    }
    private function getUser($id){
        $user = new UserModel();
        return $user->findUser($id);
    }
    
    private function addEmployee(){
        //funkcja pobierająca dane nowego uzytkownika  i zapsisująca je w bazie 
    }
    private function findEmployees($id){
            // $model =  new EmployeeModel();
            // return  $model->findEmployeesAndTheirVacationDays($id);
            $db=db_connect();
            $model = new CustomModel($db);
            return $model->findEmployees($id);         
    }
    private function findEmployeesHolidays($id){
        $db=db_connect();
        $model = new CustomModel($db);
        return $model->findEmployeesVacation($id);    
    }
    //-----------------------------------------------------------------------------
    private function createArrayDatesHolidays($employersHolidays, $employees){
        $holidays_array=[];
        $employees_array=[];
        $how = 0;

        $i=0;
        foreach($employees as $e){
            foreach($employersHolidays as $h){
                if($e->id_user === $h->id_user){

                    $t = strtotime($h->data);
                    $ob=[ 
                        'id_row'=>$i,
                        'id_day'=>date("j-n-Y",$t),
                    ];
                    var_dump([ $e->id_user , $h->id_user]);
                    $holidays_array[$how] = $ob;
                    $how++;
                }
            }
            $i++;
            $emp=[
            'id_user'=>$e->id_user,
            'name'  =>$e->name,
            'last_name'=>$e->last_name,
            'number_free_days'=>$e->number_free_days,
            'days_used'=>$e->days_used,
            ];   
            $employees_array[$i]=$emp;
        }

        return [
            'holidays'=>$holidays_array,
            'employees'=>$employees_array,
        ];
    }


	//--------------------------------------------------------------------

}
