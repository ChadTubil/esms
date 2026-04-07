<?php
namespace App\Models;
use \CodeIgniter\Model;

class SHSRateOtherFeesModel extends Model 
{
    protected $table = 'rateotherfees_shs';
    protected $primaryKey = 'rofid';
    protected $allowedFields = [
        'rateid', 'name', 'otherfees', 'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}