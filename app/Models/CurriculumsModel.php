<?php
namespace App\Models;
use \CodeIgniter\Model;

class CurriculumsModel extends Model 
{
    protected $table = 'curriculum';
    protected $primaryKey = 'currid';
    protected $allowedFields = [
        'course', 'sy', 'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}