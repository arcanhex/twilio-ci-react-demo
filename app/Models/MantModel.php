<?php

namespace App\Models;

class MantModel extends \CodeIgniter\Model
{
  protected $table = 'mant';

  protected $allowedFields = ['fullName', 'phoneNumber', 'filterType', 'retired', 'isSent', 'created_at', 'updated_at'];

  protected $returnType = 'App\Entities\Mant';

  protected $useTimestamps = true;

  protected $validationRules = [
    'fullName' => 'required|alpha_space',
    'phoneNumber' => 'required|is_natural|exact_length[10]|is_unique[mant.phoneNumber]',
    'filterType' => 'required'
  ];

  protected $validationMessages = [
    'fullName' => [
      'required' => 'Name is required',
      'alpha_space' => 'Only letters and spaces are accepted'
    ],
    'phoneNumber' => [
      'required' => 'Phone number is required',
      'is_natural' => 'Only numbers are valid',
      'exact_length' => 'You can only enter numbers of 10 digits',
      'is_unique' => 'Phone is already registered'
    ],
    'filterType' => [
      'required' => 'Filter type is required'
    ]
  ];
}
