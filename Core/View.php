<?php

declare(strict_types=1);
namespace App\Core;

class View
{
  private string $DEFAULT_LAYOUT = "_layout";
  private string $DEFAULT_PAGE = "_page";

  protected function addPrefix(string $view) 
  {
    return str_contains($view, '.php') ? $view : "$view.php";
  }
  
  protected function readTemplate(string $view, array $params = []): string
  {
    foreach ($params as $key => $value)
    {
      $$key = $value;
    }

    ob_start();
    include_once Application::$ROOT_VIEW_DIR . $this->addPrefix($view);
    return ob_get_clean();
  }

  protected function checkDefaultLayout(string $path): string
  {
    $pathArray = explode("/", $path);
    $pathLen = count($pathArray);
    $nearLayout = implode("/", array_slice($pathArray, 0, $pathLen - 1)) . '/' . $this->addPrefix($this->DEFAULT_LAYOUT);
   
    // Check is the file is alone or it is a directory
    if (file_exists(Application::$ROOT_VIEW_DIR . $this->addPrefix($path)))
    {
      // Check if there is a default layout next to the file
      if (file_exists(Application::$ROOT_VIEW_DIR . $nearLayout)) 
      {
        return $nearLayout;
      }
    }
    else 
    {
      // Check if the directory has a default layout file
      if (is_dir(Application::$ROOT_VIEW_DIR . $path) && file_exists(Application::$ROOT_VIEW_DIR . $path . '/' . $this->addPrefix($this->DEFAULT_LAYOUT)))
      {
        return $path . '/' . $this->DEFAULT_LAYOUT;
      }
    }

   // To get the layout from top of the tree to the bottom 
    for ($i = $pathLen - 2; $i >= 0; --$i)
    {
      
      $filePath = implode("/", array_slice($pathArray, 0, $i + 1)) . '/' . $this->DEFAULT_LAYOUT;
      if (file_exists(Application::$ROOT_VIEW_DIR . $filePath))
      {
        return $filePath;
      }
    }
    
    return $this->DEFAULT_LAYOUT;
  }
  
  public function renderView(string $view,?array $params = [], ?string $layout = null): string
  {
    
    // To get the layout from the view path if the layout is not specified
    if (is_null($layout)) 
    {
      $layout = $this->checkDefaultLayout($view);
    }
    // To get layout if the layout is specified as directory and the file not exist
    else if (is_dir(Application::$ROOT_VIEW_DIR . $layout) && !file_exists(Application::$ROOT_VIEW_DIR . $this->addPrefix($layout)))
    {
      $layout = $view . '/' . $this->DEFAULT_LAYOUT;
    }
    
    // To get the view if client use directory path if the file not exist
    if (is_dir(Application::$ROOT_VIEW_DIR . $view) && !file_exists(Application::$ROOT_VIEW_DIR . $this->addPrefix($view)) )
    {
      $view = $view . '/' . $this->DEFAULT_PAGE;
    }
    
    $layoutTemplate = $this->readTemplate($layout); 
    $pageTemplate = $this->readTemplate($view, $params);
    return preg_replace('/\{\{\s*content\s*\}\}/', $pageTemplate, $layoutTemplate);
  }
}