<?php
namespace App\Models;
use \CodeIgniter\Model;

class SHSCurriculumModel extends Model 
{
    protected $table = 'curriculum_shs';
    protected $primaryKey = 'currid';
    protected $allowedFields = [
        'cluster', 'sy', 'level', 'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}