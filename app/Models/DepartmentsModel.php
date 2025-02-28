<?php
namespace App\Models;
use \CodeIgniter\Model;

class DepartmentsModel extends Model 
{
    protected $table = 'departments';
    protected $primaryKey = 'deptid';
    protected $allowedFields = [
        'deptname', 'deptcode', 'deptisdel',
    ];
    protected $returnType = 'array';
    
}