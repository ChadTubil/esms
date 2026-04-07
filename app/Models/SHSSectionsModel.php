<?php
namespace App\Models;
use \CodeIgniter\Model;

class SHSSectionsModel extends Model 
{
    protected $table = 'sections_shs';
    protected $primaryKey = 'secid';
    protected $allowedFields = [
        'section', 'sy', 'level', 'cluster', 'status',
        'isdel',
    ];
    protected $returnType = 'array';
    
}