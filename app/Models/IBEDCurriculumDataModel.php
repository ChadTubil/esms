<?php
namespace App\Models;
use \CodeIgniter\Model;

class IBEDCurriculumDataModel extends Model 
{
    protected $table = 'currdata_ibed';
    protected $primaryKey = 'cdid';
    protected $allowedFields = [
        'curriculumid', 'subid', 'level',
        'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}