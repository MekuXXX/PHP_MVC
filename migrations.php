<?php 

require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Application;
use App\Core\Config;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$app = new Application(config: new Config($_ENV));

$app->db->applyMigrations();