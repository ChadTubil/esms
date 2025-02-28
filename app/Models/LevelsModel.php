<?php
namespace App\Models;
use \CodeIgniter\Model;

class LevelsModel extends Model 
{
    protected $table = 'levels';
    protected $primaryKey = 'levelid';
    protected $allowedFields = [
        'level', 'leveldeptid', 'levelisdel',
    ];
    protected $returnType = 'array';
    
}