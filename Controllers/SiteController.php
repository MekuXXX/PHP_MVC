<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\ExerciseForm;

class SiteController extends Controller
{

  public function home()
  { 
    $params = [
      'name' => "Mayushi"
    ];

    return $this->render(view: 'home', params: $params);
  }

  public static function handleContact(Request $request)
  {
    $body = $request->getBody();
    var_dump($body);
    return "Handle from controller";
  }
  
  public function exercise(Request $req, Response $res) 
  {
    $model = new ExerciseForm();


    if ($req->isPost()) 
    {
      $model->loadData($req->getBody());

      if ($model->validate()) 
      {
        $filename = $this->upload($model->file);
        if ($filename) {
          Application::$app->session->setFlash('success', "Thanks for uploading the file!!");
          Application::$app->response->redirect('/preview?file='.$filename);
          exit;
        }
      }
    }
    return $this->render(view: "exercise/upload", params: [
      'model' => $model
    ]);
  }
}