<?php
namespace App\Models;
use \CodeIgniter\Model;

class CurriculumDataModel extends Model 
{
    protected $table = 'currdata';
    protected $primaryKey = 'cdid';
    protected $allowedFields = [
        'curriculumid', 'grade', 'subjectsid', 'level', 'sem',
        'prerequisite', 'pregrade', 'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}