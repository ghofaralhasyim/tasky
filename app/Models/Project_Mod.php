<?php

namespace App\Models;

use CodeIgniter\Model;

class Project_Mod extends Model
{
    protected $table = 'project';

    protected $allowedFields = ['IDproject','name','IDleader','description'];
}