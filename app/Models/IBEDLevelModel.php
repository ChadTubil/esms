<?php
namespace App\Models;
use \CodeIgniter\Model;

class IBEDLevelModel extends Model 
{
    protected $table = 'ibedlevel';
    protected $primaryKey = 'ibedlvlid';
    protected $allowedFields = [
        'code', 'name', 'isdel',
    ];
    protected $returnType = 'array';
    
}