<?php namespace App\Controllers;
use \Mpdf\Mpdf;


class FormPDF extends BaseController
{
	public function index()
	{	
		echo view('Home/templates/header');
		echo view('PDF/form');
		echo view('Home/templates/footer');
	}
	public function generate_pdf(){
		if($this->request->getMethod() == 'post'){
			$mpdf = new \Mpdf\Mpdf();
			$stylesheet = file_get_contents('css/style.css');
			$data = [
				'name'=>'Karolina',
				'last_name'=>'Zielińska',
				'company'=>'Pierogi',
			];
			$html = view('PDF/wniosek',$data);
			$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
			$mpdf->WriteHTML($html,\Mpdf\HTMLParserMode::HTML_BODY);

			//$mpdf->WriteHTML('Hello World');
			return redirect()->to($mpdf->Output('wniosek.pdf','I'));
		}
	}
	//--------------------------------------------------------------------

}
