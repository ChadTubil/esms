<?php
namespace App\Models;
use \CodeIgniter\Model;

class SectionsModel extends Model 
{
    protected $table = 'sections';
    protected $primaryKey = 'secid';
    protected $allowedFields = [
        'section', 'level', 'sy', 'sem', 'course',
        'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}