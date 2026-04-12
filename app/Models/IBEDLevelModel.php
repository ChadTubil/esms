<?php
namespace App\Models;
use \CodeIgniter\Model;

class IBEDLevelModel extends Model 
{
    protected $table = 'levels_ibed';
    protected $primaryKey = 'levelid';
    protected $allowedFields = [
        'code', 'name', 'isdel',
    ];
    protected $returnType = 'array';
    
}