<?php

namespace App\Models;

use CodeIgniter\Model;

class Inv_mod extends Model
{
    protected $table = 'invitation';

    protected $allowedFields = ['IDinvite','IDuser','IDproject','status'];
}