<?php
namespace App\Models;
use \CodeIgniter\Model;

class IBEDRatesModel extends Model 
{
    protected $table = 'rates_ibed';
    protected $primaryKey = 'rateid';
    protected $allowedFields = [
        'sy', 'level', 'tf', 'status', 
        'isdel',
    ];
    protected $returnType = 'array';
    
}