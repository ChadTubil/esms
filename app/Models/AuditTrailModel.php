<?php
namespace App\Models;
use \CodeIgniter\Model;

class AuditTrailModel extends Model 
{
    protected $table = 'audittrail';
    protected $primaryKey = 'atid';
    protected $allowedFields = [
        'uid', 'action', 'message',
        'date', 'time',
    ];
    protected $returnType = 'array';
    
}