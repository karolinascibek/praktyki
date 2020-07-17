<?php namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\CustomModel;

class Employee extends BaseController
{
	public function index()
	{
		$data=[];
		helper(['form']);

		if($this->request->getMethod()=='post'){
			$rules=[
				'email'=>'required|valid_email',
				'password'=>'required|max_length[255]|validateEmployee[email,password]',
			];

			$errors = [
				'password' => [
					'validateEmployee' => 'Email lub hasło jest niepoprawne',
				],
				'email' => [
					'required' => 'Pole adres email nie może być puste.',
				],
			];
			if(!$this->validate($rules,$errors)){
				$data['validation']=$this->validator;
			}
			else{
                // podane dane w formularzu były poprane 
				$model = new EmployeeModel();
				
				$email = $this->request->getVar('email');
				$password = $this->request->getVar('password');
				$user = $model->where('email', $this->request->getVar('email'))
								->first();
				
				$this->setUserSession($user);
				var_dump($_SESSION);

                return redirect()->to('/dashboard');
			}
		}
		echo view('Home/templates/header');
		echo view('Employee/login_employee',$data);
		echo view('Home/templates/footer');


	}

	private function setUserSession($user){
		$data = [
			'id' => $user['id_employee'],
			'name'=> $user['name'],
			'last_name'=> $user['last_name'],
			'email'=> $user['email'],
			'isLoggedIn'=>true,
			'isEmployer'=>false,
		];
		$session = session();
		$session->set($data);
		return true;

	}
	public function register_employee()
	{
		$data=[];
		helper(['form']);
		if($this->request->getMethod()=='post'){
			$rules=[
				'name'=>'required',
				'last_name'=>'required',
				'email'=>'required|valid_email|is_unique[users.email]',
				'password'=>'required|max_length[255]',
				'password_confirm'=>'matches[password]',
			];
			if(!$this->validate($rules)){
				$data['validation']=$this->validator;
			}
			else{
                // dodoanie do bazy pracodawcy
                $model = new EmployeeModel();
                $newData = [
                    'name'=>$this->request->getVar('name'),
                    'last_name'=>$this->request->getVar('last_name'),
                    'email' => $this->request->getVar('email'),
                    'password' => $this->request->getVar('password')
                ];

                $model->save($newData);
                $session = session();
                $session->setFlashdata('success','Rejestracja zakończyła się pomyślnie');
                return redirect()->to('/employee');
			}
		}
		echo view('Home/templates/header');
		echo view('Employee/registration_employee',$data);
		echo view('Home/templates/footer');
	}
	public function  edit(){
		echo 'Edycja Pracownika';
	}


	public function getAllEmployees(){
		$db=db_connect();
		$model = new CustomModel($db);
		$employees = $model->all();
		$data = [
			'meta_title'=> 'Post not Found',
			'title'=>'Post not Found',
		];
		$data['employees']=$employees;

		return $data;
	}
	//--------------------------------------------------------------------

}
