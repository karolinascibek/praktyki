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
            'year'      => $cal['year'],
        ];
        
        $session->set($data);
        $id =$data['id'];
        //przekierowanie na strone edycji

        $db=db_connect();
        $model_calendar = new CustomModel($db);
        if($this->request->getMethod()=='post'){
            //------------------------------------------------------------------------- usunięcie i dodanie dat do bazy 

            // pobranie osób do kalendarza           
            $employees = $model_calendar->findEmployessForCalendar(session()->get('id_calendar'));

            if(is_array($employees)){
                //pobranie z bazy 
                $days = json_decode($_POST['array']);
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

                            $date = date("Y-m-d",$t);
                            //echo 'data do usniecia';
                            $model_holiday->where(['id_employee'=> $emDb->id_employee ,'data' => $date,'id_calendar'=> session()->get('id_calendar')])->delete();
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
            $session->setFlashdata('success','Wprowadzone zmiany zostały zapisane.');
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
        }
        echo view('templates/header', $data);

        // gdy nie ma jeszcze dodanego zadnego pracownika do kalendarza
        if( is_array($employees_model) && count($employees_model) == 0){
            $model = new CalendarModel();
            $cal = $model->where('id_calendar',session()->get('id_calendar'))
                         ->first();
            $data['code'] = $cal['code'];
            echo view('empty_calendar', $data);
        }
        else{
            echo view('calendar', $data);
        }
        echo view('templates/footer', $data);
    }
    public function delete_empty_calendar(){
        $session = session();
        if($this->request->getMethod() == 'post'){
            $model = new CalendarModel();
            $model->where('id_calendar',$session->get('id_calendar'))
                  ->delete();
            //Usuwamy z kalendarz z tabeli pracownicy wrazie gdyby do kalendarza już ktoś dołączył a strona nie została odświerzona.
            $cal_employee_model = new CalendarEmployeeModel();
            $cal_employee_model->where('id_calendar',$session->get('id_calendar'))
                               ->delete();
            return redirect()->to('/dashboard');
        }
    }
    // ----------------------------------------------------------------------------------------------

    public function mycalendar(){
        $session = session();
        if(!$session->get('isLoggedIn')){
            return redirect()->to('/');
        }
        $id_cal = $session->get('id_calendar');

        $cal = new CalendarModel();
        $cal = $cal->where('id_calendar' ,$id_cal)
                    ->join('users','users.id = calendar.id_employer')
                    ->select('users.name as owner, users.last_name , year, calendar.name, calendar.id_calendar')
                    ->first();

        $data = [
			'id'       => $session->get('id'),
			'name'     =>  $session->get('name'),
			'last_name'=> $session->get('last_name'),
			'email'    =>  $session->get('email'),
            'isLoggedIn'=>true,
            'title'     => $cal['name'],
            'owner_calendar' => $cal['owner'].' '.$cal['last_name'],
            'year'  =>$cal['year'],
		];
        $session->set($data);
        
        $model_employees = new EmployeeModel();
        $id =$data['id'];
            //aktualizacja liczby dni urlopu
        if($this->request->getMethod() == 'post'){
            $data = $this->edit_employee_days_holiday($id, $id_cal, $data);
        }

        $db=db_connect();
        $model_holidays= new HolidaysModel();
        $model_calendar= new CalendarEmployeeModel();

        $employee_data = $model_calendar->where([ 'calendar_employee.id_employee'=>$id , 'id_calendar' =>$id_cal])
                                        ->join('employees','employees.id_employee = calendar_employee.id_employee')
                                        ->select('employees.id_employee, name, last_name,email, id_calendar ,calendar_employee.number_free_days, calendar_employee.days_used')
                                        ->get()->getResult();

        if(is_array($employee_data)){
            $holidays_data = $model_holidays->where([ 'id_employee'=>$id , 'id_calendar'=> $id_cal])->get()->getResult();

           $array=$this->createArrayDatesHolidays($holidays_data, $employee_data);

           $data['employees'] = $array['employees'];
           $data['holidays']  = $array['holidays'];
           echo view('templates/header', $data);
           echo view('calendaremployee', $data);
           echo view('templates/footer', $data);
        }
        else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
    private function edit_employee_days_holiday($id_employee, $id_calendar, $data){
       
            //aktualizacja liczby dni urlopu

            $rules=[
                'pula'=>'required|is_natural'
            ];
            $errors =[
                'pula'=>[
                    'required'=>'To pole nie może być puste. ',
                    'is_natural'=>'Podałeś nieprawidłowo wartość, pole może zawierać tylko liczby naturalne'
                ]
                ];
            if($this->validate($rules,$errors)){
                $model_calendar= new CalendarEmployeeModel();
                $employee_calendar_update = $model_calendar->where(['id_employee' => $id_employee, 'id_calendar'=>$id_calendar])
                                                                    ->first();

                $model_calendar->update($employee_calendar_update['id'],['number_free_days'=>$_POST['pula']]);
            }
            else{
                $data['validation']=$this->validator;
            }
        
            return $data;
    }

    //przygotowanie talicy dat do wysłania 
    private function createArrayDatesHolidays($employersHolidays, $employees){
        $holidays_array=[];
        $employees_array=[];
        $how = 0;

        $i=0;
        foreach($employees as $e){
            foreach($employersHolidays as $h){
                if($e->id_employee === $h ->id_employee){

                    $t = strtotime($h ->data);
                    $ob=[ 
                        'id_row'  => "$i",
                        'id_day'  => date("Y-n-j",$t),
                        'id_user' => $h ->id_employee,
                    ];

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

    // do edycji kalendarza 
    public function edit(){
        
        helper('form');
        $session = session();
        $id_cal = $session->get('id_calendar');
        $id_employer =  $session->get('id');

        if(!$session->get('isEmployer')){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            
        }

        if($this->request->getMethod()=='post'){
            if( !isset( $_POST['delete'])){
                $rules = [
                    'name'=>'required|max_length[255]',
                ];
                $errors =[
                    'name'=>[
                        'required'=>'Pole nazwa nie może być puste.'
                    ]
                    ];
                if($this->validate($rules,$errors)){
                    $cal = new CalendarModel();
                    $cal->update($id_cal,[ 'name'=>$_POST['name'] ]);
                }
                else{
                    $data['validation'] = $this->validator;
                }
            }
            else{
                $cal_model = new CalendarModel();
                $cal_model->where(['id_employer'=>$id_employer, 'id_calendar'=>$id_cal ])
                                ->delete();
                $cal_employee_model = new CalendarEmployeeModel();
                $cal_employee_model->where('id_calendar',$id_cal)
                                    ->delete();
                $holidays_in_calendar = new HolidaysModel();
                $holidays_in_calendar->where('id_calendar',$id_cal)
                                    ->delete();
            }
            return redirect()->to('/dashboard');
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
            'code'      => $cal['code'],
        ];
        $session->set($data);
        
        $id =$data['id'];
        echo view('templates/header', $data);
        echo view('edit_calendar', $data);
        echo view('templates/footer', $data);
    }
    public function edit_employee($id = null){

        $session = session();
        if(!$session->get('isEmployer')){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();            
        }
        if(!is_numeric($id) || $id < 1 ){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(); 
        }
        else{

            helper('form');
            $id_cal = $session->get('id_calendar');

            $number_employess_in_cal = new CalendarEmployeeModel();
            $number_employess_in_cal = $number_employess_in_cal->where('id_calendar',$id_cal)->findAll();

            if($id > count($number_employess_in_cal) ){
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(); 
            }

            $calEmployeeModel = new CalendarEmployeeModel();
            $cal_emp = $calEmployeeModel->where('id_calendar' ,$id_cal)
                        ->join('employees','employees.id_employee = calendar_employee.id_employee')
                        ->findAll();

            $cal = new CalendarModel();
            $cal_array = $cal->find($id_cal);
            $data = [
                'id' => $session->get('id'),
                'name'=>  $session->get('name'),
                'last_name'=> $session->get('last_name'),
                'email'=>  $session->get('email'),
                'isLoggedIn'=>true,
                'title'     => $cal_array['name'],
                'name_employee' =>$cal_emp[$id-1]['name'],
                'last_name_employee' =>$cal_emp[$id-1]['last_name'],
            ];
            $session->set($data);
            //echo $id.'----';
            if($this->request->getMethod() == 'post'){
                if(!isset($_POST['delete'])){
                    $data = $this->edit_employee_days_holiday($cal_emp[$id-1]['id_employee'], $id_cal, $data);
                }
                else{
                    echo 'usuniete';
                    $id_employee = $cal_emp[$id-1]['id_employee'];
                    $employeeToDelete = $calEmployeeModel->where(['id_employee'=>$id_employee, 'id_calendar'=>$id_cal])->delete();
                    $holiday_model = new HolidaysModel();
                    $holidays_employee = $holiday_model->where(['id_employee'=>$id_employee, 'id_calendar'=>$id_cal])->delete();                                        
                }
                return redirect()->to('/calendar');
            }

            $cal_emp = $calEmployeeModel->where('id_calendar' ,$id_cal)
                        ->join('employees','employees.id_employee = calendar_employee.id_employee')
                        ->findAll();

            $data['number_free_days']=$cal_emp[$id-1]['number_free_days'];
            echo view('templates/header', $data);
            echo view('edit_employee', $data);
            echo view('templates/footer', $data);
        }
    }
    //--------------------------------------------------------------------
    

}
