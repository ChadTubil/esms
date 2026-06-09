<?php
namespace App\Models;
use \CodeIgniter\Model;

class StudentOtherBillsModel extends Model 
{
    protected $table = 'studotherbills';
    protected $primaryKey = 'sobid';
    protected $allowedFields = [
        'studno', 'name', 'totalamount', 'tablename', 'id', 'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}