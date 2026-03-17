<?php
namespace App\Models;
use \CodeIgniter\Model;

class PaymentAllocationModel extends Model 
{
    protected $table = 'paymentallocation';
    protected $primaryKey = 'allocationid';
    protected $allowedFields = [
        'paymentid', 'sadid', 'amountallocated', 'allocatteddate', 'allocatedby',
        'isdel',
    ];
    protected $returnType = 'array';
    
}