<?php
namespace App\Models;
use \CodeIgniter\Model;

class EnrollmentHistorySHSModel extends Model 
{
    protected $table = 'enrollmenthistory_shs';
    protected $primaryKey = 'ehid';
    protected $allowedFields = [
        'studid', 'studfullname', 'sy', 'level', 'cluster', 'date', 
        'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}