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

  public function upload(array $data, ?bool $multiple = false): string | array
  {
    if ($multiple) 
    {
      $filenames = [];
      foreach ($data as $file) 
      {
        $generatedFilename = $this->generateFilename($file['name']);
        move_uploaded_file($file['tmp_name'], Application::$app::$UPLOAD_FOLDER . $generatedFilename);
        array_push($filenames, $generatedFilename);
      }
      return $filenames;
    }
    else 
    {
      $generatedFilename = $this->generateFilename($data['name']);
      move_uploaded_file($data['tmp_name'], Application::$app::$UPLOAD_FOLDER . $generatedFilename);
      return $generatedFilename;
    }
  }

  public function clearBasename(string $basename): string
  {
      $basename = strtolower($basename);
      $filename = pathinfo($basename, PATHINFO_FILENAME);
      $filename = preg_replace('/[\/\\\\?%*:|"<> ]/', '_', $filename); 
      $extension = pathinfo($basename, PATHINFO_EXTENSION);
      
      return $filename . ($extension ? '.' . $extension : '');

  }

  public function generateFilename(string $basename): string
  {
      $clearedName = $this->clearBasename($basename);
      $uniqueId = uniqid();
      $timestamp = date('Y-m-d H:i:s');

      return "{$timestamp}_{$uniqueId}_{$clearedName}";
  }
}