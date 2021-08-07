<?php

namespace App\Models;

use CodeIgniter\Model;

class User_Mod extends Model
{
    protected $table = 'user';

    protected $allowedFields = ['IDuser','name','username','email','password','role','last_log'];
}