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
				'email' => [
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
			'isEmployer'=>true,
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
				'nip' => 'required|min_length[10]|max_length[10]',
				'firm' => 'required'
			];
			$errors = [
				'name'=>[
					'required'=>'Pole Nazwa jest wymagane'],
				'last_name'=>[
					'required'=>'Pole Nazwisko jest wymagane'],
				'email'=> [
					'required'=>'Pole Nazwa jest wymagane',
					'valid_email' => 'Adress email jest nie poprawny',
					'is_unique' => 'Podany email już istnieje'
				],
				'password' => [
					'required' => 'Pole hasło jest wymagane',
				],
				'password_confirm'=>[
					'matches'=>'Pole Hasło i Powtórz hasło musza byc takie same.'
				],
				'nip'=>[
					'required'=> 'Pole nip jest wymagane.',
					'min_length' => 'Pole nip nie może byc krótrze niź 10 znaków',
					'max_length' => 'Pole nip nie może byc krótrze dłuższe 10 znaków',
				],
				'firm'=>[
					'required' =>'Pole nazwa firmy jest wymagane.'
				]
			];
			if(!$this->validate($rules,$errors)){
				$data['validation']=$this->validator;
			}
			else{
                // dodoanie do bazy pracodawcy
                $model = new UserModel();
                $newData = [
                    'name'=>$this->request->getVar('name'),
                    'last_name'=>$this->request->getVar('last_name'),
                    'email' => $this->request->getVar('email'),
                    'password' => $this->request->getVar('password'),
                    'nip' => $this->request->getVar('nip'),
                    'firm' => $this->request->getVar('firm')
                ];
				var_dump($newData);
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
	public function  edit(){
		
		echo view('Home/templates/header');
		echo 'Edycja Pracodawcy';
		echo view('Home/templates/footer');
	}
	public function logout()
	{
		session()->destroy();
		return redirect()->to('/');
    }
}