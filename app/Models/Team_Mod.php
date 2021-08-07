<?php

namespace App\Models;

use CodeIgniter\Model;

class Team_Mod extends Model
{
    protected $table = 'team';

    protected $allowedFields = ['IDteam','IDuser','IDproject','role'];
}