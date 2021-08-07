<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskHistory_Mod extends Model
{
    protected $table = 'taskhistory';

    protected $allowedFields = ['IDtask','IDuser','activity','description'];
}