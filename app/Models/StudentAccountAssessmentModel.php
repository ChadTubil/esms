<?php
namespace App\Models;
use \CodeIgniter\Model;

class StudentAccountAssessmentModel extends Model 
{
    protected $table = 'studentassessment';
    protected $primaryKey = 'sadid';
    protected $allowedFields = [
        'said', 'studentno', 'feeid', 'amount', 'discountamount',
        'netamount', 'paidamount', 'balance', 'assessmentdate', 'isbilled', 
        'createddate', 'isdel',
    ];
    protected $returnType = 'array';
    
}