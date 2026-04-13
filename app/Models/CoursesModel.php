<?php
namespace App\Models;
use \CodeIgniter\Model;

class CoursesModel extends Model 
{
    protected $table = 'courses';
    protected $primaryKey = 'courid';
    protected $allowedFields = [
        'code', 'name', 'isdel',
    ];
    protected $returnType = 'array';
    
}