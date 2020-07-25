<?php namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;

use CodeIgniter\Model;
class UserModel extends Model{

    
    protected $table      = 'users';
    protected $primaryKey = 'id';

    //protected $returnType     = 'array';
    //protected $useSoftDeletes = true;

    protected $allowedFields = ['name','last_name' ,'email','password','nip','firm'];

    protected $useTimestamps = true;
    protected $createdField  = 'user_data_created';
    protected $updatedField  = 'user_data_updated';

    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];
    //protected $deletedField  = 'deleted_at';

    //protected $validationRules    = [];
    //protected $validationMessages = [];
    //protected $skipValidation     = false;


    protected function passwordHash(array $data){
        //haszowanie hasła
        if(isset($data['data']['password'])){
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
    
    protected function beforeInsert(array $data){
        $data = $this->passwordHash($data);
        return $data;
    }
    protected function beforeUpdate(array $data){
        $data = $this->passwordHash($data);
        return $data;
    }
    
    public function getAll(){
        return $this->findAll();
    }

    public function findUser($id){
        $user = $this->find($id);
        return $user;
    }



 
}
?>
