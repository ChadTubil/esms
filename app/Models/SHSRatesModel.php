<?php
namespace App\Models;
use \CodeIgniter\Model;

class SHSRatesModel extends Model 
{
    protected $table = 'rates_shs';
    protected $primaryKey = 'rateid';
    protected $allowedFields = [
        'sy', 'level', 'cluster', 'tf', 'status', 
        'isdel',
    ];
    protected $returnType = 'array';
    
}