<?php namespace App\Controllers;

class Test extends BaseController
{
	public function index()
	{
    $data = [
      'todo_list' => ['Clean House', 'Call Mom', 'Run Errands'],
      'title'     => "My Real Title",
      'heading'   => "My Real Heading"
];

        //$data['title']="kk";

        echo view('templates/header', $data);
        echo view('test', $data);
        echo view('templates/footer', $data);
    }
    public function info(){
        $employee = array( [
            "employee_id" => 10011,
              "Name" => "Nathan",
              "Skills" =>
               array(
                      "analyzing",
                      "documentation" =>
                       array(
                         "desktop",
                           "mobile"
                        )
                   )],
                   [
                    "employee_id" => 10011,
                      "Name" => "Nathan",
                      "Skills" =>
                       array(
                              "analyzing",
                              "documentation" =>
                               array(
                                 "desktop",
                                   "mobile"
                                )
                           )],
           ); 
           $data['dane']=$employee;
    
        echo json_encode($data);
        echo view('test',$data);
      }
    

	//--------------------------------------------------------------------

}
