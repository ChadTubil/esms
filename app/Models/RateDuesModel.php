<?php
namespace App\Models;
use \CodeIgniter\Model;

class RateDuesModel extends Model 
{
    protected $table = 'ratedues';
    protected $primaryKey = 'rdid';
    protected $allowedFields = [
        'rateid', 'name', 'due', 'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}