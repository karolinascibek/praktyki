<?php namespace App\Controllers;
use App\Models\CustomModel;
use App\Models\EmployeeModel;


class Calendar extends BaseController
{
	public function index()
	{
        $data = [
            'title'=>'Kalendarz',
            'styles' =>'calendar'
        ];

        $employees =  $this->getAllEmployees();
        $data['employees'] = $employees;
        echo view('templates/header', $data);

        // gdy nie ma jeszcze dodanego zadnego pracownika do kalendarza
        if( count($employees) == 0){
            echo view('createCalendar', $data);
        }
        else{
            echo view('calendar', $data);
        }
        echo view('templates/footer', $data);
    }
    
    public function getAllEmployees(){
		// $db=db_connect();
		// $model = new CustomModel($db);
		// $employees = $model->all();
		// $data = [
		// 	'meta_title'=> 'Post not Found',
		// 	'title'=>'Post not Found',
		// ];
        // $data['employees']=$employees;
        
        $e = new EmployeeModel();
        $t = $e->getAllForEmployer(2);

		return $t;
    }
    
    public function addEmployee(){
        //funkcja pobierająca dane nowego uzytkownika  i zapsisująca je w bazie 
    }

	//--------------------------------------------------------------------

}
