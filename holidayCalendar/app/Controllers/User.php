<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		return view('welcome_message');
	}
	public function login_employer()
	{
		echo view('Form/templates/header');
		echo view('Form/login_employer');
		echo view('Form/templates/footer');
	}
	public function login_employee()
	{
		echo view('Form/templates/header');
		echo view('Form/login_employee');
		echo view('Form/templates/footer');
	}
	public function register_employer()
	{
		echo view('Form/templates/header');
		echo view('Form/registration_employer');
		echo view('Form/templates/footer');
	}
	public function register_employee()
	{
		echo view('Form/templates/header');
		echo view('Form/registration_employee');
		echo view('Form/templates/footer');
	}

	//--------------------------------------------------------------------

}
