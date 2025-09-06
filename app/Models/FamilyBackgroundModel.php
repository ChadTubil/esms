<?php
namespace App\Models;
use \CodeIgniter\Model;

class FamilyBackgroundModel extends Model 
{
    protected $table = 'familybackground';
    protected $primaryKey = 'fbid';
    protected $allowedFields = [
        'studid', 'nfather', 'fmobile', 'fwork', 'femail',
        'foffice', 'nmother', 'mmobile', 'mwork', 'memail',
        'moffice', 'mstatus', 'misdel',
    ];
    protected $returnType = 'array';
    
}