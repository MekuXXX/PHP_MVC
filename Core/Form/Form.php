<?php

namespace App\Core\Form;

use App\Core\Model;
use App\Core\Form\FORM_TYPE;

class Form
{
  private Model $model;
  public function __construct(Model $model)
  {
    $this->model = $model;
  }

  public function begin(?string $action = "", ?string $method = 'get'): void 
  {
    echo sprintf('<form action="%s" method="%s" class="w-full flex flex-col gap-3">', $action, $method);
  }

  public function field(string $attribute, ?FORM_TYPE $type = FORM_TYPE::TEXT): FormField 
  {
    $field = new FormField($this->model, $attribute, $type);
    echo $field;
    return $field;
  }

  public function button(): void
  {
    echo sprintf('<button type="submit" class="bg-blue-600 text-white py-2 rounded-lg transition hover:opacity-[0.8]">Submit</button>');
  }

  public function end(): void 
  {
    echo "</form>";
  }
}
 