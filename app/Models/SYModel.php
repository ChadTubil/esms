<?php
namespace App\Models;
use \CodeIgniter\Model;

class SYModel extends Model 
{
    protected $table = 'sy';
    protected $primaryKey = 'syid';
    protected $allowedFields = [
        'syname', 'systatus', 'syisdel',
    ];
    protected $returnType = 'array';
    
}