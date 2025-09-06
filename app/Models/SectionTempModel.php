<?php
namespace App\Models;
use \CodeIgniter\Model;

class SectionTempModel extends Model 
{
    protected $table = 'sectiontemp';
    protected $primaryKey = 'stid';
    protected $allowedFields = [
        'section', 'schedid',
    ];
    protected $returnType = 'array';
    
}