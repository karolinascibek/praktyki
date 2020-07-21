<?php namespace App\Controllers;
use App\Models\CalendarModel;
use App\Models\Employer;
use App\Models\CalendarEmployeeModel;

class Dashboard extends BaseController
{
	public function index()
	{
        $session = session();
        $id = $session->get('id');
        $data = [
            'title' =>'Kalendarz',
            'name'  => $session->get('name'),
            'last_name'  => $session->get('last_name'),
        ];

        helper('form');
        //zalogowany jaki pracodawca
        if( $session->get('isEmployer')){

            $model = new CalendarModel();
            if($this->request->getMethod() == 'post'){
                $rules=[
                    'name' =>'required',
                ];
                $errors = [
                    'name' => [
                        'required' => 'Pole Nazwa jest wymagane.',
                    ],
                ];
                if($this->validate($rules,$errors)){
                    //losowy kod dla kalendarza
                    $code = $this->generateCode(5,10);

                    $newData = [
                        'name' =>$this->request->getVar('name'),
                        'code' =>$code,
                        'id_employer' =>$id,
                    ];
                    $model->save($newData);
                }
                else{
                    $data['validation']=$this->validator;
                }
            }
            $calendar = $model->where('id_employer',$id)->get()->getResult();
            $data['calendars'] = $calendar;

		    echo view('templates/header',$data);
		    echo view('Dashboard/dashboard',$data);
        }
        else{
            //strona pracownika 

            $model = new CalendarModel();
            if($this->request->getMethod() == 'post'){

                $rules=[
                    'code' =>'required|is_not_unique[calendar.code]|alpha_numeric|validateCode[code,id_employee]',
                ];
                $errors = [
                    'code' => [
                        'alpha_numeric' => 'Kod składa się tylko z znaków alfabetu i cyfer. Nie może zawierać spacji.',
                        'required' => 'Pole Kod jest wymagane.',
                        'is_not_unique' => 'Podany kod nie istnieje.',
                        'validateCode' => 'Należysz już do Kalendarza o podanym kodzie.'
                    ],
                ];
                if($this->validate($rules,$errors)){
                    $model = new CalendarModel();
                    $calendar = $model->where('code',$_POST['code'])
                                     ->first();
                    $newData = [
                        'id_employee' =>session()->get('id'),
                        'id_calendar' =>$calendar['id_calendar'],
                    ];
                    $model_calendar_employee = new CalendarEmployeeModel();
                    $model_calendar_employee->save($newData);
                  
                }
                else{
                    $data['validation']=$this->validator;
                }
            }
            //wyświetlenie listy z kalendarzami 
            $model = new CalendarEmployeeModel();
            $employeeCalendars = $model->where('id_employee',$session->get('id'))
                                        ->join('calendar' , 'calendar.id_calendar = calendar_employee.id_calendar')
                                        ->findAll();

            $data['calendars'] = $employeeCalendars;

            echo view('templates/header',$data);
            echo view('Dashboard/employeePage',$data);
        }      

		echo view('templates/footer');
    }

    public function single_calendar($id=null){
        //pracodawca -----------------------------------------------------------------------
            helper('url');
            if( !is_numeric($id)  ){
                    // nie ma takiej strony 
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
            elseif($id >=1  ){
                //pracodawca
                if( session()->get('isEmployer')){
                    $model = new CalendarModel();
                    $calendars = $model->where('id_employer', session()->get('id') )
                                        ->get()
                                        ->getResult();
                }
                else{
                //pracowanik
                    $model = new CalendarEmployeeModel();
                    $calendars = $model->where('id_employee', session()->get('id') )
                                    ->get()
                                    ->getResult();
                    var_dump($calendars);
                }
                if( !isset($calendars) || count($calendars) < $id ){
                        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
                }else{
                    //liczba kalendarzy uzytkownika
                    $db = db_connect();
                    
                    //pracodawca
                    if( session()->get('isEmployer')){
                        $calendar = $db->table('calendar')
                                        ->where('id_employer', session()->get('id') )
                                        ->get()
                                        ->getResult();
                        session()->set('id_calendar',$calendar[$id -1 ]->id_calendar);
                        session()->set('calendar_year',$calendar[$id -1 ]->year);
                        return redirect()->to('/calendar');  
                    }
                    //pracownik
                    else{
                        $calendar = $db->table('calendar_employee')
                                    ->where('id_employee', session()->get('id') )
                                    ->get()
                                    ->getResult();
                        var_dump($calendar);
                        $id_cal = $calendar[$id -1 ]->id_calendar;
                        $calendarYear = $db->table('calendar')->where('id_calendar', $id_cal)
                                                                ->get()->getResult();
                        session()->set('id_calendar',$id_cal);
                        session()->set('calendar_year',$calendarYear[0]->year);
                        return redirect()->to('/calendar/mycalendar');  
                    }
                    
                }           

            }
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }
    private function generateCode($min,$max){
        $z = random_int($min,$max);
        $code = substr(md5(date("d.m.Y.H.i.s").rand(1,1000000)) , 0 , $z);

        $model = new CalendarModel();
        $cal = $model->where('code',$code)->first();
        while( $cal != null ){
            $code = substr(md5(date("d.m.Y.H.i.s").rand(1,1000000)) , 0 , $z);
            $cal = $model->where('code',$code)->first();

            echo 'szuka losowego nie powtarzającego się codu ---- .';
        }
        return $code;
    }
}