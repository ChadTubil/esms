<?php
namespace App\Models;
use \CodeIgniter\Model;

class UniformsAssessmentModel extends Model 
{
    protected $table = 'uniformsassessment';
    protected $primaryKey = 'uniaid';
    protected $allowedFields = [
        'studentno', 'uniformid', 'qty', 'totalamount', 'transactionno', 'ornumber', 'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}