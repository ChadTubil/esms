<?php
namespace App\Models;
use \CodeIgniter\Model;

class AssessmentModel extends Model 
{
    protected $table = 'assessment';
    protected $primaryKey = 'assessmentid';
    protected $allowedFields = [
        'asstudentno', 'assy', 'assem',
        'asscourse', 'asslevel', 'asstatus', 'assisdel',
    ];
    protected $returnType = 'array';
    
}