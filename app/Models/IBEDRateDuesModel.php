<?php
namespace App\Models;
use \CodeIgniter\Model;

class IBEDRateDuesModel extends Model 
{
    protected $table = 'ratedues_ibed';
    protected $primaryKey = 'rdid';
    protected $allowedFields = [
        'rateid', 'name', 'due', 'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}