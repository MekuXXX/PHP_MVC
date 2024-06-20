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
  public Database $db;
  public Router $router;
  public Response $response;
  public Session $session;
  protected Request $request;
  protected Config $config;

  public function __construct(?Config $config, ?string $ROOT_DIR = __DIR__ . '/../', ?string $ROOT_VIEW_DIR = __DIR__ . '/../views/')
  {
    self::$app = $this;
    self::$ROOT_DIR = $ROOT_DIR;
    self::$ROOT_VIEW_DIR = $ROOT_VIEW_DIR;
    $this->config = $config;
    $this->router = new Router();
    $this->request = new Request();
    $this->response = new Response();
    $this->db = new Database($this->config->db);
    $this->session = new Session();
  }

  public function run() {
    echo $this->router->resolve();
  }
}