<?php
namespace App\Models;
use \CodeIgniter\Model;

class COLFamilyBackgroundModel extends Model 
{
    protected $table = 'familybackground_col';
    protected $primaryKey = 'fbid';
    protected $allowedFields = [
        'studid', 'nfather', 'fmobile', 'fwork', 'femail',
        'foffice', 'nmother', 'mmobile', 'mwork', 'memail',
        'moffice', 'mstatus', 'misdel',
    ];
    protected $returnType = 'array';
    
}