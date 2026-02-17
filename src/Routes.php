<?php

namespace App;

use Comet\Comet;

class Routes
{

  /**
   * Registers all route files in the routes directory.
   */
  public static function register(Comet $app): void
  {
    $routesDir = __DIR__ . '/../routes';

    if (!is_dir($routesDir)) {
      return;
    }

    // retrieves all php files in the routes directory and requires them
    // requires means that the routes defined in those files will be registered
    // along with the app instance passed to this method
    $files = glob($routesDir . '/*.php');

    foreach ($files as $file) {
      require_once $file;
    }
  }
}
