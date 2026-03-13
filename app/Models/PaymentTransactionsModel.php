<?php
namespace App\Models;
use \CodeIgniter\Model;

class PaymentTransactionsModel extends Model 
{
    protected $table = 'paymenttransactions';
    protected $primaryKey = 'paymentid ';
    protected $allowedFields = [
        'paymentreference', 'studentno', 'studfullname', 'accountno', 'paymentdate', 'paymenttime',
        'paymentmethod', 'checknumber', 'checkdate', 'bankname', 'amountpaid',
        'particulars', 'receivedby', 'ornumber', 'paymentstatus', 'createddate',
        'isdel',
    ];
    protected $returnType = 'array';
    
}