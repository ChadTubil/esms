<?php
namespace App\Models;
use \CodeIgniter\Model;

class IBEDSchoolRecordModel extends Model 
{
    protected $table = 'ibedstudentschoolrecord';
    protected $primaryKey = 'ssrid';
    protected $allowedFields = [
        'studid', 'sy', 'level', 'status',
    ];
    protected $returnType = 'array';
    
}