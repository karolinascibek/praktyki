<?php namespace App\Controllers;

class Calendar extends BaseController
{
	public function index()
	{
        $data = [
            'title'=>'Kalendarz',
            'styles' =>'calendar'
        ];

        echo view('templates/header', $data);
        echo view('calendar', $data);
        echo view('templates/footer', $data);
	}

	//--------------------------------------------------------------------

}
