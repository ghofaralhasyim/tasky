<?php

namespace App\Models;

use CodeIgniter\Model;

class Task_Mod extends Model
{
    protected $table = 'task';

    protected $allowedFields = ['IDtask','IDproject','title','description','deadline','status'];
}