<?php
namespace App\Models;
use \CodeIgniter\Model;

class EmployeesModel extends Model 
{
    protected $table = 'employees';
    protected $primaryKey = 'empid';
    protected $allowedFields = [
        'empnum', 'impno', 'empfn', 'empmn', 'empln', 'empextension',
        'empfullname', 'emphiringdate', 'empresignationdate', 'empposition', 
        'rfidno', 'image', 'empstatus', 'empisdel',
    ];
    protected $returnType = 'array';
    
}