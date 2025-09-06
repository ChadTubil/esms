<?php
namespace App\Models;
use \CodeIgniter\Model;

class StudentCurriculumModel extends Model 
{
    protected $table = 'studentcurriculum';
    protected $primaryKey = 'scid';
    protected $allowedFields = [
        'studentno', 'currid', 'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}