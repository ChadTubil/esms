<?php
namespace App\Models;
use \CodeIgniter\Model;

class ChartofAccountsModel extends Model 
{
    protected $table = 'chartofaccounts';
    protected $primaryKey = 'accountid';
    protected $allowedFields = [
        'accountcode', 'accountname', 'accounttype', 'parentaccountid', 'description',
        'isactive', 'createddate', 'isdel',
    ];
    protected $returnType = 'array';
    
}