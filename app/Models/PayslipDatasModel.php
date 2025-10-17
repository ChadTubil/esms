<?php
namespace App\Models;
use \CodeIgniter\Model;

class PayslipDatasModel extends Model 
{
    protected $table = 'payslipdata';
    protected $primaryKey = 'payslipid';
    protected $allowedFields = [
        'cutoffdate',
        'employeeno', 'name', 'basicpay', 
        'unpaidabtard', 'unpaiddays', 'netbasicpay', 
        'advisoryclass', 'specialdesignation',
        'gs', 'jhs', 'college', 'shs', 'economic',
        'adjustmentOL', 'makeupclass', 'cpload', 'allowance', 'thesis',
        'ot', 'grossincome', 'sss', 'philhealth', 'pagibig',
        'peraa', 'absences', 'absencesOL', 'deductionOL', 'tax',
        'ssssalary', 'ssscalamity', 'mpl', 'pagibigcalamity', 'peraaloan',
        'advancestoemployees', 'cbsloan', 'otherdeduction', 'grossdeduction',
        'netpay', 'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}