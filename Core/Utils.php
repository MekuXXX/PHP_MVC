<?php

namespace App\Core;

class Utils
{

  public static function log_format(string $message): string
  {
    return '[ ' . date('Y-m-d H:i:s') . " ] " . $message . PHP_EOL;
  }
  public static function log(string $message): void
  {
    echo self::log_format($message);
  }
}
