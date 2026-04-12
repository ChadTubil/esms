<?php
namespace App\Models;
use \CodeIgniter\Model;

class EnrollmentHistoryIBEDModel extends Model 
{
    protected $table = 'enrollmenthistory_ibed';
    protected $primaryKey = 'ehid';
    protected $allowedFields = [
        'studid', 'studfullname', 'sy', 'level', 'date', 
        'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}