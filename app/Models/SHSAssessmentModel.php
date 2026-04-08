<?php
namespace App\Models;
use \CodeIgniter\Model;

class SHSAssessmentModel extends Model 
{
    protected $table = 'assessment_shs';
    protected $primaryKey = 'assid';
    protected $allowedFields = [
        'studid', 'sy', 'level', 'cluster', 'curriculum',
        'section', 'date', 'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}