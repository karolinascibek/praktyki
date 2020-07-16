<?php namespace App\Controllers;

use App\Models\UserModel;


class Employer extends BaseController
{
	public function index()
	{
		$data=[];
		helper(['form']);

		if($this->request->getMethod()=='post'){
			$rules=[
				'email'=>'required|valid_email',
				'password'=>'required|max_length[255]|validateUser[email,password]',
			];

			$errors = [
				'password' => [
					'validateUser' => 'Email lub hasło jest niepoprawne',
				],
				'eamil' => [
					'required' => 'Pole adres email nie może być puste.',
				],
			];
			if(!$this->validate($rules,$errors)){
				$data['validation']=$this->validator;
			}
			else{
                // podane dane w formularzu były poprane 
				$model = new UserModel();
				
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
		echo view('Employer/login_employer',$data);
		echo view('Home/templates/footer');
	}

	private function setUserSession($user){
		$data = [
			'id' => $user['id'],
			'name'=> $user['name'],
			'last_name'=> $user['last_name'],
			'email'=> $user['email'],
			'isLoggedIn'=>true,
		];
		$session = session();
		$session->set($data);
		return true;

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
                $model = new UserModel();
                $newData = [
                    'name'=>$this->request->getVar('name'),
                    'last_name'=>$this->request->getVar('last_name'),
                    'email' => $this->request->getVar('email'),
                    'password' => $this->request->getVar('password')
                ];

                $model->save($newData);
                $session = session();
                $session->setFlashdata('success','Rejestracja zakończyła się pomyślnie');
                return redirect()->to('/employer');
			}
		}
		echo view('Home/templates/header');
		echo view('Employer/registration_employer', $data);
		echo view('Home/templates/footer');
	}
	public function logout()
	{
		session()->destroy();
		return redirect()->to('/');
    }
}