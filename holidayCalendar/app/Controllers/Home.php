<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		echo view('Home/templates/header');
		echo view('Home/home');
		echo view('Home/templates/footer');
	}
	
	//--------------------------------------------------------------------

}
