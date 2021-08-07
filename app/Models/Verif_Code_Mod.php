<?php

namespace App\Models;

use CodeIgniter\Model;

class Verif_Code_Mod extends Model
{
    protected $table = 'verification_code';

    protected $allowedFields = ['IDuser','code','description','type'];
}