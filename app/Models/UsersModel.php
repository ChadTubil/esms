<?php
namespace App\Models;
use \CodeIgniter\Model;

class UsersModel extends Model 
{
    protected $table = 'users';
    protected $primaryKey = 'uid';
    protected $allowedFields = [
        'uaccountid', 'username', 'upassword', 'uadmin',
        'ustudent', 'uregistrar', 'uprogramchair', 'uhrd', 'uemployee',
        'ustatus', 'uisdel',
    ];
    protected $returnType = 'array';
    
    public function getLoggedInUserData($uid){
        $builder = $this->db->table('users');
        $builder->where('uid', $uid);
        $result = $builder->get();
        if(count($result->getResultArray())==1){
            return $result->getRow();
        }
        else{
            return false;
        }
    }
    public function verifyUser($student){

        $builder = $this->db->table('users');
        $builder->select("uid, ustatus, username, upassword, uadmin, ustudent");
        $builder->where('username', $student);

        $result = $builder->get();
        if(count($result->getResultArray())==1)
        {
            return $result->getRowArray();
        }
        else
        {
            return false;
        }
    }
}