<?php

namespace App\Core;

class Config
{

  protected array $config = [];
  public function __construct(array $env)
  {
    $this->config = [
      'db' => [
        'driver'      => $env['DB_DRIVER'] ?? 'pgsql',
        'host'        => $env['DB_HOST'],
        'port'        => $env['DB_PORT'],
        'database'    => $env['DB_DATABASE'],
        'user'        => $env['DB_USER'],
        'password'    => $env['DB_PASSWORD'],
      ]
    ];
  }

  public function __get(string $name)
  {
    return $this->config[$name] ?? null;
  }
}