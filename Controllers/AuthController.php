<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Core\Request;
use App\Models\RegisterModel;

class AuthController extends Controller
{

  public function login()
  {
    return $this->render(view: 'auth/login');
  }

  public function register(Request $request)
  {
    $registerModel = new RegisterModel();
    if ($request->isPost())
    {
      $registerModel->loadData($request->getBody());
      if ($registerModel->validate() && $registerModel->register())
      {
        return "Register successfully";
      }

    }
    return $this->render('auth/register',params: [
      'model' => $registerModel
    ]);

  }

}

