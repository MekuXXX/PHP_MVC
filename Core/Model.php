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
          $this->addErrorForRule($attribute, RULE::REQUIRED);
        }
        else if ($rulename == RULE::EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL))
        {
          $this->addErrorForRule($attribute, RULE::EMAIL);
        }
        else if ($rulename == RULE::MIN_LENGTH && strlen($value) < $rule[1])
        {
          $this->addErrorForRule($attribute, RULE::MIN_LENGTH, $rule[1]);
        }
        elseif ($rulename == RULE::MAX_LENGTH && strlen($value) > $rule[1])
        {
          $this->addErrorForRule($attribute, RULE::MAX_LENGTH, $rule[1]);
        }
        else if ($rulename == RULE::MATCH && $this->{$rule[1]} !== $value)
        {
          $this->addErrorForRule($attribute, RULE::MATCH, $this->getLabel($rule[1]));
        }
        else if ($rulename === RULE::UNIQUE) 
        {
          $className = $rule['class'];
          $uniqueAttr = $rule['attribute'] ?? $attribute;
          $tableName = $className::tableName();
          $statement = Database::prepare("Select * FROM $tableName WHERE $uniqueAttr = :attr");
          $statement->bindValue(":attr", $value);
          $statement->execute();
          
          $recod = $statement->fetchObject();
          if ($recod) {
            $this->addErrorForRule($attribute, RULE::UNIQUE, $attribute);
          }
        }
        
      }
    }
    return empty($this->errors);
  }

  public function labels(): array
  {
    return [];
  }
  
  public function getLabel(string $attribute): string
  {
    return $this->labels()[$attribute] ?? $attribute;
  }

  private function addErrorForRule(string $attribute, RULE $rule, string | int $placeholder = null)
  {
    $message = $rule->message() ?? "";

    if ($placeholder)
    {
      $message = preg_replace('/\{\{(.*?)\}\}/',"$placeholder", $message);
    }

    $this->errors[$attribute][] = $message;
  }
  
  function addError(string $attribute, string $message)
  {
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