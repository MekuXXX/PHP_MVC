<?php

namespace App\Models;
use App\Core\Model;
use App\Core\RULE;

class ExerciseForm extends Model
{
  public $file;
  function rules(): array 
  {
    return [
      'file' => [RULE::REQUIRED, RULE::FILE, [RULE::EXTENSION, 'extensions' => ['csv']], [RULE::SIZE, 'size' => 2097152]]
    ];
  }
  
  function labels(): array 
  {
    return [
      'file' => "CSV File"
    ];
  }
}