<?php
namespace App\Models;
use \CodeIgniter\Model;

class SHSCurriculumDataModel extends Model 
{
    protected $table = 'currdata_shs';
    protected $primaryKey = 'cdid';
    protected $allowedFields = [
        'curriculumid', 'subid', 'level', 'sem','prerequisite', 
        'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}