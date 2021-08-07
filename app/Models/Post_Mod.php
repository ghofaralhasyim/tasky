<?php

namespace App\Models;

use CodeIgniter\Model;

class Post_Mod extends Model
{
    protected $table = 'post';

    protected $allowedFields = ['IDpost','IDuser','IDproject','content','date'];
}