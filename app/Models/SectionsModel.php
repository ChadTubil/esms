<?php
namespace App\Models;
use \CodeIgniter\Model;

class SectionsModel extends Model 
{
    protected $table = 'sections';
    protected $primaryKey = 'secid';
    protected $allowedFields = [
        'section', 'seclevelid', 'secsyid', 'secsemid', 'seccourid',
        'secstatus', 'secisdel',
    ];
    protected $returnType = 'array';
    
}