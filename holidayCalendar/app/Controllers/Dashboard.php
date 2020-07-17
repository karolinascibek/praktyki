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

        //zalogowany jaki pracodawca
        if( $session->get('isEmployer')){
            $model = new CalendarModel();
            if($this->request->getMethod() == 'post'){
                $rules=[
                    'code' =>'required|is_unique[calendar.code]|alpha_numeric',
                    'name' =>'required',
                ];
                $errors = [
                    'code' => [
                        'alpha_numeric' => 'Kod składa się tylko z znaków alfabetu i cyfer. Nie może zawierać spacji.',
                        'required' => 'Pole Kodjest wymagane.',
                    ],
                    'name' => [
                        'required' => 'Pole Nazwa jest wymagane.',
                    ],
                ];
                if($this->validate($rules,$errors)){
                    $newData = [
                        'name' =>$this->request->getVar('name'),
                        'code' =>$this->request->getVar('code'),
                        'id_employer' =>$id,
                    ];
                    $model->save($newData);
                    //var_dump($newData);                  
                }
                else{
                    $data['validation']=$this->validator;
                }
            }
            $calendar = $model->where('id_employer',$id)->get()->getResult();
            $data['calendars'] = $calendar;
            //var_dump($calendar);
		    echo view('templates/header',$data);
		    echo view('Dashboard/dashboard',$data);
        }
        else{
            //strona pracownika 

            $model = new CalendarModel();
            if($this->request->getMethod() == 'post'){
                var_dump($_POST);
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
                    //var_dump($newData);                  
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
            //var_dump($employeeCalendars);
            $data['calendars'] = $employeeCalendars;



            echo view('templates/header',$data);
            echo view('Dashboard/employeePage',$data);
        }      
        //var_dump($_SESSION);
		echo view('templates/footer');
    }

    public function mycalendar($id=null){
        //pracodawca -----------------------------------------------------------------------
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
                        $id_cal = $calendar[$id -1 ]->id_calendar;
                        $calendarYear = $db->table('calendar')->where('id_calendar', $id_cal)
                                                                ->get()->getResult();
                        session()->set('id_calendar',$id_cal);
                        session()->set('calendar_year',$calendarYear[0]->year);
                        echo 'mój kalendarz';
                        var_dump($calendar[$id -1 ]);
                        return redirect()->to('/calendar/mycalendar');  
                    }
                    
                }           

            }
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        // //pracownik -------------------------------------------------------------------------------
        // else{

        //     $model = new CalendarEmployeeModel();
        //     if( !is_numeric($id)  ){
        //             // nie ma takiej strony 
        //         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        //     }elseif($id >=1  ){
        //         $calendars = $model->where('id_employee', session()->get('id') )
        //                             ->get()
        //                             ->getResult();
        //         var_dump($calendars);
        //         if( !isset($calendars) || count($calendars) < $id ){
        //                 throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        //         }else{
        //             //liczba kalendarzy uzytkownika
        //             $db = db_connect();
                
        //             $calendar = $db->table('calendar_employee')
        //                             ->where('id_employee', session()->get('id') )
        //                             ->get()
        //                             ->getResult();
        //             session()->set('id_calendar',$calendar[$id -1 ]->id_calendar);
        //             session()->set('calendar_year',$calendar[$id -1 ]->year);
        //             echo 'mój kalendarz';
        //             var_dump($calendar[$id -1 ]);
        //             return redirect()->to('/calendar/mycalendar');  
        //         }           

        //     }
        //     echo 'kalendarz pracownika';
        //     throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        // }

    //}
}