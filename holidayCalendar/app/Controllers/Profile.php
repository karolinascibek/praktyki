<?php namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CalendarModel;
use App\Models\CalendarEmployeeModel;
use App\Models\HolidaysModel;
use App\Models\EmployeeModel;

class Profile extends BaseController
{
	public function index()
	{
        $session = session();
        if(!$session->get('isLoggedIn')){
            return redirect()->to('/home');
        }
        $data = [
			'id' => $session->get('id'),
			'name'=>  $session->get('name'),
			'last_name'=> $session->get('last_name'),
			'email'=>  $session->get('email'),
            'isLoggedIn'=>true,
            'title'     => 'Profil',
        ];
        if( $session->get('isEmployer')){
            $this->profile_employer($data);
        }
        else{
            $this->profile_employee($data);
        }
        if($session->get('validation_name')){
            $session->remove('validation_name');
        }
        if($session->get('validation')){
            $session->remove('validation');
        }

	}
	

    private function profile_employee($data){
        echo view('templates/header',$data);
		echo view('Profile/profile_employee',$data);
		echo view('templates/footer');
    }
    private function profile_employer($data){

        
        echo view('templates/header',$data);
		echo view('Profile/profile_employer',$data);
		echo view('templates/footer');
    }

    public function edit_name_employer(){
        $session = session();
        helper('form');
    
        if($this->request->getMethod() == 'post'){

            $rules = [
                'name' =>'required',
                'last_name' => 'required'
            ];
            $errors=[
                'name' => [
                    'required' => 'Pole Imie nie może być puste',
                ] ,
                'last_name' => [
                    'required' => 'Pole Nazwisko nie może być puste',
                ] 
            ];
            if($this->validate($rules,$errors)){
                $model = new UserModel();
                $id = $session->get('id');
                $data=[
                    'name' => $_POST['name'],
                    'last_name' => $_POST['last_name']
                ];
                $model->update($id,$data);
                $user = $model->find($id);
                $_SESSION['name'] = $user['name'];
                $_SESSION['last_name'] = $user['last_name'];
            }
            else{
                $_SESSION['validation_name'] = $this->validator;
            }

            return redirect()->to('/profile');
        }
    }
    public function edit_password_employer(){
        $session = session();
        $id = $session->get('id');
        helper('form');
        if($this->request->getMethod() == 'post'){
            $rules = [
                'password' => 'required',
                'confirm_password' => 'required|matches[password]'
            ];
            $errors=[
                'password' => [
                    'required' => 'Pole Hasło nie może być puste',
                ] ,
                'confirm_password' => [
                    'required' => 'Pole Powtórz hasło nie może być puste',
                    'matches' => 'Hasła muszą być takie same.',
                ] 
            ];
            if($this->validate($rules,$errors)){
                    
                    $data=[
                        'password' => $_POST['password'],
                    ];
                    $model = new UserModel();
                    $model->update($id,$data);
            }
            else{
                $_SESSION['validation'] = $this->validator;
            }
            return redirect()->to('/profile');
        }
    }
    public function delete_account_employer(){
        $session = session();
        $id = $session->get('id');
        helper('form');
        if($this->request->getMethod() == 'post'){
            
            //usuwamy wszystkie powiązane z uzytkownikiem  kalendarze oraz daty
            $calendar = new CalendarModel();
            $cal = $calendar->where('id_employer',$id)->get()->getResult();

            $calendar_employees = new CalendarEmployeeModel();
            $holiday = new HolidaysModel();

            foreach($cal as $c){
                $calendar_employees->where('id_calendar',$c->id_calendar)->delete();
                $holiday->where('id_calendar',$c->id_calendar)->delete();
            }
            $calendar->where('id_employer',$id)->delete();                   
            
            $model = new UserModel();
            $user = $model->where('id',$id)->delete();

            $session->setFlashdata('success','Konto zostało usunięte');
            $session->destroy();
            return redirect()->to('/employer');
        }
    }

    public function edit_name_employee(){
        $session = session();
        helper('form');
    
        if($this->request->getMethod() == 'post'){

            $rules = [
                'name' =>'required',
                'last_name' => 'required'
            ];
            $errors=[
                'name' => [
                    'required' => 'Pole Imie nie może być puste',
                ] ,
                'last_name' => [
                    'required' => 'Pole Nazwisko nie może być puste',
                ] 
            ];
            if($this->validate($rules,$errors)){
                $model = new EmployeeModel();
                $id = $session->get('id');
                $data=[
                    'name' => $_POST['name'],
                    'last_name' => $_POST['last_name']
                ];
                $model->update($id,$data);
                $user = $model->find($id);
                $_SESSION['name'] = $user['name'];
                $_SESSION['last_name'] = $user['last_name'];
            }
            else{
                $_SESSION['validation_name'] = $this->validator;
            }

            return redirect()->to('/profile');
        }
    }
    public function edit_password_employee(){
        $session = session();
        $id = $session->get('id');
        helper('form');
        if($this->request->getMethod() == 'post'){
            $rules = [
                'password' => 'required',
                'confirm_password' => 'required|matches[password]'
            ];
            $errors=[
                'password' => [
                    'required' => 'Pole Hasło nie może być puste',
                ] ,
                'confirm_password' => [
                    'required' => 'Pole Powtórz hasło nie może być puste',
                    'matches' => 'Hasła muszą być takie same.',
                ] 
            ];
            if($this->validate($rules,$errors)){
                    
                    $data=[
                        'password' => $_POST['password'],
                    ];
                    $model = new EmployeeModel();
                    $model->update($id,$data);
            }
            else{
                $_SESSION['validation'] = $this->validator;
            }
            return redirect()->to('/profile');
        }
    }
    public function delete_account_employee(){
        $session = session();
        $id = $session->get('id');
        helper('form');
        if($this->request->getMethod() == 'post'){
            
            $calendar_employees = new CalendarEmployeeModel();
            $holiday = new HolidaysModel();
            
            $calendar_employees->where('id_employee',$id)->delete();
            $holiday->where('id_employee',$id)->delete();
            
            $model = new EmployeeModel();
            $user = $model->where('id_employee',$id)->delete();
            $session->destroy();
            
            $session = session();
            $session->setFlashdata('success','Konto zostało usunięte');
            return redirect()->to('/employee');
        }
    }
	//--------------------------------------------------------------------

}
