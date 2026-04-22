<?php
namespace App\Models;
use \CodeIgniter\Model;

class RatesModel extends Model 
{
    protected $table = 'rates';
    protected $primaryKey = 'rateid';
    protected $allowedFields = [
        'sy', 'sem', 'course', 'year', 'major', 'minor',
        'nstp01', 'nstp02', 'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}