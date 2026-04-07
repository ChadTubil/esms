<?php
namespace App\Models;
use \CodeIgniter\Model;

class SHSRateDuesModel extends Model 
{
    protected $table = 'ratedues_shs';
    protected $primaryKey = 'rdid';
    protected $allowedFields = [
        'rateid', 'name', 'due', 'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}