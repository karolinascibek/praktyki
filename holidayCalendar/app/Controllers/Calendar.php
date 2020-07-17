<?php namespace App\Controllers;
use App\Models\CustomModel;
use App\Models\EmployeeModel;
use App\Models\UserModel;
use App\Models\HolidaysModel;
use App\Models\CalendarModel;
use App\Models\CalendarEmployeeModel;


class Calendar extends BaseController
{

	public function index()
	{
        $session = session();
        $id_cal = $session->get('id_calendar');

        if(!$session->get('isEmployer')){
            var_dump($_SESSION);
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $cal = new CalendarModel();
        $cal = $cal->find($id_cal);

        $data = [
			'id' => $session->get('id'),
			'name'=>  $session->get('name'),
			'last_name'=> $session->get('last_name'),
			'email'=>  $session->get('email'),
            'isLoggedIn'=>true,
            'title'     => $cal['name'],
            'styles'    => 'calendar',
        ];
        
        $session->set($data);
        
        //$model_employees = new EmployeeModel();
        $id =$data['id'];
        //var_dump($_SESSION);

        //przekierowanie na strone edycji

        $db=db_connect();
        $model_calendar = new CustomModel($db);
        //$request = \Config\Services::request();
        if($this->request->getMethod()=='post'){
            //------------------------------------------------------------------------- usunięcie i dodanie dat do bazy 

            // pobranie osób do kalendarza           
            $employees = $model_calendar->findEmployessForCalendar(session()->get('id_calendar'));

            if(is_array($employees)){
                //pobranie z bazy 
                $days = json_decode($_POST['array']);
                //var_dump($days);
                $deleted_days = $days->deleted;
                $added_days   = $days->added;

                ////--------------------------------------------------usunięcie dat odznaczonych z kalendarza
                $i = 0;
                $model_holiday = new HolidaysModel();
                foreach($employees as $emDb){
                    $counter = 0;
                    foreach($deleted_days as $deleted){
                        if( (int)$deleted->id_row === $i ){
                            //echo 'usuniety';
                            $t = strtotime($deleted->id_day);
                            //echo 'id: '.$deleted->id_day.'<br>';

                            $date = date("Y-m-d",$t);
                            //echo 'data do usniecia';
                            //var_dump($date);
                            $model_holiday->where(['id_employee'=> $emDb->id_employee ,'data' => $date,'id_calendar'=> session()->get('id_calendar')])->delete();
                            //var_dump($deleted);
                            $counter--;
                        }
                    }
                    //----------------------------------------------------------- ddanie do bazy nowe daty
                    foreach($added_days as $added){
                        if( (int)$added->id_row === $i ){
                            //echo 'dodany';
                            $daysToDb =[
                                'data' => $added->id_day,
                                'id_employee' => $emDb->id_employee,
                                'id_calendar' => $id_cal
                                
                            ];
                            $model_holiday->save($daysToDb);
                            $counter++;
                        }
                    }
                    //aktualizajca dla pracownika 
                    $model_calendar_employee = new CalendarEmployeeModel();
                    $updateCalendarEmployee  = $model_calendar_employee->where(['id_employee'=>$emDb->id_employee, 'id_calendar'=>session()->get('id_calendar')])
                                                                        ->first();
                    $updateCalendarEmployee['days_used'] += $counter;
                    $model_calendar_employee->save($updateCalendarEmployee);
                                                    
                    $i++;
                }
            }
            //-----------------------------------------------------------------------------
        }
        // pobranie osób do kalendarza
        $model_custom = new CustomModel($db);

        $employees_model = $model_custom->findEmployessForCalendar(session()->get('id_calendar'));
        //jesli istnieją jacyś pracownicy dla kalendarza 
        if(is_array($employees_model)){

           $model2 = new CustomModel($db);
           $holidays_model = $model2->findHolidaysEmployees(session()->get('id_calendar'));

           $array=$this->createArrayDatesHolidays($holidays_model, $employees_model);
           $data['employees'] = $array['employees'];
           $data['holidays']  = $array['holidays'];
           //var_dump($array);
        }
        echo view('templates/header', $data);

        // gdy nie ma jeszcze dodanego zadnego pracownika do kalendarza
        if( is_array($employees_model) && count($employees_model) == 0){
            echo view('empty_calendar', $data);
        }
        else{
            echo view('calendar', $data);
        }
        echo view('templates/footer', $data);
    }
    // ----------------------------------------------------------------------------------------------new

    public function mycalendar(){
        $session = session();
        if(!$session){
            return redirect()->to('/');
        }
        $id_cal = $session->get('id_calendar');

        $cal = new CalendarModel();
        $cal = $cal->where('id_calendar' ,$id_cal)
                    ->join('users','users.id = calendar.id_employer')
                    ->select('users.name as owner, users.last_name , calendar.name, calendar.id_calendar')
                    ->first();
        //var_dump($cal);
        $data = [
			'id'       => $session->get('id'),
			'name'     =>  $session->get('name'),
			'last_name'=> $session->get('last_name'),
			'email'    =>  $session->get('email'),
            'isLoggedIn'=>true,
            'title'     => $cal['name'],
            'owner_calendar' => $cal['owner'].' '.$cal['last_name'],
            'styles'    => 'calendar',
		];
        $session->set($data);
        
        $model_employees = new EmployeeModel();
        $id =$data['id'];

        $db=db_connect();
        $model_holidays= new HolidaysModel();
        $model_calendar= new CalendarEmployeeModel();

        $employee_data = $model_calendar->where([ 'calendar_employee.id_employee'=>$id , 'id_calendar' =>$id_cal])
                                        ->join('employees','employees.id_employee = calendar_employee.id_employee')
                                        ->select('employees.id_employee, name, last_name,email, id_calendar ,calendar_employee.number_free_days, calendar_employee.days_used')
                                        ->get()->getResult();
        //var_dump($employee_data);

        if(is_array($employee_data)){

            $holidays_data = $model_holidays->where([ 'id_employee'=>$id , 'id_calendar'=> $id_cal])->get()->getResult();
           // var_dump($holidays_data);

           $array=$this->createArrayDatesHolidays($holidays_data, $employee_data);

           $data['employees'] = $array['employees'];
           $data['holidays']  = $array['holidays'];
           //var_dump($data);
           echo view('templates/header', $data);
           echo view('calendaremployee', $data);
           echo view('templates/footer', $data);
        }
        else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        echo 'kalendarz pracownika';
    }
   
    //---------------------------------------------------------------- do bazy danych
    // private function getUser($id){
    //     $user = new UserModel();
    //     return $user->findUser($id);
    // }
    // private function findEmployees($id){
    //         // $model =  new EmployeeModel();
    //         // return  $model->findEmployeesAndTheirVacationDays($id);
    //         $db=db_connect();
    //         $model = new CustomModel($db);
    //         return $model->findEmployees($id);         
    // }
    // private function findEmployeesHolidays($id){
    //     $db=db_connect();
    //     $model = new CustomModel($db);
    //     return $model->findEmployeesVacation($id);    
    // }
    //-----------------------------------------------------------------------------
    //przygotowanie talicy dat do wysłania 
    private function createArrayDatesHolidays($employersHolidays, $employees){
        $holidays_array=[];
        $employees_array=[];
        $how = 0;

        $i=0;
        foreach($employees as $e){
            foreach($employersHolidays as $h){
                if($e->id_employee === $h ->id_employee){
                    //var_dump($h->data);
                    $t = strtotime($h ->data);
                    $ob=[ 
                        'id_row'  => "$i",
                        'id_day'  => date("Y-n-j",$t),
                        'id_user' => $h ->id_employee,
                    ];
                    //var_dump([ $e->id_user , $h->id_user]);
                    $holidays_array[$how] = $ob;
                    $how++;
                }
            }
            $emp=[
            'id_user'         => $e ->id_employee,
            'id_row'          => $i,
            'name'            => $e ->name,
            'last_name'       => $e ->last_name,
            'number_free_days'=> $e ->number_free_days,
            'days_used'       => $e ->days_used,
            ];   
            $employees_array[$i] = $emp;
            $i++;
        }

        return [
            'holidays' => $holidays_array,
            'employees'=> $employees_array,
        ];
    }
    //--------------------------------------------------------------------
    

}
