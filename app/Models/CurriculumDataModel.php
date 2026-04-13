<?php
namespace App\Models;
use \CodeIgniter\Model;

class CurriculumDataModel extends Model 
{
    protected $table = 'currdata';
    protected $primaryKey = 'cdid';
    protected $allowedFields = [
        'curriculumid', 'subid', 'level', 'sem',
        'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}