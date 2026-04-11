<?php
namespace App\Models;
use \CodeIgniter\Model;

class SchoolLedgerModel extends Model 
{
    protected $table = 'schoolledger';
    protected $primaryKey = 'schoolledgerid';
    protected $allowedFields = [
        'said', 'transactiondate', 'transactiontype',
        'description', 'debit', 'credit', 'balance',
        'createdby', 'isdel',
    ];
    protected $returnType = 'array';
    
}