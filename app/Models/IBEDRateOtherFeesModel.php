<?php
namespace App\Models;
use \CodeIgniter\Model;

class IBEDRateOtherFeesModel extends Model 
{
    protected $table = 'rateotherfees_ibed';
    protected $primaryKey = 'rofid';
    protected $allowedFields = [
        'rateid', 'name', 'otherfees', 'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}