<?php

declare(strict_types=1);
namespace App\Core;

class Router
{
  public static string $NOT_FOUND = 'errors/404NotFound';
  protected array $routes = [];
  protected Request $request;
  protected Controller $controller;

  public function __construct() 
  {  
    $this->request = new Request();
    $this->controller = new Controller();
  }

  public function resolve() 
  {
    $method = $this->request->getMethod();
    $path = $this->request->getPath();
    $callback = $this->routes[$method][$path] ?? self::$NOT_FOUND;

    if (self::$NOT_FOUND === $callback)
    {
      Application::$app->response->setStatusCode(404);
    }
    
    if (is_string($callback)) 
    {
      return $this->controller->render(trim($callback));
    }

    if (is_array($callback))
    {
      $callback[0] = new $callback[0]();
    }

    return call_user_func($callback, $this->request);
  }

  public function get(string $path, callable | string | array $callback) 
  {
    $this->routes['get'][$path] = $callback;
  }


  public function post(string $path, callable | array $callback) 
  {
    $this->routes['post'][$path] = $callback;
  }
}
