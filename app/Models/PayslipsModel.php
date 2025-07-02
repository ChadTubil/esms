<?php
namespace App\Models;
use \CodeIgniter\Model;

class PayslipsModel extends Model 
{
    protected $table = 'payslip';
    protected $primaryKey = 'cutoffid';
    protected $allowedFields = [
        'cutoffdate', 'file', 'description', 'createdat', 'status',
        'isdel',
    ];
    protected $returnType = 'array';
    
}