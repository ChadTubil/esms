<?php
namespace App\Models;
use \CodeIgniter\Model;

class SHSFamilyBackgroundModel extends Model 
{
    protected $table = 'familybackground_shs';
    protected $primaryKey = 'fbid';
    protected $allowedFields = [
        'studid', 'nfather', 'fmobile', 'fwork', 'femail',
        'foffice', 'nmother', 'mmobile', 'mwork', 'memail',
        'moffice', 'mstatus', 'misdel',
    ];
    protected $returnType = 'array';
    
}