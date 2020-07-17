<?php namespace App\Validation;
use App\Models\CalendarModel;
use App\Models\CalendarEmployeeModel;

class CalendarRules 
{
    public function validateCode(string $str, string $fields,array $data)
    {
        $model = new CalendarModel();
        $calendar = $model->where('code',$data['code'])
                      ->first();
        if( !$calendar){
            return false;
        }
        $model_calendar_employer = new CalendarEmployeeModel();
        $code = $model_calendar_employer->where(['id_calendar'=>$calendar['id_calendar'], 'id_employee' => $data['id_employee']])->first();
        if($code){
            return false;
        }

        return true;
    }
}


?>