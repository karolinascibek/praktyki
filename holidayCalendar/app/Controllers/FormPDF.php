<?php namespace App\Controllers;
use \Mpdf\Mpdf;
use App\Models\EmployeeModel;
use App\Models\UserModel;
use App\Models\CalendarModel;

class FormPDF extends BaseController
{
	public function index()
	{	
		helper('form');
		$model = new CalendarModel();
		$session = session();
		$cal = $model->find($session->id_calendar);
		$userMolde = new UserModel();
		$user = $userMolde->find($cal['id_employer']);
		$data = [
			'title'=>'Wniosek',
			 'name' =>session()->name,
			 'last_name'=>session()->last_name,
			 'year' =>$cal['year'],
			 'firm' =>$user['firm'],
			 'nip' =>$user['nip'],
		];
		$data['validation'] = $this->generate_pdf($data);
		echo view('templates/header',$data);
		echo view('PDF/form');
		echo view('templates/footer');
	}
	public function generate_pdf($data){
		if($this->request->getMethod() == 'post'){

			$rules = [
				'type' =>'required',
				'from_day' =>'required|is_natural_no_zero',
				'from_month' =>'required|is_natural_no_zero',
				'from_year' =>'required|is_natural_no_zero',
				'to_day' =>'required|is_natural_no_zero',
				'to_month' =>'required|is_natural_no_zero',
				'to_year' =>'required|is_natural_no_zero',
			];
			$errors = [
				'type'=>[
					'required'=>'Pole urlop jest wymagane.'
				],
				'from_day'=>[
					'required'=>'Pole "dzień od" jest wymagane.',
					'is_natural_no_zero' =>"Pole 'dzień od' musi być to liczba naturalną."
				],
				'to_day'=>[
					'required'=>'Pole "dzień do" jest wymagane.',
					'is_natural_no_zero' =>"Pole 'dzień do' musi być to liczba naturalną."
				],
				'from_month'=>[
					'required'=>'Pole "miesiąc od" jest wymagane.',
					'is_natural_no_zero' =>"Pole 'miesiąc od' musi być to liczba naturalną."
				],
				'to_month'=>[
					'required'=>'Pole "miesiąc do" jest wymagane.',
					'is_natural_no_zero' =>"Pole 'miesiąc do' musi być to liczba naturalną."
				],
				'from_year'=>[
					'required'=>'Pole "rok od" jest wymagane.',
					'is_natural_no_zero' =>"Pole 'rok od' musi być to liczba naturalną."
				],
				'to_year'=>[
					'required'=>'Pole "rok do" jest wymagane.',
					'is_natural_no_zero' =>'Pole  "rok do" musi być to liczba naturalną.'
				],
			];
			if($this->validate($rules,$errors)){
				$mpdf = new \Mpdf\Mpdf();
				$stylesheet = file_get_contents('css/style.css');

				$model = new EmployeeModel();
				$session = session();
				$employee = $model->find($session->id);

				$from_date = new \DateTime($_POST['from_year']."-".$_POST['from_month'].'-'.$_POST['from_day']);
				$to_date   = new \DateTime($_POST['to_year']."-".$_POST['to_month']."-".$_POST['to_day']);
				$date = $to_date ->diff($from_date);

				$newdata = [
					'title' =>'PDF',
					'name'=>$employee['name'],
					'last_name'=>$employee['last_name'],
					'company'=>$data['firm'],
					'nip'=>$data['nip'],
					'from' =>$from_date->format('d.m.Y'),
					'to' =>$to_date->format('d.m.Y'),
					'days'=> $date->days,
					'year'=>$data['year'],
					'type'=>$_POST['type']
				];
				$html = view('PDF/wniosek',$newdata);
				$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
				$mpdf->WriteHTML($html,\Mpdf\HTMLParserMode::HTML_BODY);

				return redirect()->to($mpdf->Output('wniosek.pdf','I'));
			}
			else{			
				return  $this->validator;
			}
		}
	}
	//--------------------------------------------------------------------

}
