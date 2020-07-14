<?php namespace App\Controllers;
use App\Models\CustomModel;
use App\Models\EmployeeModel;
use App\Models\UserModel;
use App\Models\HolidaysModel;


class Calendar extends BaseController
{

	public function index()
	{
        $session = \Config\Services::session();

        $newdata = [
            'username'  => 'frima1',
            'email'     => 'alicja@gmail.com',
            'logged_in' => TRUE,
            'id_user'   => 2
        ];   
        $session->set($newdata);
        $id =$newdata['id_user'];
        //var_dump($_SESSION);

        //przekierowanie na strone edycji
        //var_dump($_POST);
        $request = \Config\Services::request();
        if($this->request->getMethod()=='post'){
            $prodID = $request->getPost();
            //var_dump($prodID);

            //------------------------------------------------------------------------- usunięcie i dodanie dat do bazy 

            // pobranie osób do kalendarza
            $employees =  $this->findEmployees($id);
            if(is_array($employees)){
                //pobranie z bazy 
                $employees_db = $this->findEmployees($id);
                $days = json_decode($_POST['array']);
                //var_dump($employees_db);
                $deleted_days = $days->deleted;
                $added_days = $days->added;

                //var_dump($deleted_days);
                //var_dump($added_days);
                ////------------------------------------- 
                $i = 0;
                $model = new HolidaysModel();
                foreach($employees_db as $emDb){
                    foreach($deleted_days as $deleted){
                        if( (int)$deleted->id_row === $i ){
                            //echo 'usuniety';
                            $t = strtotime($deleted->id_day);
                            //echo 'id: '.$deleted->id_day.'<br>';

                            $date = date("Y-m-d",$t);
                            //echo 'data do usniecia';
                            //var_dump($date);
                            $model->where(['id_employee'=> $emDb->id_employee ,'data' => $date])->delete();
                            //var_dump($deleted);
                        }
                    }
                    foreach($added_days as $added){
                        if( (int)$added->id_row === $i ){
                            //echo 'dodany';
                            $daysToDb =[
                                'data' => $added->id_day,
                                'id_employee' => $emDb->id_employee
                                
                            ];
                            $model->set($daysToDb);
                            $model->insert();
                            //var_dump($added);
                        }
                    }
                    $i++;
                }

                //var_dump($array);
            }



            //-----------------------------------------------------------------------------

        }
        $user = $this->getUser($id);
        $data = [
            'title'     => 'Kalendarz',
            'styles'    => 'calendar',
            'last_name' => $user['last_name'],
            'name'      => $user['name'],
            'user_name' => $user['user_name']
        ];
        // pobranie osób do kalendarza
        $employees =  $this->findEmployees($id);
        if(is_array($employees)){
           $employersHolidays = $this->findEmployeesHolidays($id);
           $array=$this->createArrayDatesHolidays($employersHolidays, $employees);
           $data['employees'] = $array['employees'];
           $data['holidays']  = $array['holidays'];
           //var_dump($array);
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
    // ----------------------------------------------------------------------------------------------new
    public function new_employee(){
        $session = \Config\Services::session();
        $id=$session->get('id_user');

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
                'name'     =>'required',
                'last_name'=>'required',
                'email'    =>'required',
                'password' =>'required'
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
                    var_dump($user);

                //return redirect()->to('/Calendar');
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
