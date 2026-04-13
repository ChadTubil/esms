<?php
namespace App\Models;
use \CodeIgniter\Model;

class StudentSubjectsModel extends Model 
{
    protected $table = 'student_subjects';
    protected $primaryKey = 'ssid';
    protected $allowedFields = [
        'studid', 'cdid', 'prelim', 'midterm', 'final',
        'semestral', 'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}