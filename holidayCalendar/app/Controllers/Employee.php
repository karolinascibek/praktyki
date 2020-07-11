<?php namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\CustomModel;

class Employee extends BaseController
{
	public function index()
	{
		$db=db_connect();
		$model = new CustomModel($db);
		echo '<prev>';
		//var_dump( );
		echo '</prev>';
		$data = [
			'meta_title'=>'CodeIgniter 4 Blog Dynamic',
			'title'=>'this is a title page',
		];

		$posts = [
			'title','title 2','title 3'
		];
		$data['posts']=$posts;
		echo 'emplo';

		//return view('blog', $data);


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
