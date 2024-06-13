<?php

declare(strict_types=1);

namespace App\Core;
use App\Core\Router;
use App\Core\Request;
use App\Core\Response;

class Application
{
  public static Application $app;
  public static string $ROOT_DIR;
  public static string $ROOT_VIEW_DIR;
  public Response $response;
  public Database $db;
  public Router $router;
  protected Request $request;
  protected Config $config;

  public function __construct(?Config $config, ?string $ROOT_DIR = __DIR__ . '/../', ?string $ROOT_VIEW_DIR = __DIR__ . '/../views/')
  {
    self::$ROOT_DIR = $ROOT_DIR;
    self::$ROOT_VIEW_DIR = $ROOT_VIEW_DIR;
    self::$app = $this;
    $this->router = new Router();
    $this->request = new Request();
    $this->response = new Response();
    $this->config = $config;
    $this->db = new Database($this->config->db);
  }

  public function run() {
    echo $this->router->resolve();
  }
}
