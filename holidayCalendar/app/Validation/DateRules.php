<?php namespace App\Validation;
use App\Models\EmployeeModel;
use CodeIgniter\I18n\Time;

class DateRules
{
    public function checkDate(string $str, string $fields,array $data)
    {
        $model = new EmployeeModel();
        $user = $model->where('email',$data['email'])
                      ->first();
        if( !$user){
            return false;
        }
        return password_verify($data['password'], $user['password']);
    }

    public function checkMonth(string $str)
    {
        if( (int)$str <= 12){
            return true;
        }
        return false;
    }
    public function checkDays(string $str, string $fields, array $data)
    {
        //zwiększamy o jeden miesiac 
        $requiredfields = [];
        $fields = explode(',', $fields);
        foreach($fields as $field)
        {
            if (array_key_exists($field, $data))
            {
                $requiredFields[] = $field;
            }
        }
        $y = $data[$requiredFields[0]];
        $m = $data[$requiredFields[1]];
        if( is_numeric($y)  && is_numeric($m)  ){
            $date_str = $data[$requiredFields[0]].'-'.((int)$data[$requiredFields[1]]).'-1';
            $date = Time::parse( $date_str);
            $date = $date->addMonths(1);
            $date = $date->subDays(1);
            if((int)$str >= 1 && (int)$str <= (int)$date->getDay()){
                return true;
            }  
        }
        return false;
    }
    public function checkYear(string $str)
    {
        $now = Time::parse('now');
        if( (int)$str >= (int)$now->getYear() && (int)$str <= (int)$now->addYears(1)->getYear()){
            return true;
        }
        return false;
    }


}


?>