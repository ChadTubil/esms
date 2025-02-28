<?php
namespace App\Models;
use \CodeIgniter\Model;

class SubjectsModel extends Model 
{
    protected $table = 'subjects';
    protected $primaryKey = 'subid';
    protected $allowedFields = [
        'subject', 'subcode', 'subunits', 'substatus', 'subisdel',
    ];
    protected $returnType = 'array';
    
}