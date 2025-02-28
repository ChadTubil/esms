<?php
namespace App\Models;
use \CodeIgniter\Model;

class CoursesModel extends Model 
{
    protected $table = 'courses';
    protected $primaryKey = 'courid';
    protected $allowedFields = [
        'courcode', 'course', 'courisdel',
    ];
    protected $returnType = 'array';
    
}