<?php
namespace App\Models;
use \CodeIgniter\Model;

class CollegeGradesModel extends Model 
{
    protected $table = 'collegegrades';
    protected $primaryKey = 'colgradeid';
    protected $allowedFields = [
        'studentno', 'assid', 'currid', 'subid', 'prelim',
        'midterm', 'final', 'semestral', 'section', 'empid',
        'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}