<?php namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;

use CodeIgniter\Model;
class CalendarModel extends Model{

    
    protected $table      = 'calendar';
    protected $primaryKey = 'id_calendar';

    //protected $returnType     = 'array';
    //protected $useSoftDeletes = true;

    protected $allowedFields = ['id_calendar','id_employer','name','code' ];

    //protected $useTimestamps = true;
    //protected $createdField  = 'data_created';
    //protected $updatedField  = 'data_updated';
    //protected $deletedField  = 'deleted_at';

    //protected $validationRules    = [];
    //protected $validationMessages = [];
    //protected $skipValidation     = false;

    public function getAll(){
        return $this->findAll();
    }

    public function findUser($id){
        $user = $this->find($id);
        return $user;
    }



 
}
?>
