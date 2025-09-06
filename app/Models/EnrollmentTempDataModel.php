<?php
namespace App\Models;
use \CodeIgniter\Model;

class EnrollmentTempDataModel extends Model 
{
    protected $table = 'enrollmenttempdata';
    protected $primaryKey = 'etdid';
    protected $allowedFields = [
        'studno', 'fullname', 'sy',
        'sem', 'level', 'course',
        'date', 'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}