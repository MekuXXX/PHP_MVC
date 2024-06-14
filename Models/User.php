<?php
declare(strict_types=1);
namespace App\Models;
use App\Core\DBModel;
use App\Core\Rule;
use App\Core\USER_STATUS;

class User extends DBModel 
{
  
  public string $first_name;
  public string $last_name; 
  public string $email;
  public string $password;
  public string $repeat_password;

  public int $status;
  
  public function __construct()
  {
    $this->status = USER_STATUS::INACTIVE->message();
  }
  
  
  public function save(): bool
  {
    $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    return parent::save();
  }
  
  public function tableName(): string
  {
    return "users";
  }
  
  public function attributes(): array
  {
    return [
      'first_name',
      'last_name',
      'email',
      'password',
      'status'
    ];
  }

  protected function rules(): array
  {
    return [
      'first_name' => [RULE::REQUIRED, [RULE::MAX_LENGTH, 12]],
      'last_name' => [RULE::REQUIRED, [RULE::MAX_LENGTH, 12]],
      'email' => [RULE::EMAIL],
      'password' => [RULE::REQUIRED, [RULE::MIN_LENGTH, 8]],
      'repeat_password' => [RULE::REQUIRED, [RULE::MATCH, 'password']],
    ];
  } 
}