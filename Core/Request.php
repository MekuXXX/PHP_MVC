<?php
declare(strict_types=1);
namespace App\Core;

class Request
{

  public function getPath(): string 
  {
    $path = $_SERVER['REQUEST_URI'] ?? '/';
    return explode('?', $path)[0];
  }

  public function getMethod(): string 
  {
    return strtolower($_SERVER['REQUEST_METHOD']) ?? 'get';
  }

  public function getBody(): array
  {
    $body = [];
    
    if ($this->getMethod() == 'get')
    {
      foreach ($_GET as $key => $_)
      {
        $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
      }
    }
    else if ($this->getMethod() == 'post')
    {
      foreach ($_POST as $key => $_)
      {
        $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
      }
      
      if (!empty($_FILES)) {
        foreach ($_FILES as $key => $data) 
        {
          $body[$key] = $data; 
        }
      }
      
    }

    return $body;
  }

  public function isGet(): bool
  {
    return $this->getMethod() === 'get';
  }

  public function isPost(): bool 
  {
    return $this->getMethod() === 'post';
  }

}