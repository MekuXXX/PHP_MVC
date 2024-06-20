<?php
declare(strict_types=1);
namespace App\Core;

enum RULE
{
  case REQUIRED;
  case EMAIL;
  case UNIQUE;
  case MAX_LENGTH;
  case MIN_LENGTH;
  case MATCH;

  public function message(): string
    {
      return match($this) 
      {
        RULE::REQUIRED => "This field is required",
        RULE::EMAIL => "This field must be a valid email address",
        RULE::MIN_LENGTH => "This field must be at least {{min}} characters",
        RULE::MAX_LENGTH => "This field must be at most {{max}} characters",
        RULE::MATCH => "This field must be same as the {{match}}",
        RULE::UNIQUE => "This {{placeholder}} is used before"
      };
    }
}