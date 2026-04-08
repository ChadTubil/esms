<?php
namespace App\Models;
use \CodeIgniter\Model;

class StudentAccountsModel extends Model 
{
    protected $table = 'studentsaccounts';
    protected $primaryKey = 'said';
    protected $allowedFields = [
        'studentno', 'assessmentid', 'sy', 'sem', 'course',
        'cluster', 'level', 'totalassessment', 'totalpayments', 'totalbalance', 'accountstatus',
        'createddate', 'updateddate', 'isdel',
    ];
    protected $returnType = 'array';
    
}