<?php namespace App\Controllers;
use \Mpdf\Mpdf;
use App\Models\EmployeeModel;
use App\Models\UserModel;
use App\Models\CalendarModel;
use CodeIgniter\I18n\Time;

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
				'from_month' =>'required|is_natural_no_zero|checkMonth',
				'from_year' =>'required|is_natural_no_zero|checkYear',
				'to_month' =>'required|is_natural_no_zero|checkMonth',
				'to_year' =>'required|is_natural_no_zero|checkYear',
			];
			$errors = [
				'type'=>[
					'required'=>'Pole urlop jest wymagane.'
				],
				'from_month'=>[
					'required'=>'Pole "miesiąc od" jest wymagane.',
					'is_natural_no_zero' =>"Pole 'miesiąc od' musi być to liczba z zakresu < 1, 12 >.",
					'checkMonth' => 'Podany miesiac jest nieprawidłowy'
				],
				'to_month'=>[
					'required'=>'Pole "miesiąc do" jest wymagane.',
					'is_natural_no_zero' =>"Pole 'miesiąc do' musi być to liczba zakresu < 1, 12 >.",
					'checkMonth' => 'Podany miesiac jest nieprawidłowy'
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
			if($this->validate($rules,$errors) ){
				$rules = [
					'from_day' =>'required|is_natural_no_zero|checkDays[from_year,from_month]',
					'to_day' =>'required|is_natural_no_zero|checkDays[to_year,to_month]',
				];
				$errors = [
					'from_day'=>[
						'required'=>'Pole "dzień od" jest wymagane.',
						'is_natural_no_zero' =>"Pole 'dzień od' musi być to liczba całkowitą większą od 0.",
						'checkDays' => 'Podany dzień jest nieprawidłowy'
					],
					'to_day'=>[
						'required'=>'Pole "dzień do" jest wymagane.',
						'is_natural_no_zero' =>"Pole 'dzień do' musi być to liczba całkowitą większa od 0.",
						'checkDays' => 'Podany dzień jest nieprawidłowy'
					],
				];
				if($this->validate($rules,$errors) ){
					$mpdf = new \Mpdf\Mpdf();
					$stylesheet = file_get_contents('css/style.css');

					$model = new EmployeeModel();
					$session = session();
					$employee = $model->find($session->id);

					// określenie ile dni roboczych obejmuje urlop 
					$from_date = Time::parse($_POST['from_year']."-".$_POST['from_month'].'-'.$_POST['from_day']);
					$to_date   = Time::parse($_POST['to_year']."-".$_POST['to_month']."-".$_POST['to_day']);
					$numberDays = $to_date ->diff($from_date)->days;
					$working_days = $this->calculateTheWorkingDays($from_date, $numberDays);

					$newdata = [
						'title' =>'PDF',
						'name'=>$employee['name'],
						'last_name'=>$employee['last_name'],
						'company'=>$data['firm'],
						'nip'=>$data['nip'],
						'from' =>$from_date->format('d.m.Y'),
						'to' =>$to_date->format('d.m.Y'),
						'days'=> $working_days,
						'year'=>$data['year'],
						'type'=>$_POST['type']
					];
					if($from_date->isBefore($to_date)){
						$html = view('PDF/wniosek',$newdata);
						$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
						$mpdf->WriteHTML($html,\Mpdf\HTMLParserMode::HTML_BODY);

						return redirect()->to($mpdf->Output('wniosek.pdf','I'));
					}
				}
				else{		
					return  $this->validator;
				}
			}
			else{		
				return  $this->validator;
			}
		}
	}
	private function calculateTheWorkingDays($date, $numberDays){
		$time = Time::parse($date);
		//$time2 = Time::parse('2020-04-20');
		$fd = $this->freeDays($date);
		//$d= $time->diff($time2) ->days;
		$d = $numberDays;

		//usuniecie niedziel/sobót
		$working_days = $d;
		for($i = 0; $i < $d; $i++){
			if($time->getDayOfWeek() == 7 || $time->getDayOfWeek() == 6 ){
				$working_days -=1;
			}
			else{
				//usuniecie dni wolnych od pracy 
				foreach( $fd as $day){
					$day = Time::parse($day);
					if( $day->equals($time)){
						$working_days -=1;
					}
				}
			}
			$time = $time->addDays(1);
		}
		return $working_days;
	}
	private function whenEaster($date){
			$year = $date->getYear();
			$a = $year % 19;
			$b = (int)( $year / 100 );
			$c = $year % 100;
			$d = (int)($b/4);
			$e = $b % 4;
			$f = (int)( ($b+8) / 25 );
			$g = (int)( ($b-$f+1)/3);
			$h = ( 19*$a+$b-$d-$g+15) % 30;
			$i = (int)( $c / 4);
			$k = $c % 4;
			$l = ( 32+2*$e+2*$i-$h-$k) % 7;
			$m = (int)( ($a+11+$h+22*$l) / 451);
			$p = ( $h + $l - 7*$m + 114 ) %  31;
		
			//dzień
			$p = $p+1;
		
			//miesiąc
			$n = (int)( ($h+$l-7*$m+114)/31 );
		    $dt_str = $date->getYear().'-'.($n).'-'.$p;
			$easter = Time::parse($dt_str);
			return  $easter; 
	}
	private function freeDays($date){
			//wielkanoc
			$easter = $this->whenEaster($date);
		
			// poniedziałek wielkanocny
			$easterMonday = Time::parse($easter->getYear().'-'.$easter->getMonth().'-'.($easter->getDay()));
			$easterMonday = $easterMonday->addDays(1);
		
			// //Zielone Światki 
			$pentecost = Time::parse($easter->getYear().'-'.$easter->getMonth().'-'.($easter->getDay()));
			$pentecost = $pentecost->addDays(49);
			
			// //Boże Ciało
			$corpusChristi = Time::parse($easter->getYear().'-'.$easter->getMonth().'-'.($easter->getDay()));
			$corpusChristi = $corpusChristi->addDays(60);

			$year = $date->getYear();
			$freeDays = [
				$year.'-1-1',
				$year.'-1-6',
				$year.'-'.($easter->getMonth()).'-'.$easter->getDay(),  // wielkanoc
				$year.'-'.($easterMonday->getMonth()).'-'.$easterMonday->getDay(),  // poniedziałek wielkanocny
				$year.'-5-1',  
				$year.'-5-3',
				$year.'-'.($pentecost->getMonth()).'-'.$pentecost->getDay(),  //zielone światki
				$year.'-'.($corpusChristi->getMonth()).'-'.$corpusChristi->getDay(), // boże ciało
				$year.'-8-15',
				$year.'-11-1',
				$year.'-11-11',
				$year.'-12-25',
				$year.'-12-26',
			];
			return $freeDays;
	}
	//--------------------------------------------------------------------

}
