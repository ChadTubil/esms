<?php
namespace App\Models;
use \CodeIgniter\Model;

class DiscountsModel extends Model 
{
    protected $table = 'discount';
    protected $primaryKey = 'discountid';
    protected $allowedFields = [
        'studentno', 'discounttype', 'discountname', 'discountpercentage', 'discountamount',
        'feetype', 'startdate', 'enddate', 'terms', 'approvedby',
        'status', 'createddate', 'isdel',
    ];
    protected $returnType = 'array';
    
}