<?php 

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AuthController;
use App\Core\Application;
use App\Controllers\SiteController;
use App\Core\Config;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$config = 
$dotenv->load();


$app = new Application(config: new Config($_ENV));

$app->router->get("/",[SiteController::class, 'home']);

$app->router->get('/contact', 'contact');
$app->router->post('/contact', [SiteController::class, 'handleContact']);

// Authentication routes

$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);


$app->run();