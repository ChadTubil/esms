<?php
namespace App\Models;
use \CodeIgniter\Model;

class RateOtherFeesModel extends Model 
{
    protected $table = 'rateotherfees';
    protected $primaryKey = 'rofid';
    protected $allowedFields = [
        'rateid', 'name', 'otherfees', 'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}