<?php namespace App\Controllers;
use App\Models\CustomModel;
use App\Models\EmployeeModel;
use App\Models\UserModel;
use App\Models\HolidaysModel;
use App\Models\CalendarModel;


class Calendar extends BaseController
{

	public function index()
	{
        $session = session();
        $id_cal = $session->get('id_calendar');


        $cal = new CalendarModel();
        $cal = $cal->find($id_cal);
        //var_dump($cal);
        $data = [
			'id' => $session->get('id'),
			'name'=>  $session->get('name'),
			'last_name'=> $session->get('last_name'),
			'email'=>  $session->get('email'),
            'isLoggedIn'=>true,
            'title'     => $cal['name'],
            'styles'    => 'calendar',
		];
		$session = session();
        $session->set($data);
        
        $model_employees = new EmployeeModel();

        //$model = new Calendar();


        $id =$data['id'];
        //var_dump($_SESSION);

        //przekierowanie na strone edycji
        //var_dump($_POST);
        $db=db_connect();
            $model = new CustomModel($db);
            //echo $id_cal.' // ';
        $request = \Config\Services::request();
        if($this->request->getMethod()=='post'){
            $prodID = $request->getPost();
            //var_dump($prodID);

            //------------------------------------------------------------------------- usunięcie i dodanie dat do bazy 

            // pobranie osób do kalendarza
            
            $employees = $model->findEmployessForCalendar(session()->get('id_calendar'));
            //var_dump($employees);

            //$employees =  $this->findEmployees($id);--
            if(is_array($employees)){
                //pobranie z bazy 
                //$employees_db = $this->findEmployees($id);--
                $employees_db = $this->findEmployees($id);
                $days = json_decode($_POST['array']);
                //var_dump($days);
                $deleted_days = $days->deleted;
                $added_days = $days->added;

                //var_dump($deleted_days);
                //var_dump($added_days);
                ////------------------------------------- 
                $i = 0;
                $model = new HolidaysModel();
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
                            $model->where(['id_employee'=> $emDb->id_employee ,'data' => $date,'id_calendar'=> session()->get('id_calendar')])->delete();
                            //var_dump($deleted);
                            $counter--;
                        }
                    }
                    foreach($added_days as $added){
                        if( (int)$added->id_row === $i ){
                            //echo 'dodany';
                            $daysToDb =[
                                'data' => $added->id_day,
                                'id_employee' => $emDb->id_employee,
                                'id_calendar' => $id_cal
                                
                            ];
                            $model->save($daysToDb);
                            $counter++;
                            // $model->set($daysToDb);
                            // $model->insert();
                            //var_dump($added);
                        }
                    }
                    //aktualizajca dla pracownika 
                    $updateEmpl = new EmployeeModel();
                    $changeEmpl=$updateEmpl->find($emDb->id_employee);
                    $changeEmpl['days_used'] = $counter;
                    var_dump($changeEmpl);
                    $updateEmpl->save($changeEmpl);

                    $i++;
                }
            }
            //-----------------------------------------------------------------------------

        }
        //$user = $this->getUser($id);
        // pobranie osób do kalendarza
        //$employees =  $this->findEmployees($id);
        $db=db_connect();
        $model = new CustomModel($db);

        $employees_model = $model->findEmployessForCalendar(session()->get('id_calendar'));
       // var_dump($employees_model);
       // var_dump($data);
        if(is_array($employees_model)){
           //$employersHolidays = $this->findEmployeesHolidays($id);
           //var_dump($employees);
           //var_dump($employersHolidays);
           //$array=$this->createArrayDatesHolidays($employersHolidays, $employees);

           //--------------------------------------------------------------------------------
            
            //var_dump($employees_model);
            $model2 = new CustomModel($db);
            $holidays_model = $model2->findHolidaysEmployees(session()->get('id_calendar'));
            //var_dump($holidays_model);
            //-----------------------------------------------------------------------------------
           $array=$this->createArrayDatesHolidays($holidays_model, $employees_model);
           $data['employees'] = $array['employees'];
           $data['holidays']  = $array['holidays'];
           //var_dump($array);
        }
        echo view('templates/header', $data);

        // gdy nie ma jeszcze dodanego zadnego pracownika do kalendarza
        //if( is_array($employees) && count($employees) == 0){
        if( is_array($employees_model) && count($employees_model) == 0){

            echo view('empty_calendar', $data);
        }
        else{
            //var_dump($data);
            echo view('calendar', $data);
        }
        echo view('templates/footer', $data);
    }
    // ----------------------------------------------------------------------------------------------new
    public function new_employee(){
        $session = \Config\Services::session();
        $id=$session->get('id_user');

        helper(['form', 'url']);

        $data = [
            'title'  =>'Add',
            'styles' =>'calendar'
        ];

        //dane uzytkownika
        $user = $this->getUser($id);

        $data['name']     = $user['name'];
        $data['last_name'] = $user['last_name'];

        if($this->request->getMethod() == 'post'){
            $rules=[
                'name'     => [ 'label' => 'Name', 'rules'     =>'required'],
                'last_name'=> ['label'  => 'Nazwisko', 'rules' => 'required'],
                'email'    => ['label'  => 'Adres email','rules'=>'required|valid_email'],
                'password' => ['label'  => 'Hasło', 'rules'     => 'required|min_length[7]'],
                'password_confirm' => ['label'  => 'Hasło', 'rules'     => 'required|matches[password]'],
                'number_free_days' => ['label'  => 'Liczba dni', 'rules'     => 'required|is_natural'],
            ];
            if($this->validate($rules)){
                    $model = new EmployeeModel();
                    $user['name']      = $_POST['name'];
                    $user['last_name'] = $_POST['last_name'];
                    $user['email']     = $_POST['email'];
                    $user['password']  = $_POST['password'];
                    $user['id_employer']     = (string)$id;
                    $user['number_free_days']= $_POST['number_free_days'];
                    $user['days_used']       = (string) 0;

                    // dodanie do tabeli employees
                    $model->set($user);
                    $model->insert();
                    //var_dump($user);
                
                // 
                return redirect()->to('/Calendar');
            }
            else{
                $data['validation']=$this->validator;
            }
        }

        echo view('templates/header', $data);
        echo view('new_employee',$data);
        echo view('templates/footer', $data);
    }
    //----------------------------------------------------------------------------------------------edit
    public function edit_employee(){
        $session = \Config\Services::session();
         //dane uzytkownika
         $id=$session -> get('id_user');
         $s=$session->get('me');
         //dane uzytkownika
         var_dump($_SESSION);
         $user = $this -> getUser($id);

        $data = [
            'title'     => 'Add',
            'styles'    =>'calendar',
            'name'      => $user['name'],
            'last_name' => $user['last_name']
        ];

        if(array_key_exists('pula',$_POST)){
            $employess = new EmployeeModel();

            $employee_id = $session -> get('id_employee');
            $employess -> set('number_free_days',$_POST['pula'] ,FALSE);
            $employess ->where('id_employee',$employee_id);
            $employess -> update();
            echo 'puuuuuuuuuuuuuuuuuuuuuuuuuuula';
        }
        if(array_key_exists('delete',$_POST)){
            var_dump($_POST['delete']);
            echo 'deeeeeeeeeeeeeeeeeleeee';
        }
        echo view('templates/header', $data);
        echo view('edit_employee',$data);
        echo view('templates/footer', $data); 
    }
    //---------------------------------------------------------------- do bazy danych
    private function getUser($id){
        $user = new UserModel();
        return $user->findUser($id);
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
