<?php
namespace App\Models;
use \CodeIgniter\Model;

class PermanentRecordModel extends Model 
{
    protected $table = 'permanentrecord';
    protected $primaryKey = 'prid';
    protected $allowedFields = [
        'studid', 'eschool', 'eyeargraduate',
        'jhschool', 'jhyeargraduate', 'shschool', 'shyeargraduate',
    ];
    protected $returnType = 'array';
    
}