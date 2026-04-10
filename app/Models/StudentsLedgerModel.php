<?php
namespace App\Models;
use \CodeIgniter\Model;

class StudentsLedgerModel extends Model 
{
    protected $table = 'studentledger';
    protected $primaryKey = 'ledgerid';
    protected $allowedFields = [
        'studentno', 'said', 'transactiondate', 'transactiontype', 'allocationid',
        'description', 'debit', 'credit', 'balance', 'createddate',
        'createdby', 'isdel',
    ];
    protected $returnType = 'array';
    
}