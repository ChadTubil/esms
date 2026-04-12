<?php
namespace App\Models;
use \CodeIgniter\Model;

class IBEDSectionsModel extends Model 
{
    protected $table = 'sections_ibed';
    protected $primaryKey = 'secid';
    protected $allowedFields = [
        'section', 'sy', 'level',
        'isdel',
    ];
    protected $returnType = 'array';
    
}