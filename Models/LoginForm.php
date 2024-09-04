<?php

namespace App\Models;
use App\Core\Model;
use App\Core\RULE;

class LoginForm extends Model
{
    public string $email;
    public string $password;
    
    public function rules(): array
    {
        return [
            'email' => [RULE::EMAIL],
            'password' => [RULE::REQUIRED]
        ];
    }

    public function login()
    {
        // $user = User::findOne(['email', $this->email]);

        // if (!$user)
        // {
        //     $this->addError('email', "User is not exist");
        // }
    }
}