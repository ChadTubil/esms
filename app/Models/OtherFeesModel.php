<?php
namespace App\Models;
use \CodeIgniter\Model;

class OtherFeesModel extends Model 
{
    protected $table = 'otherfees';
    protected $primaryKey = 'ofid';
    protected $allowedFields = [
        'name', 'price', 'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}