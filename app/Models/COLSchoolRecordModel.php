<?php
namespace App\Models;
use \CodeIgniter\Model;

class COLSchoolRecordModel extends Model 
{
    protected $table = 'colstudentschoolrecord';
    protected $primaryKey = 'ssrid';
    protected $allowedFields = [
        'studid', 'sy', 'level', 'sem', 'course', 'status',
    ];
    protected $returnType = 'array';
    
}