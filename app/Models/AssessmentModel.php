<?php
namespace App\Models;
use \CodeIgniter\Model;

class AssessmentModel extends Model 
{
    protected $table = 'assessment';
    protected $primaryKey = 'assid';
    protected $allowedFields = [
        'studentno', 'sy', 'sem', 'level', 'course',
        'curriculum', 'section', 'date', 'status',
        'isdel',
    ];
    protected $returnType = 'array';
    
}