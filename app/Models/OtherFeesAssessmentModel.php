<?php
namespace App\Models;
use \CodeIgniter\Model;

class OtherFeesAssessmentModel extends Model 
{
    protected $table = 'otherfeesassessment';
    protected $primaryKey = 'ofaid';
    protected $allowedFields = [
        'studno', 'ofid', 'price', 'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}