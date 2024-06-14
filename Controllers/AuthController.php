<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Core\Request;
use App\Models\User;

class AuthController extends Controller
{

  public function login()
  {
    return $this->render(view: 'auth/login');
  }

  public function register(Request $request)
  {
    $user = new User();
    if ($request->isPost())
    {
      $user->loadData($request->getBody());
      
      if ($user->validate() && $user->save())
      {
        return "Register successfully";
      }

    }
    
    return $this->render('auth/register', params: [
      'model' => $user
    ]);

  }

}