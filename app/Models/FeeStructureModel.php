<?php
namespace App\Models;
use \CodeIgniter\Model;

class FeeStructureModel extends Model 
{
    protected $table = 'feestructure';
    protected $primaryKey = 'feeid';
    protected $allowedFields = [
        'feecode', 'feename', 'feedescription', 'amount', 'accountid',
        'course', 'sy', 'semester', 'ismandatory', 'isactive',
        'createddate', 'isdel',
    ];
    protected $returnType = 'array';
    
}