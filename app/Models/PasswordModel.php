<?php

namespace App\Models;

class PasswordModel extends \CodeIgniter\Model
{
  protected $table = 'passwords_twilio';

  protected $allowedFields = ['hashedPassword', 'lookUpID', 'attempts', 'expires_at'];

  protected $returnType = 'App\Entities\Pass';

  protected $useTimestamps = true;

  protected $validationRules = [
    'hashedPassword' => 'required'
  ];

  protected $validationMessages = [
    
  ];
}
