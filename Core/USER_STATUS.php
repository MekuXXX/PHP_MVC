<?php
declare(strict_types=1);
namespace App\Core;

enum USER_STATUS 
{
  case ACTIVE;
  case INACTIVE;
  case DELETED;
  
  public function message(): int 
    {
      return match($this) 
      {
        USER_STATUS::DELETED => -1,
        USER_STATUS::INACTIVE => 0,
        USER_STATUS::ACTIVE => 1,
      };
    }
}