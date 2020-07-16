<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		echo view('Home/templates/header');
		echo view('Home/home');
		echo view('Home/templates/footer');
	}
	

	public function register_employer()
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
			}
		}
		echo view('Home/templates/header');
		echo view('Home/registration_employer', $data);
		echo view('Home/templates/footer');
	}
	public function login_employer()
	{
		
		echo view('Home/templates/header');
		echo view('Home/login_employer');
		echo view('Home/templates/footer');
	}

	//-----------------------------------------------
	public function login_employee()
	{
		echo view('Home/templates/header');
		echo view('Home/login_employee');
		echo view('Home/templates/footer');
	}
	
	public function register_employee()
	{
		echo view('Home/templates/header');
		echo view('Home/registration_employee');
		echo view('Home/templates/footer');
	}

	//--------------------------------------------------------------------

}
