<?php
namespace App\Models;
use \CodeIgniter\Model;

class SHSSchoolRecordModel extends Model 
{
    protected $table = 'shsstudentschoolrecord';
    protected $primaryKey = 'ssrid';
    protected $allowedFields = [
        'studid', 'lrn', 'sy', 'level', 'cluster', 'status',
    ];
    protected $returnType = 'array';
    
}