<?php
namespace App\Validation;

class Custom_validation{
  public $length;

  public $lengthCheck = false;

  public $numericCheck = false;
  
  public function pass_check(string $str,string $length, array $data, string &$error = null){
    $this->lengthCheck = strlen($str) >= $this->length;
    if ($this->lengthCheck && preg_match('/[0-9]/', $str))
    {
        return true;
    }
    $error = "Password must be at least {$length} character and must containt at least one number";
    return false;
  }

  public function char_only(string $str, string &$error = null)
  {
    if(!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $str))
      {
        return true;
      }
      return false;
  }
}