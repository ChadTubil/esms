<?php
namespace App\Models;
use \CodeIgniter\Model;

class IBEDCurriculumModel extends Model 
{
    protected $table = 'curriculum_ibed';
    protected $primaryKey = 'currid';
    protected $allowedFields = [
        'level', 'sy', 'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}