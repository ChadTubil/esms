<?php
namespace App\Models;
use \CodeIgniter\Model;

class COLAssessmentModel extends Model 
{
    protected $table = 'assessment_col';
    protected $primaryKey = 'assid';
    protected $allowedFields = [
        'studid', 'sy', 'level', 'sem', 'course', 'curriculum',
        'section', 'date', 'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}