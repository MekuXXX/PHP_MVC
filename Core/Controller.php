<?php

declare(strict_types=1);
namespace App\Core;

class Controller
{
  private View $view;
  
  public function __construct()
  {
    $this->view = new View();
  }
  public function render(string $view,?array $params = [],?string $layout = null): string
  {
    return $this->view->renderView(view: $view,layout: $layout,params: $params);
  }
}