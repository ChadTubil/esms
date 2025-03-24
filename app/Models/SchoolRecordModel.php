<?php
namespace App\Models;
use \CodeIgniter\Model;

class SchoolRecordModel extends Model 
{
    protected $table = 'studentschoolrecord';
    protected $primaryKey = 'ssrid';
    protected $allowedFields = [
        'srsy', 'srsem', 'srlevel', 'srstudid',
        'srirregular', 'srcourseid', 'srmajor', 'srstatus',
    ];
    protected $returnType = 'array';
    
}