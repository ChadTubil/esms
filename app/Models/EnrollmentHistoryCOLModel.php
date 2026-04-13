<?php
namespace App\Models;
use \CodeIgniter\Model;

class EnrollmentHistoryCOLModel extends Model 
{
    protected $table = 'enrollmenthistory_col';
    protected $primaryKey = 'ehid';
    protected $allowedFields = [
        'studid', 'studfullname', 'sy', 'level', 'sem', 'course', 'date', 
        'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}