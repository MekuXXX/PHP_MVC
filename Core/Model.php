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
        else if ($rulename === RULE::SIZE) {
          if ($value['size'] > $rule['size']){
            $this->addErrorForRule($attribute, RULE::SIZE, "2 MB");
          }
        }
        else if ($rulename === RULE::EXTENSION) {
          $fileExt = pathinfo($value['name'], PATHINFO_EXTENSION);

          if (!in_array($fileExt, $rule['extensions'])) {
            $this->addErrorForRule($attribute, RULE::EXTENSION, implode(", ", $rule['extensions']));
          }
        }
        else if ($rulename === RULE::FILE) 
        {
          switch ($value['error']) 
          {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
              $this->addErrorForRule($attribute, RULE::SIZE, "2 M");
            case UPLOAD_ERR_PARTIAL:
              $this->addErrorForRule($attribute, RULE::FILE, "There is an error that the file is partially uploaded");
            case UPLOAD_ERR_NO_FILE:
              $this->addErrorForRule($attribute, RULE::FILE, "There is no file uploaded");
            case UPLOAD_ERR_NO_TMP_DIR:
              $this->addErrorForRule($attribute, RULE::FILE, "Error with the uploading directory");
            case UPLOAD_ERR_CANT_WRITE:
              $this->addErrorForRule($attribute, RULE::FILE, "There is no permision to write this file");
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