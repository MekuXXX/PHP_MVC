<?php
declare(strict_types=1);
namespace App\Models;
use App\Core\Model;
use App\Core\Rule;

class RegisterModel extends Model
{
  
  public string $first_name;
  public string $last_name; 
  public string $email;
  public string $password;
  public string $repeat_password;
  
  public function register()
  {
    echo "Nothing";
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
