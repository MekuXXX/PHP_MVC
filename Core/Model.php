<?php
declare(strict_types=1);
namespace App\Core;

abstract class Model
{
  public array $errors = [];

  public function loadData(array $data)
  {
    foreach ($data as $key => $value)
    {
      if (property_exists($this, $key))
      {
        $this->{$key} = $value;
      }
    }
  }

  abstract protected function rules(): array;


  public function validate(): bool
  {
    foreach ($this->rules() as $attribute => $rules)
    {
      $value = $this->{$attribute};
      foreach ($rules as $rule)
      {
        $rulename = $rule;
        if (is_array($rule))
        {
          $rulename = $rule[0];
        }

        if ($rulename === RULE::REQUIRED && !$value)
        {
          $this->addError($attribute, RULE::REQUIRED);
        }
        
        if ($rulename == RULE::EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL))
        {
          $this->addError($attribute, RULE::EMAIL);
        }

        if ($rulename == RULE::MIN_LENGTH && strlen($value) < $rule[1])
        {
          $this->addError($attribute, RULE::MIN_LENGTH, $rule[1]);
        }

        if ($rulename == RULE::MAX_LENGTH && strlen($value) > $rule[1])
        {
          $this->addError($attribute, RULE::MAX_LENGTH, $rule[1]);
        }

        if ($rulename == RULE::MATCH && $this->{$rule[1]} !== $value)
        {
          $this->addError($attribute, RULE::MATCH, $rule[1]);
        }
      }
    }
    return empty($this->errors);
  }

  public function addError(string $attribute, RULE $rule, string | int $placeholder = null)
  {
    $message = $rule->message() ?? "";

    if ($placeholder)
    {
      $message = preg_replace('/\{\{(.*?)\}\}/',"$placeholder", $message);
    }

    $this->errors[$attribute][] = $message;
  }

  public function hasError(string $attr): bool
  {
    return isset($this->errors[$attr]);
  }

  public function getFirstError(string $attr): string
  {
    return $this->errors[$attr][0];
  }
}
