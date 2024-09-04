<?php

namespace App\Core\Form;

enum FORM_TYPE
{
  case TEXT;
  case EMAIL;
  case PASSWORD;
  case NUMBER;
  case DATE;
  case FILE;
  case MULTIPLE_FILES;

  public function type(): string
  {
    return match($this)
    {
      self::TEXT => 'text',
      self::EMAIL => 'email',
      self::PASSWORD => 'password',
      self::NUMBER => 'number',
      self::DATE => 'date',
      self::FILE => 'file',
      self::MULTIPLE_FILES => 'file'
    };
  }
}