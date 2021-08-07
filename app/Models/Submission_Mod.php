<?php

namespace App\Models;

use CodeIgniter\Model;

class Submission_mod extends Model
{
    protected $table = 'submission';
    
    protected $primaryKey = 'IDsubmission';
    protected $allowedFields = ['IDsubmission','IDtask','file'];
}