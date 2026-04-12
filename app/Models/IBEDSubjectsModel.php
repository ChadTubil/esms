<?php
namespace App\Models;
use \CodeIgniter\Model;

class IBEDSubjectsModel extends Model 
{
    protected $table = 'subjects_ibed';
    protected $primaryKey = 'subid';
    protected $allowedFields = [
        'code', 'subject', 
        'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}