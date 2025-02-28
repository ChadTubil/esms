<?php
namespace App\Models;
use \CodeIgniter\Model;

class SemesterModel extends Model 
{
    protected $table = 'semester';
    protected $primaryKey = 'semid';
    protected $allowedFields = [
        'semester', 'semstatus', 'semisdel',
    ];
    protected $returnType = 'array';
    
}