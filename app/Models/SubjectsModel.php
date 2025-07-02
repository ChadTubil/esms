<?php
namespace App\Models;
use \CodeIgniter\Model;

class SubjectsModel extends Model 
{
    protected $table = 'subjects';
    protected $primaryKey = 'subid';
    protected $allowedFields = [
        'subcode', 'subject', 'lechours', 'labhours', 'hours',
        'lecunits', 'labunits', 'units', 'major', 'prerequisite',
        'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}