<?php namespace App\Controllers;
use App\Models\CalendarModel;
use App\Models\Employer;

class Dashboard extends BaseController
{
	public function index()
	{
        $session = session();
        $id = $session->get('id');
        $data = [
            'title' =>'Welcome',
            'name'  => $session->get('name'),
            'last_name'  => $session->get('last_name'),
        ];

        $model = new CalendarModel();
        if($this->request->getMethod() == 'post'){
            $rules=[
                'code' =>'required|is_unique[calendar.code]',
                'name' =>'required',
            ];
            if($this->validate($rules)){
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
		echo view('templates/footer');
    }

    public function singleCalendar($id=null){
        $model = new CalendarModel();
        if( !is_numeric($id)  ){
                // nie ma takiej strony 
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }elseif($id >=1  ){

            $calendars = $model->where('id_employer', session()
                                ->get('id') )->get()
                                ->getResult();
            //var_dump($calendars);
            if( !isset($calendars) || count($calendars) < $id ){
                    //
                    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }else{
                //liczba kalendarzy uzytkownika
                //$calendar = $model->findAll(1, $id-1);
                $db = db_connect();
               
                $calendar = $db->table('calendar')
                                ->where('id_employer', session()
                                ->get('id') )
                                ->get()
                                ->getResult();
                //var_dump($calendars);
                session()->set('id_calendar',$calendar[$id -1 ]->id_calendar);
                return redirect()->to('/calendar');  
            }           

        }
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        

    }
}