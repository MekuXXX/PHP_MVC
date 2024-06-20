<?php

namespace App\Core;

class Response
{
 
  
  public function setStatusCode(int $statusCode)
  {
    http_response_code($statusCode);
  }
  
  public function redirect(string $path) 
  {
    // header("Location: " . $path); // Got error when use this
    echo sprintf('<meta http-equiv="refresh" content="0;url=%s" />', $path);
  }
}