<?php
namespace App\Models;
use \CodeIgniter\Model;

class SHSSubjectsModel extends Model 
{
    protected $table = 'subjects_shs';
    protected $primaryKey = 'subid';
    protected $allowedFields = [
        'code', 'subject', 'hours', 'prerequisite', 'type',
        'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}