<?php
namespace App\Models;
use \CodeIgniter\Model;

class IBEDAssessmentModel extends Model 
{
    protected $table = 'assessment_ibed';
    protected $primaryKey = 'assid';
    protected $allowedFields = [
        'studid', 'sy', 'level', 'curriculum',
        'section', 'date', 'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}