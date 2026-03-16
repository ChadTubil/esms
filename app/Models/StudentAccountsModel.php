<?php
namespace App\Models;
use \CodeIgniter\Model;

class StudentAccountsModel extends Model 
{
    protected $table = 'studentsaccounts';
    protected $primaryKey = 'said';
    protected $allowedFields = [
        'accountno', 'studentno', 'sy', 'sem', 'course',
        'yearlevel', 'totalassessment', 'totalpayments', 'totalbalance', 'accountstatus',
        'createddate', 'updateddate', 'isdel',
    ];
    protected $returnType = 'array';
    
}